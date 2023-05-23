<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuVuc extends Model
{
    use HasFactory;
    protected $table = 'khu_vucs';
    protected $fillable = [
        'ten_khu_vuc',
        'slug_khu_vuc',
        'tinh_trang',
    ];
}
