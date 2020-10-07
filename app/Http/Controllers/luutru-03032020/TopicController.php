<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Topic;
use App\User;
use App\Question;
use App\Setting; 
use App\Answer; 
use App\Organization; 
use App\Survey; 
use App\Result; 

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //'data'=>$data,   

         $topic = Topic::orderBy('topic_id', 'DESC');


         $topic=$topic->where('topic_idCreated',Auth::id());

        $topic = $topic->paginate(Setting::getconfig('config_showeverypage'));

        return view('admin.topic.list',['data'=>$data,'topic'=>$topic]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // copy topic
    public function copy($id){// id của question cần copy
        $top=Topic::find($id); 
        $ques=Question::where('question_idTopic', $id)->get();
        //========
        $topic = new Topic;
        $topic->topic_name =  'Copy-'.$top->topic_name; 
        $topic->topic_description = $top->topic_description; 
        $topic->topic_type = $top->topic_type; 
        $topic->topic_thumb = $top->topic_thumb;
        $topic->topic_idCreated =Auth::id();
        $topic->topic_isActived= 0;
        $topic->topic_idorg=$top->topic_idorg;
        $topic->topic_created_at=date("Y-m-d");
        $topic->topic_updated_at=date("Y-m-d");
        $topic->save();
        //------chép câu hỏi qua question
        foreach($ques as $q)
        $this->copy_question($q->question_id,$topic->topic_id);
        //=======
        return redirect('admin/topic/'.$topic->topic_id.'/edit')->with('messenger', 'Copy Chủ đề Thành Công');

    }

    public function copy_question($qid,$tid){// id của question cần copy
        $ques=Question::find($qid); 
        $answere=Answer::where('answer_idQuestion', $qid)->get();
        //========
        $question = new Question;
        $question->question_idTopic = $tid; 
        $question->question_isActived= 1;
        $question->question_description = $ques->question_description; 
        $question->question_order = $ques->question_order; 
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
         
    }
    public function create()
    {
         //
        $data['title']='Tạo Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic/create"),
        );
        //'data'=>$data,   


        return view('admin.topic.add',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topic = new Topic;
        $topic->topic_name = $request->topic_name; 
        $topic->topic_description = $request->topic_description; 
        $topic->topic_type = $request->topic_type; 
        $topic->topic_thumb = $request->topic_thumb;
        $topic->topic_idCreated =Auth::id();

        //==========
        $tempus=User::find(Auth::id());
        if($tempus->user_level==1){}
        else{
           $orgt=Organization::where('org_id',$tempus->user_IdOrg)->get()->first();
           if($orgt->org_level==2){
              $orgp=Organization::orderBy('org_order', 'DESC')->where('org_id',$orgt->org_idParent)->get()->first();
           }
           else{
              $orgp=Organization::orderBy('org_order', 'DESC')->where('org_id',$tempus->user_IdOrg)->get()->first();
           }
           $org=$orgp;
           
           $topic->topic_idorg =$org->org_id; 
 
        }

        

        $topic->topic_isActived= $request->topic_isActived;
        $topic->topic_created_at=date("Y-m-d");
        $topic->topic_updated_at=date("Y-m-d");
        $topic->save();
        return redirect('admin/topic')->with('messenger', 'Thêm mới chủ đề Thành Công');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $topic=Topic::find($id); 

        $data['title']='Sửa Chủ đề';

        //tạo breadcumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' =>'Trang chủ',
            'href' => url("/admin")
        );
        $data['breadcrumbs'][] = array(
            'text' => $data['title'],
            'href' => url("/admin/topic/".$id."/edit"),
        );
        //'data'=>$data,   
        $question = Question::orderBy('question_order', 'asc')->where("question_idTopic",$id)->get(); 


        if( $topic)
        return view('admin.topic.edit',['data'=>$data, 'topic'=>$topic, 'question'=>$question]);
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
        $topic= Topic::find($id);   
        $topic->topic_name =$request->topic_name; 
        $topic->topic_description = $request->topic_description; 
        $topic->topic_type = $request->topic_type; 
        $topic->topic_thumb = $request->topic_thumb;
        $topic->topic_idCreated =Auth::id();
        $topic->topic_isActived= $request->topic_isActived;
        $topic->topic_created_at=date("Y-m-d");
        $topic->topic_updated_at=date("Y-m-d");
        $topic->save();
        return redirect('admin/topic')->with('messenger', 'Cập nhật chủ đề Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cập nhật lại tổ chức có đơn vị cấp trên có id=org_id 
        //topic::where('org_idParent', $org_id)->update(['org_idParent' => 0]);
        
        // Answer::where('answer_idQuestion', $id)->delete();
        // $question = Question::find($id);
        //if($question) $question->delete();

        //$topic = Topic::find($id);
        //if($topic) $topic->delete();

        $topic = Topic::find($id);
        
        if($topic){
            // xoa kháo sát, trả lời
            $surveys = Survey::where("survey_idTopic",$id)->get(); 
            if(count($surveys)>0)
            foreach($surveys as $i=>$sur){ 
                // xoa het cau tra loi cho cau hoi
                Result::where('result_idSurvey', $sur->survey_id)->delete(); 
                // xoa cau hoi nay luon
                $sur->delete();   
            }

            // xóa chủ câu hỏi, đáp án
            $questions = Question::where("question_idTopic",$id)->get(); 
            if(count($questions)>0)
            foreach($questions as $i=>$ques){ 
                // xoa het cau tra loi cho cau hoi
                Answer::where('answer_idQuestion', $ques->question_id)->delete(); 
                // xoa cau hoi nay luon
                $ques->delete();   
            }
            // xoa chu de luon
            $topic->delete();
        }

    }
}
