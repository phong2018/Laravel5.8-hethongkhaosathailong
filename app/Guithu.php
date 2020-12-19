<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
 

class Guithu extends Model
{
    public static function sendmail($data){
      /*-------------config gửi mail*/        
      config(   ['mail.driver'  => Setting::where("key","=",'config_mail_protocol')->first()->value]);
      config(   ['mail.host'    => Setting::where("key","=",'config_mail_smtp_hostname')->first()->value]);
      config(   ['mail.port'    => Setting::where("key","=",'config_mail_smtp_port')->first()->value]);
      config(   ['mail.username'    => Setting::where("key","=",'config_mail_smtp_username')->first()->value]);
      config(   ['mail.password'    => Setting::where("key","=",'config_mail_smtp_password')->first()->value]);
      config(   ['mail.encryption'  => Setting::where("key","=",'config_mail_encryption')->first()->value]);
        /*--------Mẫu dữ liệu data
        $data = array(
          'to_email'=>"phong2018@gmail.com",
          'to_name'=>"Tên Người Nhận",
          'subject'=>'Tựa đề của Email',
          'from_email'=>"nkh_email@gmail.com",
          'from_name'=>"PhongLG",
          'view_blade'=>'admin.email.sendmail',// blade view để hiện ra
        );
        */
        /*--------------gửi mail*/
      Mail::send(['html'=>$data['view_blade']], $data, function($message) use ($data) {
         $message->to($data['to_email'],$data['to_name'])->subject
            ($data['subject']);
         $message->from($data['from_email'],$data['from_name']);


         
         if(isset($data['bc1']) && file_exists($data['bc1']))
         $message->attach($data['bc1']);
 

         if(isset($data['bc2']) && file_exists($data['bc2']))
         $message->attach($data['bc2']);

         if(isset($data['bc3']) && file_exists($data['bc3']))
         $message->attach($data['bc3']); 

      });

    }
   
}
