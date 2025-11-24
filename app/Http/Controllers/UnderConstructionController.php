<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnderConstructionController extends Controller
{
    public function index()
    {
        return view('under-construction');
    }

    public function socialMediaUnavailable()
    {
        return view('social-media-unavailable');
    }
}

