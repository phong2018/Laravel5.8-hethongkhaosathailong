<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\TestExport;
use App\User;

class ExcelController extends Controller
{
    public function test(){ 
        //---------
        $sheet_col='N';/*cột excel cuối*/
        $sheet_data= User::where("id",">", 7)->get();
        $sheet_header=[['DANH SÁCH NHÂN VIÊN1',],
                       ['#','fullname','Email','Created at','Updated at']];
        //---------
        $tex=new TestExport;
        $tex->sheet_col=$sheet_col;
        $tex->sheet_data=$sheet_data;
        $tex->sheet_header=$sheet_header;
    	return Excel::download($tex, 'test.xlsx');
    }
}

