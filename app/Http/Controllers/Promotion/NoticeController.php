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
                            ->orWhere('status', 1);
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
                    // $s = new SmsService();
                    // $s->send($user->phone, $message);
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
                    // dispatch(new PushNotificationJob($user->id, $payload));
                }
            });

            $this->repository->create([
                'message' => $message,
            ]);

            return redirect()->route('due-notice', [
                'status' => 1,
                'count' => $unpaid->count(),
            ]);
        }

        return redirect()->route('due-notice', ['status' => 0]);
    }

    public function dueNotice(Request $request)
    {
        $status = $request->get('status', -1);
        $count = $request->get('count', 0);

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
            'status' => $status,
            'count' => $count,
            'months' => $months,
            'history' => $history,
        ]);
    }
}
