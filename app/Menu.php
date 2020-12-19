<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    public $timestamps = false;
	
    protected $table = 'ks_menu';
    protected $primaryKey = 'ID_Menu';
}
