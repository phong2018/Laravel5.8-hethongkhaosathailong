<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Position;
use App\User;
use App\Procedures;
use App\Dossiers;
use App\DossierProcess;
use App\Assigns;
use App\TaskAppointment;
use App\ListStep;

class ManagerController extends Controller
{
    public function listassign()
    {
    	$assign = Assigns::all();
    	return view('admin.assign.listassign',['assigns' => $assign]);
    }

    public function newassign()
    {
    	$user = User::all();
    	$proce = Procedures::all();
    	return view('admin.assign.addassign',['employee' =>$user, 'procedure' => $proce]);
    }
    
    public function createassign(Request $request)
    {
    	foreach ($_POST['procedure'] as $k) {
            $store = new Assigns;
            $store->ID_Employee = $request->employee;
            $store->ID_Procedure = $k;
            $store->duration = date('y/m/d');
            $store->active = 1;
            $store->save();
        }
        return redirect('admin/assign');
    }

    public function getappend($id)
    {
        $dossier = Dossiers::find($id);
        return view('admin.taskappointment.append',['dossier' => $dossier]);
    }
    public function append($id, Request $request)
    {
        
    }

    public function getlist()
    {
        $task = TaskAppointment::paginate(15);
        $process = DossierProcess::paginate(15);
        return view('admin.taskappointment.listappointment',['taskappointment' =>$task, 'dossierprocess' => $process]);
    }

    public function getinfo($id)
    {   
        $task = TaskAppointment::find($id);
        $idstep = $task->TA_Dossier->dp_dossierprocess->stepstepstep->ID_Step;
        $step = ListStep::where('ID_Step','!=',$idstep)->get();
        return view('admin.taskappointment.infotask',['task'=>$task, 'liststep' => $step]);
    }

    public function handling(Request $request)
    {
        var_dump($request->handling);die();
        $process = new DossierProcess;

        $process->ID_Dossier = $request->dossier_name;
        $process->ID_Step = $request->handling;
        if (isset($request->manager)) {
            $process->ID_Assign = $request->manager;
        }else{
            $process->ID_Assign = $request->staff;
        }
        $process->time_received =  $request->appointed_date;
        $process->time_return = $request->appointed_date;
        if (isset($request->note)) {
            $process->process_description = $request->note;
        }
        $process->save();


        $task = new TaskAppointment;
        $task->ID_Dossier = $request->dossier_name;
        if (isset($request->manager)) {
            $task->ID_Staff = $request->manager;
        }else{
            $task->ID_Staff = $request->staff;
        }
        if ($request->appointed == 'Tự Động') {
            $task->isAutoAppointed = 1;
        }else{
            $task->ID_Manager = $request->appointed;
        }
        $task->appointed_time = $request->appointed_date;
        $task->save();
        return redirect('admin/taskappoint');
    }

    public function getprocesslist()
    {
        $process = DossierProcess::paginate(15);
        return view('admin.dossierprocess.listprocess', ['dossierprocess' => $process]);
    }
}
