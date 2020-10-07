<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Position;
use App\Organization;
use App\Topic;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Setting;  
use App\Device;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        

         //-----lấy ds nhân viên để đánh giá nếu đánh giá nhân viên và cấu hình chọn nhân viên đánh giá
        $data['config_dangkythietbidekhaosat']=Setting::getconfig('config_dangkythietbidekhaosat'); 


        return view('frontend.home',['data'=>$data]);
 
    }
    public function baotri()
    {
        //echo 'Trang Chủ';
        return view('frontend.baotri');

        //$do = Dossiers::whereDate('time_received', '=', date('Y-m-d'))->get();
        //return view('admin.layouts.index',['dossieratnow'=>$do]);
    }
    public function timkiem(Request $request)
    {

         $dossier= DB::table('dossier')
            ->join('list_step', 'list_step.ID_Step', '=', 'dossier.id_stepcurrent')
            ->select('dossier.*','list_step.out_ofdate','list_step.step_name');

        $check    =0;
        $mhs="";
        if(isset($request->mahoso)){
            $dossier= $dossier->where('dossier.Ma_Hoso', '=', $request->mahoso);
            $check=1;
            $mhs=$request->mahoso;
        }
        $sdt="";
        if(isset($request->sodienthoai)){
            $dossier= $dossier->where('dossier.owner_phone', '=', $request->sodienthoai);
            $check=1;
            $sdt=$request->sodienthoai;
        }
        if($check==0)$dossier=array();
        else $dossier=$dossier->first();
        
        $data=array(
            'mahoso'=>$mhs,
            'sodienthoai'=>$sdt,
        );


        return view('frontend.timkiem',['dossier'=>$dossier,'data'=>$data]);
 
    }

    public function getlistemployee()
    {
        $user = User::paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);
        return view('admin.employee.listemployee',['employee'=>$user]);
    }

    public function newuser()
    {
        $pos = Position::where("pos_note",">",0)->get();
        $role = Role::where("role_active",">",0)->get();
        return view('admin.employee.addemployee',['position'=>$pos, 'roles' => $role]);
    }

    public function createuser(Request $request)
    {
        isset($request->user_15)? $user_15 = $request->user_15 : $user_15 ='';
        isset($request->user_16)? $user_16 = $request->user_16 : $user_16 ='';
        isset($request->user_17)? $user_17 = $request->user_17 : $user_17 ='';
        isset($request->user_18)? $user_18 = $request->user_18 : $user_18 ='';
        isset($request->user_19)? $user_19 = $request->user_19 : $user_19 ='';
        $user = new User;

        $user->ID_Staff = $request->staff_id;
        $user->email =$request->email;
        $user->password = bcrypt($request->password);
        $user->DoB = $request->dob;
        $user->fullname = $request->fullname;
        $user->sex = $request->sex;
        $user->phone = $request->phone;
        $user->zalo_id = $request->zalo;
        $user->address = $request->address;
        $user->avatar = '$request->avatar';
        $user->ID_Position = $request->position;
        $user->ID_Role = $request->role;
        $user->user_15 = $user_15;
        $user->user_16 = $user_16;
        $user->user_17 = $user_17;
        $user->user_18 = $user_18;
        $user->user_19 = $user_19;
        $user->save();
        return redirect('admin/employee');
    }

    /*****************************Role*****************************/
    public function getlistrole()
    {
        $role = Role::paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);
        return view('admin.role.listrole',['roles'=>$role]);
    }

    

    public function newrole()
    {
        return view('admin.role.add');
    }

    public function createrole(Request $request)
    {

        $name = Role::all();
        foreach ($name as $value) {
            if (strtolower($value->role_name) == strtolower($request->role_name)) {
                return redirect('admin/role/add')->with('messenger', 'quyền này đã tồn tại!');
            }
        }
        $role = new Role;
        $role->role_name = $request->role_name;
        $role->role_active = 1;
        $role->save();
        return redirect('admin/role');
    }

    public function delrole($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect('admin/role');
    }

    /*****************************Position*****************************/
    public function getlistposition()
    {
        $pos = Position::paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);
        return view('admin.position.listpos',['position'=>$pos]);
    }

    public function newpos()
    {
        return view('admin.position.add');
    }

    public function createpos(Request $req)
    {
        isset($req->pos_4) ? $pos_4 = $req->pos_4 : $pos_4 = 'null';
        isset($req->pos_5) ? $pos_5 = $req->pos_5 : $pos_5 = 'null';
        isset($req->pos_6) ? $pos_6 = $req->pos_6 : $pos_6 = 'null';
        isset($req->pos_7) ? $pos_7 = $req->pos_7 : $pos_7 = 'null';
        isset($req->pos_8) ? $pos_8 = $req->pos_8 : $pos_8 = 'null';

        $pos = new Position;
        $pos->pos_name = $req->pos_name;
        $pos->pos_note = 1;
        $pos->pos_short = $req->pos_short;
        $pos->pos_4 = $pos_4;
        $pos->pos_5 = $pos_5;
        $pos->pos_6 = $pos_6;
        $pos->pos_7 = $pos_7;
        $pos->pos_8 = $pos_8;
        $pos->save();
        return redirect('admin/position');
    }

    public function delpos($id)
    {
        $pos = Position::find($id);
        $pos->delete();
        return redirect('admin/position');
    }
    
}
