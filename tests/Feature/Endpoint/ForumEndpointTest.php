<?php

namespace Tests\Feature\Endpoint;

use App\Models\Forum;
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
}
