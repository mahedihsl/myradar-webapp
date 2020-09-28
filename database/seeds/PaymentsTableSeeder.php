<?php

use App\Contract\Repositories\PaymentRepository;
use App\Entities\Activation;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Entities\Car;
use App\Entities\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->restorePayments();
        // $this->restoreActivation();
        // $this->patchActivationDate();
    }

    public function patchActivationDate()
    {
        $count = 0;
        $cars = Car::with(['activation'])->get();
        foreach ($cars as $car) {
            $act = $car->activation;
            if ( ! is_null($act)) {
                $act->update([ 'created_at' => $car->created_at ]);
                $count++;
            }
        }

        echo "Activation date updated: " . $count . "\n";
    }

    public function restoreActivation()
    {
        $activations = file_get_contents(storage_path('app/imports/activation.json'));
        $activations = collect(json_decode($activations, true));

        $KEY_REG_NO = 'Car No.';

        $cars = Car::all();
        foreach ($cars as $car) {
            $record = $activations->first(function($item) use ($car, $KEY_REG_NO) {
                return $item[$KEY_REG_NO] == $car->reg_no;
            });

            if ($record) {
                $code = 1000;
                $count = intval(Activation::where('code', $code)->max('serial'));
                $car->activation()->create([
                    'code' => $code,
                    'serial' => $count + 1,
                ]);
                echo "Action record created with serial: " . ($count + 1) . "\n";
            }
        }

        echo "Activation Count: " . $activations->count() . "\n";
    }

    public function restorePayments()
    {
        return;
        
        $S1_CUSTOMER = 'Customer';
        $S1_CAR_NO = 'Car No.';
        $S1_CONN_MONTH = 'Connection Month';
        $S1_PAID = 'Paid';
        $S1_WAIVE = 'Waive';
        $S1_EXTRA = 'Extra';
        $S1_BILL = 'Monthly Bill';
        $S1_CLEARED_MONTHS = '(Paid + Waive) Months';
        $S1_KNOWN_MONTHS = 'Paid Automatic Entry (Date Available)';
        $S1_UNKNOWN_MONTHS = 'Paid Automatic Entry (Default Date 5th of any month)';

        $S2_CUSTOMER = 'Customer';
        $S2_CAR_NO = 'Car No.';
        $S2_DATE = 'Date/Time';
        $S2_AMOUNT = 'Amount';
        $S2_METHOD = 'Method';
        $S2_BILL = 'Monthly Bill';
        $S2_MONTHS = 'No of Months Payment Log';

        $reports = file_get_contents(storage_path('app/imports/reports.json'));
        $reports = collect(json_decode($reports, true));
        $payments = file_get_contents(storage_path('app/imports/payments.json'));
        $payments = collect(json_decode($payments, true));

        $carProcessed = 0;
        $paymentCreated = 0;

        $cars = Car::all();
        $repository = app(PaymentRepository::class);

        foreach ($cars as $car) {
            $carReport = $reports->first(function($item) use ($car, $S1_CAR_NO) {
                return $item[$S1_CAR_NO] == $car->reg_no;
            });
            $carPayments = $payments->filter(function($item) use ($car, $S2_CAR_NO) {
                return $item[$S2_CAR_NO] == $car->reg_no;
            });

            if ($carReport) {
                echo "Processing: " . $car->reg_no . "\n";
                if ($car->payment_restored) {
                    echo "skipping " . $car->reg_no . " - RESTORING DONE\n";
                    continue;
                }

                $firstPaymentDate = '1 ' . $carReport[$S1_CONN_MONTH];
                $firstPaymentDate = Carbon::createFromFormat("j M'y", $firstPaymentDate);
                $firstPaymentDate->day = 5;
                $firstPaymentDate->addMonth();

                $totalPaid = $this->extractNumber($carReport[$S1_PAID]);
                $waive = $this->extractNumber($carReport[$S1_WAIVE]);
                $extra = $this->extractNumber($carReport[$S1_EXTRA]);
                $laterPaid = $carPayments->sum(function($item) use ($S2_AMOUNT) {
                    return $this->extractNumber($item[$S2_AMOUNT]);
                });

                if (($totalPaid + $waive + $extra) == 0) {
                    echo "skipping " . $car->reg_no . " - NO TRANSACTION\n";
                    continue;
                }

                $recordsCreated = false;
                $unknownMonths = intval($carReport[$S1_UNKNOWN_MONTHS]);
                if ($unknownMonths > 0) {
                    $props = collect([
                        'amount' => $totalPaid - $laterPaid,
                        'months' => $this->billingMonths($firstPaymentDate, $unknownMonths),
                        'date' => $firstPaymentDate->timestamp,
                        'car_id' => $car->id,
                        'user_id' => $car->user_id,
                        'waive' => $waive,
                        'extra' => $extra,
                        'note' => 'autogen_unknown_date',
                        'type' => 0,
                    ]);
                    $firstPaymentDate->addMonths($unknownMonths);
                    $repository->save($props);
                    $recordsCreated = true;
                }

                foreach ($carPayments as $knownPyment) {
                    $paymentDate = $knownPyment[$S2_DATE];
                    $paymentDate = Carbon::createFromFormat('j M Y', $paymentDate);
                    $paymentDate->hour = 10;
                    $monthCount = intval($knownPyment[$S2_MONTHS]);
                    $props = collect([
                        'amount' => $this->extractNumber($knownPyment[$S2_AMOUNT]),
                        'months' => $this->billingMonths($firstPaymentDate, $monthCount),
                        'date' => $paymentDate->timestamp,
                        'car_id' => $car->id,
                        'user_id' => $car->user_id,
                        'waive' => 0,
                        'extra' => 0,
                        'note' => 'autogen_known_date',
                        'type' => $this->findType($knownPyment[$S2_METHOD]),
                    ]);
                    $repository->save($props);
                    $firstPaymentDate->addMonths($monthCount);
                    $recordsCreated = true;
                }

                $carProcessed++;
                $car->update([
                    'payment_restored' => true,
                    'bill' => $this->extractNumber($carReport[$S1_BILL]),
                ]);
                // if ($recordsCreated) break;
            }
        }

        echo "\n\n";
        echo 'processed car count: ' . $carProcessed . "\n";
        echo 'reports count: ' . $reports->count() . "\n";
        echo 'payments count: ' . $payments->count() . "\n";
    }

    public function billingMonths($fromDate, $monthCount)
    {
        $months = [];
        $date = $fromDate->copy();
        for ($i=0; $i < $monthCount; $i++) { 
            $months[] = [$date->month - 1, $date->year];
            $date->addMonth();
        }
        return json_encode($months);
    }

    public function extractNumber($val)
    {
        $val = strval($val);
        $val = str_replace(',', '', $val);
        return intval($val);
    }

    public function findType($name)
    {
        $types = [
            'Cash',
            'bKash',
            'bKash Personal',
            'Rocket',
            'Rocket Personal',
            'Bank',
            'Visa',
            'MasterCard',
            'bKash (907)',
            'bKash (909)'
        ];

        $index = array_search($name, $types);
        return $index === FALSE ? 0 : $index + 1;
    }
}
