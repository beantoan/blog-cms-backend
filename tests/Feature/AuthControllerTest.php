<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Test login api
     */
    public function testLogin()
    {
        $loginUrl = '/api/auth/login';

        $data = [
            'email' => 'beantoan@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', $loginUrl, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'bearer'
            ]);

        $data2 = [
            'email' => 'beantoan2@gmail.com',
            'password' => '123456'
        ];

        $response2 = $this->json('POST', $loginUrl, $data2);

        $response2
            ->assertStatus(401)
            ->assertJson([
                'msg' => 'Your email or password is not valid.'
            ]);

        $data3 = [
            'email' => 'beantoan@gmail.com',
            'password' => '1234567'
        ];

        $response3 = $this->json('POST', $loginUrl, $data3);

        $response3
            ->assertStatus(401)
            ->assertJson([
                'msg' => 'Your email or password is not valid.'
            ]);
    }

    /**
     * Test me api
     */
    public function testMe()
    {
        $meUrl = '/api/auth/me';

        $user = User::find(3);

        $response = $this->actingAs($user, 'api')->json('GET', $meUrl);

        $response
            ->assertStatus(200)
            ->assertJson([
                "id" => 3,
                "email" => 'beantoan@gmail.com'
            ]);
    }
}
