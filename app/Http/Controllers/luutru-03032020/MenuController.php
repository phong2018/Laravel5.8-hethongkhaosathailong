<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\MenuRole;
use App\Setting; 

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $menu = Menu::orderBy('menu_show', 'DESC')->orderBy('menu_level', 'ASC')->orderBy('menu_order', 'ASC')->paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);

        $data['title']='Menu & Quyền truy cập';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/menu"),
        );
        //'data'=>$data, 

        
        return view('admin.menu.listmenu',['data'=>$data,'menu'=>$menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*menu thư mục mới làm cha được*/
        $menus = Menu::orderBy('menu_order')->where('menu_route','=','')
               ->get();

         $data['title']='Thêm Menu & Quyền truy cập';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/menu/create"),
        );
        //'data'=>$data, 

        return view('admin.menu.addmenu',['data'=>$data, 'menus'=>$menus]);
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
        isset($request->menu_6)? $menu_6 = $request->menu_6 : $menu_6 =1;
        isset($request->menu_7)? $menu_7 = $request->menu_7 : $menu_7 =1;
        isset($request->menu_8)? $menu_8 = $request->menu_8 : $menu_8 =1;
        isset($request->menu_9)? $menu_9 = $request->menu_9 : $menu_9 =1;
        isset($request->menu_10)? $menu_10 = $request->menu_10 : $menu_10 =1;
        
        $menu = new Menu;

        $menu->menu_name = $request->menu_name;
        $menu->menu_note = $request->menu_note;
        if(!isset($request->menu_route))$menu->menu_route ='';
        else $menu->menu_route = $request->menu_route;
        $menu->menu_order = $request->menu_order;
        $menu->menu_parent = $request->menu_parent;
        $menu->menu_active = $request->isactive;
        $menu->menu_show = $request->menu_show;
        if($request->menu_parent==0)$menu->menu_level=1;
        else{
             $menuparent = Menu::where('ID_Menu',$request->menu_parent)
               ->get()->first();
             $menu->menu_level=$menuparent->menu_level+1;
        }



        $menu->menu_position = 1;
        $menu->menu_6 = $menu_6;
        $menu->menu_7 = $menu_7;
        $menu->menu_8 = $menu_8;
        $menu->menu_9 = $menu_9;
        $menu->menu_10 = $menu_10;
      
        $menu->save();
        return redirect('admin/menu')->with('messenger', 'Thêm mới Menu Thành Công');
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
        $menu=Menu::find($id); 


        /*menu thư mục mới làm cha được*/
        $menus= Menu::orderBy('menu_order')->where('menu_route','=','')
               ->get();

         $data['title']='Sửa Menu & Quyền truy cập';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/menu/".$id."/edit"),
        );
        //'data'=>$data, 


        return view('admin.menu.editmenu',['data'=>$data, 'menus'=>$menus,'menu'=>$menu]);
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
        isset($request->menu_6)? $menu_6 = $request->menu_6 : $menu_6 =1;
        isset($request->menu_7)? $menu_7 = $request->menu_7 : $menu_7 =1;
        isset($request->menu_8)? $menu_8 = $request->menu_8 : $menu_8 =1;
        isset($request->menu_9)? $menu_9 = $request->menu_9 : $menu_9 =1;
        isset($request->menu_10)? $menu_10 = $request->menu_10 : $menu_10 =1;
        
        $menu = Menu::find($id);   

        $menu->menu_name = $request->menu_name;
        $menu->menu_note = $request->menu_note;
        if(!isset($request->menu_route))$menu->menu_route ='';
        else $menu->menu_route = $request->menu_route;
        $menu->menu_order = $request->menu_order;
        $menu->menu_parent = $request->menu_parent;
        $menu->menu_active = $request->isactive;
        $menu->menu_show = $request->menu_show;
        if($request->menu_parent==0)$menu->menu_level=1;
        else{
             $menuparent = Menu::where('ID_Menu',$request->menu_parent)
               ->get()->first();
             $menu->menu_level=$menuparent->menu_level+1;
        }

        $menu->menu_position = 1;
        $menu->menu_6 = $menu_6;
        $menu->menu_7 = $menu_7;
        $menu->menu_8 = $menu_8;
        $menu->menu_9 = $menu_9;
        $menu->menu_10 = $menu_10;
      
        $menu->save();
        return redirect('admin/menu')->with('messenger', 'Cập nhật Menu Thành Công');

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
    public function Menudelete($id){
        
        /*xóa trong menu_role nữa*/     
         $res=MenuRole::where('ID_Menu',$id)->delete();

        /*cập nhật các thằng con cho nó*/
        $chirlds=Menu::where('menu_parent',$id)
               ->get();
        foreach($chirlds as $val){
            $menu=Menu::find($val['ID_Menu']); 
            $menu->menu_parent=0;
            $menu->menu_menu_level=1;
            $menu->save();
        }
        /*----*/
        $menu = Menu::find($id);
        $menu->delete();
        return redirect('admin/menu');

    }
    public function MenuAjaxChangeActive(){

    }
}
