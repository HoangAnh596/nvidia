<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

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
        'name', 'slug', 'parent_id', 'filter_ids',
        'image', 'title_img', 'alt_img', 'content',
        'title_seo', 'keyword_seo', 'des_seo', 'stt_cate', 'is_home',
        'is_serve', 'is_parent', 'is_menu', 'is_outstand', 'is_public'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_categories', 'category_id', 'product_id');
    }

    public function children()
    {

        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function parent()
    {

        return $this->belongsTo(Category::class, 'parent_id')->with('parent');
    }

    public function getAllChildrenIds()
    {
        $childrenIds = $this->children()->pluck('id')->toArray();

        foreach ($this->children as $child) {
            $childrenIds = array_merge($childrenIds, $child->getAllChildrenIds());
        }

        return $childrenIds;
    }
    // Lấy ra id của cha có parent_id = 0
    public function topLevelParent()
    {
        $category = $this;
        while ($category->parent_id != 0) {
            $category = $category->parent;
        }
        return $category;
    }

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
    
    // Thiết lập mối quan hệ với FilterCate
    public function filters()
    {
        return $this->hasMany(FilterCate::class, 'cate_id', 'id');
    }

    public function getFilterCates()
    {
        if (!empty($this->filter_ids)) {
            $filId = json_decode($this->filter_ids);
            return FilterCate::select('id', 'name', 'slug', 'cate_id', 'top_filter', 'special')->whereIn('id', $filId)
                ->where('is_public', 1)
                ->orderBy('stt_filter', 'ASC')->get();
        }
    }
}
