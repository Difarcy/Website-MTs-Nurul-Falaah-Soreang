<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

class ContactController extends Controller
{
    public function index()
    {
        $kontaks = Kontak::active()->ordered()->get();
        return view('contact', compact('kontaks'));
    }
}

