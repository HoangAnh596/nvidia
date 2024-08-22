<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infor extends Model
{
    use HasFactory;

    protected $table = 'infors';

    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;
    const IS_KT = 1;
    const IS_KD = 0;

    protected $fillable = [
        'name', 'role', 'phone',
        'skype', 'zalo', 'gmail',
        'stt', 'is_public', 'send_price'
    ];
    
}
