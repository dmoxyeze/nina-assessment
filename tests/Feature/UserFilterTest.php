<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFilterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAmericanUsers()
    {
        //$response = $this->json('GET','/users');
        $users = User::americans()->latest('id')->get();
        $passes = $this->IterateUsersObjects($users);
        $passes ? $this->assertTrue($passes): $this->assertFalse($passes);
    }

    public function IterateUsersObjects($users) {
        foreach($users as $user) {
            if ($user->location != 'America') {
                return false;
            }
        }
        return true;
    }
}
