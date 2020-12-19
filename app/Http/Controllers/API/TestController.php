<?php



namespace App\Http\Controllers\API;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\User;

use Illuminate\Support\Facades\Auth;

use Validator;


class TestController extends Controller

{



    public $successStatus = 200;

 

    /**

     * details api

     *

     * @return \Illuminate\Http\Response

     */

    public function testmot()

    {
        $data=array(
            'test'=>'success'
        );
        
        return response()->json(['data' => $data], $this->successStatus);

    }

}