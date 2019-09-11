<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [
        'product_id',
        'color_id'
    ];
    protected $table='product_color';
    public $timestamp=true;

    public function color(){
      return $this->belongsTo(\App\Models\Color::class, 'color_id','id');
    }
}
