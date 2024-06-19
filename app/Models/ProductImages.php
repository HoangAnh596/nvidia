<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImages extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'image',
        'title',
        'alt',
        'product_id',
        'stt_img'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
