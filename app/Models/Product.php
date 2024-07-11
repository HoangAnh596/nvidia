<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [ 
        'name', 'code', 'slug',
        'price', 'image', 'related_pro',
        'status', 'title_img', 'alt_img',
        'title_seo', 'keyword_seo', 'des_seo',
        'maker_id', 'image_ids', 'tag_ids',
        'des', 'content', 'is_outstand'
    ];

    public function getRelatedProducts()
    {
        if (!empty($this->related_pro)) {
            $relatedIds = json_decode($this->related_pro);
            return Product::whereIn('id', $relatedIds)->get();
        }
    }

    public function getProductTags()
    {
        if (!empty($this->tag_ids)) {
            $tagId = json_decode($this->tag_ids);
            return ProductTag::whereIn('id', $tagId)->get();
        }
    }

    public function getProductImages()
    {
        if (!empty($this->image_ids)) {
            $imgId = json_decode($this->image_ids);
            return ProductImages::whereIn('id', $imgId)->get();
        }
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories', 'product_id', 'category_id');
    }

    protected $casts = [
        'images_id' => 'array',
        'tag_id' => 'array',
        'related_id' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'id', 'image_ids');
    }

    public function tags()
    {
        return $this->hasMany(ProductTag::class, 'id', 'tag_ids');
    }

    public function relatedProducts()
    {
        return $this->hasMany(Product::class, 'id', 'related_pro');
    }

    public function getImages()
    {
        return ProductImages::whereIn('id', $this->image_ids ?: [])->get();
    }

    public function getTags()
    {
        return ProductTag::whereIn('id', $this->tag_ids ?: [])->get();
    }

    public function getRelatedPro()
    {
        return Product::whereIn('id', $this->related_pro ?: [])->get();
    }
}
