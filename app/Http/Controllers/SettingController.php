<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Template;
use App\Dossiers;
use Illuminate\Support\Facades\DB;
use App\History;
use App\Organization ;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    //
    public function edit(){

       
 		$data=array();
 		/*Lay config tu setting ra*/
    	$configs = Setting::where('code','config')->get();
        if($configs)      
    	foreach ($configs as $val) {
		    $data[$val->key]=$val->value;
		    //echo $val->key.'--'.$val->value.'<br>';
		}
		/*Tổng quát*/
		if(!isset($data['config_ks_meta_title'])) $data['config_ks_meta_title']='';
        if(!isset($data['config_logo_htks'])) $data['config_logo_htks']='';
        if(!isset($data['config_banner_htks'])) $data['config_banner_htks']='';

        
        if(!isset($data['config_logoadmin_htks'])) $data['config_logoadmin_htks']='';
		if(!isset($data['config_ks_meta_description'])) $data['config_ks_meta_description']='';

        if(!isset($data['config_ks_intro_home_htks'])) $data['config_ks_intro_home_htks']='';
        if(!isset($data['config_ks_thankyou_htks'])) $data['config_ks_thankyou_htks']='';
        if(!isset($data['config_amthanhxinchao'])) $data['config_amthanhxinchao']='';
        if(!isset($data['config_amthanhcamon'])) $data['config_amthanhcamon']='';
    
        /*Tùy chọn*/
		if(!isset($data['config_showeverypage'])) $data['config_showeverypage']=15;
        if(!isset($data['config_time_auto_direct'])) $data['config_time_auto_direct']=30;
        /*config cho gửi mail*/
        if(!isset($data['config_mail_protocol'])) $data['config_mail_protocol']='smtp';
        if(!isset($data['config_mail_parameter'])) $data['config_mail_parameter']='';
         if(!isset($data['config_mail_smtp_hostname'])) $data['config_mail_smtp_hostname']='';
         if(!isset($data['config_mail_smtp_username'])) $data['config_mail_smtp_username']='';
        if(!isset($data['config_mail_smtp_password'])) $data['config_mail_smtp_password']='';
        if(!isset($data['config_mail_smtp_port'])) $data['config_mail_smtp_port']='';
        if(!isset($data['config_mail_encryption'])) $data['config_mail_encryption']='';
        
        if(!isset($data['config_mail_smtp_timeout'])) $data['config_mail_smtp_timeout']='';
        
        /*----*/
        if(!isset($data['config_sms_provider'])) $data['config_sms_provider']='esms.vn';
        // key api cho esms.vn
        if(!isset($data['config_esmsvn_api_key'])) $data['config_esmsvn_api_key']='';
        if(!isset($data['config_esmsvn_secret_key'])) $data['config_esmsvn_secret_key']='';
        // key api cho smsnhanh.com

        /*chế độ bảo trì*/
        if(!isset($data['config_maintenance'])) $data['config_maintenance']=0;
        if(!isset($data['config_dangkythietbidekhaosat'])) $data['config_dangkythietbidekhaosat']=0;

         if(!isset($data['config_tencoquan'])) $data['config_tencoquan']='';
        if(!isset($data['config_diachi'])) $data['config_diachi']='';
        if(!isset($data['config_sodienthoai'])) $data['config_sodienthoai']='';
        if(!isset($data['config_emailcoquan'])) $data['config_emailcoquan']='';
        /*barcode*/
        if(!isset($data['config_bacode_symbology'])) $data['config_bacode_symbology']='';
        if(!isset($data['config_orgtosurvey'])) $data['config_orgtosurvey']='';

        if(!isset($data['config_barcode-height'])) $data['config_barcode-height']=0;
        if(!isset($data['config_barcode-width'])) $data['config_barcode-width']=0;
        if(!isset($data['config_barcode-padding'])) $data['config_barcode-padding']=0;
        /*hẹn giờ backup*/
        if(!isset($data['config_backup_time'])) $data['config_backup_time']='khongbk';
        /*chọn các mẫu*/
        if(!isset($data['config_temp_guiemail'])) $data['config_temp_guiemail']='';
        if(!isset($data['config_temp_guisms'])) $data['config_temp_guisms']='';
        if(!isset($data['config_temp_biennhanhoso'])) $data['config_temp_biennhanhoso']='';
        if(!isset($data['config_temp_chuyenhoso'])) $data['config_temp_chuyenhoso']='';


        $data['orgs'] = Organization::orderBy('org_order', 'DESC')->where("org_isActived",">",0)->where("org_level","=",1)->get();


        $temps = Template::all()->sortBy('temp_order');

        $data['mavach_type']=array('upc-a','upc-e','ean-8','ean-13','ean-13-pad','ean-13-nopad','ean-128','code-39','code-39-ascii','code-93','code-93-ascii','code-128','codabar','itf','qr','qr-l','qr-m','qr-q','qr-h','dmtx','dmtx-s','dmtx-r','gs1-dmtx','gs1-dmtx-s','gs1-dmtx-r');
        

        $data['title']='Thiết lập chung';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/setting/edit"),
        );
        //'data'=>$data, 

        /*-----------*/
    	return view('admin.setting.edit',['data'=>$data,'temps'=>$temps]); 
    }
 
    public function update(Request $request){
    	$messages = [
            'required' => 'Trường :attribute bắt buộc nhập.',
        ];
        $validator = Validator::make($request->all(), [
            'config_ks_meta_title' => 'required',
            'config_ks_meta_description' => 'required',
            'config_showeverypage' => 'required|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/setting/edit')->withErrors($validator)->withInput();
        }
        else{
 
        	/*insert config vao*/
			$data=$request->request; 

        	foreach($data as $key => $value) 
        	if($key!='_token'){

                /*delete setting code='config' */
                $res=Setting::where('code','config')->where('key',$key)->delete();

        		$setting = new Setting;

        		$setting->code='config';
        		$setting->key=$key;
        		//---------
        		if (!is_array($value)) {
        			$setting->value=$value;
        			$setting->serialized=0;
        		}
        		else{
        			$setting->value=json_encode($value);
        			$setting->serialized=1;
        		} 
                //---------
        		$setting->save();
			}
            //-------xu ly file am thanh cam on
            if ($request->hasFile('config_amthanhcamon')) {
                if(Setting::getconfig('config_amthanhcamon')){
                    $amthanhcamon=public_path().'/'.Setting::getconfig('config_amthanhcamon');
                    if(file_exists($amthanhcamon)) unlink($amthanhcamon);
                    $res=Setting::where('code','config')->where('key','config_amthanhcamon')->delete();
                }

                $file = $request->file('config_amthanhcamon');
                $tenfile=time().$file->getClientOriginalName();   
                $target_file=public_path().'/'.$tenfile;
                if(move_uploaded_file($_FILES["config_amthanhcamon"]["tmp_name"], $target_file)){
                    $setting = new Setting;
                    $setting->code='config';
                    $setting->key='config_amthanhcamon';
                    $setting->value=$tenfile;
                    $setting->serialized=0;
                    $setting->save();
                } 
            }    
            //-------xu ly file am thanh xinchao
            if ($request->hasFile('config_amthanhxinchao')) {
                if(Setting::getconfig('config_amthanhxinchao')){
                    $amthanhxinchao=public_path().'/'.Setting::getconfig('config_amthanhxinchao');
                    if(file_exists($amthanhxinchao)) unlink($amthanhxinchao);
                    $res=Setting::where('code','config')->where('key','config_amthanhxinchao')->delete();
                }

                $file = $request->file('config_amthanhxinchao');
                $tenfile=time().$file->getClientOriginalName();   
                $target_file=public_path().'/'.$tenfile;
                if(move_uploaded_file($_FILES["config_amthanhxinchao"]["tmp_name"], $target_file)){
                    $setting = new Setting;
                    $setting->code='config';
                    $setting->key='config_amthanhxinchao';
                    $setting->value=$tenfile;
                    $setting->serialized=0;
                    $setting->save();
                } 
            }

            

			return redirect('admin/setting/edit')->with('messenger', 'Thiết lập Thành Công');
        	 
        }

    	 
    }
    
    public function ajax_upload(Request $request){
       
        $config_logo=Setting::getconfig('config_logo');
        if($config_logo=='/avatars/configlogo1')
        $name_config_logo='configlogo2';
        else $name_config_logo='configlogo1';
        //--------
        $file = $request->file('config_logo');
        $tenfile=$name_config_logo;   
        $target_file=public_path().'/avatars/'.$tenfile;
        move_uploaded_file($_FILES["config_logo"]["tmp_name"], $target_file);
        //-----
        $url = '/avatars/'.$tenfile;
        //-----
        $json=array();
        $json['config_logo']= $url;
        $json['success']='success';
        return response()->json($json);
         
    } 
    public function mauguimail(){
        //echo 'vvv';
        $data=array();
        $filename=resource_path().'\views\admin\email\sendmail.blade.php';
        //--- mo fil doc
        $content='';
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $data['content']=fread($myfile,filesize($filename));
        return view('admin.setting.mauguimail',['data'=>$data]); 
    }  
    public function capnhatmauguimail(Request $request){
        $filename=resource_path().'\views\admin\email\sendmail.blade.php';
        //-------Mở file viết;
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        $content=$request->content;
        fwrite($myfile, $content);
        fclose($myfile);
    }

    public function nhatky(){

        $dossier= DB::table('dossier')
            ->select('dossier.*')
            ->where('dossier.history_file', '!=','');
          $data=array(
            'filter_Ma_Hoso'=>''
        );
        //check mã hồ sơ
        if(isset($_GET['filter_Ma_Hoso']) && $_GET['filter_Ma_Hoso']!=''){
            $dossier= $dossier->where('dossier.Ma_Hoso', '=', $_GET['filter_Ma_Hoso']);
            $data['filter_Ma_Hoso']=$_GET['filter_Ma_Hoso'];
        }
        //-------
        $dorr=$dossier->orderBy('ID_Dossier', 'DESC')->paginate(Setting::where("key","=",'config_showeverypage')->first()->value);

        $dossier=$dossier->paginate(Setting::where("key","=",'config_showeverypage')->first()->value);


        $hiss=array(); 
        foreach($dorr as $dor){
            $his_content=array();

            $filename=$dor->history_file;
            if(file_exists($filename)){
                $myfile = fopen($filename, "r") or die("Unable to open file!");
                while(!feof($myfile)) {
                  $his_content[]= fgets($myfile);
                }
                fclose($myfile);
            }           
            //----------
            $hiss[]=array(
                'idhoso'=>$dor->Ma_Hoso,
                'ID_Dossier'=>$dor->ID_Dossier,
                //'content'=>str_replace("\r\n","<br>",$his_content),
                'content'=>$his_content,
                'created_at'=>$dor->time_received,
                //'ID_Dossier'=>$dor->ID_Dossier,
            );
        }

        $data['title']='Nhật ký hoạt động';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/setting/nhatky"),
        );
        //'data'=>$data,


        return view('admin.setting.list_history',['hiss' =>$hiss,'dorr'=>$dorr,'data'=>$data]);
    }
    public function deletenhatky($id){
        $do = History::where('id_history',$id)->delete();

        return redirect('admin/setting/nhatky')->with('messenger', 'Xóa nhật ký '.$id.' thành công');
             
    }

    public function historydownload($id){
        $dor = Dossiers::find($id);
        $filepath=base_path($dor->history_file);
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
           // exit;

        }
        else return redirect('admin/backup')->with('messenger', 'Không tồn tại file Nhật ký.');
        
    }
     public function addcoulum_org(){

        DB::statement('ALTER TABLE ks_organization ADD org_nhanemail text COLLATE utf8_unicode_ci');
    }
}
