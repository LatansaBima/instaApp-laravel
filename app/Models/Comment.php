<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $fillable = ['user_id', 'post_id', 'comment'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id_post');
    }
}
