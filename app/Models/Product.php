<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str facade for slug generation

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // This is the vendor's user_id
        'name',
        'slug',
        'description',
        'image',
        'price',
        'sale_price',
        'stock_quantity',
        'is_approved',
    ];

    // A product belongs to a user (who is a vendor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutator to automatically generate slug from product name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}