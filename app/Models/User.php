<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Fillable attributes
    protected $fillable = ['username', 'email', 'password', 'role'];

    // Hidden attributes (for security reasons)
    protected $hidden = [
        'password',
        'remember_token',  // Add remember_token to hidden attributes
    ];

    // Cast attributes to appropriate data types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            if (isset($user->password) && !password_get_info($user->password)['algo']) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
