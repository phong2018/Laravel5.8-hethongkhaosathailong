@extends ('admin.layouts.index')

@section ('title')
<title>Danh sách đơn vị</title>
@endsection
@section ('style')
<style type="text/css">
	.btn_delObj{
		color: #3490dc;
	}
	.btn_delObj:hover{
		cursor: pointer;
		color: #1D68A7;
	}
</style>
@endsection

@section ('content')


  
@if(session('messenger'))
  <span class='plgalertsuccess'>
   <div class="alert alert-success"><i class="fa fa-check-circle"></i>    
  {{session('messenger')}}   <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
  </span>
  @endif
  
  
<div class='container'>
<div class="row justify-content-center">
   <div class="page-header">
    <div class="container-fluid">
      @if (isset($data['title']))
      <h1>{{$data['title']}}</h1>
      @endif  
      @if(isset($data['breadcrumbs']))
      <ul class="breadcrumb">
        <?php foreach ($data['breadcrumbs'] as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
        @endif
        
    </div>
  </div>
	<div class="col-md-12 col-lg-12 col-xs-12">
 
		<form method="GET" action="" enctype="multipart/form-data" style="padding-bottom: 10px;">      

           <div class="col-sm-8">
              <div class="form-group">
                <label class="control-label" for="input-org_id">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị.">Chọn Đơn vị</span>
                </label>
                
                <select  name="filter_orgid" class="form-control{{ $errors->has('org_id') ? ' is-invalid' : '' }}">
                      <option value="0">Choose...</option>
                    @foreach($orgs as $orgg)

                      <option 
                    @if ($data['filter_orgid']==$orgg->org_id)
                    selected
                    @endif

                    value="{{$orgg->org_id}}">{{$orgg->org_name}}</option>
                  
                    @endforeach 
 	 
                    
                   
                </select>
              </div>
            </div>
            
            <div class="col-sm-4 text-right">
				<div class="form-group">
					 
					<table class='pull-right bordernone '>
						 
						<tr><td style="padding-top:20px;"> 
						<button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i>  Tìm kiếm</button> 
						</td> 
						<td style="padding-top:20px;">
							<a href="{{ route('organization.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
						</td>
					</tr>
					</table>
					<br><br> 
				</div>
			</div>
           
          </form> 
				  
		 

<br>
		<table class="table panel panel-default">
			<thead>
				<tr>

					<th scope="col"># &nbsp Tên</th>
					<th scope="col"  >Địa chỉ</th>
					<th scope="col">Điện thoại</th>
					<th scope="col">Thứ tự</th>
			 
					<th scope="col">Cấp bậc</th>
					<th scope="col">SlideTV</th>
					<th scope="col">Tình trạng</th>
					<th scope="col" class=' width1pt' >Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($org as $no1=>$val)
				<tr> 
					<td> <span class="glyphicon glyphicon-triangle-right" style='font-size: 10px;'></span> <strong>{{$val->org_name}}</strong></td>
					<td>{{$val->org_address}}</td>
					<td>{{$val->org_phone}}</td>
					<td>{{$val->org_order}}</td>
				 
					<td><?php
					$tengoilevel=array();     
                    $tengoilevel[2]='Cấp 2';    
                    $tengoilevel[1]='Cấp 1'; 
                    echo $tengoilevel[$val->org_level];
					?></td>

					<td>
						<a href="{{url('/')}}/survey/slidetv/{{$val->org_id}}" target="_blank">
						<strong>Url</strong>
						</a>
					</td>
					
					<td><?php
					if($val->org_isActived==0){?>
						<img style="cursor:pointer;"   src="{{url('/')}}/public/chuakichhoat.png"/>	
					<?php } else { ?>
						<img style="cursor:pointer;"   src="{{url('/')}}/public/dakichhoat.png"/>
					<?php }?></td>
 
					<td>
 					<table class='iconaction'><td>
					<a data-original-title="Sửa Chức Vụ" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/organization/' . $val->org_id. '/edit')}}"><i class="fas fa-edit"></i></a></td>
					<td> &nbsp &nbsp </td><td>
					<span data-original-title="Xóa Chức vụ" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$val->org_id}})" ><i class="fa fa-trash-o " ></i></span></td>
					</table>
					</td> 
					<?php $i++;?>
				</tr>
						<?php $ii=1;?>
						<?php if(count($org_child[$no1])>0) ?>
						@foreach ($org_child[$no1] as $val1)
						<tr>
							
							<td> &nbsp &nbsp &nbsp   <span class="glyphicon glyphicon-triangle-right"  style='font-size: 10px;'></span>  {{$val1->org_name}}</td>
							<td>{{$val1->org_address}}</td>
							<td>{{$val1->org_phone}}</td>
							<td>{{$val1->org_order}}</td> 
							<td><?php
							$tengoilevel=array();     
		                    $tengoilevel[2]='Cấp 2';    
		                    $tengoilevel[1]='Cấp 1'; 
		                    echo $tengoilevel[$val1->org_level];
							?></td>
							<td></td>
							<td><?php
							if($val1->org_isActived==0){?>
								<img style="cursor:pointer;"   src="{{url('/')}}/public/chuakichhoat.png"/>	
							<?php } else { ?>
								<img style="cursor:pointer;"   src="{{url('/')}}/public/dakichhoat.png"/>
							<?php }?></td>
 
							<td>
		 					<table class='iconaction'><td>
							<a data-original-title="Sửa Chức Vụ" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/organization/' . $val1->org_id. '/edit')}}"><i class="fas fa-edit"></i></a></td>
							<td> &nbsp &nbsp </td><td>
							<span data-original-title="Xóa Chức vụ" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$val1->org_id}})" ><i class="fa fa-trash-o " ></i></span></td>
							</table>
							</td> 
							<?php $ii++;?>
						</tr>
						@endforeach				
				@endforeach
		</tbody>
	</table>
	{{ $org->render() }}
</div>
</div>
</div>
@endsection

@section ('script')
<script>
function delObj(id){
	var r = confirm('Bạn chắc chắn xóa đơn vị này?');
        if (r) {
        	$.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                url: 'organization/'+id,
                type: "DELETE",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                	alert("Xóa đơn vị thành công ");
                	window.location="organization";
                },
                error:function () {//alert("NO");
                	alert("Xóa đơn vị thất bại ");
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
}
</script>
@endsection
