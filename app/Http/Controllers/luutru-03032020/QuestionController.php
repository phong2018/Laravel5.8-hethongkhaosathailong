<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Question;
use App\Answer;
use App\Topic;
use App\User;
use App\Setting; 
use App\Survey; 
use App\Result; 

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

 
        


        $data['title']='Câu hỏi';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/question"),
        );
        //'data'=>$data,   

        $question = Question::orderBy('question_idTopic', 'DESC')->orderBy('question_id', 'DESC')->paginate(Setting::getconfig('config_showeverypage'));
      

        return view('admin.question.list',['data'=>$data,'question'=>$question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //
        $data['title']='Tạo Câu hỏi';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/Question/create"),
        );
        //'data'=>$data,   
          $topic = Topic::all();

        return view('admin.question.add',['data'=>$data,'topic'=>$topic]);
    }
    function createbytopic($topicid){
        //echo 'vv';
        //
        $data['title']='Tạo Câu hỏi';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/Question/create"),
        );
        //'data'=>$data,   
        $topic = Topic::where('topic_id', $topicid)->get();

        return view('admin.question.add',['data'=>$data,'topic'=>$topic]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question;
        $question->question_description = $request->question_description; 
        $question->question_isActived= $request->question_isActived;
        $question->question_order = $request->question_order; 
        $question->question_idTopic = $request->question_idTopic; 
        $question->question_options = $request->question_options; 
        $question->question_scores = $request->question_scores; 
        $question->question_type = $request->question_type; 
        $question->question_options = $request->question_options;  
        $question->question_created_by=Auth::id();
        $question->question_created_at=date("Y-m-d");
        $question->question_updated_at=date("Y-m-d");
        $question->save();
        //------
        for($i=1;$i<=$question->question_options;$i++){
            $ans = new Answer;
            $ans->answer_idQuestion=$question->question_id;
            $nametraloi="traloi".$i;
            $namediemtraloi="diemtraloi".$i;
            $ans->answer_description=$request->$nametraloi;
            $ans->answer_scores=$request->$namediemtraloi;
            $ans->answer_order=$i;
            $ans->save();
        }
        return redirect('admin/topic/'.$request->question_idTopic.'/edit')->with('messenger', 'Thêm mới Câu hỏi Thành Công');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title']='Câu hỏi';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/Question"),
        );
        //'data'=>$data,   

        //$question = Question::where("question_id",$id)->get(); 

        $question = Question::where("question_id",$id)->paginate(Setting::getconfig('config_showeverypage'));


        return view('admin.question.list',['data'=>$data,'question'=>$question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function copy($id){// id của question cần copy
        $ques=Question::find($id); 
        $answere=Answer::where('answer_idQuestion', $id)->get();
        //========
        $question = new Question;
        $question->question_isActived= 0;
        $question->question_description =  'Copy-'.$ques->question_description; 
        $question->question_order = $ques->question_order; 
        $question->question_idTopic = $ques->question_idTopic; 
        $question->question_options = $ques->question_options; 
        $question->question_scores = $ques->question_scores; 
        $question->question_type = $ques->question_type; 
        $question->question_options = $ques->question_options;  
        $question->question_created_by=Auth::id();
        $question->question_created_at=date("Y-m-d");
        $question->question_updated_at=date("Y-m-d");
        $question->save();
        //------chép câu hỏi qua question
        foreach($answere as $i=>$ansi){
            $ans = new Answer;
            $ans->answer_idQuestion= $question->question_id;
            $ans->answer_description= $ansi->answer_description;
            $ans->answer_scores= $ansi->answer_scores;
            $ans->answer_order=$i+1;
            $ans->save();
        }
        //========xóa khảo xác chứa câu hỏi này
        // xoa khao sat chứa câu hỏi này
        $topic = Topic::find($ques->question_idTopic);// láy chủ dề chứa câu hỏi
        if($topic){
            $surveys = Survey::where("survey_idTopic",$topic->topic_id)->get(); 
            if(count($surveys)>0)
            foreach($surveys as $i=>$val){ 
                Result::where('result_idSurvey', $val->survey_id)->delete();
                //$survey = Survey::find($val->survey_id);
                $val->delete();  
            } 
        }
        
        return redirect('admin/topic/'.$question->question_idTopic.'/edit')->with('messenger', 'Copy Câu hỏi Thành Công');

    }
    public function edit($id)
    {
        //
        $question=Question::find($id); 

        $data['title']='Sửa Câu hỏi';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/Question/".$id."/edit"),
        );
        //'data'=>$data,   
         $topic = Topic::all();
         $ans = Answer::where('answer_idQuestion', $id)
               ->orderBy('answer_order', 'asc')
               ->get();

        if( $question)
        return view('admin.question.edit',['data'=>$data, 'question'=>$question, 'topic'=>$topic,'ans'=>$ans]);
        else  return abort(404);
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
        $question= Question::find($id);   
        $question->question_description = $request->question_description; 
        $question->question_isActived= $request->question_isActived;
        $question->question_order = $request->question_order; 
        $question->question_idTopic = $request->question_idTopic; 
        $question->question_options = $request->question_options; 
        $question->question_scores = $request->question_scores; 
        $question->question_type = $request->question_type; 
        $question->question_options = $request->question_options; 
        $question->question_created_by=Auth::id();
        $question->question_created_at=date("Y-m-d");
        $question->question_updated_at=date("Y-m-d");
        $question->save();
        // xoa cau hoi
        Answer::where('answer_idQuestion', $id)->delete();
        // xoa khao sat chứa câu hỏi này
        $topic = Topic::find($question->question_idTopic);// láy chủ dề chứa câu hỏi
        if($topic){
            $surveys = Survey::where("survey_idTopic",$topic->topic_id)->get(); 
            if(count($surveys)>0)
            foreach($surveys as $i=>$val){ 
                Result::where('result_idSurvey', $val->survey_id)->delete();
                //$survey = Survey::find($val->survey_id);
                $val->delete();  
            } 
        }
 
        //------
        for($i=1;$i<=$question->question_options;$i++){
            $ans = new Answer;
            $ans->answer_idQuestion=$question->question_id;
            $nametraloi="traloi".$i;
            $namediemtraloi="diemtraloi".$i;
            $ans->answer_description=$request->$nametraloi;
            $ans->answer_scores=$request->$namediemtraloi;
            $ans->answer_order=$i;
            $ans->save();
        }
        return redirect('admin/topic/'.$question->question_idTopic.'/edit')->with('messenger', 'Cập nhật Câu hỏi Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cập nhật lại tổ chức có Câu hỏi cấp trên có id=org_id 
        //Question::where('org_idParent', $org_id)->update(['org_idParent' => 0]);
        Answer::where('answer_idQuestion', $id)->delete();
        $question = Question::find($id);

        $topic = Topic::find($question->question_idTopic);// láy chủ dề chứa câu hỏi
        if($topic){
            $surveys = Survey::where("survey_idTopic",$topic->topic_id)->get(); 
            if(count($surveys)>0)
            foreach($surveys as $i=>$val){ 
                Result::where('result_idSurvey', $val->survey_id)->delete();
                //$survey = Survey::find($val->survey_id);
                $val->delete();  
            } 
        }

        
        if($question) $question->delete();
    }
}


