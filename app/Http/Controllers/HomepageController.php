<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    public function index()
    {
        // $posts = DB::table('posts')->join('users', 'posts.id_user', '=', 'users.id_user')->get();\
        
        $posts = Post::with('user', 'likes')->get();
        return view('users.pages.home', [
            'posts' => $posts
        ]);
    }
}
