<?php

namespace Tests\Browser;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginPageCanBeRendered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertTitle("Laravel")
                ->assertSee(trans("Email"))
                ->assertSee(trans("Password"))
                ->assertSee(trans("Remember me"))
                ->assertSee(trans("Forgot your password?"))
                ->assertSee(trans("Log in"));
        });
    }

    public function testLoginSuccessFully()
    {
        Role::insert([['id' => 1, 'name' => 'admin'], ['id' => 2, 'name' => 'user']]);
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->assertInputPresent('email')
                ->type('#email', $user->email)
                ->assertInput('password')
                ->type('#password', "12345678")
                ->click('button');
        });
    }
}
