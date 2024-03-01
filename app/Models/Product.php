<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'category',
        'price',
        'quantity',
        'status',
        'product_category_id',
        'counter'
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getParentCategoryName()
    {
        if ($this->product_category && $this->product_category->parent) {
            return $this->product_category->parent->name;
        } else {
            return null; // Or handle it as per your requirement
        }
    }

    public function getFirstChildCategoryName()
    {
        if ($this->product_category && $this->product_category->children->isNotEmpty()) {
            return $this->product_category->children->first()->name;
        } else {
            return null; // Or handle it as per your requirement
        }
    }

}
