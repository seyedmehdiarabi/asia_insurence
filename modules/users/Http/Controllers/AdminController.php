<?php


namespace Modules\users\Http\Controllers;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        config()->set('view.search_components','add');
        return CView('users::admin.index');

    }

    public function author_panel()
    {
        return CView('users::admin.author_panel');
    }

    public function error403()
    {
        dd('403');
        return CView('403');
    }
}
