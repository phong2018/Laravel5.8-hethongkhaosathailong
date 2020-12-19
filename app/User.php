<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    public $timestamps = false;

    public function Role()
    {
        return $this->hasOne('App\Role','ID_Role','ID_Role');
    }
    public function Position()
    {
        return $this->hasOne('App\Position','ID_Pos','ID_Position');
    }

    public function assignss()
    {
        return $this->hasMany('App\Assigns', 'id' , 'ID_Employee');
    }

    public function appointment()
    {
        return $this->hasMany('App\TaskAppointment', 'id', 'ID_Staff');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'ID_Staff', 'fullname', 'DoB', 'sex', 'phone', 'zalo_id', 'address', 'avatar', 'ID_Position', 'ID_Role', 'isActived', 'user_15', 'user_16', 'user_17', 'user_18', 'user_19',
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
}
