<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Question;
use App\User;
use App\Organization;
use App\Topic;
use Illuminate\Support\Facades\DB;
use App\Answer;
use Auth;
use App\Survey;
use App\Setting;
use App\Guithu; 
use App\Result;
use App\Schedule;
use App\Device;
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel; 
use Khill\Lavacharts\Lavacharts;
use Session;


class ThongkeController extends Controller
{
    public function addcot(){
        DB::connection()->getPdo()->exec("ALTER TABLE `ks_result` ADD `resultSelected` VARCHAR(100) NULL AFTER `result_Answer`;
        ");
    }
    //----
    public function tkTheoCauhoi(){
        $data=array();
        //tạo breadcumbs
        $data['title']='Kết quả khảo sát theo câu hỏi';
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/survey/surveyresult"),
        );
        //bộ lọc
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );   
        //-lấy dữ liệu từ kết quả thống kê, nối bảng Result và Survey
        $results=  DB::table('ks_result')
        ->join('ks_survey','ks_survey.survey_id','=','ks_result.result_idSurvey')
        ->where('ks_survey.survey_isActived',1);
        //-check đơn vị level1
        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $results= $results->where('ks_survey.survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
            //----chắc chắc sẽ có topic
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            $results= $results->where('ks_survey.survey_idTopic', '=', $data['filter_survey_topic_id']); 
        } 
        //-check theo ngày nhận
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $results= $results->where('ks_survey.survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //-check den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $results= $results->where('ks_survey.survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
        //lấy dữ từng câu trả lời 
        $data['slThongke']=0;
        $data['arr_body']=array();
        $data['arr_body_excel']=array();
        $data['arr_header']=array('Kết quả thống kê');
        $lava=array();
        if($data['filter_survey_idorglv1']>0){
            $data['topic']=Topic::find( $data['filter_survey_topic_id']);
            $data['question'] = Question::orderBy('question_order', 'asc')->where("question_idTopic", $data['filter_survey_topic_id'])->where("question_isActived",1)->get();
            //từ ds survey, tính xem Mỗi câu, Mỗi đáp án chọn mấy lần   
            $temp=$this->tinhThongke($results->get());//print_r($data['thongke']);
            $data['thongke']=$temp[0];
            $data['slThongke']=count($temp[1]);
            $data['maxAns']=0;
            //-----
            $lava=array();
            //-----
            $slTk=count($data['thongke']);
            foreach($data['thongke'] as $notk=>$tk){
                $question=Question::find($tk['qid']);
                $ans=Answer::orderBy('answer_order', 'asc')->where("answer_idQuestion", $question->question_id)->get();
                if(count($ans))$data['maxAns']=count($ans);
                $data['arr_body'][$notk][]='<strong>Câu '.($notk+1).'</strong>:'.$question->question_description;
                $data['arr_body_excel'][$notk][]='<strong>Câu '.($notk+1).'</strong>:'.$question->question_description;
                //-------
                $value=array();
                foreach($ans as $noans=>$a){
                    $tilept=$tk['ans'][$noans]/$data['slThongke']*100; 
                    if($tk['ans'][$noans]==0) $tt=" <span style='color:#ddd;'>..</span>0%";
                    else $tt="<span style='color:red;'>..</span>".$tk['ans'][$noans].'/'.$data['slThongke']." (".$tilept."%)";
                    
                    $data['arr_body'][$notk][]=$a->answer_description."<div class='w100'><div class='fl'></div><div class='fl w100'>"."<div class='w100' style='border:none;  '><div class='containerbar  w100'>
                    <div class='skillsbar html' style='width:".$tilept."%;'>".$tt."</div></div></div>"."</div></div>";
                    $data['arr_body_excel'][$notk][]=$a->answer_description."||".$tilept;
                    //lay du lieu cho bieu do
                    $value[]=array(rtrim(html_entity_decode(strip_tags($a->answer_description))),$tilept); 
                } 
                //-------bieu do tron 
                $lava[$notk] =  $value;
                
            }
        }
       /* kiểm tra Xuất Excel */ 
       if(isset($_GET['xuatexcel'])){
            $sheet_col='C';  
            //==========
            $arr_header=['#','Câu hỏi/Trả lời','Tỉ lệ'];
            $sheet_header=[['BÁO CÁO KHẢO SÁT'],$arr_header];
            //$arr_body=array(array('a1','a2','a3'),array('b1','b2','b3'));
            $arr_body=array();
            foreach($data['arr_body_excel'] as $no=>$vr){
                //$v=array(($no+1),$vr,'3');
              
                foreach($vr as $novv=>$vv){
                    $v=array();
                    if($novv==0)$v[]="Câu ".($no+1); 
                    else $v[]="+ " ;
                    if($novv==0){
                        $v[]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($vv))));
                        $v[]='';
                    }                    
                    else{
                        $str=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($vv))));;
                        $v1=strpos($str,"||");
                        $v2=strlen($str);
                        //substr(string,start,length)
                        $v[]=substr($str,0,$v1);
                        $v[]=substr($str,$v1+2,$v2-$v1)."%";
                    }
                    $arr_body[]=$v;
                }
                
            }
            $arr_body[]=array();
            //-----
            $sheet_data= collect($arr_body);
            //---------
            $tex=new ExcelExport;
            $tex->sheet_col=$sheet_col;
            $tex->sheet_data=$sheet_data;
            $tex->sheet_header=$sheet_header;
            $filename='Report-Survey-'.date("d-m-Y-H-i-s").'.xlsx';
            return Excel::download($tex, $filename);
            die;
        }
        else{
            

            //-hiển thị
            $data['topics'] = Topic::all();
            return view('admin.survey.tkTheoCauhoi',['data'=>$data,'lava'=>$lava ]);
        }
    }
    //--------
    public function tinhThongke($results){
        $data=array(); 
        $vtCauhoi=array();
        $slThongke=array();
        $slCauhoi=0;
        foreach($results as $rs){
            if(!isset($slThongke[$rs->result_idSurvey])) $slThongke[$rs->result_idSurvey]=true;
            if(!isset($vtCauhoi[$rs->result_idQuestion])){//[$rs->resultSelected]
                $vtCauhoi[$rs->result_idQuestion]=$slCauhoi;
                $data[$slCauhoi]['qid']=$rs->result_idQuestion;
                $data[$slCauhoi]['ans']=array(0,0,0,0,0,0,0);//khởi tạo=0 cho việc chọn
                $slCauhoi++;
            }
            //cộng thêm cho chọn đáp án $rs->resultSelected
            if(isset($data[$vtCauhoi[$rs->result_idQuestion]]['ans'][$rs->resultSelected]))
            $data[$vtCauhoi[$rs->result_idQuestion]]['ans'][$rs->resultSelected]++;
        }
        return array($data,$slThongke);
    }
    //-------
    public function layBody($topic){
      
    }
    //-------
    public function layHeader($topic){
      
    }

}