<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Position;
use App\Menus;
use Auth;
use App\User;
use App\Topic;
use App\Survey;

use App\Device; 
use App\Organization;

class ajaxController extends Controller
{   
   public function checkdanhgiatrungbinh(){
      $data=array();
       //-----
      $tempus=User::find(Auth::id());
      if($tempus->user_level==2){ // nếu là giám sát thì mới cho xem láy dữ liệu
          //------
           $orgt=Organization::where('org_id',$tempus->user_IdOrg)->get()->first();
           //========
           if($orgt->org_level==2){
              $orgp=Organization::orderBy('org_id', 'DESC')->where('org_id',$orgt->org_idParent)->get()->first();
           }
           else{
              $orgp=Organization::orderBy('org_id', 'DESC')->where('org_id',$tempus->user_IdOrg)->get()->first();
           }
           $surveys = Survey::orderBy('survey_id', 'ASC')
                            ->where('survey_isActived',1)
                            ->where('survey_idorglv1', '=', $orgp->org_id)
                            ->where('survey_created_at', '>=', date(date("Y-m-d")))
                            ->where('survey_created_at', '<=', date(date("Y-m-d")))
                            ->where('survey_note1','=','1')
                            ->get();
            //---lấy dữ liệu và cập nhật lại xem rồi
            foreach($surveys as $no=> $sv){
              $data[]="<p><strong>".($no+1).". Khảo sát số ".$sv->survey_id.". </strong>Khách hàng ".$sv->survey_customer." chưa hài lòng: <a target='_blank' href='".route('survey.showsv', ['survey' => $sv->survey_id])."'><strong>Xem</strong></a></p>";
              //------
               $sv = Survey::find($sv->survey_id);
               $sv->survey_note1 = 2;//chuyển lại lưu ==2 // tức là dã xem rồi
               $sv->save();
            }
      }
      
      //---------
       return response()->json($data);
    }

    public function checkdevice($deviceid){
      $data=array();
      $device = Device::where('device_uid',$deviceid)->get()->first();

      if(count($device)>0){
        $data['device_isactived']=1;
        $data['device_id']=$device->device_id;
      }
      else{
        // đăng ký thiết bị mới
        //$id = strtoupper(bin2hex(openssl_random_pseudo_bytes(1))).rand(0,9).strtoupper(bin2hex(openssl_random_pseudo_bytes(1)));


        $data['device_isactived']=0;
      }

      return response()->json($data);

    }

     public function checkdevice_actived($deviceid){
      $data=array();
      $device = Device::where('device_uid',$deviceid)->get()->first();
       $data['tenphuong'] ='';
      //->where('device_isActived',1)
      if(count($device)>0){
          if($device['device_isActived']==0)$data['device_isactived']=-1;  
          else $data['device_isactived']=1;

          $data['device_orgid']=$device['device_orgid'];
          $data['device_giaodien']=$device['device_giaodien'];
          $data['device_assign_userid']=$device['device_assign_userid'];
          $data['topic_id']= 0;
          $data['topic_type']= 0;
          //===========lấy topic luôn, từ device
          if($data['device_assign_userid']>0){


              //lọc lại thwo cấp quản lý nếu ko phải admin
              $tempus=User::find($data['device_assign_userid']);
  
              $org=Organization::find($tempus->user_IdOrg);
              if($org->org_level>1) $orglv1=Organization::find($org->org_idParent);
              else $orglv1=$org;
              
              $topic = Topic::find($orglv1->org_topic_id);
              if(count($topic)>0){
                 $data['topic_id']= $topic->topic_id;
                 $data['topic_type']= $topic->topic_type;
              }
          }

          $org=Organization::find($device->device_orgid);
          $data['tenphuong'] =$org->org_name;
          $data['logophuong'] =$org->org_image;
          

      } 
      else{
          $data['device_isactived']=0;

          $id=$deviceid;
          $device = new Device;
          $device->device_name = 'Thiết bị '.$id;
          $device->device_uid = $id;
          $device->device_orgid= 0;
          $device->device_giaodien = 2;
          $device->device_registerDate = date("Y-m-d");
          $device->device_isActived = 0;
          $device->save();
          
          $data['device_uid']=$id;


      }

      return response()->json($data);

    }

  
     
    public function Object_getobject($topic_id){
        $topic=Topic::find($topic_id);
        $typeobject=$topic->topic_type;

        $data=array();
        if($typeobject==1) 
        $data['object']= Organization::where('org_isActived', 1)
               ->where('org_level', 1)
               ->orderBy('org_id', 'desc') 
               ->get();
        else{
          $data['object']= User::where('user_level','>', 1) 
               ->orderBy('id', 'desc') 
               ->get();

        } 

         /*
         $data['orglv1']=Organization::where('org_topic_id', $topic_id) 
               ->where('org_isActived', 1) 
               ->orderBy('org_id', 'DESC') 
               ->get();
         */

        $orglv1=Organization::where('org_isActived', 1) 
                ->orderBy('org_id', 'desc')->where('org_level', 1);

                   
         //lọc lại thwo cấp quản lý nếu ko phải admin
        $tempus=User::find(Auth::id());
         if($tempus->user_level>1){
           
           $orgt=Organization::find($tempus->user_IdOrg);

           if($orgt->org_level==2){
             $orglv1=Organization::orderBy('org_id', 'DESC')->where('org_id',$orgt->org_idParent)->get();
           }
           else{
             $orglv1=Organization::orderBy('org_id', 'DESC')->where('org_id',$tempus->user_IdOrg)->get();
           }
 
        }
        else
        $orglv1=$orglv1->get();

        $data['orglv1']=$orglv1;


        $data['topic_type']=$topic->topic_type;



        $data['topic']= Topic::where('topic_type', $typeobject)
               ->where('topic_isActived', 1)
               ->orderBy('topic_id', 'desc') 
               ->get();

        return response()->json($data);
    }
	/*ajax của Organization*/
    public function Organization_getAssigned_Parent($level){/*lấy Phân công và cha cho đơn vị*/
        $data=array();
        $data['assigned']=User::where("user_level","=",2)->get()->toArray();

         $tempus=User::find(Auth::id());
        if($tempus->user_level==1){
            $data['org']=Organization::where("org_level","=",1)->get()->toArray();
        }
        else{
            $orgt=Organization::where('org_id',$tempus->user_IdOrg)->get()->first();

           if($orgt->org_level==2){
               
              $data['org']=Organization::orderBy('org_id', 'DESC')->where('org_id',$orgt->org_idParent)->get()->toArray(); 
           }
           else{
              $data['org']=Organization::orderBy('org_id', 'DESC')->where('org_id',$tempus->user_IdOrg)->get()->toArray();
              
           }

            

        }

        return response()->json($data);
    }
    /*ajax của Organization*/
    public function Organization_gettypetopic($topicid){/*lấy Phân công và cha cho đơn vị*/
        $data=array();
        $data['topic']=Topic::find($topicid);
        return response()->json($data);
    }
}
