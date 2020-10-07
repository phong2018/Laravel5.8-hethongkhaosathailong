<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Organization;
use App\User;
use App\Topic;
use App\Setting; 
use App\Schedule;
use Illuminate\Support\Facades\DB;


class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $data['title']='Đơn vị';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/organization"),
        );
        //'data'=>$data,  

         $data['filter_orgid']=0;

         $org = Organization::orderBy('org_order', 'ASC');

       



        if(isset($_GET['filter_orgid']) && $_GET['filter_orgid']!=0){
            //$devices= $devices->where('device_orgid',$_GET['filter_device_orgid']);
            $org =$org->where('org_id',$_GET['filter_orgid']);
            $data['filter_orgid']=$_GET['filter_orgid'];
        }  


          //lọc lại thwo cấp quản lý nếu ko phải admin
        $tempus=User::find(Auth::id());
        if($tempus->user_level>1){
           $orgt=$org->where('org_id',$tempus->user_IdOrg)->get()->first();

           if($orgt->org_level==2){
             $org=Organization::orderBy('org_order', 'ASC')->where('org_id',$orgt->org_idParent)->paginate(Setting::getconfig('config_showeverypage')); 
           }
           else{
             $org=Organization::orderBy('org_order', 'ASC')->where('org_id',$tempus->user_IdOrg)->paginate(Setting::getconfig('config_showeverypage')); 
           }
        }
        else
        $org =$org->where('org_level',1)->paginate(Setting::getconfig('config_showeverypage'));


        $org_child=array();
        foreach($org as $no=>$val){
            $org_child[$no] = Organization::orderBy('org_order', 'ASC')->where('org_idParent',$val->org_id)->get();
        }

       // $orgs= Organization::orderBy('org_order', 'ASC')->where("org_isActived",">",0)->where("org_level","=",1)->get();

       // print_r($orgs);
 

        return view('admin.organization.list',['data'=>$data,'org'=>$org,'orgs'=>$org, 'org_child'=>$org_child]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // copy topic
    public function copy($id){// id của question cần copy
        $orgt=Organization::find($id);  
        //========
        $org = new Organization;
        $org->org_name = $orgt->org_name.'-copy';
        $org->org_image= $orgt->org_image;
        $org->org_level = $orgt->org_level;
        $org->org_idCreated =Auth::id();
        $org->org_idAssigned = $orgt->org_idAssigned;
        $org->org_topic_id = $orgt->org_topic_id;
        $org->org_idParent= $orgt->org_idParent;
        $org->org_address= $orgt->org_address;
        $org->org_nhanemail= $orgt->org_nhanemail;
        $org->org_phone= $orgt->org_phone;
        $org->org_order= $orgt->org_order;
        $org->org_isSelectEmp= $orgt->org_isSelectEmp;
        $org->org_isActived= 0;
        $org->org_chudebatbuoc= $orgt->org_chudebatbuoc;
        $org->save();

        return redirect('admin/organization/'.$org->org_id.'/edit')->with('messenger', 'Copy Đơn vị Thành Công');

    }

    public function create()
    {
        //
        $data['title']='Tạo Đơn Vị';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/organization/create"),
        );
        //'data'=>$data,   
       

       $topic=DB::table('ks_topic')
           ->select('ks_topic.*')
           ->where('ks_topic.topic_idCreated','=',Auth::id()) 
           ->orwhere('ks_topic.topic_idCreated','=',1) 
           ->get();

        $tempus=User::find(Auth::id());
        $data['lvus']=$tempus->user_level;




        return view('admin.organization.add',['data'=>$data,'topic'=>$topic]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $org = new Organization;
        $org->org_name = $request->org_name;
        $org->org_image= $request->org_image;
        $org->org_level = $request->org_level;
        $org->org_idCreated =Auth::id();
        $org->org_idAssigned = $request->org_idAssigned;
        $org->org_topic_id = $request->org_topic_id;
        if($request->org_idParent=="") $org->org_idParent=0;
        else $org->org_idParent= $request->org_idParent;
        $org->org_address= $request->org_address;
        $org->org_nhanemail= $request->org_nhanemail;
        $org->org_phone= $request->org_phone;
        $org->org_order= $request->org_order;
        $org->org_isSelectEmp= $request->org_isSelectEmp;
        $org->org_isActived= $request->org_isActived;
        $org->org_chudebatbuoc= $request->org_chudebatbuoc;
        $org->save();
        return redirect('admin/organization')->with('messenger', 'Thêm mới Đơn vị Thành Công');
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

        if(Setting::getlvuser(Auth::id())>1 && Setting::getorgid_cuaOrg($id)!=Setting::getorglv1_cuaUser(Auth::id()))
        return redirect('admin/organization')->with('messenger', 'Không tìm thấy Đơn vị');
        
        //
        $organization=Organization::find($id); 

        $data['title']='Sửa Đơn Vị';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/organization/".$id."/edit"),
        );
        //'data'=>$data,   

        $topic=DB::table('ks_topic')
           ->select('ks_topic.*')
           ->where('ks_topic.topic_idCreated','=',Auth::id()) 
           ->orwhere('ks_topic.topic_idCreated','=',1) 
           ->get(); 

           $tempus=User::find(Auth::id());
        $data['lvus']=$tempus->user_level;

         $tempus=User::find(Auth::id());
        $data['lvus']=$tempus->user_level;
        

        if( $organization)
        return view('admin.organization.edit',['data'=>$data, 'org'=>$organization,'topic'=>$topic]);
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
        $org  = Organization::find($id);   
        $org->org_name = $request->org_name;
        $org->org_image= $request->org_image;
        $org->org_level = $request->org_level;
        $org->org_idCreated =Auth::id();
        $org->org_idAssigned = $request->org_idAssigned;
        $org->org_topic_id = $request->org_topic_id;
        
        if($request->org_idParent=="" || $org->org_level==1) $org->org_idParent=0;
        else $org->org_idParent= $request->org_idParent;

        $org->org_address= $request->org_address;
        $org->org_nhanemail= $request->org_nhanemail;
        $org->org_phone= $request->org_phone;
        $org->org_order= $request->org_order;
        $org->org_isSelectEmp= $request->org_isSelectEmp;
        $org->org_isActived= $request->org_isActived;
        $org->org_chudebatbuoc= $request->org_chudebatbuoc;
        $org->save();
        return redirect('admin/organization')->with('messenger', 'Cập nhật Đơn vị Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($org_id)
    {
         if(Setting::getlvuser(Auth::id())>1 && Setting::getorgid_cuaOrg($id)!=Setting::getorglv1_cuaUser(Auth::id()))
        return redirect('admin/organization')->with('messenger', 'Không tìm thấy Đơn vị');
        // cập nhật lại tổ chức có đơn vị cấp trên có id=org_id 
        Organization::where('org_idParent', $org_id)
          ->delete();
        
        Schedule::where('schedule_idOrg', $org_id)
          ->delete();


        $org = Organization::find($org_id);
        if($org) $org->delete();
    }

    
}
