<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    public $timestamps = false;

    protected $table = 'ks_menu_role';
    protected $primaryKey = 'ID_Menurole';

    public function roless()
    {
        return $this->belongsTo('App\Role', 'ID_Role', 'ID_Role');
    }
    public function menuss()
    {
        return $this->belongsTo('App\Menus', 'ID_Menu', 'ID_Menu');
    }

    protected $fillable = [
        'ID_Menurole', 'ID_Menu', 'ID_Role', 'menurole_actived', 'menurole_4', 'menurole_5', 'menurole_6', 'menurole_7', 'menurole_8',
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
