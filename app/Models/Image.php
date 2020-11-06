<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
