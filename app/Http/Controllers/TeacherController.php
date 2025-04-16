<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function teachers(): View|Application
    {
        $teachers = User::with('clubs')->get();
        return view('teachers', compact('teachers'));
    }
}
