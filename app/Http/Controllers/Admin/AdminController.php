<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $controller_name = 'admin';
    protected $path_to_view = 'admin.pages.';
    protected $path_to_ui = 'ui_resources/startbootstrap-sb-admin-2/';

    public function __construct()
    {
        $this->middleware('auth');
        // Var want to share
        view()->share('controller_name', $this->controller_name);
        view()->share('path_to_ui', $this->path_to_ui);
    }

    public function index()
    {
        return view('admin.pages.dashboard');
    }
}
