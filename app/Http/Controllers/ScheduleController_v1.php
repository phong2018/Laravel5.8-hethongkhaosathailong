<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Organization;
use App\Setting; 
use App\User; 
use Auth;

use App\Schedule; 

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data = ['appId'=>4, 'languageId'=>5];
        //echo Setting::passDataToModelMethod($data);  
        //echo Setting::getconfig('HLEO');  


        $data=array(
            'filter_schedule_orgid'=>0 ,
            'filter_schedule_isActived'=>0 
        );


         $data['title']='Lịch Làm Việc';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/schedule"),
        );
        //'data'=>$data,   

        $schedules= DB::table('ks_schedule')
            ->join('ks_organization', 'ks_organization.org_id', '=', 'ks_schedule.schedule_idOrg')
            ->select('ks_schedule.*');

        //=============
        $data['uslv1']=1;
        $tempus=User::find(Auth::id());
        if($tempus->user_level>1){
           $_GET['filter_schedule_orgid']=Setting::getorglv1_cuaUser(Auth::id()); 
           $data['uslv1']=0;
        }
 

        if(isset($_GET['filter_schedule_orgid']) && $_GET['filter_schedule_orgid']!=0){
            $schedules= $schedules->where('ks_organization.org_id',$_GET['filter_schedule_orgid'])->orwhere('ks_organization.org_idParent',$_GET['filter_schedule_orgid']);
            $data['filter_schedule_orgid']=$_GET['filter_schedule_orgid'];
        } 

        if(isset($_GET['filter_schedule_isActived']) ){
            $schedules= $schedules->where('schedule_isActived',$_GET['filter_schedule_isActived']);
            $data['filter_schedule_isActived']=$_GET['filter_schedule_isActived'];
        } 

         
        $schedules= $schedules->paginate(Setting::getconfig('config_showeverypage'));

        if($tempus->user_level==1)
        $data['orgs'] = Organization::orderBy('org_order', 'DESC')->where("org_isActived",">",0)->where("org_level","=",1)->get();
        else $data['orgs'] = Organization::orderBy('org_order', 'DESC')->where("org_id","=",$_GET['filter_schedule_orgid'])->get();

 
        return view('admin.schedule.listschedule',['data'=>$data, 'schedules'=>$schedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
        $data['title']='Thêm lịch làm việc';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/schedule"),
        );

        $org = Organization::orderBy('org_order', 'ASC')->where('org_level',1)->where("org_isActived",">",0)->paginate(Setting::getconfig('config_showeverypage'));

        $org_child=array();
        foreach($org as $no=>$val){
            $org_child[$no] = Organization::orderBy('org_order', 'ASC')->where('org_idParent',$val->org_id)->where("org_isActived",">",0)->get();
        }
   
        //'data'=>$data,   
        return view('admin.schedule.addschedule',['data'=>$data,'org'=>$org,'org_child'=>$org_child]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule;
        $schedule->schedule_name = $request->schedule_name;
        $schedule->schedule_idOrg = $request->schedule_IdOrg;
        $schedule->schedule_morningStart =$request->schedule_morningStart;
        $schedule->schedule_morningEnd =$request->schedule_morningEnd;
        $schedule->schedule_afternoonStart =$request->schedule_afternoonStart;
        $schedule->schedule_afternoonEnd =$request->schedule_afternoonEnd;
        $schedule->schedule_eveningStart =$request->schedule_eveningStart;
        $schedule->schedule_eveningEnd =$request->schedule_eveningEnd;      
        $schedule->schedule_isActived= $request->schedule_isActived;

        $schedule->save();
        return redirect('admin/schedule')->with('messenger', 'Thêm mới Lịch làm việc thành công');
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
        if(Setting::getlvuser(Auth::id())>1 && Setting::getorgid_cuaSchedule($id)!=Setting::getorglv1_cuaUser(Auth::id()))
        return redirect('admin/schedule')->with('messenger', 'Không tìm thấy thiết bị');

        
        $schedule=Schedule::find($id); 
        
        $data['title']='Sửa Lịch Làm Việc';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/schedule/".$id.'/edit'),
        );
        //'data'=>$data,   
        $org = Organization::orderBy('org_order', 'ASC')->where('org_level',1)->where("org_isActived",">",0);

        if(Setting::getlvuser(Auth::id())>1){
            $org=$org->where("org_id",Setting::getorgid_cuaSchedule($id));     
        }

        $org = $org->get();



        $org_child=array();
        foreach($org as $no=>$val){
            $org_child[$no] = Organization::orderBy('org_order', 'ASC')->where('org_idParent',$val->org_id)->where("org_isActived",">",0)->get();
        }
        
        if( $schedule)
        return view('admin.schedule.editschedule',['data'=>$data ,'org'=>$org,'org_child'=>$org_child, 'schedule' => $schedule]);

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
          $schedule = Schedule::find($id);
        $schedule->schedule_name = $request->schedule_name;
        $schedule->schedule_idOrg = $request->schedule_IdOrg;
        $schedule->schedule_morningStart =$request->schedule_morningStart;
        $schedule->schedule_morningEnd =$request->schedule_morningEnd;
        $schedule->schedule_afternoonStart =$request->schedule_afternoonStart;
        $schedule->schedule_afternoonEnd =$request->schedule_afternoonEnd;
        $schedule->schedule_eveningStart =$request->schedule_eveningStart;
        $schedule->schedule_eveningEnd =$request->schedule_eveningEnd;      
        $schedule->schedule_isActived= $request->schedule_isActived;

        $schedule->save();
        return redirect('admin/schedule')->with('messenger', 'Sửa Lịch làm việc thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(Setting::getlvuser(Auth::id())>1 && Setting::getorgid_cuaSchedule($id)!=Setting::getorglv1_cuaUser(Auth::id()))
        return redirect('admin/schedule')->with('messenger', 'Không tìm thấy thiết bị');
     
        $Sche = Schedule::find($id);
        if($Sche) $Sche->delete();
    
    }
}
