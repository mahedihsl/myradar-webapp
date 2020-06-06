<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Entities\User;

class PaymentTest extends DuskTestCase
{
    /**
     * @group payment
     * @return void
     */
    public function testNewPaymentPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/new/payment')
                    ->assertPathIs('/home');
        });
    }
}
