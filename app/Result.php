<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //
    public $timestamps = false;
	
    protected $table = 'ks_result';
    protected $primaryKey = 'result_id';
}
