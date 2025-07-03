<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        // Load posts with relationships and limit comments to 5 initially
        $posts = Post::with([
            'user', 
            'likes', 
            'comments' => function($query) {
                $query->with('user')->orderBy('created_at', 'desc')->limit(5);
            }
        ])->orderBy('created_at', 'desc')->get();
        
        // Add like count, comment count, and is_liked for each post
        foreach ($posts as $post) {
            $post->like_count = $post->getLikeCount();
            $post->is_liked = $post->isLikedBy(Auth::user()->id_user);
            $post->comment_count = $post->getCommentCount();
            $post->has_more_comments = $post->getCommentCount() > 5;
        }
        
        return view('users.pages.home', [
            'posts' => $posts
        ]);
    }
}
