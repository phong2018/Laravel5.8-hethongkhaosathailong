<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assigns extends Model
{
    public $timestamps = false;
	
    protected $table = 'assign';
    protected $primaryKey = 'ID_Assign';

    public function employeess()
    {
    	return $this->belongsTo('App\User', 'ID_Employee', 'id');
    }
    public function proceduress()
    {
    	return $this->belongsTo('App\Procedures', 'ID_Procedure', 'ID_Procedure');
    }

    protected $fillable = [
        'ID_Assign', 'ID_Employee', 'ID_Procedure', 'duration', 'active', 'assign_6', 'assign_7', 'assign_8', 'assign_9', 'assign_10'
    ];
}
