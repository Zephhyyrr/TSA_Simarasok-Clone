<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alias',
        // 'roles',
        'status',
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
    ];
    public function getAlias($nama)
    {
        $words = explode(' ', $nama);
        $alias = '';

        foreach ($words as $word) {
            if (strlen($word) >= 2) {
                $alias .= substr($word, 0, 1);
            } else {
                $alias .= substr($word, 0);
            }
        }
        return $alias;
    }
    public function sendPasswordResetNotification($token): void
    {
        // $url = 'http://127.0.0.1:8000/password.reset?token='.$token;

        // $this->notify(new ResetPasswordNotification($url));

        $url = URL::signedRoute(
            'password.reset',
            ['token' => $token, 'email' => $this->getEmailForPasswordReset()]
        );

        $this->notify(new ResetPasswordNotification($url));
    }
}
