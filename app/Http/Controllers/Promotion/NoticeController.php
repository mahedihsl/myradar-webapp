<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\NoticeRepository;
use App\Entities\User;
use App\Entities\Notice;
use App\Entities\Payment;
use App\Jobs\PushNotificationJob;
use App\Service\NotificationService;
use App\Service\SmsService;
use Carbon\Carbon;
use App\Entities\PendingNotice;
use App\Transformers\PendingNoticeTransformer;
use Illuminate\Support\Facades\Log;
use Exception;
use Excel;

class NoticeController extends Controller
{
    private $repository;

    public function __construct(NoticeRepository $repository)
    {
        $this->repository = $repository;
    }

    // $mm = month (1 indexed)
    private function getUnpaidUsers($mm, $yy)
    {
        $date = Carbon::createFromDate($yy, $mm, 1);
        $date->setTime(0, 0);

        $mm--;

        $users = Payment::where('months', 'all', [[$mm, $yy]])
                    ->orWhere('months', 'all', [[$mm, strval($yy)]])
                    ->get(['user_id'])
                    ->map(function($v) {return $v->user_id;})
                    ->toArray();

        $unpaid = User::where('type', User::$TYPE_CUSTOMER)
                    ->where('created_at', '<', $date)
                    ->whereNotIn('_id', $users)
                    ->where(function($query) {
                        $query->where('status', 'exists', false)
                            ->orWhere('status', 1)
                            ->orWhere('status', "1");
                    })
                    ->get(['phone']);

        return $unpaid;
    }

    public function sendDueNotice(Request $request)
    {
        $month = explode(",", $request->get('month'));
        $mm = intval($month[0]);
        $yy = intval($month[1]);
        $via = $request->get('via');

        $message = $request->get('message', null);

        if (strlen($message)) {
            $unpaid = $this->getUnpaidUsers($mm, $yy);
            $unpaid->each(function($user) use ($message, $via) {
                if ($via == 'sms') {
                    PendingNotice::create([
                        'via' => $via,
                        'to' => $user->phone,
                        'payload' => $message,
                    ]);
                } else {
                    $payload = [
                        'title' => 'Notice',
                        'body' => $message,
                        'type' => NotificationService::$TYPE_BILL,
                    ];
                    PendingNotice::create([
                        'via' => $via,
                        'to' => $user->id,
                        'payload' => $payload,
                    ]);
                }
            });

            $this->repository->create([ 'message' => $message ]);

            return redirect()->route('due-notice', [
                'status' => 1,
                'via' => $via,
                'count' => PendingNotice::where('via', $via)->count(),
            ]);
        }

        return redirect()->route('due-notice', ['status' => 0]);
    }

    public function exportDueNotice(Request $request, $via)
    {
        $notices = PendingNotice::where('via', $via)->get();
        $targets = $notices->map(function($v) {return $v->to;});
        
        $foreignField = $via == 'sms' ? 'phone' : '_id';
        $users = User::whereIn($foreignField, $targets)->get();

        $fileName = 'Pending Notices - ' . strtoupper($via);
        Excel::create($fileName, function ($excel) use ($notices, $users) {
            $excel->sheet('data', function ($sheet) use ($notices, $users) {
                $notices->transform(function ($notice) use ($users) {
                    $user = $users->first(function($user) use ($notice) {
                        if ($notice->via == 'sms') {
                            return $user->phone == $notice->to;
                        }
                        return $user->id == $notice->to;
                    });
                    $transformer = new PendingNoticeTransformer();
                    return $transformer->transform($notice, $user);
                });

                $sheet->fromArray($notices->toArray(), null, 'A1', false, true);
            });
        })->download('xlsx');
    }

    public function sendSingleNotice(Request $request)
    {
        $via = $request->get('via', 'none');
        $model = PendingNotice::where('via', $via)->first();
        if ( ! is_null($model)) {
            try {
                if ($model->via == 'sms') {
                    $s = new SmsService();
                    $s->send($model->to, $model->payload);
                } else if ($model->via == 'push') {
                    $j = new PushNotificationJob($model->to, collect($model->payload));
                    $j->handle();
                }
                $model->delete();
            } catch (Exception $error) {
                Log::info('Single Notice Delivery Error', [
                    'message' => $error->getMessage(),
                    'model' => $model->toArray(),
                ]);
            }
        }
        return response()->json([
            'remaining' => PendingNotice::where('via', $via)->count(),
        ]);
    }

    public function dueNotice(Request $request)
    {
        $counts = collect(['sms', 'push'])->mapWithKeys(function ($tag) {
            return [
                $tag => PendingNotice::where('via', $tag)->count(),
            ];
        });

        $months = collect(range(0, 11))->map(function($i) {
            $temp = Carbon::today()->subMonths($i);
            return [
                'value' => $temp->format('n,Y'),
                'label' => $temp->format('F Y'),
            ];
        });
        $history = Notice::orderBy('_id', 'desc')
                    ->limit(5)
                    ->get();

        return view('promotion.notice')->with([
            'months' => $months,
            'history' => $history,
            
            'counts' => $counts,
        ]);
    }
}
