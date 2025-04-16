<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function clubs(): View|Application
    {
        $clubs = Club::all();
        return view('clubs', compact('clubs'));
    }
}
