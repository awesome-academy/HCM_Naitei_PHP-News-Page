<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Image;

class UserCategoryController extends Controller
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
    public function index()
    {
        //
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
    public function showSubCategories($id)
    {
        //sub category
        $category = Category::findOrFail($id);
        //posts
        $posts = $category->posts()->paginate($this->limit);

        return view(
            $this->pathToView . 'detailSubCategory',
            array_merge(
                compact('posts'),
                [
                    'searchKeyWord' => $this->searchKeyWord,
                    'imgPosts' => $this->imgPosts,
                    'categoriesWithChildren' => $this->categoriesWithChildren,
                ]
            )
        );
    }

    public function showCategories($parent_id)
    {
        //parent category
        $categories = Category::where('parent_id', '=', $parent_id)->get('id');
        $items = array();
        //sub categories
        foreach ($categories as $category) {
            $items[] = $category['id'];
        }
        //posts
        $posts = Post::whereIn('category_id', $items)->orderBy('created_at', 'DESC')->paginate($this->limit);
        //check null sub-category
        if (empty($items)) {
            $posts = Post::where('category_id', $parent_id)->orderBy('created_at', 'DESC')->paginate($this->limit);
        }
        //parent name
        $parentName = Category::where('id', '=', $parent_id)->firstOrFail()['name'];

        return view(
            $this->pathToView . 'detailCategory',
            array_merge(
                compact('posts', 'parentName'),
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
}
