<script src="<?php echo e(asset('/public/js/jquery.min.js')); ?>"></script><script src="<?php echo e(asset('/public/plg/xulymau.js')); ?>"></script>
<p><button class="btn btn-primary" id="btinmaunhanhoso" onclick="inmaunhanhoso()">In Mẫu</button><button class="btn btn-primary" id="xuatwordmaunhanhoso" ma_hoso="" onclick="xuatword('MaunhanHoso-{{$MaHoSo}}')">Xuất File Word</button></p>

<div id="maunhanhoso" style="width:85%;margin:auto;">
<table style="width:100%;text-align:center;">
	<tbody>
		<tr>
			<td>Cơ Quan Chủ Quản<br> <strong> {{$TenCoQuan}} </strong><br />
			S&ocirc;́: &hellip;&hellip;&hellip;&hellip;&hellip;.
			<p>M&atilde; Hồ Sơ</p>

			<p><img id="barcode" src="{{$BarCode}}" /></p>
			</td>
			<td style='vertical-align: top'><strong>CỘNG H&Ograve;A X&Atilde; HỘI CHỦ NGHĨA VIỆT NAM<br />
			Độc lập - Tự do - Hạnh ph&uacute;c</strong>
			<p style="text-align:right;">&hellip;&hellip;&hellip;, ng&agrave;y&hellip; th&aacute;ng&hellip; năm&hellip;</p>
			</td>
		</tr>
	</tbody>
</table>

<div class="tieude" style="text-align: center;width: 100%;">
<h1>PHIẾU BI&Ecirc;N NHẬN HỒ SƠ</h1>
</div>

<p>Bộ phận Tiếp nhận v&agrave; trả kết quả đ&atilde; nhận hồ sơ của &ocirc;ng (b&agrave;):&nbsp;<strong><span style="color:#FF0000;">{{$ChuHoSo}}</span></strong></p>

<p>Địa chỉ:<strong>{{$DiaChiChuHoSo}}</strong></p>

<p>Số điện thoại:&nbsp;<strong>{{$DienThoaiChuHoSo}}</strong></p>

<p>Email:&nbsp;<strong>{{$EmailChuHoSo}}&nbsp;</strong></p>

<p>Nội dung y&ecirc;u cầu giải quyết:&nbsp;&nbsp;<strong>{{$TenHoSo}}</strong></p>

<p>Hồ sơ gồm:</p>

<p>1. Th&agrave;nh phần hồ sơ, y&ecirc;u cầu v&agrave; số lượng mỗi loại giấy tờ gồm:</p>

<table style="width:100%;border: 1px solid black;border-collapse: collapse;">
	<tbody>
		<tr>
			<th style="border: 1px solid black;border-collapse: collapse;">STT</th>
			<th style="border: 1px solid black;border-collapse: collapse;">T&ecirc;n giấy tờ, t&agrave;i liệu</th>
			<th style="border: 1px solid black;border-collapse: collapse;">Bản ch&iacute;nh</th>
			<th style="border: 1px solid black;border-collapse: collapse;">Bản sao c&oacute; chứng thực</th>
			<th style="border: 1px solid black;border-collapse: collapse;">Bản sao</th>
		</tr>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse;">1</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
		</tr>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse;">2</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
		</tr>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse;">3</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
		</tr>
		<tr>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
			<td style="border: 1px solid black;border-collapse: collapse;">...</td>
		</tr>
	</tbody>
</table>

<p>2. Số lượng hồ sơ:................ (bộ)</p>

<p>3. Thời gian giải quyết hồ sơ theo quy định l&agrave;:................ ng&agrave;y</p>

<p>4. Thời gian nhận hồ sơ:....... giờ..... ph&uacute;t, ng&agrave;y........ th&aacute;ng....... năm...........</p>

<p>5. Thời gian trả kết quả giải quyết hồ sơ:........ giờ..... ph&uacute;t, ng&agrave;y....... th&aacute;ng...... năm...........</p>

<p>6. Đăng k&yacute; nhận kết quả tại (1):</p>

<p>V&agrave;o Sổ theo d&otilde;i hồ sơ, Quyển số:.................. Số thứ tự:..................</p>

<table style="text-align: 	right;width: 100%;">
	<tbody>
		<tr>
			<td>
			<p><strong>NGƯỜI TIẾP NHẬN</strong></p>

			<p>(K&yacute; v&agrave; ghi r&otilde; họ t&ecirc;n)</p>
			<br />
			<br />
			&nbsp;</td>
		</tr>
	</tbody>
</table>

<p>Ghi ch&uacute;:<br />
- (1) C&aacute; nh&acirc;n, tổ chức c&oacute; thể đăng k&yacute; thỏa thuận nhận kết quả tại Bộ phận tiếp nhận v&agrave; trả kết quả hoặc tại địa chỉ y&ecirc;u cầu qua dịch vụ bưu ch&iacute;nh hoặc c&aacute;c h&igrave;nh thức kh&aacute;c theo quy định của cơ quan.<br />
- Phiếu n&agrave;y c&aacute; nh&acirc;n, tổ chức nộp lại sau khi nhận được kết quả đ&atilde; giải quyết v&agrave; được lưu v&agrave;o hồ sơ tại cơ quan.<br />
- Nếu gặp vướng mắc, kh&oacute; khăn, đề nghị &ocirc;ng (b&agrave;) phản &aacute;nh theo đường d&acirc;y n&oacute;ng như sau:<br />
+ Cơ quan: .............................................................................................................<br />
+ Ph&ograve;ng Cải c&aacute;ch h&agrave;nh ch&iacute;nh (Sở Nội vụ): 061.3941833; cchc@dongnai.gov.vn.<br />
+ Ph&ograve;ng Kiểm so&aacute;t thủ tục h&agrave;nh ch&iacute;nh (Sở Tư ph&aacute;p): 061.3842244; ks.tthc@dongnai.gov.vn.&lt;</p>
</div>