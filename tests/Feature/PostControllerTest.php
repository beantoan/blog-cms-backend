<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function testIndex()
    {
        $user = User::find(3);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/posts');

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
            ]);
    }

    public function testStore()
    {
        $user = User::find(3);

        $data = [
            'title' => '',
            'content' => ''
        ];

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', $data);

        $response
            ->assertStatus(400)
            ->assertJson([
                'code' => 200,
                "msg" => "Please provide valid data."
            ]);

        $data = [
            'title' => 'a title',
            'content' => ''
        ];

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', $data);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'code' => 200,
                "msg" => "Please provide valid data.",
                "data" => [
                    "content" => [
                        "The content field is required."
                    ]
                ]
            ]);

        $data = [
            'title' => '',
            'content' => 'a content'
        ];

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', $data);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'code' => 200,
                "msg" => "Please provide valid data.",
                "data" => [
                    "title" => [
                        "The title field is required."
                    ]
                ]
            ]);

        $data = [
            'title' => 'a title',
            'content' => 'a content'
        ];

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', $data);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "msg" => 'Post "a title" is saved successfully.'
            ]);
    }

    public function testShow()
    {
        $user = User::find(3);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/posts/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                "id" => 1
            ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/posts/-1');

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 203
            ]);
    }

    public function testUpdate()
    {
        $user = User::find(3);

        $data = [
            'title' => 'new title 1',
            'content' => 'new content 1'
        ];

        $response = $this->actingAs($user, 'api')->json('PUT', '/api/posts/1', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                "msg" => 'Post "new title 1" is saved successfully.'
            ]);

        $data = [
            'title' => 'new title 1',
            'content' => ''
        ];

        $response = $this->actingAs($user, 'api')->json('PUT', '/api/posts/1', $data);

        $response
            ->assertStatus(400)
            ->assertJson([
                "code" => 200,
                "msg" => "Please provide valid data."
            ]);
    }
}
