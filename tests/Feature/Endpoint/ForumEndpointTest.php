<?php

namespace Tests\Feature\Endpoint;

use App\Models\Forum;
use App\Models\User;
use Tests\DatabaseTestCase;

class ForumEndpointTest extends DatabaseTestCase
{
    /**
     * @covers \App\Http\Controllers\Api\ForumController::index
     * @return void
     */
    public function testIndexRoute(): void
    {
        Forum::factory(5)->create();
        $response = $this->getJson(route('api.forum.all'));
        $response->assertStatus(200);
        foreach ($response->collect() as $data) {
            $forum = Forum::find($data['id']);
            $this->assertNotNull($forum);
            $this->assertEquals($forum->name, $data['name']);
            $this->assertEquals($forum->description, $data['description']);
        }
    }

    /**
     * @covers \App\Http\Controllers\Api\ForumController::create
     * @return void
     */
    public function testCreateRoute(): void
    {
        $token = User::factory()->create()->repository()->getToken()->token;
        $data = ['__token' => $token, 'name' => 'Test Name', 'description' => 'Test Description'];
        $this->postJson(route('api.forum.create'))->assertStatus(403);
        $this->postJson(route('api.forum.create'), ['__token' => $token])->assertStatus(422);
        $this->postJson(route('api.forum.create'), ['__token' => $token, 'name' => 'Test Name'])->assertStatus(422);
        $this->postJson(route('api.forum.create'), ['__token' => $token, 'description' => 'Test Description'])->assertStatus(422);
        $response = $this->postJson(route('api.forum.create'), $data);
        $response->assertStatus(200);
        $forum = Forum::find($response->json('id'));
        $this->assertNotNull($forum);
    }
}
