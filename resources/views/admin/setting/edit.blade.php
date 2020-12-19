@extends ('admin.layouts.index')

@section ('title')
<title>Thiết Lập Chung</title>
@endsection
@section ('style')

@section ('content')

  
  
   @if(session('messenger'))
  <span class='plgalertsuccess'>
   <div class="alert alert-success"><i class="fa fa-check-circle"></i>    
  {{session('messenger')}}   <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
  </span>
  @endif
 
 
 <div class='row justify-content-center'>
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
 </div>
  <form action="update" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
     {{csrf_field()}}
    
    <ul class="nav nav-tabs ">
      <li class="active"><a data-toggle="tab" href="#tongquat">Tổng Quát</a></li>
      <li><a data-toggle="tab" href="#tuychon">Tùy Chọn</a></li>
      <li><a data-toggle="tab" href="#email">Email</a></li>
      <li><a data-toggle="tab" href="#sms">SMS</a></li>
      <li><a data-toggle="tab" href="#maychu">Máy Chủ</a></li>
    </ul>
    <div class="tab-content">
      <!-- Tổng quát  -->
        <div id="tongquat" class="tab-pane fade in active">
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-ks_meta-title">Tên Hệ Thống</label>
              <div class="col-sm-10">
                <input type="text" name="config_ks_meta_title" value="{{$data['config_ks_meta_title']}}" placeholder="Tên cửa hàng" id="input-ks_meta-title" class="form-control">
              </div>
             </div>
       
             <div class="form-group">
                <label class="col-sm-2 control-label" for="input-logoadmin">Hình đại diện trang quản lý</label>
                <div class="col-sm-10">
                    <div class="input-group">
                      <input type="button" id="lfmlogoadmin" data-input="thumbnaillogoadmin" data-preview="holderlogoadmin" value="Upload">
                      <input type="hidden" id="thumbnaillogoadmin" class="form-control" value="{{$data['config_logoadmin_htks']}}" type="text" name="config_logoadmin_htks">
                  </div>
                  <img id="holderlogoadmin" src="{{url('/')}}/public{{$data['config_logoadmin_htks']}}" style="margin-top:15px;max-height:100px;">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bannerhtks">Banner trang chủ</label>
                <div class="col-sm-10">
                    <div class="input-group">
                      <input type="button" id="lfmbannerhtks" data-input="thumbnailbannerhtks" data-preview="holderbannerhtks" value="Upload">
                      <input type="hidden" id="thumbnailbannerhtks" class="form-control" value="{{$data['config_banner_htks']}}" type="text" name="config_banner_htks">
                  </div>
                  <img id="holderbannerhtks" src="{{url('/')}}/public{{$data['config_banner_htks']}}" style="margin-top:15px;max-height:100px;">
                </div>
              </div>

              <div class="form-group plghidden">
                <label class="col-sm-2 control-label" for="input-logo">Hình đại diện trang chủ</label>
                <div class="col-sm-10">
               
                    <div class="input-group">
                      <input type="button" id="lfm" data-input="thumbnail" data-preview="holder" value="Upload">
                      <input type="hidden" id="thumbnail" class="form-control" value="{{$data['config_logo_htks']}}" type="text" name="config_logo_htks">
                  </div>
                  <img id="holder" src="{{url('/')}}/public{{$data['config_logo_htks']}}" style="margin-top:15px;max-height:100px;">
                 
                   


                </div>
              </div>

              <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-tencoquan">Tên Cơ quan</label>
              <div class="col-sm-10">
                <input type="text" name="config_tencoquan" value="{{$data['config_tencoquan']}}" placeholder="Tên Cơ quan" id="input-tencoquan" class="form-control">
              </div>
             </div>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-diachi">Địa chỉ</label>
              <div class="col-sm-10">
                <input type="text" name="config_diachi" value="{{$data['config_diachi']}}" placeholder="Địa chỉ" id="input-diachi" class="form-control">
              </div>
             </div>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-sodienthoai">Số điện thoại</label>
              <div class="col-sm-10">
                <input type="text" name="config_sodienthoai" value="{{$data['config_sodienthoai']}}" placeholder="Địa chỉ" id="input-sodienthoai" class="form-control">
              </div>
             </div>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-emailcoquan">Email</label>
              <div class="col-sm-10">
                <input type="text" name="config_emailcoquan" value="{{$data['config_emailcoquan']}}" placeholder="Địa chỉ" id="input-emailcoquan" class="form-control">
              </div>
             </div>


             <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ks_meta-description">Mô tả  Hệ Thống</label>
                  <div class="col-sm-10">
                    <textarea name="config_ks_meta_description" rows="5" placeholder="Mô tả Tóm tắt Hệ Thống" id="input-ks_meta-description" class="form-control">{{$data['config_ks_meta_description']}}</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ks_intro_home_htks">Giới thiệu hệ thống</label>
                  <div class="col-sm-10">
                    
                    
                    <textarea  id="config_ks_intro_home_htks" name="config_ks_intro_home_htks" class="form-control"> {{$data['config_ks_intro_home_htks']}} </textarea>

                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ks_thankyou_htks">Trang cám ơn</label>
                  <div class="col-sm-10">
                    
                    
                    <textarea  id="config_ks_thankyou_htks" name="config_ks_thankyou_htks" class="form-control"> {{$data['config_ks_thankyou_htks']}} </textarea>

                  </div>
                </div>

         </div>

        <!-- Tùy chọn  -->
      <div id="tuychon" class="tab-pane fade">

          <div class="form-group plghidden">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo 'Phải đăng ký thiết bị để làm khảo sát' ?>"><?php echo 'Phải đăng ký thiết bị để làm khảo sát'; ?></span></label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <?php if ($data['config_dangkythietbidekhaosat']) { ?>
                  <input type="radio" name="config_dangkythietbidekhaosat" value="1" checked="checked" />
                  <?php echo 'Có' ?>
                  <?php } else { ?>
                  <input type="radio" name="config_dangkythietbidekhaosat" value="1" />
                  <?php echo 'Có'; ?>
                  <?php } ?>
                </label>
                <label class="radio-inline">
                  <?php if (!$data['config_dangkythietbidekhaosat']) { ?>
                  <input type="radio" name="config_dangkythietbidekhaosat" value="0" checked="checked" />
                  <?php echo 'Không'; ?>
                  <?php } else { ?>
                  <input type="radio" name="config_dangkythietbidekhaosat" value="0" />
                  <?php echo 'Không'; ?>
                  <?php } ?>
                </label>
             </div>
           </div>


           <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-showeverypage"><span data-toggle="tooltip" title="" data-original-title="Số lượng hiển thị Mỗi Trang.">Số lượng hiển thị Mỗi Trang</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_showeverypage" value="{{$data['config_showeverypage']}}" placeholder="Số lượng hiển thị Mỗi Trang" id="input-showeverypage" class="form-control">
                   </div>
            </div> 



            <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-time_auto_direct"><span data-toggle="tooltip" title="" data-original-title="Thời gian tự động chuyển trang ở trang chủ khảo sát.">Thời gian tự động chuyển trang</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_time_auto_direct" value="{{$data['config_time_auto_direct']}}" placeholder="Thời gian tự động chuyển trang" id="input-time_auto_direct" class="form-control">
                   </div>
            </div> 

             <div class="form-group row  plghidden">
              <label class="col-sm-2 control-label" for="input-cofig_orgtosurvey"><span data-toggle="tooltip" title="" data-original-title="Chọn đơn vị khảo sát mặt định.">Chọn đơn vị khảo sát mặt định</span></label>

                  <div class="col-md-10">
                      <select id="config_orgtosurvey"  name="config_orgtosurvey" class="form-control{{ $errors->has('config_orgtosurvey') ? ' is-invalid' : '' }}">
                          <option value="">Choose...</option>
                          @foreach($data['orgs'] as $no=>$val)
                          <option 
                           @if ($val['org_id']==$data['config_orgtosurvey'])
                           selected
                           @endif

                          value="{{($val['org_id'])}}">{{$val['org_name']}}</option>
                          @endforeach
                      </select>
                       @if ($errors->has('config_orgtosurvey')) 
                          <p class='plgalert'>{{ $errors->first('config_orgtosurvey') }}</p>
                        @endif
                  </div>

              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-amthanhxinchao">Âm thanh xin chào</label>
                <div class="col-sm-10">
                      <input type="file" name="config_amthanhxinchao" />
                      <audio controls>
                      <source src="{{url('/')}}/public/{{$data['config_amthanhxinchao']}}" type="audio/mpeg">
                      </audio>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-amthanhcamon">Âm thanh cám ơn</label>
                <div class="col-sm-10">
                      <input type="file" name="config_amthanhcamon" />
                      <audio controls>
                      <source src="{{url('/')}}/public/{{$data['config_amthanhcamon']}}" type="audio/mpeg">
                      </audio>
                </div>
              </div>


 
            <span class='plghidden  '>
            <hr>
            <h4 >Mã Vạch</h4>
             <div class="form-group row ">
              <label class="col-sm-2 control-label" for="input-bacode_symbology"><span data-toggle="tooltip" title="" data-original-title="Loại mã Vạch.">Loại mã vạch</span></label>

                  <div class="col-md-10">
                      <select id="config_bacode_symbology"  name="config_bacode_symbology" class="form-control{{ $errors->has('config_bacode_symbology') ? ' is-invalid' : '' }}">
                          <option value="">Choose...</option>
                          @foreach($data['mavach_type'] as $no=>$val)
                          <option 
                           @if ($val==$data['config_bacode_symbology'])
                           selected
                           @endif

                          value="{{($val)}}">{{$val}}</option>
                          @endforeach
                      </select>
                       @if ($errors->has('config_bacode_symbology')) 
                          <p class='plgalert'>{{ $errors->first('config_bacode_symbology') }}</p>
                        @endif
                  </div>

              </div>
              <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-barcode-width"><span data-toggle="tooltip" title="" data-original-title="Chiều rộng Mã Vạch">Chiều rộng Mã Vạch</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_barcode-width" value="{{$data['config_barcode-width']}}" placeholder="Số lượng Hồ Sơ Mỗi Trang" id="input-barcode-width" class="form-control">
                   </div>
            </div> 
            <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-barcode-height"><span data-toggle="tooltip" title="" data-original-title="Chiều cao Mã Vạch">Chiều cao Mã Vạch</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_barcode-height" value="{{$data['config_barcode-height']}}" placeholder="Số lượng Hồ Sơ Mỗi Trang" id="input-barcode-height" class="form-control">
                   </div>
            </div> 
             <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-barcode-padding"><span data-toggle="tooltip" title="" data-original-title="Pading Mã Vạch">Pading Mã Vạch</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_barcode-padding" value="{{$data['config_barcode-padding']}}" placeholder="Số lượng Hồ Sơ Mỗi Trang" id="input-barcode-padding" class="form-control">
                   </div>
            </div> 

          <hr>
            <h4>Chọn các mẫu</h4>
            <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-config_temp_guiemail"><span data-toggle="tooltip" title="" data-original-title="Chọn mẫu gửi Email">Chọn mẫu gửi Email</span></label>
                  <div class="col-sm-10">
                    <select id="config_temp_guiemail" name="config_temp_guiemail" class="form-control{{ $errors->has('config_temp_guiemail') ? ' is-invalid' : '' }}"   >
                        <option value="">Choose...</option>
                        @foreach($temps as $val)
                        <option 
                        @if ($data['config_temp_guiemail']==$val->id_template)
                        selected
                        @endif
                        value="{{$val->id_template}}">{{$val->temp_name}}</option>
                        @endforeach
                    </select>
                   </div>
            </div> 
            <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-config_temp_guisms"><span data-toggle="tooltip" title="" data-original-title="Chọn mẫu gửi SMS">Chọn mẫu gửi SMS</span></label>
                  <div class="col-sm-10">
                    <select id="config_temp_guisms" name="config_temp_guisms" class="form-control{{ $errors->has('config_temp_guisms') ? ' is-invalid' : '' }}"   >
                        <option value="">Choose...</option>
                        @foreach($temps as $val)
                        <option 
                        @if ($data['config_temp_guisms']==$val->id_template)
                        selected
                        @endif
                        value="{{$val->id_template}}">{{$val->temp_name}}</option>
                        @endforeach
                    </select>
                   </div>
            </div> 
             <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-config_temp_biennhanhoso"><span data-toggle="tooltip" title="" data-original-title="Chọn mẫu Biên nhận hồ sơ">Chọn mẫu Biên nhận hồ sơ</span></label>
                  <div class="col-sm-10">
                    <select id="config_temp_biennhanhoso" name="config_temp_biennhanhoso" class="form-control{{ $errors->has('config_temp_biennhanhoso') ? ' is-invalid' : '' }}"   >
                        <option value="">Choose...</option>
                        @foreach($temps as $val)
                        <option 
                        @if ($data['config_temp_biennhanhoso']==$val->id_template)
                        selected
                        @endif
                        value="{{$val->id_template}}">{{$val->temp_name}}</option>
                        @endforeach
                    </select>
                   </div>
            </div> 
             <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-config_temp_chuyenhoso"><span data-toggle="tooltip" title="" data-original-title="Chọn mẫu chuyển hồ sơ">Chọn mẫu chuyển hồ sơ</span></label>
                  <div class="col-sm-10">
                    <select id="config_temp_chuyenhoso" name="config_temp_chuyenhoso" class="form-control{{ $errors->has('config_temp_chuyenhoso') ? ' is-invalid' : '' }}"   >
                        <option value="">Choose...</option>
                        @foreach($temps as $val)
                        <option 
                        @if ($data['config_temp_chuyenhoso']==$val->id_template)
                        selected
                        @endif
                        value="{{$val->id_template}}">{{$val->temp_name}}</option>
                        @endforeach
                    </select>
                   </div>
            </div> 

            </span>

      </div>
      <!-- Email -->
      <div id="email" class="tab-pane fade">
           
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-protocol"><span data-toggle="tooltip" title="Chỉ chọn 'Thư' trừ khi máy chủ lưu trữ của bạn đã bị vô hiệu hoá chức năng mail php.">Giao thức thư</span></label>
                <div class="col-sm-10">
                  <select name="config_mail_protocol" id="input-mail-protocol" class="form-control">
                    <?php if ($data['config_mail_protocol'] == 'mail') { ?>
                    <option value="mail" selected="selected">Mail</option>
                    <?php } else { ?>
                    <option value="mail">Mail</option>
                    <?php } ?>
                    <?php if ($data['config_mail_protocol'] == 'smtp') { ?>
                    <option value="smtp" selected="selected">SMTP</option>
                    <?php } else { ?>
                    <option value="smtp">SMTP</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-parameter"><span data-toggle="tooltip" title="Khi sử dụng 'Mail', mail thông số bổ sung có thể được thêm ở đây ">Tham số thư</span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_parameter" value="<?php echo $data['config_mail_parameter']; ?>" placeholder="Tham số thư" id="input-mail-parameter" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-hostname"><span data-toggle="tooltip" title="Thêm tiền tố 'tls://' Nếu kết nối an ninh là cần thiết. (Ví dụ:  tls://smtp.gmail.com).">SMTP Hostname</span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_hostname" value="<?php echo $data['config_mail_smtp_hostname']; ?>" placeholder="SMTP Hostname" id="input-mail-smtp-hostname" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-username">SMTP Username</label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_username" value="<?php echo $data['config_mail_smtp_username']; ?>" placeholder="SMTP Username" id="input-mail-smtp-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-password">SMTP Password</label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_password" value="<?php echo $data['config_mail_smtp_password']; ?>" placeholder="SMTP Password" id="input-mail-smtp-password" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-port">SMTP Port</label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_port" value="<?php echo $data['config_mail_smtp_port']; ?>" placeholder="SMTP Port" id="input-mail-smtp-port" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-encryption">Mail Encryption</label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_encryption" value="<?php echo $data['config_mail_encryption']; ?>" placeholder="Mail Encryption" id="input-mail-encryption" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-smtp-timeout">SMTP Timeout</label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail_smtp_timeout" value="<?php echo $data['config_mail_smtp_timeout']; ?>" placeholder="SMTP Timeout" id="input-mail-smtp-timeout" class="form-control" />
                </div>
              </div>
              
            



      </div>
      <!-- SMS -->
      <div id="sms" class="tab-pane fade">
        <h4>Chọn nhà cung cấp dịch vụ SMS</h4>
          
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="Tick để chọn nhà cung cấp esms.vn"> ESMS.VN </span></label>
                <div class="col-sm-10" style='padding-top: 7px;'>
                <input type="radio" name="config_sms_provider" value="esms.vn" 
                <?php if($data['config_sms_provider']=='esms.vn') echo 'checked'; ?>
                />
                </div>
               </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-esmsvn_api_key"><span data-toggle="tooltip" title="SMS Api key">Api Key</span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_esmsvn_api_key" value="<?php echo $data['config_esmsvn_api_key']; ?>" placeholder="SMS Api key" id="input-esmsvn_api_key" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-esmsvn_secret_key"><span data-toggle="tooltip" title="SMS Secret key">Secret Key</span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_esmsvn_secret_key" value="<?php echo $data['config_esmsvn_secret_key']; ?>" placeholder="SMS secret key" id="input-esmsvn_secret_key" class="form-control" />
                </div>
              </div>
              
            <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="Tick để chọn nhà cung cấp smsnhanh.com"> SMSNHANH.COM </span></label>
                <div class="col-sm-10" style='padding-top: 7px;'>
                <input type="radio" name="config_sms_provider" value="smsnhanh.com" 
                <?php if($data['config_sms_provider']=='smsnhanh.com') echo 'checked'; ?>
                />
                </div>
               </div>
              
              
              
            



      </div>
      <!-- Máy chủ -->
      <div id="maychu" class="tab-pane fade">
         
          <div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo 'Chế độ bảo trì' ?>"><?php echo 'Chế độ bảo trì'; ?></span></label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <?php if ($data['config_maintenance']) { ?>
                  <input type="radio" name="config_maintenance" value="1" checked="checked" />
                  <?php echo 'Có' ?>
                  <?php } else { ?>
                  <input type="radio" name="config_maintenance" value="1" />
                  <?php echo 'Có'; ?>
                  <?php } ?>
                </label>
                <label class="radio-inline">
                  <?php if (!$data['config_maintenance']) { ?>
                  <input type="radio" name="config_maintenance" value="0" checked="checked" />
                  <?php echo 'Không'; ?>
                  <?php } else { ?>
                  <input type="radio" name="config_maintenance" value="0" />
                  <?php echo 'Không'; ?>
                  <?php } ?>
                </label>
             </div>
           </div>

           <!--backup time -->
           <hr>
           <div class="form-group">
                <?php
                  $backup_time=explode(",",$data['config_backup_time']);
                  if(isset($backup_time[1])) $backup_time[1]=str_replace(":00","",$backup_time[1]);
                  if(isset($backup_time[2])) $backup_time[2]=str_replace(":00","",$backup_time[2]);
                  //print_r($backup_time);
                ?>
                <label class="col-sm-2 control-label" for="input-logo">Hẹn thời gian Backup</label>
                <div class="col-sm-10">
                   <div class="input-group">
                    <table class='timebackuptb borderchinone'><th></th><th></th><th></th><th></th>
                      <tr><td>
                      <input type="radio" id='khongbk' onclick="capnhat_time('khongbk')" name="config_radiotimebackup"
                      @if($backup_time[0]=='khongbk')
                      checked
                      @endif
                      value="0"> Không Backup<br>
                      </td></tr>
                      <tr><td>

                      <input type="radio" id='hourlyAt' onclick="capnhat_time('hourlyAt')" name="config_radiotimebackup"
                      @if($backup_time[0]=='hourlyAt')
                      checked
                      @endif
                        value="hourlyAt"> Mỗi giờ 

                      <span data-toggle="tooltip" title="" data-original-title="Bakcup mỗi giờ, nhập vào phút bên cạnh (1..60)!"><span class="glyphicon glyphicon-question-sign"></span></span>

                      </td><td><input onkeyup="capnhat_time('hourlyAt')"  class='nhaptime' placeholder="Phút?" type="text" id='hourlyAt1' value="<?php if($backup_time[0]=='hourlyAt') echo $backup_time[1];?>"> 
                      </td></tr>

                      <tr><td>
                      <input type="radio" id='dailyAt' onclick="capnhat_time('dailyAt')" name="config_radiotimebackup" 
                      @if($backup_time[0]=='dailyAt')
                      checked
                      @endif                      
                       value="dailyAt"> Mỗi Ngày 

                       <span data-toggle="tooltip" title="" data-original-title="Bakcup mỗi ngày, nhập vào giờ bên cạnh (1..12)!"><span class="glyphicon glyphicon-question-sign"></span></span>

                      </td><td><input onkeyup="capnhat_time('dailyAt')" placeholder="Giờ?" class='nhaptime'  type="text" id='dailyAt1' value="<?php if($backup_time[0]=='dailyAt') echo $backup_time[1];?>"> 
                      </td></tr>

                      <tr><td>
                      <input type="radio" id='weeklyOn' onclick="capnhat_time('weeklyOn')" name="config_radiotimebackup" 
                      @if($backup_time[0]=='weeklyOn')
                      checked
                      @endif 
                      value="weeklyOn"> Mỗi tuần 
                       <span data-toggle="tooltip" title="" data-original-title="Bakcup mỗi tuần, nhập vào thứ mấy, giờ nào bên cạnh! <br>(1->7: Thứ 2-> Chủ nhật)"><span class="glyphicon glyphicon-question-sign"></span></span>

                      </td><td><input   onkeyup="capnhat_time('weeklyOn')" class='nhaptime'  placeholder="Thứ?" type="text" id='weeklyOn1' value="<?php if($backup_time[0]=='weeklyOn') echo $backup_time[1];?>"> 
                      </td><td><input   onkeyup="capnhat_time('weeklyOn')"  class='nhaptime' placeholder="Giờ?" type="text" id='weeklyOn2' value="<?php if($backup_time[0]=='weeklyOn') echo $backup_time[2];?>"> 
                      </td></tr>

                      <tr><td>
                      <input type="radio" id='monthlyOn' onclick="capnhat_time('monthlyOn')"  name="config_radiotimebackup"
                      @if($backup_time[0]=='monthlyOn')
                      checked
                      @endif 
                      value="monthlyOn"> Mỗi tháng 
                       <span data-toggle="tooltip" title="" data-original-title="Bakcup mỗi tháng,nhập vào ngày mấy, giờ nào bên cạnh?"><span class="glyphicon glyphicon-question-sign"></span></span>
                      </td><td><input onkeyup="capnhat_time('monthlyOn')"   class='nhaptime'  placeholder="Ngày?" type="text" id='monthlyOn1' value="<?php if($backup_time[0]=='monthlyOn') echo $backup_time[1];?>"> 
                      </td><td><input onkeyup="capnhat_time('monthlyOn')" class='nhaptime' placeholder="Giờ?" type="text" id='monthlyOn2' value="<?php if($backup_time[0]=='monthlyOn') echo $backup_time[2];?>"> 
                      </td></tr> 
                  </table>
                      <!-- type="hidden" -->
                      <input   type="hidden"  id="config_backup_time" class="form-control" value="{{$data['config_backup_time']}}" type="text" name="config_backup_time">
                  </div>
                </div>
              </div>
              <!--end backup time -->


      </div>
      <br><br><br>
    </div>
   

    <div  style="" class='submitsetting'>
      <button type="submit" class="btn btn-primary">
          {{ __('Lưu Lại') }}
      </button>
      &nbsp 
                <a onclick="document.getElementById('nutquaylai').click();" type="submit" class="btn btn-primary">
                                Quay Lại
                </a>
    </div>
  </form>
 

  <script src="{{url('/')}}/public/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        var options = {prefix:"{{url('/public/')}}"}
        $('#lfm').filemanager('image',options);
        $('#lfmlogoadmin').filemanager('image',options);
        $('#lfmbannerhtks').filemanager('image',options);
    </script> 


<script src="<?php echo e(asset('/public/ckeditor/ckeditor.js')); ?>"></script>
<script>
  //----------
  var options = {
    filebrowserImageBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
     height : '150px'
  };
  CKEDITOR.replace('config_ks_intro_home_htks', options);
  CKEDITOR.replace('config_ks_thankyou_htks', options);
  
    </script>



<script type="text/javascript">
  /*xử lý time backup*/
  function capnhat_time(backuptime){
    //alert(backuptime);
    /*cho khung vừa chọn là check luôn*/

    document.getElementById(backuptime).checked = true;

    var t1=backuptime+'1';
    var e1 = document.getElementById(t1);
    var c1='';
    if(e1){
      t1='#'+t1;
      c1=$(t1).val();
      if(c1=='') c1='1';
      
    }
    var t2=backuptime+'2';
    var e2 = document.getElementById(t2);
    var c2='';
    if(e2){
      t2='#'+t2;
      c2=$(t2).val();
      if(c2=='') c2='1';
     
    }
  
    var vl=backuptime+','+c1+','+c2;
    $('#config_backup_time').val(vl);

  }

  function uploadhinhanh(){
     //alert(0);
      
     
      $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
      /*-------*/
      var config_logo = $('#config_logo')[0].files[0];
      var form = new FormData();
      form.append('config_logo', config_logo);
      /*---------*/
      var urll="{{ url('admin/setting/upload')}}";
      $.ajax({
          url: urll,
          cache: false,
          contentType: false,
          processData: false,
          type: 'POST',
          data: form,
          success: function (response)
          {
              //alert('YES');
              document.getElementById("thumb_config_logo").src= "{{url('/public')}}"+ response['config_logo'];
              $("#value_config_logo").val(response['config_logo']);
              //alert(response['success']);
          },
          error: function(xhr) {
              //alert('NO');
              console.log(xhr.responseText);  
         }
      });
     
  }

</script>
@endsection

@section ('script')


 
