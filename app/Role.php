<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public $timestamps = false;
	
    protected $table = 'role';
    protected $primaryKey = 'ID_Role';

    public function menurole_func()
    {
        return $this->hasMany('App\Menurole','ID_Role', 'ID_Role');
    }

    protected $fillable = [
        'ID_Role', 'role_name', 'role_active', 'role_4', 'role_5', 'role_6', 'role_7', 'role_8',
    ];
}
