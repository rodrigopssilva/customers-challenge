<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @covers App\Http\Controllers\AuthController::login
     * @return void
     */
    public function testAuthenticationFailsWithEmptyEmailAndPass()
    {
        $invalidData = ['email' => '', 'password' => ''];
        $response = $this->json('POST', '/api/auth/login', $invalidData);
        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertExactJson(['error' => 'Unauthorized']);
    }

    /**
     * @covers App\Http\Controllers\AuthController::login
     * @covers App\Http\Controllers\AuthController::respondWithToken
     */
    public function testAuthenticationSuccessWithValidUser()
    {
        $user = factory(User::class)->create();
        $userData = ['email' => $user->email, 'password' => 'secret'];

        $response = $this->json('POST', '/api/auth/login', $userData);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * @covers App\Http\Controllers\AuthController::me
     */
    public function testMeWithAuthenticatedUserShouldReturnOk()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->json('POST', '/api/auth/me');
        $response
            ->assertStatus(Response::HTTP_OK);
    }

}
