<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dontallowaccess(){
        //echo $path;
        //$echo $status;
        return view('admin.layouts.dontallowaccess');
    }
}
