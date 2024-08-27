<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'name', 'product_id', 'user_id',
        'parent_id', 'email', 'phone',
        'content', 'star', 'is_public',
    ];

    public function cmtProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }
}
