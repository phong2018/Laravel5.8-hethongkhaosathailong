<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	public $timestamps = false;
	
    protected $table = 'position';
    protected $primaryKey = 'ID_Pos';

    

    protected $fillable = [
        'ID_Pos', 'pos_name', 'pos_note', 'pos_short', 'pos_4', 'pos_5', 'role_6', 'pos_7', 'pos_8',
    ];
}
