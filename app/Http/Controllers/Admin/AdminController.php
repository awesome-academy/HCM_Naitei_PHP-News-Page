<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Carbon\Carbon;
use App\Repositories\Admin\AdminRepositoryInterface;

class AdminController extends Controller
{
    protected $controllerName = 'admin';
    protected $pathToView = 'admin.pages.';
    protected $pathToUi = 'ui_resources/startbootstrap-sb-admin-2/';
    protected $adminRepo;
    public function __construct(AdminRepositoryInterface $adminRepo)
    {
        $this->middleware('auth');
        // Var want to share
        view()->share('controllerName', $this->controllerName);
        view()->share('pathToUi', $this->pathToUi);
        $this->adminRepo = $adminRepo;
    }

    public function index()
    {
        $posts = $this->adminRepo->chartCountPosts();
        $datas = $posts['datas'];
        $days = $posts['days'];

        return view($this->pathToView.'dashboard', compact('datas', 'days'));
    }
}
