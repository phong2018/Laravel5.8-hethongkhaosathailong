<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Setting; 
use App\User; 

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $pos = Position::paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);
          $data['title']='Chức vụ';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/position"),
        );
        //'data'=>$data,   


        return view('admin.position.listpos',['data'=>$data,'position'=>$pos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
            $data['title']='Tạo Chức vụ';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/position/create"),
        );
        //'data'=>$data,   


        return view('admin.position.add',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        isset($request->pos_4) ? $pos_4 = $request->pos_4 : $pos_4 = 'null';
        isset($request->pos_5) ? $pos_5 = $request->pos_5 : $pos_5 = 'null';
        isset($request->pos_6) ? $pos_6 = $request->pos_6 : $pos_6 = 'null';
        isset($request->pos_7) ? $pos_7 = $request->pos_7 : $pos_7 = 'null';
        isset($request->pos_8) ? $pos_8 = $request->pos_8 : $pos_8 = 'null';

        $pos = new Position;
        $pos->pos_name = $request->pos_name;
        $pos->pos_note = 1;
        $pos->pos_short = $request->pos_short;
        $pos->pos_4 = $pos_4;
        $pos->pos_5 = $pos_5;
        $pos->pos_6 = $pos_6;
        $pos->pos_7 = $pos_7;
        $pos->pos_8 = $pos_8;
        $pos->save();
        return redirect('admin/position')->with('messenger', 'Thêm mới chức vụ Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $position=Position::find($id); 

        $data['title']='Sửa Chức vụ';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/position/".$id."/edit"),
        );
        //'data'=>$data,   


        if( $position)
        return view('admin.position.edit',['data'=>$data, 'position'=>$position]);
        else  return abort(404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        isset($request->pos_4) ? $pos_4 = $request->pos_4 : $pos_4 = 'null';
        isset($request->pos_5) ? $pos_5 = $request->pos_5 : $pos_5 = 'null';
        isset($request->pos_6) ? $pos_6 = $request->pos_6 : $pos_6 = 'null';
        isset($request->pos_7) ? $pos_7 = $request->pos_7 : $pos_7 = 'null';
        isset($request->pos_8) ? $pos_8 = $request->pos_8 : $pos_8 = 'null';

        $pos = Position::find($id);   

        $pos->pos_name = $request->pos_name;
        $pos->pos_note = 1;
        $pos->pos_short = $request->pos_short;
        $pos->pos_4 = $pos_4;
        $pos->pos_5 = $pos_5;
        $pos->pos_6 = $pos_6;
        $pos->pos_7 = $pos_7;
        $pos->pos_8 = $pos_8;
        $pos->save();
        return redirect('admin/position')->with('messenger', 'Cập nhật chức vụ Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function Positiondelete($id){
        $pos = Position::find($id);

        $us=User:: where('ID_Position', $id)->get();
        
        if(count($us)==0){
              $pos->delete();
              return redirect('admin/position')->with('messenger', 'Xóa chức vụ thành công!');
        }
        else
        return redirect('admin/position')->with('messenger', 'Chức vụ này đang được sử dụng. Không xóa được!');
         

    }
    public function PositionAjaxChangeActive(){
        $position = position::find($id);

        if ($position->position_active == 1) {
            $position->position_active = 0;
        }else{
            $position->position_active = 1;
        }

        $json=array();

 
        if($position->save()){
             $json['success']='Success';
        } 
        else{
            $json['error']='Error';
        }

        
        $json=array();
        $json['success']='Success';
        return response()->json($json);
    }
}
