@extends ('admin.layouts.index')

@section ('title')
<title>thêm Lịch làm việc</title>
@endsection
@section ('style')

@endsection

@section ('content')
<div class="container">
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
  
        <div class="col-md-12">
            <div class="card">
                
                @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                <div class="alert alert-danger">{{$err}}</div>
                @endforeach
                @endif
                <div class="card-body">
                    <form method="POST" action="{{url('admin/schedule', [$schedule->schedule_id])}}"  enctype="multipart/form-data">
                        {{ method_field('PUT') }}{{csrf_field()}}

                        <div class="form-group row">
                                <label for="schedule_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Lịch Làm việc') }}</label>

                                <div class="col-md-10">
                                    <input id="schedule_name" type="text" class="form-control{{ $errors->has('schedule_name') ? ' is-invalid' : '' }}" name="schedule_name"  value="{{$schedule->schedule_name}}" required>

                                    @if ($errors->has('schedule_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('schedule_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                         <div class="form-group row">
                            <label for="schedule_morningStart" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Morning Start <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"  id="schedule_morningStart" name="schedule_morningStart" value="{{$schedule->schedule_morningStart}}" class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule_morningEnd" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Morning End <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"   id="schedule_morningEnd" name="schedule_morningEnd"  value="{{$schedule->schedule_morningEnd}}" class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule_afternoonStart" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Afternoon Start <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"   id="schedule_afternoonStart" name="schedule_afternoonStart" value="{{$schedule->schedule_afternoonStart}}" class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule_afternoonEnd" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Afternoon End <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"   id="schedule_afternoonEnd" name="schedule_afternoonEnd" value="{{$schedule->schedule_afternoonEnd}}" class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule_eveningStart" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Evening Start <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"   id="schedule_eveningStart" name="schedule_eveningStart"  value="{{$schedule->schedule_eveningStart}}"  class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="schedule_eveningEnd" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Thời gian">Evening End <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                  <input type="time"   id="schedule_eveningEnd" name="schedule_eveningEnd"  value="{{$schedule->schedule_eveningEnd}}" class="form-control"  required>
                                
                                </select>
                            </div>
                        </div>

                          

                        <div class="form-group row">
                            <label for="schedule_IdOrg" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn đơn vị">Chọn đơn vị <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="schedule_IdOrg" name="schedule_IdOrg" class="form-control"  required>
                                    <option value="">Choose...</option><?php
                                    try {
                                        foreach ($org as $no=>$org) { ?>
                                            <option value="{{$org->org_id}}"

                                                @if ($org->org_id==$schedule->schedule_idOrg)
                                                selected
                                                @endif
                                                >{{$org->org_name}}</option>

                                                 <?php foreach ($org_child[$no] as $orgc) { ?>
                                                <option 
                                                @if ($schedule->schedule_idOrg==$orgc->org_id)
                                                selected
                                                @endif
                                                value="{{$orgc->org_id}}"> ++ {{$orgc->org_name}}</option>
                                             
                                                <?php } ?>  

                                            
                                        <?php }
                                        ?> <?php
                                    } catch (Exception $e) { ?>
                                        <option value="1">thằng nào đó</option>
                                        <option></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="schedule_isActived" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>
                                <div class="col-md-10">
                                    <table class='borderchinone'><td>
                                    <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                                    </td><td>
                                    <input id="active" type="radio"  name="schedule_isActived" <?php if($schedule->schedule_isActived==1) echo "checked";?> value="1">
                                    </td> <td style="width:20px;">
                                    </td><td>
                                    <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                    </td><td>
                                    <input id="inactive" type="radio"  name="schedule_isActived" <?php if($schedule->schedule_isActived==0) echo "checked";?> value="0"> 
                                     </td></table>

                                </div>
                            </div>
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lưu lại') }}
                                </button>
                                &nbsp 
                <a onclick="document.getElementById('nutquaylai').click();" type="submit" class="btn btn-primary">
                                Quay Lại
                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('script')