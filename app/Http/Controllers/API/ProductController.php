<?php
 
namespace App\Http\Controllers\API;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

 

use Illuminate\Support\Facades\Auth;

use Validator;

 
class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            
        ]);
    }
 
    public function show($id)
    {
        return response()->json([
            'success' => true,
            
        ]);
    }
 
    public function store(Request $request)
    {
        return response()->json([
            'success  store' => true,
            
        ]);
    }
 
    public function update(Request $request, $id)
    {
        return response()->json([
            'success' => true,
            
        ]);
    }
 
    public function destroy($id)
    {
        return response()->json([
            'success' => true,
            
        ]);
    }
}