<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CateFooter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cate_footer';
    
    protected $dates = ['deleted_at'];

    const IS_CLICK = 1;
    const IS_NOT_CLICK = 0;
    const IS_TAB = 1;
    const IS_NOT_TAB = 0;
    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    protected $fillable = [
        'name', 'parent_menu',
        'image', 'url', 'stt_menu',
        'is_click', 'is_tab', 'is_public'
    ];

    public function children()
    {

        return $this->hasMany(CateFooter::class, 'parent_menu')->with('children');
    }

    public function parent()
    {

        return $this->belongsTo(CateFooter::class, 'parent_menu')->with('parent');
    }
}
