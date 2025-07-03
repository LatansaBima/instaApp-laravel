<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $guarded = ['post_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_post', 'id_post');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id_post');
    }

    // Method to check if user liked this post
    public function isLikedBy($userId)
    {
        return $this->likes()->where('id_user', $userId)->exists();
    }

    // Method to get like count
    public function getLikeCount()
    {
        return $this->likes()->count();
    }

    // Method to get comment count
    public function getCommentCount()
    {
        return $this->comments()->count();
    }
}
