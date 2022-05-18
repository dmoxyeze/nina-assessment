<?php

namespace App\Models;

use App\Models\Scopes\ActiveUsersScope;
use App\Models\Scopes\UsersWithCourseScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const DEFAULT_STATUS = 'active';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'sex',
        'location',
        'status',
        'relationship_status',
    ];

    /**
     * Default value for some model fields
     * 
     */
    protected $attributes = [
        'status' => self::DEFAULT_STATUS,
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

    protected static function booted()
    {
        static::addGlobalScope(new ActiveUsersScope);
        static::addGlobalScope(new UsersWithCourseScope);
    }

    public function scopeAmericans($query) {
        return $query->whereLocation('America');
    }

    public function scopeOfSex($query, $sex)
    {
        return $query->whereSex($sex);
    }

    public function courses() {
        return $this->hasMany(Course::class);
    }
}
