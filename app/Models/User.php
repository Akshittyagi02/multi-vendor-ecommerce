<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // <--- Add this line
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // <--- Cast to boolean
    ];

    // Define the relationship for a user potentially being a vendor
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    // Define the relationship for products created by this user (if they are a vendor)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Check if the user is an admin.
     * This method combines role check with the new 'is_admin' flag.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin || $this->hasRole('admin');
    }
}
