<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','slug', 'cate_id',
        'image', 'slugParent',
        'desc', 'is_outstand', 'view_count',
        'title_img', 'alt_img', 'content',
        'title_seo', 'keyword_seo', 'des_seo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function cateNews()
    {
        return $this->belongsTo(CategoryNew::class, 'cate_id');
    }
}
