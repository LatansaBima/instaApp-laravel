<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('users.pages.profile', [
            'posts' => $posts
        ]);
    }
}
