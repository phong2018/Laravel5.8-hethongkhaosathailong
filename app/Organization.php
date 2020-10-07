<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    //
    public $timestamps = false;
	
    protected $table = 'ks_organization';
    protected $primaryKey = 'org_id';

    public function Assigned()
    {
        return $this->hasOne('App\User','id','org_idAssigned');
    }
}
