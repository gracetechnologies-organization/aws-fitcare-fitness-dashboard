<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */
    // 

    /*
    |--------------------------------------------------------------------------
    | Built-In Helpers
    |--------------------------------------------------------------------------
    */
    // 

    /*
    |--------------------------------------------------------------------------
    | Custom Helpers
    |--------------------------------------------------------------------------
    */
    public static function verifyInfo(string $email, int $otp)
    {
        return self::where('email', $email)->where('otp', $otp)->exists();
    }

    public static function insertOrUpdateInfo(string $email, int $otp)
    {
        return self::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp]
        );
    }

    public static function deleteInfoByEmail(string $email)
    {
        return self::where('email', $email)->delete();
    }
}
