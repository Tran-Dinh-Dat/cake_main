<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'sku',
        'description',
        'content',
        'price',
        'discount',
        'quantity',
        'views'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_product');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
