<?php

namespace Tests\Unit;

use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }




    /** @test */
    public function it_can_create_an_task()
    {
        $data = [
            "title"=>"taks Two",
	        "description"=>"Task Description"
        ];

        $this->post(route('tasks.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);

    }
    /** @test */
    public function it_can_read_an_task()
    {


        $this->get(route('tasks.index'))
            ->assertStatus(200);

    }

    /** @test */
    public function it_can_update_an_task()
    {
        $task = Task::factory()->count(1)->create();

        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->put(route('tasks.update', $task[0]->id), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
    /** @test */

    public function it_can_delete_an_task(){
        $task = Task::factory()->count(1)->create();

        $this->delete(route('tasks.destroy', $task[0]->id))
            ->assertStatus(204);
    }

    /** @test */

    public function can_list_posts() {
        $posts = Task::factory()->count(5)->create()->map(function ($post) {
            return $post->only(['id', 'title', 'description']);
        });

        $this->get(route('tasks.index'))
            ->assertStatus(200)
            ->assertJson($posts->toArray())
            ->assertJsonStructure([
                '*' => [ 'id', 'title', 'description' ],
            ]);
    }
}
