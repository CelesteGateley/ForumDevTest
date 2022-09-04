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
        // Should return 409, since a forum with that name exists
        $this->postJson(route('api.forum.create'), $data)->assertStatus(409);
    }

    /**
     * @covers \App\Http\Controllers\Api\ForumController::update
     * @return void
     */
    public function testUpdateRoute(): void
    {
        $token = User::factory()->create()->repository()->getToken()->token;
        $forum = Forum::factory()->create();
        $forum2 = Forum::factory()->create();
        $data = ['name' => 'Test Name', 'description' => 'Test Description'];
        $this->postJson(route('api.forum.update', ['forum' => $forum->id]))->assertStatus(403);
        $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token])->assertStatus(422);
        $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token, 'name' => 'Test Name'])->assertStatus(422);
        $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token, 'description' => 'Test Description'])->assertStatus(422);
        $response = $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token, ...$data]);
        $response->assertStatus(200);
        $response->assertJson($data);
        // Test that updating with same data works-as-intended (name should be unique except for existing)
        $response = $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token, ...$data]);
        $response->assertStatus(200);
        $response->assertJson($data);
        // Should return 409, since a forum with that name exists
        $response = $this->postJson(route('api.forum.update', ['forum' => $forum->id]), ['__token' => $token, 'name' => $forum2->name, 'description' => $forum2->description]);
        $response->assertStatus(409);
    }

    /**
     * @covers \App\Http\Controllers\Api\ForumController::delete
     * @return void
     */
    public function testDeleteRoute(): void
    {
        $token = User::factory()->create()->repository()->getToken()->token;
        $forum = Forum::factory()->create();
        $this->postJson(route('api.forum.delete', ['forum' => $forum->id]))->assertStatus(403);
        $response = $this->postJson(route('api.forum.delete', ['forum' => $forum->id]), ['__token' => $token,]);
        $response->assertStatus(200);
        $response->assertJson(['success' => true,]);
        $this->assertModelMissing($forum);
    }
}
