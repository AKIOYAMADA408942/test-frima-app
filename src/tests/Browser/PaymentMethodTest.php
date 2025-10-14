<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class PaymentMethodTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */

    
    public function testExample()
    {
        
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/purchase/1')
                    ->assertSelected('#select-payment','選択してください')
                    ->assertSeeNothingIn('#confirm-payment')
                    ->select('#select-payment','コンビニ支払い')
                    ->waitFor('#select-payment')
                    ->assertSelected('#select-payment','コンビニ支払い')
                    ->assertSeeIn('#confirm-payment','コンビニ支払い')
                    ->select('#select-payment','カード支払い')
                    ->waitFor('#select-payment')
                    ->assertSelected('#select-payment','カード支払い')
                    ->assertSeeIn('#confirm-payment','カード支払い');
        });
    }
}
