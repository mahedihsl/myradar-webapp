<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\UserLogin;
use App\Entities\User;
use Carbon\Carbon;
use DB;

class removeUnregisteredDeviceTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeviceToken:removeUnregisteredDeviceTokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periodically Check for unregistered device tokens and remove them from user logins';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tokens = DB::table('push_logs')->get()->map(function ($item) {
            $arr = [];
            array_push($arr, $item['unregistered_device_token']);
            return $arr;
        })->toArray();

        $tokenList = $tokens;
        $token_array = [];

        foreach ($tokenList as $token):
          foreach ($token as $t):
             foreach ($t as $d):
             array_push($token_array, $d);
             endforeach;
          endforeach;
        endforeach;

        $finalTokens = array_unique($token_array);

        $count = 0;
        $response = UserLogin::whereIn('device_token', $finalTokens)->get()->each(function ($item) use ($count) {
            $item->delete();
            //return $item->id;
            $count++;
        });

        $this->info("Number of unregistered device tokens deleted =>".$count);
    }
}
