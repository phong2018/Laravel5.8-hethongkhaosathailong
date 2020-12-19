<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
   //
    public $timestamps = false;

    protected $table = 'ks_answer';
    protected $primaryKey = 'answer_id';
}
