<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $pathToView = 'user.pages.';
    protected $imgPosts;
    protected $categoriesWithChildren;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->imgPosts = Image::where('imageable_type', Post::class)->get();
        $this->categoriesWithChildren = Category::with('children')->whereNull('parent_id')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $max = config('model.posts.maxDisplay');
        $min = config('model.posts.minDisplay');
        //Lastest news
        $latestPosts = Post::orderBy('created_at', 'desc')->take(5)->get();
        //World news
        $worldSubCategories = Category::with(['children'])->where('parent_id', 1)->get();
        $worldPosts = $worldSubCategories->load('posts');
        $worldPostsArray = array();
        foreach ($worldSubCategories as $category) {
            foreach ($category->posts as $post) {
                $worldPostsArray[] = $post;
            }
        }
        $worldPosts = array_slice($worldPostsArray, $min, $max);
        //Business news
        $businessSubCategories = Category::with(['children'])->where('parent_id', 2)->get();
        $businessPosts = $businessSubCategories->load('posts');
        $businessPostsArray = array();
        foreach ($businessSubCategories as $category) {
            foreach ($category->posts as $post) {
                $businessPostsArray[] = $post;
            }
        }
        $businessPosts = array_slice($businessPostsArray, $min, $max);
        //Tech news
        $techSubCategories = Category::with(['children'])->where('parent_id', 8)->get();
        $techPosts = $techSubCategories->load('posts');
        $techPostsArray = array();
        foreach ($techSubCategories as $category) {
            foreach ($category->posts as $post) {
                $techPostsArray[] = $post;
            }
        }
        $techPosts = array_slice($techPostsArray, $min, $max);
        //Health news
        $healthSubCategories = Category::with(['children'])->where('parent_id', 6)->get();
        $healthPosts = $healthSubCategories->load('posts');
        $healthPostsArray = array();
        foreach ($healthSubCategories as $category) {
            foreach ($category->posts as $post) {
                $healthPostsArray[] = $post;
            }
        }
        $healthPosts = array_slice($healthPostsArray, $min, $max-1);

        return view(
            'welcome',
            array_merge(
                compact('latestPosts', 'worldPosts', 'businessPosts', 'techPosts', 'healthPosts'),
                [
                    'searchKeyWord' => $this->searchKeyWord,
                    'imgPosts' => $this->imgPosts,
                    'categoriesWithChildren' => $this->categoriesWithChildren,
                ]
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(Request $request)
    {
        $searchKeyWord = $request->input('search');
        $posts = Post::where('title', 'LIKE', "%{$searchKeyWord}%")
            ->orWhere('body', 'LIKE', "%{$searchKeyWord}%")
            ->paginate($this->limit);
        $posts->appends(
            [
                'search' => $searchKeyWord,
            ]
        );

        return view(
            $this->pathToView . 'searchHome',
            array_merge(
                compact('posts', 'searchKeyWord'),
                [
                    'imgPosts' => $this->imgPosts,
                    'categoriesWithChildren' => $this->categoriesWithChildren,
                ]
            )
        );
    }
}
