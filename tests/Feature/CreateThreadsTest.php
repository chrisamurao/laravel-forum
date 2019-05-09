<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

//    /**
//     * @test
//     * @expectedException Illuminate\Auth\AuthenticationException
//     */
//    function guests_may_not_create_threads()
//    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $thread = factory('App\Thread')->make();
//        $this->post('/threads', $thread->toArray());
//    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // When we hit the endpoint to create a new thread
        $thread = factory('App\Thread')->make();
        $this->post('threads', $thread->toArray());

        // Then, when we visit the thread page
        $this->get($thread->path());

        // We should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}