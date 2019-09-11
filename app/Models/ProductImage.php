<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'pic'
    ];
    protected $table='product_images';
    public $timestamp=true;
}
