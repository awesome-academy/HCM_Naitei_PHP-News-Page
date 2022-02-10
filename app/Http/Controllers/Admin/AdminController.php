<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $controllerName = 'admin';
    protected $pathToView = 'admin.pages.';
    protected $pathToUi = 'ui_resources/startbootstrap-sb-admin-2/';

    public function __construct()
    {
        $this->middleware('auth');
        // Var want to share
        view()->share('controllerName', $this->controllerName);
        view()->share('pathToUi', $this->pathToUi);
    }

    public function index()
    {
        return view('admin.pages.dashboard');
    }
}
