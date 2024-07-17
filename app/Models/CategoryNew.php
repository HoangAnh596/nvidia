<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryNew extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_news';
    
    protected $dates = ['deleted_at'];

    const IS_SERVE = 1;
    const IS_NOT_SERVE = 0;
    const IS_TOP_PARENT = 1;
    const IS_NOT_PARENT = 0;
    const IS_MENU = 1;
    const IS_NOT_MENU = 0;
    const IS_TOP_OUTSTAND = 1;
    const IS_NOT_OUTSTAND = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'slug', 'image','title_img', 'alt_img',
        'related_pro', 'content', 'parent_id',
        'title_seo', 'keyword_seo', 'des_seo', 'stt_new',
        'is_serve', 'is_parent', 'is_menu', 'is_outstand', 'is_public'
    ];

    public function children()
    {
        return $this->hasMany(CategoryNew::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(CategoryNew::class, 'parent_id')->with('parent');
    }

    public function getRelatedPro()
    {
        $relatedIds = json_decode($this->related_pro);
        return Product::whereIn('id', $relatedIds)->get();
    }

    public function newProducts()
    {
        return $this->hasMany(Product::class, 'id', 'related_pro');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'id', 'cate_id');
    }
    // Lấy tất cả các bậc cha
    public function getAllParents()
    {
        $parents = collect();
        $parent = $this->parent;
        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }
}
