<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\AdminController;

class UserController extends Controller
{
    private $controller_name = 'admin';
    protected $path_to_view = 'admin.pages.';
    private $path_to_ui = 'ui_resources/startbootstrap-sb-admin-2/';
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
        $users = User::first();
        $this->limit = config('app.limit');
        $users = $users->load('role')->paginate($this->limit);
        $searchKeyWord = "";

        return view($this->path_to_view . 'listUser', compact(['users', 'searchKeyWord']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path_to_view . 'addUser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddRequest $request)
    {
        $password = Hash::make($request->password);
        $user = User::create([
            'name' => $request->name,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);
        
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view($this->path_to_view . 'viewProfile', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view($this->path_to_view . 'editUser', compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $password = Hash::make($request->password);
        User::where('id', $id)->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index');
    }
    
    public function search(Request $request)
    {
        $this->limit = config('app.limit');
        $searchKeyWord = $request->input('search');
        $users = User::where('name', 'LIKE', "%{$searchKeyWord}%")
            ->orWhere('email', 'LIKE', "%{$searchKeyWord}%")
            ->orderBy('id', 'DESC')
            ->paginate($this->limit);

        return view($this->path_to_view . 'listUser', compact('users', 'searchKeyWord'));
    }
}
