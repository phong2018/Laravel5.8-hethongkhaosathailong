<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public $timestamps = false;

    protected $table = 'ks_question';
    protected $primaryKey = 'question_id';
    public function Topic()
    {
        return $this->hasOne('App\Topic','topic_id','question_idTopic');
    }
}
