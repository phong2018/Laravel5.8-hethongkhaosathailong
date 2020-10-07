<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
     //
    public $timestamps = false;

    protected $table = 'ks_survey';
    protected $primaryKey = 'survey_id';
    public function Topic()
    {
        return $this->hasOne('App\Topic','topic_id','survey_idTopic');
    }
    //--------
    public function Object_us()
    {
        return $this->hasOne('App\User','id','survey_idObject');
    }
    //--------
    public function Object_org()
    {
        return $this->hasOne('App\Organization','org_id','survey_idObject');
    }

}
