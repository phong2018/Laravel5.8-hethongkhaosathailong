<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    public $timestamps = false;
	
    protected $table = 'ks_schedule';
    protected $primaryKey = 'schedule_id';
    public function Org()
    {
    
        return $this->hasOne('App\Organization','org_id','schedule_idOrg');

    }

}
