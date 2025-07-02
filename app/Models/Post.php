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
        return $this->hasMany(Like::class, 'id_post');
    }
}
