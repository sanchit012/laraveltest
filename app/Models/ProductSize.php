<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = [
        'product_id',
        'size_id'
    ];
    protected $table='product_size';
    public $timestamp=true;

    public function size(){
      return $this->belongsTo(\App\Models\Size::class, 'size_id','id');
    }
}
