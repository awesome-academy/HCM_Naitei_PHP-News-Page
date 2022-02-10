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
    protected $pathToView = 'admin.pages.';
    protected $pathToUi = 'ui_resources/startbootstrap-sb-admin-2/';
    protected $imgPosts;
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
        view()->share('pathToUi', $this->pathToUi);
        $this->limit = config('app.limit');
        $this->imgPosts = Image::where('imageable_type', Post::class)->get();
    }
    public function index()
    {
        $posts = Post::first();
        $posts = $posts->load('images')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->limit);

        return view(
            $this->pathToView . 'listPost',
            array_merge(
                compact('posts'),
                [
                    'searchKeyWord' => $this->searchKeyWord,
                ]
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesSub = DB::table('categories')
            ->select('*')
            ->where('parent_id', '>', '0')
            ->get();

        return view(
            $this->pathToView . 'addPost',
            compact(
                [
                    'categoriesSub',
                ]
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPostRequest $request)
    {
        //new post
        $post = new Post;
        $post = array(
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
        );
        $post = Post::create($post);
        //new image
        $imagePost = new Image;
        //save image
        if (!empty($request->images)) {
            $imageName = time() . '.' . $request->images->extension();
            $imagePost->link = $imageName;
            $request->images->storeAs('public/images', $imageName);
            DB::transaction(function () use ($post, $imagePost) {
                Post::find($post->id)
                    ->images()
                    ->save($imagePost);
            });
        }

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $imagePost = Post::findOrFail($id)->load('images');

        return view(
            $this->pathToView . 'detailPostAdmin',
            array_merge(
                compact('imagePost'),
                [
                    'imgPosts' => $this->imgPosts,
                ]
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $categories = DB::table('categories')
            ->select('*')
            ->where('parent_id', '>', '0')
            ->get();

        return view(
            $this->pathToView . 'editPost',
            compact(
                [
                    'post', 'categories',
                ],
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, $id)
    {
        Post::where('id', $id)->update(
            [
                'title' => $request->title,
                'body' => $request->body,
                'category_id' => $request->category_name,
            ]
        );

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
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
        $dbs = DB::delete('delete from posts where id in (' . implode(',', $ids) . ')');

        return redirect()->route('post.index');
    }

    public function search(Request $request)
    {
        $searchKeyWord = $request->input('search');
        $posts = Post::where('title', 'LIKE', "%{$searchKeyWord}%")
            ->orWhere('body', 'LIKE', "%{$searchKeyWord}%")
            ->orderBy('id', 'DESC')
            ->paginate($this->limit);

        return view($this->pathToView . 'listPost', compact('posts', 'searchKeyWord'));
    }
}
