<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.pages.post');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10280',
                'text' => 'required|max:500'
            ]);

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('post', $imageName);

            Post::create([
                'id_user' => Auth::user()->id_user,
                'image' => $imageName,
                'text' => $request->text
            ]);

            return redirect()->back()->with('success', 'Post berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Gagal membuat post: ' . implode(', ', $e->validator->errors()->all()))->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Handle the like action.
     */
    public function like(Request $request, $postId)
    {
        $userId = Auth::user()->id_user; // Using id_user from users table

        // Check if the user already liked the post
        $existingLike = Like::where('id_user', $userId)->where('id_post', $postId)->first();

        if ($existingLike) {
            return response()->json(['message' => 'Already liked'], 400);
        }

        // Create a new like
        Like::create([
            'id_user' => $userId,
            'id_post' => $postId,
        ]);

        // Get updated like count
        $likeCount = Like::where('id_post', $postId)->count();

        return response()->json([
            'message' => 'Liked successfully',
            'like_count' => $likeCount,
            'is_liked' => true
        ]);
    }

    /**
     * Handle the unlike action.
     */
    public function unlike(Request $request, $postId)
    {
        $userId = Auth::user()->id_user; // Using id_user from users table

        // Check if the user already liked the post
        $existingLike = Like::where('id_user', $userId)->where('id_post', $postId)->first();

        if (!$existingLike) {
            return response()->json(['message' => 'Not liked yet'], 400);
        }

        // Delete the like
        $existingLike->delete();

        // Get updated like count
        $likeCount = Like::where('id_post', $postId)->count();

        return response()->json([
            'message' => 'Unliked successfully',
            'like_count' => $likeCount,
            'is_liked' => false
        ]);
    }

    /**
     * Store a comment for a specific post.
     */
    public function storeComment(Request $request, $postId)
    {
        try {
            $request->validate([
                'comment' => 'required|string|max:500'
            ]);

            $comment = Comment::create([
                'user_id' => Auth::user()->id_user, // Using id_user from users table
                'post_id' => $postId,
                'comment' => $request->comment
            ]);

            // Load the user relationship
            $comment->load('user');

            // Get updated comment count
            $commentCount = Comment::where('post_id', $postId)->count();

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment->comment_id,
                    'comment' => $comment->comment,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans()
                ],
                'comment_count' => $commentCount
            ], 200);
        } catch (\Exception $e) {
            Log::error('Comment creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding comment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get comments for a specific post with pagination.
     */
    public function getComments($postId, Request $request)
    {
        try {
            $offset = $request->get('offset', 0);
            $limit = $request->get('limit', 10);
            
            $comments = Comment::where('post_id', $postId)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $formattedComments = $comments->map(function ($comment) {
                return [
                    'id' => $comment->comment_id,
                    'comment' => $comment->comment,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans()
                ];
            });

            $totalComments = Comment::where('post_id', $postId)->count();
            $hasMore = ($offset + $limit) < $totalComments;

            return response()->json([
                'success' => true,
                'comments' => $formattedComments,
                'has_more' => $hasMore,
                'total' => $totalComments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching comments: ' . $e->getMessage()
            ], 500);
        }
    }
}
