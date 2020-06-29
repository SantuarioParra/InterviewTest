<?php

namespace Tests\Unit\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;


class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @dataProvider provider
     */
    public function provider()
    {
        return  [
            "name" => "Juan Hernandez",
            "email" => "juan@test.com",
            "password"=> "password",
            "password_confirmation"=> "password"
        ];

    }

    /**
     * @test
     * Create user feature test
     * @return void
     */
    public function createUser()
    {
        $this->post(route('signup'),$this->provider())
        ->assertStatus(201);
    }

    /**
     * @test
     * Create user incorrect email feature test
     * @return void
     */
    public function createUserIncorrectEmail()
    {
        $user = $this->provider();
        $user['email']= "juan@test";
        $this->post(route('signup'),$user)
            ->assertStatus(422);
    }

    /**
     * @test
     * Create user feature test
     * @return void
     */
    public function createUserAsAdmin()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $this->post(route('users.store'),$this->provider())
            ->assertStatus(201);
    }

    /**
     * @test
     * Create user feature test
     * @return void
     */
    public function createUserAsAdminIncorrectInformation()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $newUser = $this->provider();
        $newUser['email']= "juan@test";
        $this->post(route('users.store'),$newUser)
            ->assertStatus(422);
    }



}

