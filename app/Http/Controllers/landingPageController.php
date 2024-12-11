<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class landingPageController extends Controller
{
    public function index()
    {
        // return view : memanggil file blade
        // folder.file
        return view('home');
    }
}
