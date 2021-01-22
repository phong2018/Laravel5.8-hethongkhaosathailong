<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
use Illuminate\Support\Facades\DB;

Route::get('/test', function () {  
	 $deviceid = "<script>document.write(localStorage.getItem('divideid'));</script>";
	 echo $deviceid;
	
});
Route::get('/baocao1', 'SurveyController@baocao1');
//==============================================
Route::get('/baotri', 'HomeController@baotri');
/*middleware kiểm tra chế độ bảo trì*/
//,,'prefix'=>'{tenphuong?}'
Route::group(['middleware' => ['checkbaotri']] , function(){
	/*---------------------login*/
	Auth::routes();
	/*---------------------ks_survey*/
	
	/*---------------------trang ngoài admin - ngay tên miền*/
	Route::get('/', 'HomeController@index');

	Route::post('/timkiem', 'HomeController@timkiem');
	/*login xong từ home direct qua admin luôn*/
	Route::get('/admin', function () {/*cho redirec to /admin*/    
		//if(Auth::user()->user_level>1) return redirect(url('/'));
		//else 
		return redirect('/admin/organization');
	});	
	//-------trang đánh gia

	Route::get('/survey/selectemp/{organization}', 'SurveyController@selectemp');
	Route::get('/survey/selectorg/{parentorg_id}', 'SurveyController@selectorg');
	Route::get('/survey/thankyou', 'SurveyController@thankyou');
	Route::get('/survey/slideresult/{orgid}', 'SurveyController@slideresult');
	Route::post('/survey/surveysave', 'SurveyController@surveysave');
	Route::get('/survey/deletesuveyfail/{survey}/{orgid}', 'SurveyController@deletesuveyfail');
	Route::get('/survey/{topic}/{object}', 'SurveyController@dosurvey');


	Route::get('/ajax/checkdevice/{deviceid}', 'AjaxController@checkdevice'); 
	Route::get('/ajax/checkdanhgiatrungbinh', 'AjaxController@checkdanhgiatrungbinh'); 
	Route::get('/ajax/checkdevice_actived/{deviceid}', 'AjaxController@checkdevice_actived'); 

	/*=======================middleware checklogin kiểm tra đăng nhập để vào trang admin*/
	Route::group(['middleware' => ['checkLogin'],'prefix'=>'admin'] , function(){
		/*các ajax get dữ liệu*/
		//lấy Phân công và cha cho đơn vị
		Route::get('ajax/Organization_getAssigned_Parent/{level}', 'AjaxController@Organization_getAssigned_Parent'); 

		//lấy type of topic id
		Route::get('ajax/Organization_gettypetopic/{topic}', 'AjaxController@Organization_gettypetopic'); 


		//lấy type object frome type
		Route::get('ajax/Object_getobject/{type}', 'AjaxController@Object_getobject'); 
		
		//thực hiện làm khảo sát
		Route::get('/survey/delete/{survey}', 'SurveyController@delete');
		Route::get('/survey/show/{survey}', 'SurveyController@showsurvey')->name('survey.showsv');;
		Route::get('/survey/surveyresult', 'SurveyController@surveyresult');
		Route::get('/survey/updateMucdoHailong', 'SurveyController@updateMucdoHailong')->name('survey.updatemucdohailong');;
		Route::get('/thongke/tkTheoCauhoi', 'ThongkeController@tkTheoCauhoi');
		

		Route::get('/thongke/addcot', 'ThongkeController@addcot');
		
		Route::get('/survey/listsurvey', 'SurveyController@listsurvey');
		Route::get('/survey/xuatchart', 'SurveyController@xuatchart');
		Route::get('/survey/chart_DanhGiaTungNhanVien', 'SurveyController@chart_DanhGiaTungNhanVien');
		
		
		/*=======================middleware chi check login và checkaccessmenu */
		Route::group(['middleware' => ['checkaccessmenu']] , function(){
			/*---------------------Setting*/
			//http://localhost/2019/201906hoso1cua/admin/setting/nhatky/download/121
			Route::get('setting/nhatky/download/{dossier}', 'SettingController@historydownload');
		});
		/*=======================kiểm tra phân công hồ sơ*/
		Route::group(['middleware' => ['checkappointed']] , function(){
			//trong admin nhưng chỉ cần login, và thamg xử lý hồ sơ là vô được
			/*---------------------trang amdin lúc vừa đăng nhập*/
			
			/*giao diện ko được quyền truy cập*/
			Route::get('dontallowaccess', 'DashboardController@dontallowaccess');
			/*---------------------Quản lý tài khoản cá nhân chỉ cần login là được*/
			Route::get('user/c/manageinfo', 'UserController@manageinfo'); 
			Route::post('user/c/updateinfo', 'UserController@updateinfo'); 
		});
		/*==============middleware kiểm tra phân công, quyền truy cập vào các trang admin*/
		Route::group(['middleware' => ['checkaccessmenu','checkappointed']] , function(){
			//------setting/edit
			Route::get('setting/edit', 'SettingController@edit');
			/*---------------------temp*/
			Route::resource('temp', 'TemplateController');
			Route::get('temp/delete/{temp}', 'TemplateController@templatedelete');
			Route::get('temp/changeactive/{temp}', 'TemplateController@tempAjaxChangeActive');
			/*---------------------user*/
			/*Quản lý nhân viên*/
			Route::resource('user', 'UserController');
			Route::get('user/{user}/copy', 'UserController@copy');
			Route::get('user/delete/{user}', 'UserController@Userdelete');
			Route::get('user/changeactive/{user}', 'UserController@UserAjaxChangeActive'); 
			/*---------------------menu*/
			Route::resource('menu', 'MenuController');
			Route::get('menu/delete/{menu}', 'MenuController@Menudelete');
			Route::get('menu/changeactive/{menu}', 'MenuController@MenuAjaxChangeActive'); 
			/*---------------------role*/
			Route::resource('role', 'RoleController');
			Route::get('role/delete/{role}', 'RoleController@Roledelete');
			Route::get('role/changeactive/{role}', 'RoleController@RoleAjaxChangeActive'); 
			/*---------------------position*/
			Route::resource('position', 'PositionController');
			Route::get('position/delete/{position}', 'PositionController@Positiondelete');
			Route::get('position/changeactive/{position}', 'PositionController@PositionAjaxChangeActive'); 
			/*---------------------ks_organization*/
			Route::resource('organization', 'OrganizationController'); 
			Route::get('organization/{organization}/copy', 'OrganizationController@copy');
			/*---------------------ks_topic*/
			Route::resource('topic', 'TopicController'); 
			Route::get('topic/{topic}/copy', 'TopicController@copy');
			/*---------------------ks_schedule*/
			Route::resource('schedule', 'ScheduleController');
			Route::get('schedule/{schedule}/copy', 'ScheduleController@copy'); 
			/*---------------------ks_device*/
			Route::resource('device', 'DeviceController'); 
			/*---------------------ks_question*/
			Route::resource('question', 'QuestionController'); 
			Route::get('question/{question}/copy', 'QuestionController@copy');
			Route::get('question/create/{topic}', 'QuestionController@createbytopic');
			/*---------------------backup*/
			Route::get('backup', 'BackupController@index'); 
			Route::get('backup/create', 'BackupController@create'); 
			Route::get('backup/restore/{backup}', 'BackupController@restore'); 	
			Route::get('backup/delete/{backup}', 'BackupController@Backupdelete');	
			Route::get('backup/download/{backup}', 'BackupController@Backupdownload');	
			Route::get('backup/backupupload', 'BackupController@Backupupload');	
			Route::post('backup/storebackupupload', 'BackupController@storebackupupload');	
			/*---------------------Setting*/
		    Route::group(['prefix' => 'setting'], function (){
				Route::get('/edit', 'SettingController@edit');
				Route::post('/update', 'SettingController@update'); 
				/*ajax upload hinhanh logo*/ 
			    Route::post('/upload', 'SettingController@ajax_upload');
			    /*xử lý với các mẫu*/
			    Route::get('/mauguimail', 'SettingController@mauguimail');
			    Route::post('/capnhatmauguimail', 'SettingController@capnhatmauguimail');
			    Route::get('/nhatky', 'SettingController@nhatky'); 
			});
			
		});
	});
});

 

/*
				 
			Route::get('dossier/c/inmaunhanhoso/{dossier}', 'DossierController@inmaunhanhoso');
			Route::get('dossier/c/inmauchuyenhoso/{dossier}', 'DossierController@inmauchuyenhoso');
			---------------------ajax gửi mail và sms
			Route::get('dossier/c/guimail', 'DossierController@ajaxguimail');
			Route::get('dossier/c/guisms', 'DossierController@ajaxguisms');
			//ajax xử lý khác
			//-------------ajax xử lý các trường hợp lấy dữ liệu cha luc thêm sửa hồ sơ
			Route::get('dossier/getprocedure/{sector}', 'DossierController@dossierAjaxGetprocedure'); 
			Route::get('dossier/getassign/{procedure}', 'DossierController@dossierAjaxGetassign');
*/
