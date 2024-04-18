<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'age',
        'interests',
        'teams',
        'is_active',
        'city_id',
        'is_admin',
        'is_taxi_driver',
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
    ];

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function points()
    {
        return $this->hasOne(Point::class);
    }

    public function pointsHistory()
    {
        return $this->hasMany(PointsHistory::class);
    }

    public function prizes()
    {
        return $this->belongsToMany(Prize::class, 'user_prizes');
    }
}
