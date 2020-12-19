<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Setting; 
use App\Guithu; 

class MailController extends Controller
{
   public function sendemail(){
       $data = array(
          'to_email'=>"phong2018@gmail.com",
          'to_name'=>"Tên Người Nhận",
          'subject'=>'Tựa đề của Email',
          'from_email'=>"nkh_email@gmail.com",
          'from_name'=>"PhongLG",
          'view_blade'=>'admin.email.template_email',
        );
        Guithu::sendmail($data);

   }
   public function sendemail1(){
        $data = array(
          'to_email'=>"phong2018@gmail.com",
          'to_name'=>"Tên Người Nhận",
          'subject'=>'Tựa đề của Email',
          'from_email'=>"nkh_email@gmail.com",
          'from_name'=>"PhongLG",
          'view_blade'=>'admin.email.test',
        );
        Guithu::sendmail($data);
    }
}
