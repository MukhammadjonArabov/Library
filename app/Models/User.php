<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 🔹 Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',     
        'address',  
        'role_id',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
