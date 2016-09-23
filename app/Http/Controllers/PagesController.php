<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show home page.
     *
     * @return string
     */
    public function home()
    {
        return view('home');
    }
}
