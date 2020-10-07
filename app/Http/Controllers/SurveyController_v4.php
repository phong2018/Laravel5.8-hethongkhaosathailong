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


class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $count_survey,$xuatexcel=0,$dtchartda,$count_question=0;

     public function xuatchart(){
       $lava = new Lavacharts; 
        $fans = $lava->DataTable();
        $value=array();
        $value[]=array("phong1",21);
        $value[]=array("phong2",21);
        $value[]=array("phong3",23);
        $value[]=array("phong4",24);
        $value[]=array("phong5",21);
        $value[]=array("phong6",28);

        $fans->addStringColumn('Football Team')
                   ->addNumberColumn('Football Fans')
                   ->addRows($value);

        //$lava->GeoChart('Football Fans', $fans);
        $lava->BarChart('Football Fans', $fans,[ 'png' => true]);
        return view('admin.survey.geochart',compact('lava'));

        //-===========  
    }

    public function layketquabaocaongay_bc3($orgid=9){
        //echo 'HL';
        $this->xuatexcel=0;
        $organization=Organization::find($orgid); 

        //print_r($organization);

        $topic = Topic::find($organization->org_topic_id);

        //print_r($topic);
        //echo 'vv';

        //die;

        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topic->topic_id)->where("question_isActived",1)->get(); 

        $survey = Survey::orderBy('survey_id', 'ASC');
        $_GET['filter_survey_topic_id']= $organization->org_topic_id; 
        $_GET['filter_survey_idorglv1']= $orgid;
        $_GET['filter-input-ngaykhaosat']=1;
        $_GET['filter_ngaykhaosat_tungay']=date("Y-m-d");
        $_GET['filter_ngaykhaosat_denngay']=date("Y-m-d");

        $_GET['traketqua']=1;
        
        //---------
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }
    
        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();
        //----------
        $arr_header=array();
        $arr_header[]='ID Nhân viên';
        $arr_header[]='Ho tên';
        $arr_header[]='Chức vụ';
        for($i=0;$i<count($question);$i++)
        $arr_header[]='Điểm câu '.($i+1);

        $arr_header[]='Thời gian';
        $arr_header[]='Khách hàng'; 


        // bắt buộc phải chọn chủ đề để thống kê
        if($topic->topic_type==2 && isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $this->count_question=count($question);
            $survey= $survey->where('survey_isActived',1);
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            //---------------
            $survey=$survey->get();// so lan khảo sát trong ngày


            ///////tuu cho nay thoi
            $sheet_col='QQ'; 
            $arr_body=array(); 
            //-------
            foreach($survey as $no1=>$val1){
                $dongno=array();
   
                $ob= User::where('id',$val1->survey_idObject)
                       ->select('ID_Staff as ID_Staff','fullname as name','chucdanh as chucdanh') 
                       ->orderBy('id', 'DESC') 
                       ->get()->first();
                $dongno[]=$ob->ID_Staff;
                $dongno[]=$ob->name;
                $dongno[]=$ob->chucdanh;
                //-------
                $tempq=$question;
                foreach($tempq as $no=>$val2){//với question_id

                    $resultques= Result::where('result_idSurvey', $val1->survey_id)->where('result_idQuestion', $val2->question_id)->first();

                    $ans= Answer::find($resultques->result_Answer); 
                    $dongno[]=$ans->answer_scores;
                    //echo $ans->answer_scores.'-dd<br>';
//
                }      
                $dongno[]=$val1->survey_created_at;
                $dongno[]=$val1->survey_customer; 
                //echo '<br><br>';
                $arr_body[]=$dongno;
            }
            //print_r($arr_body);
       
            //---------
            $ques=array();
            $ques[0][]=' ';
            $ques[0][]='';
            foreach($question as $no=>$val){
                $ques[$no+1][]='Câu '.($no+1).':';
                $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
            }
            //---------
            $arr_body[]=$ques; 

            $sheet_data= collect($arr_body);
            $sheet_header=[['DANH SÁCH TỪNG BÀI KHẢO SÁT NGÀY '.date("d-m-Y")],$arr_header];
            //0---------
            $tex=new ExcelExport;
            $tex->sheet_col=$sheet_col;
            $tex->sheet_data=$sheet_data;
            $tex->sheet_header=$sheet_header;
             
          

            $filename='Mau3-Report-'.date("d-m-Y-H-i-s").$orgid.'-bc3.xlsx'; 

            Excel::store($tex,$filename,'public');

            return storage_path('app/public/').$filename; 
      
  
        

        } 
        else return '';
 
 
    }

    public function layketquabaocaongay_bc2($orgid=9){
        //echo 'HL';
        $this->xuatexcel=0;
        $organization=Organization::find($orgid); 

        $survey = Survey::orderBy('survey_id', 'ASC');
        $_GET['filter_survey_topic_id']= $organization->org_topic_id; 
        $_GET['filter_survey_idorglv1']= $orgid;
        $_GET['filter-input-ngaykhaosat']=1;
        $_GET['filter_ngaykhaosat_tungay']=date("Y-m-d");
        $_GET['filter_ngaykhaosat_denngay']=date("Y-m-d");

        $_GET['traketqua']=1;
        
        //---------
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }
    
        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();



        // bắt buộc phải chọn chủ đề để thống kê
        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $topic=Topic::find($_GET['filter_survey_topic_id']);
            //------------
            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$_GET['filter_survey_topic_id'])->where("question_isActived",1)->get();

            $this->count_question=count($question);
            $survey= $survey->where('survey_isActived',1);
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            //---------------
            $survey=$survey->get();// so lan khảo sát trong ngày
            //--------tính thông kê từ các bài survey: [user_id][ans_id][question_id]: 
            // user_id chọn đáp án ans_id với cấu hỏi question_id số lần thongke[user_id][ans_id][question_id]
            $header=$this->layheader_bc2($topic);
            $thongketam=$this->tinhthongke_bc2($survey);
            $thongke=$thongketam['thongke'];
            $solanks=$thongketam['solanks'];
            //print_r($solanks);
            //print_r($header);
            //print_r($thongke);
            
            $objects=array();

            foreach($thongke as $key=>$val){
                //echo $key.'---';
                if($topic->topic_type==1) 
                $objects[]= Organization::where('org_isActived', 1)
                       ->where('org_id', $key)
                       ->select('org_id as id','org_name as name') 
                       ->orderBy('org_id', 'DESC') 
                       ->get()->first();
                else
                $objects[]= User::where('user_level','>', 1) 
                       ->where('id', $key)
                       ->select('id as id','fullname as name') 
                       ->orderBy('id', 'DESC') 
                       ->get()->first();
            }
            //=============   

             ////tra ket qua
                   
            $data=array(
                'header'=>$header,
                'thongke'=>$thongke,
                'objects'=>$objects,
                'solanks'=>$solanks,
            );

           // return $data;
            //xua excel luôn
             
    
                //============= 
                $sheet_col='QQ'; 

                $arr_body=array(); 

                $ques=array();
                $ques[0][]=' ';
                $ques[0][]='';
                foreach($question as $no=>$val){
                    $ques[$no+1][]='Câu '.($no+1).':';
                    $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
                }
                
                //---------
                $arr_header_excel=array();
                $arr_header_excel[]='';$arr_header_excel[]='';$arr_header_excel[]='';

                foreach($data['header']['dong1'] as $val1){
                    $arr_header_excel[]=$val1;
                    for($i=1;$i<$data['header']['socauhoi'];$i++){
                        $arr_header_excel[]='';

                    }
                    //
                }
                $dongno=array();
                foreach($data['header']['dong2'] as $val1){
                    $dongno[]=$val1;
                }
                $arr_body[]=$dongno;
                //

               
               // print_r($arr_header_excel);
                //echo '<br>';

                foreach($data['objects'] as $no=>$ob){
                    $dongno=array();
                    $dongno[]=($no+1);
                    $dongno[]=$ob->name;
                    $dongno[]=$data['solanks'][$ob->id];

                    for($i=0;$i<$data['header']['sodapan'];$i++)
                    for($j=0;$j<$data['header']['socauhoi'];$j++){
                        $uid=$ob->id;

                        $aid=$qid=0;
                        if(isset($data['header']['lay_aid'][$i][$j]))
                        $aid=$data['header']['lay_aid'][$i][$j]; 

                        if(isset($data['header']['lay_qid'][$i][$j]))   
                        $qid=$data['header']['lay_qid'][$i][$j];

                        if($aid>0 && $qid>0 && isset($data['thongke'][$uid][$aid][$qid]))
                        $dongno[]=$data['thongke'][$uid][$aid][$qid];
                        else $dongno[]='';

                    } 
                    $arr_body[]=$dongno;
                    //print_r($dongno);
                  //  echo '<br>';
                }
                $dongno=array();
                //$arr_body[]=$dongno;
                $arr_body[]=$ques;
               // $arr_body=[['1','2'],['2','4']]; 
               // $arr_header_excel=['helo','hola'];

                $sheet_data= collect($arr_body);
                $sheet_header=[['BÁO CÁO KHẢO SÁT THEO NHÂN VIÊN VÀ KẾT QUẢ KHẢO SÁT NGÀY '.date("d-m-Y")],$arr_header_excel];
                //0---------
                $tex=new ExcelExport;
                $tex->sheet_col=$sheet_col;
                $tex->sheet_data=$sheet_data;
                $tex->sheet_header=$sheet_header;
                $baocao2=array(
                    'checkbc2'=>1,
                    'sodapan'=>$data['header']['sodapan'],
                    'socauhoi'=>$data['header']['socauhoi'],
                );
                $tex->baocao2=$baocao2; 
              

                $filename='Mau2-Report-'.date("d-m-Y-H-i-s").$orgid.'-bc2.xlsx';  
                //------------
                Excel::store($tex,$filename,'public');

                return storage_path('app/public/').$filename;


                //return Excel::download($tex, $filename);

               //echo  storage_path('app/public/').$filename;



        } 
 
 
    }
 

    public function layheader_bc2($topic){
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topic->topic_id)->where("question_isActived",1)->get();
        $header=array();
        $socauhoi=count($question);
        //--------
        $header['socauhoi']=$socauhoi;
        //-------
        $header['dong1']=array();
        $header['dong2'][]='#';
        $header['dong2'][]='Đối tượng';
        $header['dong2'][]='SL K/Sát';
        $header['layid']=array();

        //print_r($question);
        //echo '<br><br>tttquestion:<br>';
        foreach($question as $no1=>$val1){ 
            $answers=Answer::orderBy('answer_order', 'asc')->where('answer_idQuestion', $val1->question_id)->get();
            //-------
            $header['sodapan']=count($answers);
            foreach($answers as $no2=>$val2){
                $header['dong1'][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val2['answer_description']))));
                for($i=1;$i<=$socauhoi;$i++){
                    $header['dong2'][]='Câu '.$i;
                  
                }
                 
            }
            break;
        }

        foreach($question as $no1=>$val1){ 
            $answers=Answer::orderBy('answer_order', 'asc')->where('answer_idQuestion', $val1->question_id)->get();
            //-------
            $header['sodapan']=count($answers);
            foreach($answers as $no2=>$val2){
                //echo $val1->question_id.'-'.$val2->answer_id.'<br>';
                $header['lay_qid'][$no2][$no1]= $val1->question_id;
                $header['lay_aid'][$no2][$no1]= $val2->answer_id;
            }

            //break;
        }
        

        return $header;
    }

    //thống kê, và xuât excel
    public function layketquabaocaongay($orgid=9){
        $this->xuatexcel=1;
        $organization=Organization::find($orgid); 

        $survey = Survey::orderBy('survey_id', 'ASC');
        $_GET['filter_survey_topic_id']= $organization->org_topic_id; 
        $_GET['filter_survey_idorglv1']= $orgid;
        $_GET['filter-input-ngaykhaosat']=1;
        $_GET['filter_ngaykhaosat_tungay']=date("Y-m-d");
        $_GET['filter_ngaykhaosat_denngay']=date("Y-m-d");

        $_GET['xuatexcel']=1;
         

        $survey = Survey::orderBy('survey_id', 'ASC');
        
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }

       

        

        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }

        


        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();



        // bắt buộc phải chọn chủ đề để thống kê
        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $topic=Topic::find($_GET['filter_survey_topic_id']);

            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$_GET['filter_survey_topic_id'])->where("question_isActived",1)->get();

            $this->count_question=count($question);


            $survey= $survey->where('survey_isActived',1);
            
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            $survey=$survey->get();
            //--------tính thông kê từ các bài survey
            $thongke=$this->tinhthongke($survey);
            $data['count_survey']=$this->count_survey;
            //----------------xử lý kết quả các bài khảo sát
            $arr_header=$this->layheader($topic);// lay header cho khảo sát
            $arr_header_excel=$this->layheaderexcel($topic);
            $arr_body=array();
            $this->dtchartda=array();
            //---- trường hợp chọn đối tượng khảo sát
            if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
                if($topic->topic_type==1){
                    $objecs= Organization::find($_GET['filter_survey_idObject']);
                    $name=$objecs->org_name;
                }
                else{
                    $objecs= User::find($_GET['filter_survey_idObject']);
                    $name=$objecs->fullname;
                }
                //-- tạo ra từng hàng cho file excel

                $arr_body[]=$this->tinhdiemtuthongke($thongke,1,$name,$data['count_survey']);
                
            }
            else{// truong hop khong chọn doi tuong khao sat
                if($topic->topic_type==1) 
                $objecs= Organization::where('org_isActived', 1)
                       ->where('org_level', 1)
                       ->select('org_id as id','org_name as name')
                       ->orderBy('org_id', 'ASC') 
                       ->get();
                else
                $objecs= User::where('user_level','>', 1) 
                       ->select('id as id','fullname as name')
                       ->orderBy('id', 'ASC') 
                       ->get();
                //======
                $no=0;
                foreach($objecs as $val){
                    $surveyi= $survey->where('survey_idObject', '=', $val->id);
                    // tính thống kê từ các bài khảo sát
                    $thongke=$this->tinhthongke($surveyi);
                    $data['count_survey']=$this->count_survey; 
                    //-- tạo ra từng hàng cho file excel
                   
                    if(count($thongke)>0){
                        $no++;
                        $arr_body[]=$this->tinhdiemtuthongke($thongke,$no,$val->name,$data['count_survey']);
                    }
                    else{
                        /*
                         $hangrong=array();
                        $hangrong[]=$no+1;
                        $hangrong[]=$val->name;
                        $hangrong[]='0/0';
                        $hangrong[]='#';
                        $hangrong[]='#';
                        foreach($question as $questionx)
                        $hangrong[]='#';
                        $hangrong[]='#';

                        $arr_body[]=$hangrong;   
                        */

                    }

                }
            }
            /* kiểm tra Xuất Excel */ 
            if(isset($_GET['xuatexcel'])){
                //$arr=array(array('a1','a2','a3'),array('b1','b2','b3'));


                
                $sheet_col='QQ'; 
                $ques=array();
                $ques[0][]=' ';
                $ques[0][]='';

                foreach($question as $no=>$val){
                    $ques[$no+1][]='Câu '.($no+1).':';
                    $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
                }
                $arr_body[]=$ques;
                //==========
                $sheet_data= collect($arr_body);
                //$arr_header=['#','Mã Hồ sơ','Tên Thủ tục','Chủ Hồ Sơ','Số điện thoại','Ngày nhận','Ngày trả','Tình trạng'];
                
                $arr_header_excel=$this->layheaderexcel($topic);

                $sheet_header=[['BÁO CÁO KHẢO SÁT TỔNG HỢP THEO NHÂN VIÊN NGÀY '.date("d-m-Y")],$arr_header_excel];

                
                //Nếu chọn tất cả thì thống kê tổng quát rồi thống kê từng đối tượng cụ thể
                //Nếu chọn đối tượng cụ thể thì thống kê 1 đối tượng đó thôi.
                //Tiêu đề header
                //Đối tượng   | từng câu hỏi và đáp án

                //Tổng hợp    | Số lần chọn từng câu hỏi                
                
                //Đối tượng 1 | Số lần chọn từng câu hỏi
                //Đối tượng ..| Tổng điểm chọn từng câu hỏi
                //Đối tượng i | Tỉ lệ % chọn từng câu hỏi

                //---------
                $tex=new ExcelExport;
                $tex->sheet_col=$sheet_col;
                $tex->sheet_data=$sheet_data;
                $tex->sheet_header=$sheet_header;
                

                $filename='Mau1-Report-'.date("d-m-Y-H-i-s").$orgid.'-bc1.xlsx';
                $path=storage_path('app/public/').date("d-m-Y");

                if (!is_dir($path)) mkdir($path);
                //------------
                Excel::store($tex,$filename,'public');

                return storage_path('app/public/').$filename;

                //return Excel::download($tex, $filename);public_path().'/photos/


 


            } 

        }
        else $survey=array();
    }

     public function baocao3(){
        $kqks_bc3=$this->layketquabaocaongay_bc3(9);

        return view('admin.survey.baocao2',['data'=>$kqks_bc3]);

    }

    public function baocao2(){
        $kqks_bc2=$this->layketquabaocaongay_bc2(9);

        return view('admin.survey.baocao2',['data'=>$kqks_bc2]);

    }

    public function baocao1(){
      /*Lặp:
         B1. Chọn tất cả các đơn vị cấp 1
         B2. Lấy kết quả báo cáo hôm nay của đơn vị này
         B3. Chọn tất cả user có vai trò lãnh đạo của đơn vị này
         B4. Gửi kết quả cho tất cả các user này. */
        //--------
        $orglv1=Organization::where('org_level',1)->get();
        foreach($orglv1 as $val){

            

            if($val->org_nhanemail!="" && $val->org_nhanemail!=" "){
                $users_nhanemail=explode(";",$val->org_nhanemail);
                //print_r($users_nhanemail);

                $bc1=$this->layketquabaocaongay($val->org_id);
                $bc2=$this->layketquabaocaongay_bc2($val->org_id);
                $bc3=$this->layketquabaocaongay_bc3($val->org_id);
                //print_r($kqks['header']);
                $data = array(
                  'to_email'=>"phong2018@gmail.com",
                  'to_name'=>"Tên Người Nhận",
                  'subject'=>$val->org_name.' - Báo Cáo Kết quả khảo sát ngày '. date("d-m-Y"),//Tựa đề của Email
                  'from_email'=>"nkh_email@gmail.com",
                  'from_name'=>Setting::getconfig('config_ks_meta_title'),//"Hệ Thống Khảo Sát",//config_ks_meta_title
                  'view_blade'=>'admin.survey.baocao1',
                  'bc1'=> $bc1,
                  'bc2'=> $bc2,
                  'bc3'=> $bc3,//storage_path('app/public/').'fileName1.xlsx',
                );
                //--------
                foreach($users_nhanemail as $no=>$val2){
                    if (filter_var(trim($val2), FILTER_VALIDATE_EMAIL)) {
                        //echo $no.'---'.$val->org_name.'--.'.$val2.'<br>';
                        $data['to_email']=trim($val2);

                        echo '<br>========::'.($no+1).'<br>';
                        print_r($data['to_email']);
                        echo '<br>========';
                        Guithu::sendmail($data);
                    }
                }

            }

        }

   }

   
   

    public function showsurvey($survey_id){

         $data['title']='Kết quả khảo sát';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic"),
        );

        //==========
        $survey = Survey::find($survey_id);
        $topic = Topic::find($survey->survey_idTopic);
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topic->topic_id)->where("question_isActived",1)->get();  
        //==========
        if(count($question)>0){
            $ans=array();
            $result=array();
            foreach($question as $no=>$val){//với question_id
                // có bao nhiêu câu trả lời    
                $ans[$no]=Answer::orderBy('answer_order', 'asc')->where("answer_idQuestion",$val->question_id)->get();
                // câu trả lời cho câu hỏi này
                $result[$no]= Result::where('result_idSurvey', $survey_id)->where('result_idQuestion', $val->question_id)->first();
                //$result[$no]=

            }
        }
        //==========
        return view('admin.survey.showsurvey',['survey'=>$survey,'data'=>$data,'topic'=>$topic,'question'=>$question,'answer'=>$ans,'result'=>$result]);

    }

    public function thankyou(){     


        return view('admin.survey.thankyou');
    }

    public function delete($id)
    {
        //xoa cau tra loi
        Result::where('result_idSurvey', $id)->delete();
        // xoa survey
        $survey = Survey::find($id);
        if($survey) $survey->delete();
        return redirect('admin/survey/listsurvey');
    }

    public function deletesuveyfail($id,$orgid)
    {
        //xoa cau tra loi
        Result::where('result_idSurvey', $id)->delete();
        // xoa survey
        $survey = Survey::find($id);
        if($survey) $survey->delete();
        return redirect(url('survey/selectorg/'.$orgid));
    }

    public function surveysave(Request $request){
        $topicid=$request->topicid;
        $objectid=$request->objectid;
        $topic = Topic::find($topicid);
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topicid)->where("question_isActived",1)->get(); 
        
        if($topic->topic_type==1) $data['phuongid']=$objectid;
        else{
            $tempuser=User::find($objectid);
            $temporg=Organization::find($tempuser->user_IdOrg);
            if($temporg->org_level==2)
            $tempphuong= Organization::find($temporg->org_idParent);
            else $tempphuong= $temporg;

            $data['phuongid']=$tempphuong->org_id;
        }

        // kiểm tra xem có làm câu nào không nếu không làm đủ thì không lưu
        $checkxoa=0;
        foreach($question as $ques){
            $res = new Result;
            $res->result_idSurvey= $request->surveytid;
            $res->result_idQuestion= $ques->question_id;
            $namequestion='question'.$ques->question_id;

            if($request->$namequestion=='') $checkxoa=1;

            if($ques->question_type==2){//nhiều đáp an checkbox
                $res->result_Answer=json_encode($request->$namequestion) ;
            }
            else $res->result_Answer=$request->$namequestion ; 
            $res->save();
        }
        //$result= Result::where('result_idSurvey', $request->surveytid)->get();
        // 
        if($checkxoa==1){
            $del=Result::where('result_idSurvey',$request->surveytid)->delete();
            $del1=Survey::where('survey_id',$request->surveytid)->delete();
        }
        else{
            $survey=Survey::find($request->surveytid);      
            $survey->survey_isActived=1;
            $survey->survey_customer=$request->customer;
            $survey->survey_idorglv1=$request->survey_idorglv1;

            $survey->save();
        }

        return redirect('survey/slideresult/'.$data['phuongid']);
    }

    public function listsurvey(){
      
         $survey = Survey::orderBy('survey_id', 'ASC');
         $survey= $survey->where('survey_isActived',1);

         //&filter_orgidlv1=31&filter-input-ngaykhaosat=1&filter_ngaykhaosat_tungay=2019-11-13&filter_ngaykhaosat_denngay=2019-11-13
         


         //print_r($survey); 
          $data=array( 
            'filter_orgidlv1'=>0, 
            'filter-input-ngaykhaosat'=>0,
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );

          $data['addurl']=array();
    
        //-----

       
        if(isset($_GET['filter_orgidlv1']) && $_GET['filter_orgidlv1']!=0){
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_orgidlv1']);
            $data['filter_orgidlv1']=$_GET['filter_orgidlv1'];
            
            $data['addurl']['filter_orgidlv1']=$_GET['filter_orgidlv1'];
        }

        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
            $data['addurl']['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }

         if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
                $data['addurl']['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
                $data['addurl']['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }


         

 

          //lọc lại thwo cấp quản lý nếu ko phải admin
        $tempus=User::find(Auth::id());
        if($tempus->user_level>1){ 

           $orgt=Organization::where('org_id',$tempus->user_IdOrg)->get()->first();
           //========
           if($orgt->org_level==2){
              $orgp=Organization::orderBy('org_order', 'ASC')->where('org_id',$orgt->org_idParent)->get()->first();
           }
           else{
              $orgp=Organization::orderBy('org_order', 'ASC')->where('org_id',$tempus->user_IdOrg)->get()->first();
           }

           $survey= $survey->where('survey_idorglv1', '=', $orgp->org_id);
           //=================
           if($orgt->org_level==2){
                $org=Organization::orderBy('org_order', 'ASC')->where('org_id',$orgt->org_idParent)->get();
           }
           else{
                $org=Organization::orderBy('org_order', 'ASC')->where('org_id',$tempus->user_IdOrg)->get();
           }

        }
        else
        $org =Organization::where('org_level',1)->paginate(Setting::getconfig('config_showeverypage'));

        

         

        //-----
        /*kiểm tra có tìm kiểm theo ngày nhận*/
        
  
          
        if(isset($_GET['xoadulieu']))  {
             $survey= $survey->get();
            foreach($survey as $sur){
                
                Result::where('result_idSurvey', $sur->survey_id)->delete();
                $del=Survey::where('survey_id',$sur->survey_id)->delete();
            }


            return  redirect('admin/survey/listsurvey?filter_orgidlv1='.$_GET['filter_orgidlv1']);  

        }else{
            $survey= $survey->paginate(Setting::getconfig('config_showeverypage'));

        
            $data['title']='Dữ liệu khảo sát';

            //tạo breadcumbs
            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                'text' =>'Trang chủ',
                'href' => url("/admin")
            );
            $data['breadcrumbs'][] = array(
                'text' => $data['title'],
                'href' => url("/admin/survey/surveyresult"),
            );
            //'data'=>$data, 

            $topic = Topic::all();



            $data['orgs'] = $org;

            return view('admin.survey.listsurvey',['data'=>$data,'survey'=>$survey,'topic'=>$topic]);
        }
            


    }

    public function layheader($topic){
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topic->topic_id)->where("question_isActived",1)->get();
        $header=array();
        $header[]='#';
        $header[]='Đối tượng';
        $header[]='SL K/Sát';
         $header[]='Tổng điểm';
        $header[]='Tỉ lệ hài lòng';
        if($this->xuatexcel==0)
        $header[]='Biểu đồ %';
        $checkchloai2=0;
        foreach($question as $no1=>$val1)
        if($val1->question_type==1)
        {
            //$header[]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $header[]='<label class="control-label" for="input-survey_idObject">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="'.'Câu '.($no1+1).': '.preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description)))).'">'.'Câu '.($no1+1).'</span>
                </label>';
            $answers=Answer::where('answer_idQuestion', $val1->question_id)->get();
            
            //for($i=1;$i<count($answers);$i++)
            //foreach($answers as $no2=>$val2)
            //$header[]='Điểm';//$val2->ans_scores;

        }
        else{$checkchloai2=1;}
    
        if($checkchloai2==1)
        $header[]='Câu hỏi #';

        foreach($question as $no1=>$val1)
        if($val1->question_type==2)
        {
            //$header[]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $header[]='#'.($no1+1).': '.preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $answers=Answer::where('answer_idQuestion', $val1->question_id)->get();
            
            //for($i=1;$i<count($answers);$i++)
            //foreach($answers as $no2=>$val2)
            //$header[]='Điểm';//$val2->ans_scores;

        }
       


        return $header;
    }

    public function layheaderexcel($topic){
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topic->topic_id)->where("question_isActived",1)->get();
        $header=array();
        $header[]='#';
        $header[]='Đối tượng';
        $header[]='SL K/Sát';
         $header[]='Tổng điểm';
        $header[]='Tỉ lệ hài lòng';
        if($this->xuatexcel==0)
        $header[]='Biểu đồ %';
        $checkchloai2=0;
        foreach($question as $no1=>$val1)
        if($val1->question_type==1)
        {
            //$header[]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $header[]='Câu '.($no1+1);
            $answers=Answer::where('answer_idQuestion', $val1->question_id)->get();
            
            //for($i=1;$i<count($answers);$i++)
            //foreach($answers as $no2=>$val2)
            //$header[]='Điểm';//$val2->ans_scores;

        }
        else{$checkchloai2=1;}
    
        if($checkchloai2==1)
        $header[]='Câu hỏi #';

        foreach($question as $no1=>$val1)
        if($val1->question_type==2)
        {
            //$header[]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $header[]='#'.($no1+1).': '.preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val1->question_description))));
            $answers=Answer::where('answer_idQuestion', $val1->question_id)->get();
            
            //for($i=1;$i<count($answers);$i++)
            //foreach($answers as $no2=>$val2)
            //$header[]='Điểm';//$val2->ans_scores;

        }
       


        return $header;
    }

    public function tinhthongke($survey){
        $thongke=array();
        $this->count_survey=0;
        //echo count($survey);
        foreach($survey as $no1=>$sur){
            //$result= Result::where('result_idSurvey', $sur->survey_id)->get();
            $result= Result::orderBy('result_id', 'ASC')->where('result_idSurvey', $sur->survey_id)->limit($this->count_question)->get();
            
            if(count($result)>0){
                $this->count_survey++;
                foreach($result as $no2=>$res){
                    //---- thông tin câu hỏi
                    $question = Question::where('question_id', $res->result_idQuestion)->first();
                    //---- thông tin câu trả lời
                    $answers=Answer::where('answer_idQuestion', $res->result_idQuestion)->get();
                    //---- câu trả lời lưu trong $res->result_Answer
                    $thongke[$res->result_idQuestion]['question_id']=$question->question_id;
                    $thongke[$res->result_idQuestion]['question_description']=$question->question_description;
                    $thongke[$res->result_idQuestion]['question_type']=$question->question_type;
                    $thongke[$res->result_idQuestion]['question_scores']=$question->question_scores;

                    $arrtt=array();
                    //----lấy thông tin câu trả lời lưu theo id
                    foreach($answers as $no3=>$ans){
                        $thongke[$res->result_idQuestion]['ans'][$ans->answer_id]['ans_description']=$ans->answer_description;
                        $thongke[$res->result_idQuestion]['ans'][$ans->answer_id]['ans_scores']=$ans->answer_scores;
                        // phục vụ cho xuất biểu dồ theo đáp án thứ $no
                        $arrtt[$ans->answer_id]['no']=$no3;
                        $arrtt[$ans->answer_id]['des']=$ans->answer_description;
                    }
                    // kiểm tra xem có chọn câu trả lời không
                    if($res->result_Answer!='') 
                    //----- 1 câu hỏi, nhiều câu trả lời
                    if($question->question_type==2){
                         $result_answer=json_decode( $res->result_Answer,true);
                         foreach($result_answer as $no4)
                         if(isset($thongke[$res->result_idQuestion]['ans'][$no4]['solanchon']))
                            $thongke[$res->result_idQuestion]['ans'][$no4]['solanchon']++;
                         else  $thongke[$res->result_idQuestion]['ans'][$no4]['solanchon']=1;
                    }
                    else{//----- 1 câu hỏi, 1 câu trả lời
                        $result_answer= $res->result_Answer;
                        if(isset($thongke[$res->result_idQuestion]['ans'][$result_answer]['solanchon']))
                        $thongke[$res->result_idQuestion]['ans'][$result_answer]['solanchon']++;
                        else $thongke[$res->result_idQuestion]['ans'][$result_answer]['solanchon']=1;

                        // phục vụ xuất biểu đồ theo đáp án thứ $no
                        if(isset($this->dtchartda[$arrtt[$result_answer]['no']]['slc']))
                        $this->dtchartda[$arrtt[$result_answer]['no']]['slc']++;
                        else $this->dtchartda[$arrtt[$result_answer]['no']]['slc']=1;

                        $this->dtchartda[$arrtt[$result_answer]['no']]['des']= preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($arrtt[$result_answer]['des']))));

                    }
                    //--------
                }
            }
            else{  // xóa thống kê ko đủ đáp án theo ngày
                 $del=Survey::where('survey_id',$sur->survey_id)->where('survey_created_at','<',date("Y-m-d"))->delete();
            }

        }
        return $thongke;
    }

    public function tinhthongke_bc2($survey){
        $data=array();

        $data['thongke']=array();
        $data['solanks']=array();
        foreach($survey as $no1=>$sur){
            //print_r($sur);
            //echo '<br><br>';
            //các đáp án trong survey
            $result= Result::orderBy('result_id', 'ASC')->where('result_idSurvey', $sur->survey_id)->get();
            if(count($result)>0){
                if(isset($data['solanks'][$sur['survey_idObject']]))
                $data['solanks'][$sur['survey_idObject']]++;
                else
                $data['solanks'][$sur['survey_idObject']]=1;

                foreach($result as $no2=>$res){ 
                    //print_r($res);
                    //echo '<br><br>';
                    $ansid=(int)$res->result_Answer;
                    //---- thông tin câu hỏi
                    $question = Question::where('question_id', $res->result_idQuestion)->first();
                    //---- thông tin câu trả lời
                    //$answers=Answer::where('answer_idQuestion', $res->result_idQuestion)->get(); 

                     
                    if(isset($data['thongke'][$sur['survey_idObject']][$ansid][$res->result_idQuestion]))
                        
                    $data['thongke'][$sur['survey_idObject']][$ansid][$res->result_idQuestion]++;

                    else $data['thongke'][$sur['survey_idObject']][$ansid][$res->result_idQuestion]=1;
                     

                }

            }
        }
        //print_r($data['thongke']);

        return $data;
    }

    public function tinhdiemtuthongke($thongke,$no,$name,$sokhaosat){
        $socau=0;
      
        //===tính kết quả trước
        $socauloai1=0;
        $tongdiemcauloai1=0;
        $tongdiemchoncauloai1=0;
     
        //====
        $socauloai2=0;
        $tongdiemcauloai2=0;
        $tongdiemchoncauloai2=0;
        $tinhdiem=array();
        $tinhdiem[]=$no;
        $tinhdiem[]=$name; 
        $tinhdiem[]=$sokhaosat;




        //------
        foreach($thongke as $key1=>$question){
            if($question['question_type']==1){
              $socauloai1++;
              $tongdiemcauloai1=$tongdiemcauloai1+$thongke[$key1]['question_scores'];
              
              foreach($thongke[$key1]['ans'] as $ans_id=>$ans){
                  if(!isset($ans['ans_scores']))$ans['ans_scores']=0;
                  if(isset($ans['solanchon']))  $solanchon=$ans['solanchon'];
                  else $solanchon=0;
                  $tongdiemchoncauloai1=$tongdiemchoncauloai1+$ans['ans_scores']*$solanchon;
              }
            }  
            else
            if($question['question_type']==2){
              $socauloai2++;
              $tongdiemcauloai2+=$thongke[$key1]['question_scores'];
              foreach($thongke[$key1]['ans'] as $ans_id=>$ans){
                  if(!isset($ans['ans_scores']))$ans['ans_scores']=0;
                  if(isset($ans['solanchon']))  $solanchon=$ans['solanchon'];
                  else $solanchon=0;
                  $tongdiemchoncauloai2+=$ans['ans_scores']*$solanchon;
              }
            }
        }
        //---------
        if($tongdiemcauloai1>0 && $sokhaosat>0){
            $tinhdiem[]=$tongdiemchoncauloai1.'/'.($tongdiemcauloai1*$sokhaosat);
            $tilept=number_format ($tongdiemchoncauloai1/($tongdiemcauloai1*$sokhaosat),4)*100;
        }else{
           $tinhdiem[]=0; 
           $tilept=0;
        }
        //======
        $tinhdiem[]=$tilept.'%';
        if($this->xuatexcel==0)
        $tinhdiem[]="<div style='border:none;width:100px; '><div class='containerbar'>
               <div class='skillsbar html' style='width:".$tilept."%;'>".$tilept."%</div></div></div>";

        $checkchloai2=0;
        //========
        foreach($thongke as $key1=>$question)
        if($question['question_type']==1)
        {
            //$tinhdiem[]= preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($thongke[$key1]['question_description']))));

            $diemcau=0;
            foreach($thongke[$key1]['ans'] as $ans_id=>$ans){
               if(!isset($ans['ans_description']))$ans['ans_description']='';
               if(!isset($ans['ans_scores']))$ans['ans_scores']=0;
                
               //echo $ans['ans_description'];
                
               if(isset($ans['solanchon']))  $solanchon=$ans['solanchon'];
               else $solanchon=0;

                $diemcau+=$solanchon*$ans['ans_scores'];
                
            }
            $tinhdiem[]=$diemcau;

        }else{$checkchloai2=1;}
        //========
        if($checkchloai2==1)
        $tinhdiem[]='';
        foreach($thongke as $key1=>$question)
        if($question['question_type']==2)
        {
            //$tinhdiem[]= preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($thongke[$key1]['question_description']))));

            $diemcau=0;
            foreach($thongke[$key1]['ans'] as $ans_id=>$ans){
               if(!isset($ans['ans_description']))$ans['ans_description']='';
               if(!isset($ans['ans_scores']))$ans['ans_scores']=0;
                
               //echo $ans['ans_description'];
                
               if(isset($ans['solanchon']))  $solanchon=$ans['solanchon'];
               else $solanchon=0;

                $diemcau+=$solanchon*$ans['ans_scores'];
                
               

                
            }
            $tinhdiem[]=$diemcau;

        }
        return $tinhdiem;
    }


    //thống kê, và xuât excel
    public function slideresult($orgid){
        $this->xuatexcel=0;
        $org=Organization::find($orgid);

        $_GET['filter_survey_idorglv1']=$orgid;
        $_GET['filter_survey_topic_id']=$org->org_topic_id;


        $survey = Survey::orderBy('survey_id', 'ASC');
        
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }

       

        

        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }

        


        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();



        // bắt buộc phải chọn chủ đề để thống kê
        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $topic=Topic::find($_GET['filter_survey_topic_id']);

            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$_GET['filter_survey_topic_id'])->where("question_isActived",1)->get();

            $this->count_question=count($question);


            $survey= $survey->where('survey_isActived',1);
            
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            $survey=$survey->get();
            //--------tính thông kê từ các bài survey
            $thongke=$this->tinhthongke($survey);
            $data['count_survey']=$this->count_survey;
            //----------------xử lý kết quả các bài khảo sát
            $arr_header=$this->layheader($topic);// lay header cho khảo sát
            $arr_header_excel=$this->layheaderexcel($topic);
            $arr_body=array();
            $this->dtchartda=array();
            //---- trường hợp chọn đối tượng khảo sát
            if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
                if($topic->topic_type==1){
                    $objecs= Organization::find($_GET['filter_survey_idObject']);
                    $name=$objecs->org_name;
                }
                else{
                    $objecs= User::find($_GET['filter_survey_idObject']);
                    $name=$objecs->fullname;
                }
                //-- tạo ra từng hàng cho file excel

                $arr_body[]=$this->tinhdiemtuthongke($thongke,1,$name,$data['count_survey']);
                
            }
            else{// truong hop khong chọn doi tuong khao sat
                if($topic->topic_type==1) 
                $objecs= Organization::where('org_isActived', 1)
                       ->where('org_level', 1)
                       ->select('org_id as id','org_name as name')
                       ->orderBy('org_id', 'ASC') 
                       ->get();
                else
                $objecs= User::where('user_level','>', 1) 
                       ->select('id as id','fullname as name')
                       ->orderBy('id', 'ASC') 
                       ->get();
                //======
                $no=0;
                foreach($objecs as $val){
                    $surveyi= $survey->where('survey_idObject', '=', $val->id);
                    // tính thống kê từ các bài khảo sát
                    $thongke=$this->tinhthongke($surveyi);
                    $data['count_survey']=$this->count_survey; 
                    //-- tạo ra từng hàng cho file excel
                   
                    if(count($thongke)>0){
                        $no++;
                        $arr_body[]=$this->tinhdiemtuthongke($thongke,$no,$val->name,$data['count_survey']);
                    }
                    else{
                        /*
                         $hangrong=array();
                        $hangrong[]=$no+1;
                        $hangrong[]=$val->name;
                        $hangrong[]='0/0';
                        $hangrong[]='#';
                        $hangrong[]='#';
                        foreach($question as $questionx)
                        $hangrong[]='#';
                        $hangrong[]='#';

                        $arr_body[]=$hangrong;   
                        */

                    }

                }
            }
            /* kiểm tra Xuất Excel */ 
            if(isset($_GET['xuatexcel'])){
                //$arr=array(array('a1','a2','a3'),array('b1','b2','b3'));


                
                $sheet_col='QQ'; 
                $ques=array();
                $ques[0][]=' ';
                $ques[0][]='';

                foreach($question as $no=>$val){
                    $ques[$no+1][]='Câu '.($no+1).':';
                    $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
                }
                $arr_body[]=$ques;
                //==========
                $sheet_data= collect($arr_body);
                //$arr_header=['#','Mã Hồ sơ','Tên Thủ tục','Chủ Hồ Sơ','Số điện thoại','Ngày nhận','Ngày trả','Tình trạng'];
                
                $arr_header_excel=$this->layheaderexcel($topic);

                $sheet_header=[['BÁO CÁO KHẢO SÁT'],$arr_header_excel];

                
                //Nếu chọn tất cả thì thống kê tổng quát rồi thống kê từng đối tượng cụ thể
                //Nếu chọn đối tượng cụ thể thì thống kê 1 đối tượng đó thôi.
                //Tiêu đề header
                //Đối tượng   | từng câu hỏi và đáp án

                //Tổng hợp    | Số lần chọn từng câu hỏi                
                
                //Đối tượng 1 | Số lần chọn từng câu hỏi
                //Đối tượng ..| Tổng điểm chọn từng câu hỏi
                //Đối tượng i | Tỉ lệ % chọn từng câu hỏi

                //---------
                $tex=new ExcelExport;
                $tex->sheet_col=$sheet_col;
                $tex->sheet_data=$sheet_data;
                $tex->sheet_header=$sheet_header;
                $filename='Report-Survey-'.date("d-m-Y-H-i-s").'.xlsx';
                return Excel::download($tex, $filename);
            } 

        }
        else $survey=array();
 


        // input
        //$survey=$survey->get();
        /*
        $topic_id=$_GET['filter_survey_topic_id'];
        $question = Question::where('topic_id', $topic_id)->get();
        //---- thống kê kết quả khảo sát
        foreach($survey as $no->$sur){
            $resultno= Result::where('result_idSurvey', $sur->survey_id)->get();
            foreach($resultno as $nore->$res){

            }

        }
        */

        //========
        $chart_eveobject=array();
        $chart_diemtheocau=array();
        
        
        

        foreach($arr_body as $no=>$val){
           $vall=$val;
           $arr=explode("/",$val[3]);
           $diem=number_format(($arr[0]/$arr[1])*100,2);
           $chart_eveobject[]=array($val[1].' ('.$val[3].'Đ: '.$val[4].')',$diem);

           foreach($vall as $no1=>$val1)
            if($no1>5){
                if(!isset($chart_diemtheocau[$no1-5]['score'])){
                    $chart_diemtheocau[$no1-5]['score']=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']=$vall[2];
                }
                else{
                    $chart_diemtheocau[$no1-5]['score']+=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']+=$vall[2];
                }
           }
        } 




        if(isset($question))
        foreach($question as $no=>$val){
            //echo $question[$no]['question_description'];
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no]['question_description']))));
        }

        $dtchart_diemtheocau=array();
        
        if(isset($question))
        foreach($chart_diemtheocau as $no=>$val){
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description']))));
            $diem=number_format(($val['score']/($val['soluotks']*$question[$no-1]['question_scores']))*100,2);
            $dtchart_diemtheocau[]=array( preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description'])))).'('.$val['score'].'/'.($val['soluotks']*$question[$no-1]['question_scores']).'Đ: ' .$diem.'%)',$diem);
        }
        //==========
         
        $lava = new Lavacharts; 
        $fans = $lava->DataTable(); 
        $value=$chart_eveobject;
 
        $fans->addStringColumn('Họ tên')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DanhGiaTungNhanVien', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*70,
            'width'=>900,
            'min'=>0, 
             'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo nhân viên'
        ]);
        //==============
      
        $fans = $lava->DataTable();
        $value=$dtchart_diemtheocau;

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DiemTheoCau', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*60,
            'width'=>900,
            'min'=>0,  
            'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],

            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo câu hỏi'
        ]);
 
        //return view('admin.survey.geochart',compact('lava'));

        //print_r($this->dtchartda);


        $fans = $lava->DataTable();
        $value=array();
        if(count($this->dtchartda)>0)
        foreach($this->dtchartda as $val){
            $value[]=array($val['des'],$val['slc']);
        }

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->PieChart('DiemTheoDapAn', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> count($value)*160,
            'width'=>900,
            'min'=>0, 
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo độ hài lòng'
        ]);

 

        $data['title']='Kết quả khảo sát';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/survey/surveyresult"),
        );
        //'data'=>$data, 


         

        $topic = Topic::all();

        $data['orgsv']=$orgid;

        return view('admin.survey.slideresult',['data'=>$data,'arr_body'=>$arr_body,'arr_header'=>$arr_header,'thongke'=>$thongke,'survey'=>$survey,'topic'=>$topic,'lava'=>$lava ]);
    }
    //-----
    //thống kê, và xuât excel
    public function slidetv($orgid){
        $this->xuatexcel=0;
        $org=Organization::find($orgid);

        $_GET['filter_survey_idorglv1']=$orgid;
        $_GET['filter_survey_topic_id']=$org->org_topic_id;


        $survey = Survey::orderBy('survey_id', 'ASC');
        
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }

       

        

        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }

        


        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();



        // bắt buộc phải chọn chủ đề để thống kê
        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $topic=Topic::find($_GET['filter_survey_topic_id']);

            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$_GET['filter_survey_topic_id'])->where("question_isActived",1)->get();

            $this->count_question=count($question);


            $survey= $survey->where('survey_isActived',1);
            
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            $survey=$survey->get();
            //--------tính thông kê từ các bài survey
            $thongke=$this->tinhthongke($survey);
            $data['count_survey']=$this->count_survey;
            //----------------xử lý kết quả các bài khảo sát
            $arr_header=$this->layheader($topic);// lay header cho khảo sát
            $arr_header_excel=$this->layheaderexcel($topic);
            $arr_body=array();
            $this->dtchartda=array();
            //---- trường hợp chọn đối tượng khảo sát
            if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
                if($topic->topic_type==1){
                    $objecs= Organization::find($_GET['filter_survey_idObject']);
                    $name=$objecs->org_name;
                }
                else{
                    $objecs= User::find($_GET['filter_survey_idObject']);
                    $name=$objecs->fullname;
                }
                //-- tạo ra từng hàng cho file excel

                $arr_body[]=$this->tinhdiemtuthongke($thongke,1,$name,$data['count_survey']);
                
            }
            else{// truong hop khong chọn doi tuong khao sat
                if($topic->topic_type==1) 
                $objecs= Organization::where('org_isActived', 1)
                       ->where('org_level', 1)
                       ->select('org_id as id','org_name as name')
                       ->orderBy('org_id', 'ASC') 
                       ->get();
                else
                $objecs= User::where('user_level','>', 1) 
                       ->select('id as id','fullname as name')
                       ->orderBy('id', 'ASC') 
                       ->get();
                //======
                $no=0;
                foreach($objecs as $val){
                    $surveyi= $survey->where('survey_idObject', '=', $val->id);
                    // tính thống kê từ các bài khảo sát
                    $thongke=$this->tinhthongke($surveyi);
                    $data['count_survey']=$this->count_survey; 
                    //-- tạo ra từng hàng cho file excel
                   
                    if(count($thongke)>0){
                        $no++;
                        $arr_body[]=$this->tinhdiemtuthongke($thongke,$no,$val->name,$data['count_survey']);
                    }
                    else{
                        /*
                         $hangrong=array();
                        $hangrong[]=$no+1;
                        $hangrong[]=$val->name;
                        $hangrong[]='0/0';
                        $hangrong[]='#';
                        $hangrong[]='#';
                        foreach($question as $questionx)
                        $hangrong[]='#';
                        $hangrong[]='#';

                        $arr_body[]=$hangrong;   
                        */

                    }

                }
            }
            /* kiểm tra Xuất Excel */ 
            if(isset($_GET['xuatexcel'])){
                //$arr=array(array('a1','a2','a3'),array('b1','b2','b3'));


                
                $sheet_col='QQ'; 
                $ques=array();
                $ques[0][]=' ';
                $ques[0][]='';

                foreach($question as $no=>$val){
                    $ques[$no+1][]='Câu '.($no+1).':';
                    $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
                }
                $arr_body[]=$ques;
                //==========
                $sheet_data= collect($arr_body);
                //$arr_header=['#','Mã Hồ sơ','Tên Thủ tục','Chủ Hồ Sơ','Số điện thoại','Ngày nhận','Ngày trả','Tình trạng'];
                
                $arr_header_excel=$this->layheaderexcel($topic);

                $sheet_header=[['BÁO CÁO KHẢO SÁT'],$arr_header_excel];

                
                //Nếu chọn tất cả thì thống kê tổng quát rồi thống kê từng đối tượng cụ thể
                //Nếu chọn đối tượng cụ thể thì thống kê 1 đối tượng đó thôi.
                //Tiêu đề header
                //Đối tượng   | từng câu hỏi và đáp án

                //Tổng hợp    | Số lần chọn từng câu hỏi                
                
                //Đối tượng 1 | Số lần chọn từng câu hỏi
                //Đối tượng ..| Tổng điểm chọn từng câu hỏi
                //Đối tượng i | Tỉ lệ % chọn từng câu hỏi

                //---------
                $tex=new ExcelExport;
                $tex->sheet_col=$sheet_col;
                $tex->sheet_data=$sheet_data;
                $tex->sheet_header=$sheet_header;
                $filename='Report-Survey-'.date("d-m-Y-H-i-s").'.xlsx';
                return Excel::download($tex, $filename);
            } 

        }
        else $survey=array();
 


        // input
        //$survey=$survey->get();
        /*
        $topic_id=$_GET['filter_survey_topic_id'];
        $question = Question::where('topic_id', $topic_id)->get();
        //---- thống kê kết quả khảo sát
        foreach($survey as $no->$sur){
            $resultno= Result::where('result_idSurvey', $sur->survey_id)->get();
            foreach($resultno as $nore->$res){

            }

        }
        */

        //========
        $chart_eveobject=array();
        $chart_diemtheocau=array();
        
        
        

        foreach($arr_body as $no=>$val){
           $vall=$val;
           $arr=explode("/",$val[3]);
           $diem=number_format(($arr[0]/$arr[1])*100,2);
           $chart_eveobject[]=array($val[1].' ('.$val[3].'Đ: '.$val[4].')',$diem);

           foreach($vall as $no1=>$val1)
            if($no1>5){
                if(!isset($chart_diemtheocau[$no1-5]['score'])){
                    $chart_diemtheocau[$no1-5]['score']=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']=$vall[2];
                }
                else{
                    $chart_diemtheocau[$no1-5]['score']+=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']+=$vall[2];
                }
           }
        } 




        if(isset($question))
        foreach($question as $no=>$val){
            //echo $question[$no]['question_description'];
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no]['question_description']))));
        }

        $dtchart_diemtheocau=array();
        
        if(isset($question))
        foreach($chart_diemtheocau as $no=>$val){
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description']))));
            $diem=number_format(($val['score']/($val['soluotks']*$question[$no-1]['question_scores']))*100,2);
            $dtchart_diemtheocau[]=array( preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description'])))).'('.$val['score'].'/'.($val['soluotks']*$question[$no-1]['question_scores']).'Đ: ' .$diem.'%)',$diem);
        }
        //==========
         
        $lava = new Lavacharts; 
        $fans = $lava->DataTable(); 
        $value=$chart_eveobject;
 
        $fans->addStringColumn('Họ tên')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DanhGiaTungNhanVien', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*70,
            'width'=>900,
            'min'=>0, 
             'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo nhân viên'
        ]);
        //==============
      
        $fans = $lava->DataTable();
        $value=$dtchart_diemtheocau;

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DiemTheoCau', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*60,
            'width'=>900,
            'min'=>0,  
            'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],

            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo câu hỏi'
        ]);
 
        //return view('admin.survey.geochart',compact('lava'));

        //print_r($this->dtchartda);


        $fans = $lava->DataTable();
        $value=array();
        if(count($this->dtchartda)>0)
        foreach($this->dtchartda as $val){
            $value[]=array($val['des'],$val['slc']);
        }

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->PieChart('DiemTheoDapAn', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> count($value)*160,
            'width'=>900,
            'min'=>0, 
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo độ hài lòng'
        ]);

 

        $data['title']='Kết quả khảo sát';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/survey/surveyresult"),
        );
        //'data'=>$data, 


         

        $topic = Topic::all();

        $data['orgsv']=$orgid;

        return view('admin.survey.slidetv',['data'=>$data,'arr_body'=>$arr_body,'arr_header'=>$arr_header,'thongke'=>$thongke,'survey'=>$survey,'topic'=>$topic,'lava'=>$lava ]);
    }
    //thống kê, và xuât excel
    public function surveyresult(){
        if(isset($_GET['xuatexcel'])) $this->xuatexcel=1;
        else $this->xuatexcel=0;


        $survey = Survey::orderBy('survey_id', 'ASC');
        
        
        $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idObject'=>0,
            'filter_survey_idorglv1'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // trường họp chọn đt khảo sát cụ thể
        
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }

        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){ 
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
        }

       

        

        //-----
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }

        


        /*kiểm tra có tìm kiểm theo ngày nhận*/
        if(isset($_GET['filter-input-ngaykhaosat']) && $_GET['filter-input-ngaykhaosat']!=''){
            $data['filter-input-ngaykhaosat']=$_GET['filter-input-ngaykhaosat'];
        }
        if($data['filter-input-ngaykhaosat']>0){
            //check   từ ngày
            if(isset($_GET['filter_ngaykhaosat_tungay']) && $_GET['filter_ngaykhaosat_tungay']!=''){
                $survey= $survey->where('survey_created_at', '>=', date($_GET['filter_ngaykhaosat_tungay']));
                $data['filter_ngaykhaosat_tungay']=$_GET['filter_ngaykhaosat_tungay'];
            }
            //check   den ngày
            if(isset($_GET['filter_ngaykhaosat_denngay']) && $_GET['filter_ngaykhaosat_denngay']!=''){
                $survey= $survey->where('survey_created_at', '<=', date($_GET['filter_ngaykhaosat_denngay']));
                $data['filter_ngaykhaosat_denngay']=$_GET['filter_ngaykhaosat_denngay'];
            }
        }
             
        $thongke=array();
        $data['count_survey']=0;
        $arr_header=array();
        $arr_body=array();



        // bắt buộc phải chọn chủ đề để thống kê
        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $topic=Topic::find($_GET['filter_survey_topic_id']);

            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$_GET['filter_survey_topic_id'])->where("question_isActived",1)->get();

            $this->count_question=count($question);


            $survey= $survey->where('survey_isActived',1);
            
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
            $survey=$survey->get();
            //--------tính thông kê từ các bài survey
            $thongke=$this->tinhthongke($survey);
            $data['count_survey']=$this->count_survey;
            //----------------xử lý kết quả các bài khảo sát
            $arr_header=$this->layheader($topic);// lay header cho khảo sát
            $arr_header_excel=$this->layheaderexcel($topic);
            $arr_body=array();
            $this->dtchartda=array();
            //---- trường hợp chọn đối tượng khảo sát
            if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
                if($topic->topic_type==1){
                    $objecs= Organization::find($_GET['filter_survey_idObject']);
                    $name=$objecs->org_name;
                }
                else{
                    $objecs= User::find($_GET['filter_survey_idObject']);
                    $name=$objecs->fullname;
                }
                //-- tạo ra từng hàng cho file excel

                $arr_body[]=$this->tinhdiemtuthongke($thongke,1,$name,$data['count_survey']);
                
            }
            else{// truong hop khong chọn doi tuong khao sat
                if($topic->topic_type==1) 
                $objecs= Organization::where('org_isActived', 1)
                       ->where('org_level', 1)
                       ->select('org_id as id','org_name as name')
                       ->orderBy('org_id', 'ASC') 
                       ->get();
                else
                $objecs= User::where('user_level','>', 1) 
                       ->select('id as id','fullname as name')
                       ->orderBy('id', 'ASC') 
                       ->get();
                //======
                $no=0;
                foreach($objecs as $val){
                    $surveyi= $survey->where('survey_idObject', '=', $val->id);
                    // tính thống kê từ các bài khảo sát
                    $thongke=$this->tinhthongke($surveyi);
                    $data['count_survey']=$this->count_survey; 
                    //-- tạo ra từng hàng cho file excel
                   
                    if(count($thongke)>0){
                        $no++;
                        $arr_body[]=$this->tinhdiemtuthongke($thongke,$no,$val->name,$data['count_survey']);
                    }
                    else{
                        /*
                         $hangrong=array();
                        $hangrong[]=$no+1;
                        $hangrong[]=$val->name;
                        $hangrong[]='0/0';
                        $hangrong[]='#';
                        $hangrong[]='#';
                        foreach($question as $questionx)
                        $hangrong[]='#';
                        $hangrong[]='#';

                        $arr_body[]=$hangrong;   
                        */

                    }

                }
            }
            /* kiểm tra Xuất Excel */ 
            if(isset($_GET['xuatexcel'])){
                //$arr=array(array('a1','a2','a3'),array('b1','b2','b3'));


                
                $sheet_col='QQ'; 
                $ques=array();
                $ques[0][]=' ';
                $ques[0][]='';

                foreach($question as $no=>$val){
                    $ques[$no+1][]='Câu '.($no+1).':';
                    $ques[$no+1][]=preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($val['question_description']))));
                }
                $arr_body[]=$ques;
                //==========
                $sheet_data= collect($arr_body);
                //$arr_header=['#','Mã Hồ sơ','Tên Thủ tục','Chủ Hồ Sơ','Số điện thoại','Ngày nhận','Ngày trả','Tình trạng'];
                
                $arr_header_excel=$this->layheaderexcel($topic);

                $sheet_header=[['BÁO CÁO KHẢO SÁT'],$arr_header_excel];

                
                //Nếu chọn tất cả thì thống kê tổng quát rồi thống kê từng đối tượng cụ thể
                //Nếu chọn đối tượng cụ thể thì thống kê 1 đối tượng đó thôi.
                //Tiêu đề header
                //Đối tượng   | từng câu hỏi và đáp án

                //Tổng hợp    | Số lần chọn từng câu hỏi                
                
                //Đối tượng 1 | Số lần chọn từng câu hỏi
                //Đối tượng ..| Tổng điểm chọn từng câu hỏi
                //Đối tượng i | Tỉ lệ % chọn từng câu hỏi

                //---------
                $tex=new ExcelExport;
                $tex->sheet_col=$sheet_col;
                $tex->sheet_data=$sheet_data;
                $tex->sheet_header=$sheet_header;
                $filename='Report-Survey-'.date("d-m-Y-H-i-s").'.xlsx';
                return Excel::download($tex, $filename);
            } 

        }
        else $survey=array();
 


        // input
        //$survey=$survey->get();
        /*
        $topic_id=$_GET['filter_survey_topic_id'];
        $question = Question::where('topic_id', $topic_id)->get();
        //---- thống kê kết quả khảo sát
        foreach($survey as $no->$sur){
            $resultno= Result::where('result_idSurvey', $sur->survey_id)->get();
            foreach($resultno as $nore->$res){

            }

        }
        */

        //========
        $chart_eveobject=array();
        $chart_diemtheocau=array();
        
        
        

        foreach($arr_body as $no=>$val){
           $vall=$val;
           $arr=explode("/",$val[3]);
           $diem=number_format(($arr[0]/$arr[1])*100,2);
           $chart_eveobject[]=array($val[1].' ('.$val[3].'Đ: '.$val[4].')',$diem);

           foreach($vall as $no1=>$val1)
            if($no1>5){
                if(!isset($chart_diemtheocau[$no1-5]['score'])){
                    $chart_diemtheocau[$no1-5]['score']=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']=$vall[2];
                }
                else{
                    $chart_diemtheocau[$no1-5]['score']+=$val1;
                    $chart_diemtheocau[$no1-5]['soluotks']+=$vall[2];
                }
           }
        } 




        if(isset($question))
        foreach($question as $no=>$val){
            //echo $question[$no]['question_description'];
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no]['question_description']))));
        }

        $dtchart_diemtheocau=array();
        
        if(isset($question))
        foreach($chart_diemtheocau as $no=>$val){
            //echo preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description']))));
            $diem=number_format(($val['score']/($val['soluotks']*$question[$no-1]['question_scores']))*100,2);
            $dtchart_diemtheocau[]=array( preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($question[$no-1]['question_description'])))).'('.$val['score'].'/'.($val['soluotks']*$question[$no-1]['question_scores']).'Đ: ' .$diem.'%)',$diem);
        }
        //==========
         
        $lava = new Lavacharts; 
        $fans = $lava->DataTable(); 
        $value=$chart_eveobject;
 
        $fans->addStringColumn('Họ tên')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DanhGiaTungNhanVien', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*70,
            'width'=>900,
            'min'=>0, 
             'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo nhân viên'
        ]);
        //==============
      
        $fans = $lava->DataTable();
        $value=$dtchart_diemtheocau;

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->BarChart('DiemTheoCau', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> (count($value)+1)*60,
            'width'=>900,
            'min'=>0,  
            'labels'=> ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],

            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo câu hỏi'
        ]);
 
        //return view('admin.survey.geochart',compact('lava'));

        //print_r($this->dtchartda);


        $fans = $lava->DataTable();
        $value=array();
        if(count($this->dtchartda)>0)
        foreach($this->dtchartda as $val){
            $value[]=array($val['des'],$val['slc']);
        }

        $fans->addStringColumn('Độ Hài Lòng')
                   ->addNumberColumn('Tỉ lệ hài lòng')
                   ->addRows($value); 
        $lava->PieChart('DiemTheoDapAn', $fans,[ 
            'png' => true,
            'fontSize'=> 12,
            'height'=> count($value)*160,
            'width'=>900,
            'min'=>0, 
            'max'=>100,
            'chartArea' => array('left'=>300,'top'=>40,'bottom'=>50,'right'=>100),
            'title'=>'Biểu đồ đánh giá hài lòng theo độ hài lòng'
        ]);

 

        $data['title']='Kết quả khảo sát';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/survey/surveyresult"),
        );
        //'data'=>$data, 


        $topic = Topic::all();

        $tempus=User::find(Auth::id());
        if($tempus->user_level==1){}
        else{
           $orgt=Organization::where('org_id',$tempus->user_IdOrg)->get()->first();
           if($orgt->org_level==2){
              $orgp=Organization::orderBy('org_order', 'ASC')->where('org_id',$orgt->org_idParent)->get()->first();
           }
           else{
              $orgp=Organization::orderBy('org_order', 'ASC')->where('org_id',$tempus->user_IdOrg)->get()->first();
           }
           $org=$orgp;

           $topic = Topic::where('topic_idorg',0)->orwhere('topic_idorg',$org->org_id)->get();
 
        }
        


        return view('admin.survey.surveyresult',['data'=>$data,'arr_body'=>$arr_body,'arr_header'=>$arr_header,'thongke'=>$thongke,'survey'=>$survey,'topic'=>$topic,'lava'=>$lava ]);
    }

    public function dosurvey($topicid,$objectid,$giaodien=2)
    {
        //echo $giaodien;
        //echo session()->getId();
        //kiểm tra xem session_id này đã làm topic này chưa, nếu chưa làm thì thêm khảo sát
        //time()

        //$sur=Survey::where("survey_session_id",session()->getId())->where("survey_idTopic",$topicid)->where("survey_idObject",$objectid)->get(); 
        //if(count($sur)==0){
        $sur=new Survey;
        $sur->survey_idTopic=$topicid;
        $sur->survey_idObject=$objectid;
        $sur->survey_session_id=session()->getId();
        $sur->survey_created_at=date("Y-m-d");
        $sur->survey_isActived=0;
        $sur->save(); 
        //}        
        $data['title']='Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic"),
        );
        //'data'=>$data,   

        $topic = Topic::find($topicid);

        if($topic->topic_type==1){
            $object=Organization::find($objectid);
            $data['nameob']=$object->org_name;
            $data['thumbob']= $object->org_image;
            $data['infoob']='';
            $data['infoob1']='';

            $data['orgsv']=$objectid;
            
            $data['orgid']=$objectid;

        }
        else{
            $object=User::find($objectid);
            $data['nameob']=$object->fullname;
            $data['thumbob']= $object->avatar;
            $data['infoob']='Mã NV: '.$object->ID_Staff;
            $data['infoob1']='Chức danh: '.$object->chucdanh;
            //------
            $tempuser=User::find($objectid);
            $temporg=Organization::find($tempuser->user_IdOrg);
            if($temporg->org_level==2)
            $tempphuong= Organization::find($temporg->org_idParent);
            else $tempphuong= $temporg;

            $data['orgid']=$tempphuong->org_id;

        }
        $data['config_amthanhcamon'] = Setting::getconfig('config_amthanhcamon');

        $data['config_time_auto_direct']=Setting::getconfig('config_time_auto_direct'); 
        //-----lấy ds nhân viên để đánh giá nếu đánh giá nhân viên và cấu hình chọn nhân viên đánh giá
        $data['config_dangkythietbidekhaosat']=Setting::getconfig('config_dangkythietbidekhaosat'); 

        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$topicid)->where("question_isActived",1)->get();      

        if(count($question)>0){
            $ans=array();
            foreach($question as $no=>$val){
                $ans[$no]=Answer::orderBy('answer_order', 'asc')->where("answer_idQuestion",$val->question_id)->get();
            }

            //$deviceid = "<script>document.write(localStorage.getItem('divideid'));</script>";
            //$device=Device::where('device_uid', $deviceid)->first();

           if($topic->topic_type==2){  // khảo sát nhân viên
                if($giaodien==2)//màn hình ngang
                return view('admin.survey.dosurvey',['survey'=>$sur,'data'=>$data,'topic'=>$topic,'question'=>$question,'answer'=>$ans,'objectid'=>$objectid]);
                else//if($giaodien==1)//màn hình doc
                return view('admin.survey.dosurvey_doc',['survey'=>$sur,'data'=>$data,'topic'=>$topic,'question'=>$question,'answer'=>$ans,'objectid'=>$objectid]);
           }
           else// khao sat dơn vị
            return view('admin.survey.dosurvey_donvi',['survey'=>$sur,'data'=>$data,'topic'=>$topic,'question'=>$question,'answer'=>$ans,'objectid'=>$objectid]);
            
        }

        
    }
    public function selectemp($org_id)
    {
        $data['title']='Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic"),
        );   
        //-----lấy topic
        $org=Organization::find($org_id);
        
        if($org->org_level>1) $orgt=Organization::find($org->org_idParent);
        else $orgt=$org;
        $topic = Topic::find($orgt->org_topic_id);
        //-----lấy ds nhân viên để đánh giá nếu đánh giá nhân viên và cấu hình chọn nhân viên đánh giá
        $data['config_dangkythietbidekhaosat']=Setting::getconfig('config_dangkythietbidekhaosat'); 
 
        $emp=  DB::table('users')
        ->join('position','users.ID_Position','=','position.ID_Pos')
        ->select('users.id','users.fullname','users.chucdanh','position.pos_name','users.ID_Staff','users.avatar')
        ->where('users.user_IdOrg', '=',$org_id) 
        ->where('users.user_level', '>', 1) 
        ->where('users.chonkhaosat', '=', 1) 
        ->where('users.isActived', '>', 0) 
        ->get();                
        return view('admin.survey.selectemp',['data'=>$data,'org'=>$org,'topic'=>$topic,'emp'=>$emp]);
     
        
 
 
    }
    // trang home bắt đầu chọn đơn vị
    /*
    từ user_id đăng nhập (nhân viên)
    -> đơn vị cấp 1, cấp 2
    từ org_id đơn vị cấp 1 
    -> chủ đề khảo sát topic_id // vì mỗi đơn vị cấp 1 sẽ có 1 chủ đề kháo sát
    + Nếu topic_type=2(khảo sát nhân viên) && phải chọn nhân viên khảo sát thì hiện màn hình chọn nhân viên
    + Ngược lại thì khảo sát luôn có 2 trường hợp:
        / nếu khảo sát đơn vị thì tiến hành khảo sát luôn
        / hoặc khảo sát ngay nhân viên đăng nhập, thì khảo sát luôn
    */

    public function selectorg($parentorg_id=0)
    {
        //$parentorg_id;

        $data['title']='Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic"),
        );   
        //-----lấy organization 
        $orgt=Organization::find($parentorg_id);
        if(count($orgt)==0)$orgt=Organization::find(Setting::getconfig('config_orgtosurvey'));

        //neu orgt ko phải là gốc thì cho cho org=cha của ortg; else org=orgt
            $org=array();
            if(count($orgt)>0)
        if($orgt->org_level>1) $org=Organization::find($orgt->org_idParent);
        else $org=$orgt;
        //-----lấy topi
        $topic=array();
        if(count($org)>0 && $org->org_topic_id>0)
        $topic = Topic::find($org->org_topic_id);
        //-----lấy ds nhân viên để đánh giá nếu đánh giá nhân viên và cấu hình chọn nhân viên đánh giá
        // loại 2 khảo sát nhân viên, phải chọn nhân viên
        if (count($topic)>0 && ($topic->topic_type==2 && $org->org_isSelectEmp==1)){

            $child_org=DB::table('ks_organization')
            ->join('ks_schedule', 'ks_schedule.schedule_idOrg', '=', 'ks_organization.org_id')
            ->where('ks_organization.org_idParent', '=',$org->org_id) 
            ->where(function($q) {
                        $q->where([
                            ['ks_schedule.schedule_morningStart', '<=',date('H:i:s')],
                            ['ks_schedule.schedule_morningEnd', '>=',date('H:i:s')]
                        ])
                        ->orWhere([
                            ['ks_schedule.schedule_afternoonStart', '<=', date('H:i:s')],
                            ['ks_schedule.schedule_afternoonEnd', '>=', date('H:i:s')]
                        ])
                        ->orWhere([
                            ['ks_schedule.schedule_eveningStart', '<=', date('H:i:s')],
                            ['ks_schedule.schedule_eveningEnd', '>=', date('H:i:s')]
                        ]);
            })
            ->orderBy('ks_organization.org_order', 'ASC')
            ->get();   


            //nếu ko có bộ phạn  thì vô trang chọn nhân viên luôn
            if(count($child_org)==0){
                // thì kiểm tra giờ làm việc của phường (bp cấp 1) xem có trong giờ làm việc không nếu có thì đi đến trang chọn nhân viên khảo sát không thì thông báo hết giờ làm việc
                $sche=Schedule::where('schedule_idOrg', '=', $org->org_id)
                        ->where(function($q) {
                        $q->where([
                            ['schedule_morningStart', '<=',date('H:i:s')],
                            ['schedule_morningEnd', '>=',date('H:i:s')]
                        ])
                        ->orWhere([
                            ['schedule_afternoonStart', '<=', date('H:i:s')],
                            ['schedule_afternoonEnd', '>=', date('H:i:s')]
                        ])
                        ->orWhere([
                            ['schedule_eveningStart', '<=', date('H:i:s')],
                            ['schedule_eveningEnd', '>=', date('H:i:s')]
                        ]);
                        })->get();


                if(count($sche)>0)        
                return  redirect('/survey/selectemp/'.$org->org_id);  

                else return view('admin.survey.ngoaigiolamviec');
            }
            // nếu có 1 bộ phần thì cũng vào trang chọn nhân viên luôn
            if(count($child_org)==1){
                $child_org=$child_org->first();
                return   redirect('/survey/selectemp/'.$child_org->org_id);  
            }
                      
            //======== $child_org>1
            foreach($child_org as $no=>$val)
            $emp[$no]=  DB::table('users')
            ->select('users.id','users.fullname','users.avatar')
            ->where('users.user_IdOrg', '=',$val->org_id) 
            ->where('users.user_level', '>',1) 
            ->where('users.isActived', '>', 0) 
            ->get();               
            //===========
            $data['config_dangkythietbidekhaosat']=Setting::getconfig('config_dangkythietbidekhaosat'); 
            //----hiện ds nhân viên để chọn khảo sát
            if(count($child_org)>1)
            return view('admin.survey.selectorg',['data'=>$data,'org'=>$org,'topic'=>$topic,'org'=>$child_org,'emp'=>$emp]);
            else return view('admin.survey.ngoaigiolamviec');
        }
        else
        if(count($topic)>0)
        {// đánh giá đơn vị phường hoặc ko chọn nhân viên đánh giá
            //adminsurvey/{topic}/{Object}
            
            //print_r($topic);
            if($topic->topic_type==1) $objectid=$org->org_id;// đánh giá đơn vị
            else $objectid=Auth::id();// đánh giá nhân viên đang làm việc
            return redirect('/survey/'.$topic->topic_id.'/'.$objectid.'/');
        }
        else  return view('admin.survey.chuachonchude');
        //-----


 
 
    }

    public function selectorg_luu1($parentorg_id=0)
    {
        echo $parentorg_id;
        $data['title']='Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic"),
        );   
        //-----lấy organization
        $user=User::find(Auth::id());
        $orgt=Organization::find($user->user_IdOrg);
        if($orgt->org_level>1)$org=Organization::find($orgt->org_idParent);
        else $org=$orgt;
        //-----lấy topi
        $topic = Topic::find($org->org_topic_id);
        //-----lấy ds nhân viên để đánh giá nếu đánh giá nhân viên và cấu hình chọn nhân viên đánh giá
        if (($topic->topic_type==2 && $org->org_isSelectEmp==1)){

            $child_org=DB::table('ks_organization')
            ->join('ks_schedule', 'ks_schedule.schedule_idOrg', '=', 'ks_organization.org_id')
            ->where('ks_organization.org_idParent', '=', $org->org_id) 
            ->where(function($q) {
                        $q->where([
                            ['ks_schedule.schedule_morningStart', '<=',date('H:i:s')],
                            ['ks_schedule.schedule_morningEnd', '>=',date('H:i:s')]
                        ])
                        ->orWhere([
                            ['ks_schedule.schedule_afternoonStart', '<=', date('H:i:s')],
                            ['ks_schedule.schedule_afternoonEnd', '>=', date('H:i:s')]
                        ])
                        ->orWhere([
                            ['ks_schedule.schedule_eveningStart', '<=', date('H:i:s')],
                            ['ks_schedule.schedule_eveningEnd', '>=', date('H:i:s')]
                        ]);
            })
            ->orderBy('ks_organization.org_order', 'ASC')
            ->get();   


            foreach($child_org as $no=>$val)
            $emp[$no]=  DB::table('users')
            ->select('users.id','users.fullname','users.avatar')
            ->where('users.user_IdOrg', '=',$val->org_id) 
            ->where('users.user_level', '>',1) 
            ->where('users.isActived', '>', 0) 
            ->get();               
            //----hiện ds nhân viên để chọn khảo sát
            return view('admin.survey.selectorg',['data'=>$data,'org'=>$org,'topic'=>$topic,'org'=>$child_org,'emp'=>$emp]);
        }
        else{// đánh giá đơn vị phường hoặc ko chọn nhân viên đánh giá
            //adminsurvey/{topic}/{Object}
            if($topic->topic_type==1) $objectid=$org->org_id;// đánh giá đơn vị
            else $objectid=Auth::id();// đánh giá nhân viên đang làm việc
            return redirect('admin/survey/'.$topic->topic_id.'/'.$objectid.'/');
        }
        //-----
        
 
 
    }
 
}

