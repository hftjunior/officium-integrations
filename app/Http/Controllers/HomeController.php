<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;

class HomeController extends Controller
{
    protected $session;

    protected $flash;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       return view('home');
    }
}
