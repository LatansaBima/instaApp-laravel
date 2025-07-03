<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get posts only from the authenticated user
        $posts = Post::where('id_user', $user->id_user)
            ->with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Add like count, comment count, and is_liked for each post
        foreach ($posts as $post) {
            $post->like_count = $post->getLikeCount();
            $post->is_liked = $post->isLikedBy($user->id_user);
            $post->comment_count = $post->getCommentCount();
        }
        
        return view('users.pages.profile', [
            'user' => $user,
            'posts' => $posts,
            'isOwnProfile' => true
        ]);
    }
    
    /**
     * Show profile of a specific user
     */
    public function show($userId)
    {
        $profileUser = User::where('id_user', $userId)->firstOrFail();
        $currentUser = Auth::user();
        
        // Get posts from the specific user
        $posts = Post::where('id_user', $userId)
            ->with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Add like count, comment count, and is_liked for each post
        foreach ($posts as $post) {
            $post->like_count = $post->getLikeCount();
            $post->is_liked = $post->isLikedBy($currentUser->id_user);
            $post->comment_count = $post->getCommentCount();
        }
        
        return view('users.pages.profile', [
            'user' => $profileUser,
            'posts' => $posts,
            'isOwnProfile' => $currentUser->id_user == $userId
        ]);
    }
}
