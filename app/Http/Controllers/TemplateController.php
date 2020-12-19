<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Setting; 

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title']='Mẫu Chức năng';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/temp"),
        );
        //'data'=>$data,

        //echo 'HELO';
        $temps = Template::orderBy('template.temp_order', 'asc')->paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);
        return view('admin.temp.list',['data'=>$data,'temps' =>$temps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        //
        $data['title']='Thêm Mẫu Chức năng';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/temp/create"),
        );
        //'data'=>$data,

        return view('admin.temp.add',['data'=>$data]);


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

        $temp = new Template;
        $temp->temp_name = $request->temp_name;
        $temp->temp_order = $request->temp_order;
        $temp->temp_parameter = $request->temp_parameter;
        $temp->temp_note =$request->temp_note;
        $temp->created_at=date("Y-m-d H:i:s");
        $temp->updated_at=date("Y-m-d H:i:s");
        $temp->save();
        //---------
        $filename='/views/admin/temp/temp'.$temp->id_template.'.blade.php';
        $temp->temp_path=$filename;
        $temp->temp_bladeview='admin.temp.temp'.$temp->id_template;
        $temp->save();
        //---------
        $filename=resource_path().$filename;
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        if($request->content=='') $content=' ';
        else $content=$request->content;
        fwrite($myfile, $content);
        fclose($myfile);

        //cập nhật đường dẫn $temp->temp_path 
        return redirect('admin/temp')->with('messenger', 'Thêm mới MẫuThành Công');
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
        $temp=Template::find($id); 
        $data=array();
        $filename=resource_path().$temp->temp_path;
     //   $filename=resource_path().'/views/admin/temp/temp6.blade.php';
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $data['content']=fread($myfile,filesize($filename));


         //
        $data['title']='Sửa Mẫu Chức năng';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/temp/".$id."/edit"),
        );
        //'data'=>$data,


        if( $temp)
        return view('admin.temp.edit',['temp'=>$temp,'data'=>$data]);
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
        $temp =Template::find($id);
        $temp->temp_name = $request->temp_name;
        $temp->temp_order = $request->temp_order;
        $temp->temp_parameter = $request->temp_parameter;
        $temp->temp_note =$request->temp_note;
        $temp->updated_at=date("Y-m-d H:i:s");
        $temp->save();
        //---------
        $filename=resource_path().'/views/admin/temp/temp'.$temp->id_template.'.blade.php';
       // $filename=resource_path().'/views/admin/temp/temp6.blade.php';
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        if($request->content=='') $content=' ';
        else $content=$request->content;

        fwrite($myfile, $content);
        fclose($myfile);

        //cập nhật đường dẫn $temp->temp_path 
        return redirect('admin/temp')->with('messenger', 'Cập nhật Mẫu Thành Công');
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
    public function templatedelete($id)
    {
        $temp =Template::find($id);
        $filename=resource_path().'/views/admin/temp/temp'.$temp->id_template.'.blade.php';
        unlink($filename);

        $step = Template::where('id_template',$id)->delete();
        return redirect('admin/temp');
    }
}
