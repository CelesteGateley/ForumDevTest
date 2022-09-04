<?php

namespace Endpoint;

use App\Models\User;
use App\Models\UserToken;
use Tests\DatabaseTestCase;

class AuthenticationEndpointTest extends DatabaseTestCase
{
    /**
     * @covers \App\Http\Controllers\Api\UserController::login
     * @return void
     */
    public function testLoginEndpoint(): void
    {
        $user = User::factory()->create();
        $this->postJson(route('api.auth.login'), ['email' => 'test@localhost', 'password' => 'password'])->assertStatus(403);
        $this->postJson(route('api.auth.login'), ['email' => $user->email, 'password' => 'wrong_password'])->assertStatus(403);
        $response = $this->postJson(route('api.auth.login'), ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(200);
        $token = UserToken::find($response->json('token'));
        $this->assertEquals($user->id, $token?->user?->id);
    }
}
