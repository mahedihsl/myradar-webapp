<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Entities\User;

class CustomerEditTest extends DuskTestCase
{
    /**
     * @group customer
     * @return void
     */
    public function testCustomerEdit()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('type', User::$TYPE_ADMIN)->first();
            $customer = User::where('type', User::$TYPE_CUSTOMER)->first();

            $browser->loginAs($admin)
                    ->visit('/customer/edit/'.$customer->id)
                    ->attach('image', '/home/palatok/Pictures/face7.jpg')
                    ->pause(2000)
                    ->click('button.btn-success')
                    ->waitForLocation('/customer/details/'.$customer->id);
        });
    }
}
