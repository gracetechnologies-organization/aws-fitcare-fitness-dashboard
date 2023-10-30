<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
        'password'
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
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function getEmployees(string $search)
    {
        return User::where('role_id', 'emp')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    }

    public static function delEmployee(int $employee_id)
    {
        return User::where('id', $employee_id)
            ->where('role_id', 2)
            ->delete();
    }

    public static function totalEmployees()
    {
        return User::where('role_id', 'emp')->count();
    }

    public static function activeOrBlockEmployee(int $employee_id, string $email_verified_at)
    {
        $verification_date = (empty($email_verified_at)) ? Carbon::now() : null;
        return User::where('id', $employee_id)
            ->update(['email_verified_at' => $verification_date]);
    }
}
