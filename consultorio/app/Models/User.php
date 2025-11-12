<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'rol',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed' is supported on newer Laravel versions; keep if using it.
    ];

    /**
     * Get the user's initials (from nombre + apellido).
     */
    public function initials(): string
    {
        $first = Str::of($this->nombre)->substr(0, 1)->upper();
        $second = Str::of($this->apellido)->substr(0, 1)->upper();

        if ($first->isEmpty() && $second->isEmpty()) {
            // fallback to email
            return Str::of($this->email)->substr(0, 1)->upper();
        }

        return $first . $second;
    }
}
