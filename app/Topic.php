<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    public $timestamps = false;

    protected $table = 'ks_topic';
    protected $primaryKey = 'topic_id';
}
