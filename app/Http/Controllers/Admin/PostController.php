<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\EditPostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $controller_name = 'admin';
    protected $path_to_view = 'admin.pages.';
    protected $path_to_ui = 'ui_resources/startbootstrap-sb-admin-2/';
    protected $limit;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Var want to share
        view()->share('controller_name', $this->controller_name);
        view()->share('path_to_ui', $this->path_to_ui);
    }
    public function index()
    {
        $posts = Post::first();
        $this->limit = config('app.limit');
        $posts = $posts->load('images')->paginate($this->limit);
        $searchKeyWord = "";

        return view($this->path_to_view . 'listPost', compact(['posts', 'searchKeyWord']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories_sub = DB::table('categories')->select('*')->where('parent_id', '>', '1')->get();

        return view($this->path_to_view . 'addPost', compact(['categories_sub']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPostRequest $request, Post $post)
    {
        //find category_id from entered category_name
        $category = Category::findOrFail($request->category_id);
        //new post
        $post = new Post;
        $post = array('title' => $request->title, 'body' => $request->body, 'category_id' => $category->id);
        $post = Post::create($post);
        //new image
        $image_post = new Image;
        //save image
        $image_post->link = $request->images->getClientOriginalName();
        DB::transaction(function () use ($post, $image_post) {
            Post::find($post->id)->images()->save($image_post);
        });

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $image_post = Post::findOrFail($id)->load('images');

        return view($this->path_to_view . 'detailPostAdmin', compact(['image_post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        return view('admin.edit', compact(['post']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, $id)
    {
        //find category_id from entered category_name
        $category_id = Category::where('name', 'like', $request->category_name)->first();
        //update post
        Post::where('id', $id)->update(['title' => $request->title,
        'body' => $request->body, 'category_id' => $category_id->id]);
        
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('post.index');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->get('ids');
        $dbs = DB::delete('delete from posts where id in ('.implode(',', $ids).')');

        return redirect()->route('post.index');
    }

    public function search(Request $request)
    {
        $searchKeyWord = $request->input('search');
        $this->limit = config('app.limit');
        $posts = Post::query()
            ->where('title', 'LIKE', "%{$searchKeyWord}%")
            ->orWhere('body', 'LIKE', "%{$searchKeyWord}%")
            ->orderBy('id', 'DESC')
            ->paginate($this->limit);

        return view($this->path_to_view . 'listPost', compact('posts', 'searchKeyWord'));
    }
}
