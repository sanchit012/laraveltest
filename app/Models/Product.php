<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price	'
    ];
    protected $table='products';
    public $timestamp=true;

    public function color(){
      return $this->hasMany(\App\Models\ProductColor::class, 'product_id','id');
    }

    public function size(){
      return $this->hasMany(\App\Models\ProductSize::class, 'product_id','id');
    }

    public function image(){
      return $this->hasMany(\App\Models\ProductImage::class, 'product_id','id');
    }
}
