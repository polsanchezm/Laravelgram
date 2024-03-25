<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // metode per redirigir a la ruta on mostra tots els posts
    public function index()
    {
        return redirect()->route('posts.showAll');
    }
}
