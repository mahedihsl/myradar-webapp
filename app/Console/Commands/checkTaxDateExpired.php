<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Event;
use App\Events\DateExpirationEvent;
use App\Http\Controllers\PushNotification\PushNotificationController;
use Mail;
use App\Entities\User;
use App\Entities\UserLogin;
use App\Entities\Car;
use Carbon\Carbon;
use DB;

class checkTaxDateExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taxDate:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this will check car dates e.g tax,fitness are expired or not';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->PushNotification = new PushNotificationController();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $dateNow = Carbon::now();
        $type = 1 ;//push notfication type => Date expiration
        $occurance = [1,3,7,15];

        foreach ($occurance as $day):
        $date = Carbon::now()->addDays(intval($day)+1);
        $device_token_type_array = [];
        $cars = Car::where('tax_date', '>', $dateNow)
                    ->where('tax_date', '<', $date)->get()->map(function ($item) {
                        return $item->user->user_logins->map(function ($elem) {
                          $array[$elem->device_token] =isset($elem->device_type)?$elem->device_type:0; //if no device_type --> android
                          return $array;
                        });
                    })->toArray();


        $device_token_type_array = !empty($cars[0])?$cars[0]:[];
        $ios_device_tokens = [];
        $android_device_tokens = [];

        foreach ($device_token_type_array as $device):
              foreach ($device as $token=>$device_type):
                if ($device_type==1) {
                    array_push($ios_device_tokens, $token);
                } else {
                    array_push($android_device_tokens, $token);
                }
               endforeach;
        endforeach;

        $message = "Tax date wiil be expired in ".$day." days";
        $title = "Tax Date about to expire!!";

        if (!empty($ios_device_tokens)) {
            //$this->PushNotification->iosPush($message, $title, $ios_device_tokens, $vibrate=1, $sound=1, $type);
            foreach($ios_device_tokens as $token):
              $this->PushNotification->iosPushSingle($message, $title, $token,$user=null,$vibrate=1, $sound=1, $type);
            endforeach;
        }

        if (!empty($android_device_tokens)) {
            // $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
            foreach($android_device_tokens as $token):
              $this->PushNotification->androidPushSingle($message, $title, $token,$user=null,$vibrate=1, $sound=1, $type);
            endforeach;
        }
        $dateNow = $date;
        endforeach;

        $this->info("Tax Date Expiration notification sent To Devices");

        DB::table('cron_logs')->insert([
          'when'=>Carbon::now(),
          'message'=>'Tax Date Expiration notification sent To Devices'
        ]);
    }
}
