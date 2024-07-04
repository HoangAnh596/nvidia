<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

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
        'name', 'slug', 'parent_id', 'filter_ids',
        'image', 'title_img', 'alt_img', 'content',
        'title_seo', 'keyword_seo', 'des_seo', 'stt_cate',
        'is_serve', 'is_parent', 'is_menu', 'is_outstand', 'is_public'
    ];

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

    public function topLevelParent()
    {
        $category = $this;
        while ($category->parent_id != 0) {
            $category = $category->parent;
        }
        return $category;
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
            return FilterCate::whereIn('id', $filId)->orderBy('stt_filter', 'ASC')->get();
        }
    }
}
