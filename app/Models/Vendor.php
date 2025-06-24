<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_slug',
        'shop_description',
        'shop_phone',
        'shop_address',
        'shop_banner',
        'commission_rate',
        'is_approved',
    ];

    // A vendor belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A vendor has many products
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id'); // Link products via user_id
    }
}