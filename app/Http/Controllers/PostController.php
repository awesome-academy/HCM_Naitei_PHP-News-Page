<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $searchKeyWord = "";

        return view('admin.index', compact(['posts', 'searchKeyWord']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Post $post)
    {
        //find category_id from entered category_name
        $category = Category::findOrFail($request->category_name);
        //new post
        $post = new Post;
        $post = array('title' => $request->title, 'body' => $request->body, 'category_id' => $category->id);
        $post = Post::create($post);
        //new image
        $image_post = new Image;
        //save image
        $image_post->link = $request->image;
        DB::transaction(function () use ($post, $image_post) {
            Post::find($post->id)->images()->save($image_post);
        });

        return redirect('admin');
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

        return view('admin.detail', compact(['image_post']));
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
    public function update(PostRequest $request, $id)
    {
        //find category_id from entered category_name
        $category_id = Category::where('name', 'like', $request->category_name)->first();
        //update post
        Post::where('id', $id)->update(['title' => $request->title,
        'body' => $request->body, 'category_id' => $category_id->id]);
        
        return redirect('admin');
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

        return redirect('admin');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->get('ids');
        $dbs = DB::delete('delete from posts where id in ('.implode(',', $ids).')');

        return redirect('admin');
    }
    
    public function search(Request $request)
    {
        $searchKeyWord = $request->input('search');
    
        $posts = Post::query()
            ->where('title', 'LIKE', "%{$searchKeyWord}%")
            ->orWhere('body', 'LIKE', "%{$searchKeyWord}%")
            ->get();
    
        return view('admin.index', compact('posts', 'searchKeyWord'));
    }
}
