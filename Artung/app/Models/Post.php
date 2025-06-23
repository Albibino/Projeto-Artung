<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_id',
        'tag1_id',
        'tag2_id',
        'tag3_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userDeletePost()
     {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function tag1() { return $this->belongsTo(Tag::class, 'tag1_id'); }
    public function tag2() { return $this->belongsTo(Tag::class, 'tag2_id'); }
    public function tag3() { return $this->belongsTo(Tag::class, 'tag3_id'); }
}
