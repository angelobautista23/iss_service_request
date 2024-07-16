<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Model\BranchUser;
use App\Model\UserStation;
use App\Model\UserSeries;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mysql';
    protected $table = 'sr_users';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branch_user_details() {
        return $this->hasMany(BranchUser::class, 'user_id', 'id');
    }

    public function user_station_details() {
        return $this->hasMany(UserStation::class, 'user_id', 'id');
    }

    public function user_series_details() {
        return $this->hasMany(UserSeries::class, 'user_id', 'id');
    }
}
