<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <?php
use Illuminate\Support\Facades\DB;
$setting=array(); 
$setting= DB::table('setting') 
            ->where('code','=','config')
            ->select('setting.*') 
            ->get()->toArray();
$dsetting=array();
if($setting)      
foreach ($setting as $val)
    $dsetting[$val->key]=$val->value;

if(!isset($dsetting['config_logoadmin_htks']))$dsetting['config_logoadmin_htks']='';
if(!isset($dsetting['config_ks_meta_title']))$dsetting['config_ks_meta_title']='';
if(!isset($dsetting['config_tencoquan']))$dsetting['config_tencoquan']='';

?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $dsetting['config_ks_meta_title'] }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" ></script>

    <link rel="shortcut icon" href="{{url('/')}}/public/favicon.ico" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="{{ asset('public/lib-keyboard/js/jkeyboard.js') }}" ></script>
    <link rel="stylesheet" href="{{asset('public/lib-keyboard/jkeyboard.css')}}">
    
<style type="text/css">
    .caret{display: none !important;}
</style>
    
</head>
<body>


    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 0px 0px 0px;">
                    <table style="width:100%">
                    <td style="width:10%;">
                    <a class="navbar-brand" id="logohomea" href="{{ url('/') }}">
                        
                        <!--

                        -->
                       
                        </a>
                    </td>
                    <td>
                        <h1 class='titleheader' style="">
                        <span id="tenphuong">&nbsp </span>        </br>
                        <?php echo $dsetting['config_ks_meta_title'];?>  
                        </h1>
                    </td>
                    <td style="width:17%;">&nbsp </td>
                    </table>
            </div>
         
     </nav>

 </div>    
         <main >
            @yield('content')
        </main>
             

<script type="text/javascript">
    $('#navbarDropdown').hide();
    var divideid;
    // Check browser support
    if (typeof(Storage) !== "undefined") {
          
          // Retrieve
          if(localStorage.getItem("divideid")){
                //alert('co id');
                divideid=localStorage.getItem("divideid");

                  $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
                  var urll="{{ url('ajax/checkdevice_actived') }}/"+divideid;//alert(urll);
                  $.ajax({
                        url: urll,
                        type: "GET",
                        data: {},//'active' : id
                        success:function (data) {//alert("YES");//alert(data['success']);
                             //Swal.fire("Y");
                            //if(data['device_isactived']==1){
                               
                           $('#tenphuong').html(data['tenphuong']);
                           var img="{{url('/')}}/public" + data['logophuong'];

                            $("#logohomea").html("<img class='logotrangchu' id='logohome' src='"+img+"'  >");

                           //document.getElementById("logohome").src = "{{url('/')}}/public" + data['logophuong'];

                           //console.log( "{{url('/')}}/public" + data['logophuong']);

                            //} 
                        },
                        error:function () {//alert("NO");
                            //alert(0);
                           // Swal.fire("NOO");
                            console.log("i cant's run. Please check bug!");
                        }
                    });


          } 
    }   


</script>
                
<style>
    /*Ipad Pro*/
@media only screen and (max-width : 1024px) {
 .titleheader{
    font-size:  20px;
 }
}

    
</style>
</body>
</html>
