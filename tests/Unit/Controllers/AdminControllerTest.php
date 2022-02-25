<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Post;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery;
use Mockery\MockInterface;
use App\Services\Web\UserService;
use App\Repositories\Admin\AdminRepository;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class AdminControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public $mockObject;
    public $controller;
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockObject = Mockery::mock(AdminRepository::class)->makePartial();
        $this->controller = new AdminController($this->mockObject);
    }
    
    public function tearDown(): void
    {
        unset($this->controller);
        Mockery::close();
        parent::tearDown();
    }
    //  test_chart_posts
    public function testChartCountPosts()
    {
        $posts = Post::factory(5)->make();
        $this->mockObject->shouldReceive('chartCountPosts')
            ->times(1)
            ->withNoArgs()
            ->andReturn($posts);
        $response = $this->controller->index();
        
        $this->assertEquals('admin.pages.dashboard', $response->getName());
    }
}
