<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /*
    |--------------------------------------------------------------------------
    | Built-In Helpers
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    /*
    |--------------------------------------------------------------------------
    | Custom Helpers
    |--------------------------------------------------------------------------
    */
    public static function insertInfo(string $name, string $email, string $password, string $role_id)
    {
        return self::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role_id
        ]);
    }

    public static function updatePassword(int $id, string $password)
    {
        return self::where('id', $id)->update(['password' => Hash::make($password)]);
    }

    public static function getInfoByEmail(string $email)
    {
        return self::where('email', $email)->first();
    }

    public static function getEmployees(string $search)
    {
        return self::where('role_id', 'emp')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    }

    public static function delEmployee(int $employee_id)
    {
        return self::where('id', $employee_id)
            ->where('role_id', 2)
            ->delete();
    }

    public static function totalEmployees()
    {
        return self::where('role_id', 'emp')->count();
    }

    public static function activeOrBlockEmployee(int $employee_id, string $email_verified_at)
    {
        $verification_date = (empty($email_verified_at)) ? Carbon::now() : null;
        return self::where('id', $employee_id)
            ->update(['email_verified_at' => $verification_date]);
    }
}
