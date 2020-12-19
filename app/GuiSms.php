<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiSms extends Model
{


    public static function sendsms($data){
    	$APIKey=Setting::where("key","=",'config_esmsvn_api_key')->first()->value;
		$SecretKey=Setting::where("key","=",'config_esmsvn_secret_key')->first()->value;
		
		$YourPhone=$data['to_phone'];
		$Content=$data['content_sms'];
		
		$SendContent=urlencode($Content);
		$data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&Brandname=QCAO_ONLINE&SmsType=2";
		//De dang ky brandname rieng vui long lien he hotline 0902435340 hoac nhan vien kinh Doanh cua ban
		$curl = curl_init($data); 
		curl_setopt($curl, CURLOPT_FAILONERROR, true); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		$result = curl_exec($curl); 
			
		/*$obj = json_decode($result,true);
	    if($obj['CodeResult']==100)
	    {
	        print "<br>";
	        print "CodeResult:".$obj['CodeResult'];
	        print "<br>";
	        print "CountRegenerate:".$obj['CountRegenerate'];
	        print "<br>";     
	        print "SMSID:".$obj['SMSID'];
	        print "<br>";
	    }
	    else
	    {
	        print "ErrorMessage:".$obj['ErrorMessage'];
	    }*/
    }
}
