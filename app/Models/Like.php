<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'like_id';
    protected $fillable = ['id_user', 'id_post'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
}
