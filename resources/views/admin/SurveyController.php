<?php

namespace App\Http\Controllers;

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
    public $count_survey,$xuatexcel=0,$dtchartda;

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

    public function deletesuveyfail($id)
    {
        //xoa cau tra loi
        Result::where('result_idSurvey', $id)->delete();
        // xoa survey
        $survey = Survey::find($id);
        if($survey) $survey->delete();
        return redirect(url('/'));
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

         //print_r($survey); 
          $data=array(
            'filter_survey_topic_id'=>0, 
            'filter_survey_idorglv1'=>0,
            'filter_survey_idObject'=>0,
            'filter-input-ngaykhaosat'=>'',
            'filter_ngaykhaosat_tungay'=>date("Y-m-d"),
            'filter_ngaykhaosat_denngay'=>date("Y-m-d"),
        );
        // 
        
       
        if(isset($_GET['filter_survey_idObject']) && $_GET['filter_survey_idObject']!=0){
            $survey= $survey->where('survey_idObject', '=', $_GET['filter_survey_idObject']);
            $data['filter_survey_idObject']=$_GET['filter_survey_idObject'];
        }
        if(isset($_GET['filter_survey_idorglv1']) && $_GET['filter_survey_idorglv1']!=0){
            $survey= $survey->where('survey_idorglv1', '=', $_GET['filter_survey_idorglv1']);
            $data['filter_survey_idorglv1']=$_GET['filter_survey_idorglv1'];
        }


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

           $survey= $survey->where('survey_idorglv1', '=', $orgp->org_id);
        }

        

         

        //-----
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

        if(isset($_GET['filter_survey_topic_id']) && $_GET['filter_survey_topic_id']!=0){
            $survey= $survey->where('survey_idTopic', '=', $_GET['filter_survey_topic_id']);
            $data['filter_survey_topic_id']=$_GET['filter_survey_topic_id'];
        }
          
        $survey= $survey->paginate(Setting::getconfig('config_showeverypage'));

        
        $data['title']='Danh sách khảo sát';

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

        return view('admin.survey.listsurvey',['data'=>$data,'survey'=>$survey,'topic'=>$topic]);


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
            $result= Result::where('result_idSurvey', $sur->survey_id)->get();
            
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


        $survey = Survey::orderBy('survey_id', 'ASC');
        $org=Organization::find($orgid);
        
        
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

        
            $survey= $survey->where('survey_idorglv1', '=', $orgid);
         

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
        if(isset($org->org_topic_id) && $org->org_topic_id!=0){
            $topic=Topic::find($org->org_topic_id);

            $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$org->org_topic_id)->where("question_isActived",1)->get();

            $survey= $survey->where('survey_isActived',1);
            
            $survey= $survey->where('survey_idTopic', '=', $org->org_topic_id);
            $data['filter_survey_topic_id']=$org->org_topic_id;
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

    public function dosurvey($topicid,$objectid)
    {
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
        }
        else{
            $object=User::find($objectid);
            $data['nameob']=$object->fullname;
            $data['thumbob']= $object->avatar;
            $data['infoob']='Mã NV: '.$object->ID_Staff;
            $data['infoob1']='Chức danh: '.$object->chucdanh;
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

           if($topic->topic_type==2)  // khảo sát nhân viên
            return view('admin.survey.dosurvey',['survey'=>$sur,'data'=>$data,'topic'=>$topic,'question'=>$question,'answer'=>$ans,'objectid'=>$objectid]);
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
        if($orgt->org_level>1) $org=Organization::find($orgt->org_idParent);
        else $org=$orgt;
        //-----lấy topi
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
                // thì kiểm tra giờ làm việc của Đơn vị (bp cấp 1) xem có trong giờ làm việc không nếu có thì đi đến trang chọn nhân viên khảo sát không thì thông báo hết giờ làm việc
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
        {// đánh giá đơn vị Đơn vị hoặc ko chọn nhân viên đánh giá
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
        else{// đánh giá đơn vị Đơn vị hoặc ko chọn nhân viên đánh giá
            //adminsurvey/{topic}/{Object}
            if($topic->topic_type==1) $objectid=$org->org_id;// đánh giá đơn vị
            else $objectid=Auth::id();// đánh giá nhân viên đang làm việc
            return redirect('admin/survey/'.$topic->topic_id.'/'.$objectid.'/');
        }
        //-----
        
 
 
    }
 
}
