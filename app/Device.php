<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    public $timestamps = false;
	
    protected $table = 'ks_device';
    protected $primaryKey = 'device_id';
    public function Org()
    {
        return $this->hasOne('App\Organization',  'org_id','device_orgid');
    }
}
