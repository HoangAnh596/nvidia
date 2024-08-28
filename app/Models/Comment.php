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
        'slugProduct',
    ];

    public function cmtProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    public function getAllChildrenIds()
    {
        $childrenIds = $this->replies()->pluck('id')->toArray();

        foreach ($this->replies as $child) {
            $childrenIds = array_merge($childrenIds, $child->getAllChildrenIds());
        }

        return $childrenIds;
    }
}
