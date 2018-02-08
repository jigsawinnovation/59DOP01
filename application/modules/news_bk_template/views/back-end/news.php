<?php if($mode == ''){?>
	<div class="wrap_data">
		<div class="h3">&nbsp;&nbsp;<?php echo $title;?></div>
		<?php echo css_asset("../plugin/datatable/css/jquery.dataTables.min.css");?>
		<?php echo js_asset("../plugin/datatable/js/jquery.js");?>
		<?php echo js_asset("../plugin/datatable/js/jquery.dataTables.min.js");?>
		<div class="table_result">
			<div class="command">
				<button title="เพิ่มข้อมูลใหม่" type='button' class="bt_tools bt_add"  onclick="window.location.href='<?php echo base_url(uri_seg(1)."/".uri_seg(2)."/add")?>'"><i class="fa fa-plus"></i> เพิ่มข้อมูลใหม่</button>
			</div>
			<table id="datatable">
				<thead>
					<th>ID</th>
					<th>หัวข้อข่าวสาร</th>
					<th>เรื่องย่อ</th>
					<!-- <th>เจ้าของข่าว</th> -->
					<!-- <th>แสดงสถานะ New</th> -->
					<th>สถานะ</th>
					<th>เครื่องมือ</th>
				</thead>
				<tbody>
				<?php foreach ($nRows as $row) { 
					$head 	= uns($row['N_Head']);
					$tt 	= uns($row['N_Title']);
					$own 	= uns($row['N_Owner_info']);
					$allow 	= array('1' => "เผยแพร่", '2' => "ไม่เผยแพร่");?>
					<tr>
						<td><?php echo $row['N_ID'];?></td>
						<td width="40%"><?php echo nameTitle($head['TH'],150);?></td>
						<td><?php echo nameTitle($tt['TH']);?></td>
						<!-- <td><?php echo $own['TH'];?></td> -->
						<!-- <td>
						<?php 
							$date1=date_create($row['N_StartDate']);
							$date2=date_create($row['N_EndDate']);
							echo date_diff($date1,$date2)->days." วัน";
						?>
						</td> -->
						<td><?php echo $allow[$row['N_Allow']];?></td>
						<td class="td-image" width="15%">
							<button title="แก้ไข" type='button' class="bt_tools bt_edit" onclick="window.location.href ='<?php echo base_url("news/news{$CN_ID}/edit/{$row['N_ID']}");?>';"><i class="fa fa-pencil"></i> แก้ไข</button>
					        <button title="ลบ" type='button' class="bt_tools bt_del" onclick="if(confirm('ยืนยันการลบข้อมูล!')){ window.location.href='<?php echo base_url("news/news{$CN_ID}/del/{$row['N_ID']}");?>';}else{ return false;}"><i class="fa fa-trash-o"></i> ลบ</button>
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
		<script type="text/javascript">
			$('#datatable').DataTable({'iDisplayLength': 25,"aaSorting": []});
		</script>
	</div>
<?php }elseif($mode == 'add' || $mode == 'edit') {?> 
	<?php echo js_asset("../plugin/ckeditor/ckeditor.js");?>
	<div class="wrap_form">
		
		<div class="h3">&nbsp;&nbsp;<?php echo $title;?></div>
		<div class="content">
			<?php echo validation_errors('<div class="form_message_error">*',"</div>"); ?>
			<?php echo form_open_multipart()?>
			<table>
				<tr><td>
					<ul class="tab">
						<li class="lg_select" title="Thai Language"><img src="<?php echo base_url('assets/images/thai_icon.png');?>"><span>TH</span></li>
						<li title="English Language"><img src="<?php echo base_url('assets/images/English_icon.png');?>"><span>EN</span></li>
					</ul>
				</td></tr>
			
				<tr>
					<td class="first_col">ภาพไตเติ้ลประกอบ<font class="required"><span> </span><span>(ขนาด 2:1 หรือ 600x318px)</span></font>:</td>
					<td>
						<img style="max-height:200px;" class="myPreview" src="<?php if($news['N_ImgTitle']!=''){echo base_url('assets/modules/news/images/'.$news['N_ImgTitle']);}?>">
						<br>
						<input accept='image/*' type="file" title="ภาพไตเติ้ลประกอบ" name="N_ImgTitle" onclick="resetValue('N_ImgTitle','hidden');" onchange="imgPerview(this,'.myPreview');">
						<a class="filesBrowser bt_tools" href="#fb"
							data-module="news"
							data-open="images"
							data-showid=".myPreview"
							data-saveid="#selected_json"
							data-multi="false"
							onclick="init($(this));resetValue('N_ImgTitle','file');">
						<i class="fa fa-upload"></i> เลือกไฟล์</a>
						<input id="selected_json" name="N_ImgTitle" type="hidden">
					</td>
				</tr>

				<?php if($CN_ID == 3){ ?>

				<tr>
					<td class="first_col">ประเภท<font class="required"><span>*</span><span></span></font>:</td>
					<td>
						<select name="N_Type" class="select se_medium" title="ประเภท" required>
						<?php
						$arr_N_Type = array(
							'1'	=> 'ประกาศราคากลาง',
							'2'	=> 'ประกาศร่าง',
							'3'	=> 'ประกาศเชิญชวน',
							'4'	=> 'ประกาศผลการเสนอราคา',
						);
						
						foreach($arr_N_Type as $key=>$value) {
						?>
							<option value="<?php echo $key;?>" <?php if($news['N_Type'] == $key) echo 'selected'?>><?php echo $value;?></option>
						<?php	
						}
						?>
						</select>
					</td>
				</tr>

				<?php } ?>

				<tr>
					<td class="first_col">หัวข้อข่าวสาร<font class="required"><span>*</span><span></span></font>:</td>
					<td class="th" colspan="3"><input type="text" title="หัวข้อข่าวสาร" name="N_Head[TH]" class="txtinput in_vlarge" value="<?php echo $news['N_Head']['TH']?>" autofocus required></td>
					<td class="en" style="display:none;" colspan="3"><input type="text" title="หัวข้อข่าวสาร" name="N_Head[EN]" class="txtinput in_vlarge" value="<?php echo $news['N_Head']['EN']?>"></td>
				</tr>
				<tr>
					<td class="first_col top">เรื่องย่อ<font class="required"><span>*</span><span></span></font>:</td>
					<td class="th"><textarea title="เรื่องย่อ" name="N_Title[TH]" class="txtarea ar_large"><?php echo $news['N_Title']['TH']?></textarea></td>
					<td class="en" style="display:none;"><textarea title="Title" name="N_Title[EN]" class="txtarea ar_large"><?php echo $news['N_Title']['EN']?></textarea></td>
				</tr>
				<tr>
					<td class="first_col top">เนื้อเรื่อง<font class="required"><span>*</span><span></span></font>:</td>
					<td class="th" colspan="3"><textarea id="ckeditorTH" title="เนื้อเรื่อง" name="N_Descript[TH]" class="txtarea ar_large ckeditor"><?php echo $news['N_Descript']['TH']?></textarea></td>
					<td class="en" style="display:none;" colspan="3"><textarea id="ckeditorEN" title="Description" name="N_Descript[EN]" class="txtarea ar_large ckeditor"><?php echo $news['N_Descript']['EN']?></textarea></td>
				</tr>
				<?php if($cnRow['CN_ActivityCheck'] == '1'){?>
					<tr>
						<td class="first_col">กิจกรรมเริ่มต้นวันที่<font class="required"><span></span><span></span></font>:</td>
						<td><input type="text" name="N_StartActivity" class="txtinput in_medium dateStart" value="<?php echo dateChange($news['N_StartActivity'],3)?>"></td>
					</tr>

					<tr>
						<td class="first_col">กิจกรรมสิ้นสุดวันที่<font class="required"><span></span><span></span></font>:</td>
						<td><input type="text" name="N_EndActivity" class="txtinput in_medium dateEnd" value="<?php echo dateChange($news['N_EndActivity'],3)?>"></td>
					</tr>
				<?php }?>
				<tr>
					<td class="first_col">วันที่เริ่มแสดงสถานะ New:</td>
					<td><input type="text" name="N_StartDate" class="txtinput in_medium dateStart" value="<?php echo dateChange($news['N_StartDate'],3)?>"></td>
				</tr>
				<tr>
					<td class="first_col">วันที่สิ้นสุดแสดงสถานะ New:</td>
					<td><input type="text" name="N_EndDate" class="txtinput in_medium dateEnd" value="<?php echo dateChange($news['N_EndDate'],3)?>"></td>
				</tr>
				<tr>
					<td class="first_col">จำนวนวิวที่จะขึ้นสถานะ Hot:</td>
					<td><input type="number" min='0' step='10' name="N_HotNumDisplay" class="txtinput in_medium" value="<?php echo $news['N_HotNumDisplay']?>"></td>
				</tr>
				<tr>
					<td class="first_col top">ไฟล์แนบ:</td>
					<td class="top">

						<?php if(!empty($newsFiles)){?>
							<ul class="file_attach">
							<?php foreach ($newsFiles as $fRow) {
								$name['ND_Name'] = uns($fRow['ND_Name']);
								?>
								<li>
									<span class='th'>
										<a target="_blank" title="<?php echo $name['ND_Name']['TH'];?>" href="<?php echo base_url('news/fileDownload/'.$fRow['ND_ID']);?>"><?php echo $name['ND_Name']['TH'];?></a>
										<a class="del" title="Delete <?php echo $name['ND_Name']['TH'];?>" href="javascript:void('Delete <?php echo $name['ND_Name']['TH'];?>')" onClick='del_file(<?php echo $fRow['ND_ID']?>,this)'><img width="16" height="16" src='<?php echo base_url("assets/admin/images/tools/delete.png")?>'></a>
									</span>
									<span class='en' style="display:none">
										<a target="_blank" title="<?php echo $name['ND_Name']['EN'];?>" href="<?php echo base_url('news/fileDownload/'.$fRow['ND_ID']);?>"><?php echo $name['ND_Name']['EN'];?></a>
										<a class="del" title="Delete <?php echo $name['ND_Name']['EN'];?>" href="javascript:void('Delete <?php echo $name['ND_Name']['EN'];?>')" onClick='del_file(<?php echo $fRow['ND_ID']?>,this)'><img width="16" height="16" src='<?php echo base_url("assets/admin/images/tools/delete.png")?>'></a>
									</span>
								</li>
							<?php }?>
							</ul>
						<?php }?>
						<input type="file" name="N_File[]" onchange="upLoaddetail(this)" multiple><br>
						<ul class="fileHolder fileUL"></ul>
						<div style="clear:both"></div>
						<a class="filesBrowser bt_tools bt_upload" href="#fb"
							data-module="news"
							data-open="uploads"
							data-showid=".fileSE"
							data-saveid="#selected_json2"
							data-multi="true"
							onclick="init($(this))">
						<i class="fa fa-upload"></i> เลือกไฟล์</a>
						<input id="selected_json2" name="N_File" type="hidden">
						<ul class="fileHolder fileSE"></ul>
					</td>
					
				</tr>
				<tr>
					<td class="first_col top" >คีย์เวิร์ด<font class="required"><span>*</span><span></span></font>:</td>
					<td class="th" ><textarea title="คีย์เวิร์ด" name="N_Keyword[TH]" class="txtarea ar_medium" required><?php echo $news['N_Keyword']['TH']?></textarea></td>
					<td class="en"  style="display:none"><textarea title="Keyword" name="N_Keyword[EN]" class="txtarea ar_medium"><?php echo $news['N_Keyword']['EN']?></textarea></td>	
				</tr>
				
				<tr>
					<td class="first_col top" >ข้อมูลเจ้าของข่าวและช่องทางติดต่อ:</td>
					<td class="th" ><textarea title="ข้อมูลเจ้าของข่าวและช่องทางติดต่อ" name="N_Owner_info[TH]" class="txtarea ar_medium"><?php echo $news['N_Owner_info']['TH']?></textarea></td>
					<td class="en"  style="display:none"><textarea title="Owner Information News Contact channels" name="N_Owner_info[EN]" class="txtarea ar_medium"><?php echo $news['N_Owner_info']['EN']?></textarea></td>
				</tr>
				<tr>
					<td class="first_col">สถานะ<font class="required"><span>*</span><span></span></font>:</td>
					<td>
						<select name="N_Allow" class="select se_small">
							<option value="1" <?php if($news['N_Allow'] == '1') echo 'selected'?>>เผยแพร่</option>
							<option value="2" <?php if($news['N_Allow'] == '2') echo 'selected'?>>ไม่เผยแพร่</option>
						</select>
					</td>
				</tr>
				<?php if($mode == 'edit'){?>
					<tr>
						<td class="first_col top">อัพเดทล่าสุด:</td><td><?php echo $news['N_UserUpdate'];?> เวลา <?php echo formatDateThaiFromDatatime($news['N_DateTimeUpdate']);?></td>
					</tr>
				<?php }?>
				<tr>
					<td colspan='6'>
						<center>
							<input type='submit' name="bt_submit" value='บันทึกข้อมูล' hidden='hidden'>
							<button title="บันทึกข้อมูล" type='submit' class="bt_tools bt_save" onclick="$('input[name=bt_submit]').click()"><i class="fa fa-pencil-square-o"></i> บันทึกข้อมูล</button>						
							<?php if($mode == 'edit'){?>
								<button title="ลบ" type='button' class="bt_tools bt_del" onclick="if(confirm('ยืนยันการลบข้อมูล!')){ window.location.href='<?php echo base_url(uri_seg(1)."/".uri_seg(2)."/del/{$news['N_ID']}");?>';}else{ return false;}"><i class="fa fa-trash-o"></i> ลบข้อมูล</button>
							<?php }?>
							<button title="กลับไปยังรายการ" type='button' class="bt_tools bt_cancel"  onclick="window.location.href='<?php echo base_url(uri_seg(1)."/".uri_seg(2));?>'"><i class="fa fa-undo"></i> กลับไปยังรายการ</button>
						</center>
					</td>
				</tr>
			</table>
			<?php echo form_close()?>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.dateStart').datepicker({
				dateFormat: 'dd/mm/yy',
			});
			$('.dateEnd').datepicker({
				dateFormat: 'dd/mm/yy',
			});
		});
		function del_file(ID,item){
			//key=$(item).parent().index();
			setTimeout(function(){
			    $.ajax({
			        url: "<?php echo base_url('news/del_file');?>",
			        data: "ID="+ID+"&method=news_document&idn=ND_ID&fd=news_files&fn=ND_File",
			        type:'post',
			        dataType: "json",
			        success:function(res){
			            $(".file_attach li:eq("+$(item).parent().parent().index()+")").remove();
			        },
			        error:function(err){
			            alert('ERROR! : '+err);
			        }
			    });
			},200);
		}
		function imgPerview(input,target){
			if (input.files && input.files[0]) {
	            var reader = new FileReader();
				reader.onload = function (e) {
	            	$(target).attr('src', e.target.result)
	            	// $('.fileName').val(input.files[0].name);
	        	}
				reader.readAsDataURL(input.files[0]);
				// console.log(input.files);
	        }
		}
		function resetValue(element,type){
			$('input[name="'+element+'"][type="'+type+'"]').val('');
		}

	</script>
	<?php 
	echo css_asset("../admin/css/file_browser.css");
	echo css_asset('../plugin/fancyapps/source/jquery.fancybox.css');
	echo js_asset('../plugin/fancyapps/source/jquery.fancybox.pack.js');
?>
<div id="fb" class="fb_wapper" style="display:none">
	<div class="FB_Header">
		<a href="javascript:getItem('images');" class="fb-tab t_image">Images</a> | <a href="javascript:getItem('uploads');" class="fb-tab t_upload">Uploads</a>
		<div class="currectPath">./assets/<span id="yourPath"></span></div>
		<div class="r_header">
			<a href="javascript:save();" class="btn">ตกลง</a>
		</div>
	</div>
	<div class="fb_content"></div>
</div>

<script type="text/javascript">
	$('.filesBrowser').fancybox({	
		width		: 900,
		height		: 600,
		type		: 'inline',
	    autoSize 	: false,
	    // afterLoad	: getItem($('.fancybox').data('open')),
	    // afterShow	: getItem($('.fancybox').data('open')),
	    closeClick  : false,
	    helpers     : { 
	        overlay : {
	        	closeClick: false
	        }
	    },
	});
</script>

<script type="text/javascript">
	Array.prototype.clear = function() {
	  	while (this.length) {
		    this.pop();
		}
	};
	var base 	= '<?php echo base_url("assets");?>';
	var selected_arr = [];
	var all_file 	= [];
	var sub_path 	= "";
	var multiple 	= '';
	var nowIndex 	= -1;
	var showID 		= '';
	var saveID 		= '';
	var module 		= '';
	var type 		= '';

	function init(item){
		// alert(item.index());
		if(nowIndex != item.index()){
			nowIndex = item.index();

			selected_arr.clear();
			all_file.clear();

			module 		= item.data('module');
			multiple 	= item.data('multi');
			saveID 		= $(item.data('saveid'));
			showID 		= $(item.data('showid'));
			type 		= item.data('open');

			// var elementType = showID.prop('tagName');
			// alert(elementType);
			$.fancybox.open({beforeShow : getItem(item.data('open'))});
		}
		// console.log(item.data('saveid'));
		// console.log(saveID);
	}
	function getItem(new_path){
		// alert(new_path);
		selected_arr.clear();
		all_file.clear();
		$.ajax({
			url: '<?php echo site_url("control/file_browser");?>/'+module,
			type: 'POST',
			dataType: 'json',
			data: {
				folder 	: new_path,
				type 	: type
			},
		})
		.done(function(res) {
			console.log("success");
			console.dir(res);
			all_file = res['item'];
			var str = path = display_path ="";
			$('.fb_content').empty();

			var o_path = new_path.split('/');
			if(o_path !== ''){
				if(o_path[0] == 'images'){
					$('.t_image').addClass('tab-select');
					$('.t_upload').removeClass('tab-select');
				}else{
					$('.t_image').removeClass('tab-select');
					$('.t_upload').addClass('tab-select');
				}
			}
			delete o_path[o_path.length-1];
			o_path = o_path.join('/');
			o_path = o_path.substring(0,o_path.length-1);
			if(o_path !=''){
				str+="<a class='back-link' title='Back' href='javascript:getItem(\""+o_path+"\");'>";
				str+="<div class='back-icon fb_item'>";
				str+="<img src='"+base+"/images/ico/folder_back.png'>";
				// str+="<div class='file_name'>Back</div>";
				str+="</div>";
				str+="</a>";
			}
			for (var i = 0; i < res['item'].length; i++) {
				var imgExt = ["gif","jpeg","jpg","png"];
				var ext = res['item'][i].split('.');
				var isImage = $.inArray(ext[ext.length-1], imgExt);
				

				if(ext[ext.length-1] == 'folder'){
					str+="<a title='"+ext[0]+"' href='javascript:getItem(\""+new_path+"/"+ext[0]+"\");'>";
					str+="<div class='fb_item' id='item"+i+"'>";
					str+="<img src='"+base+"/images/ico/folder.png'>";
					str+="<div class='file_name'>"+ext[0]+"</div>";
					str+="</div>";
					str+="</a>";
				}else{
					if(res['module_name'] != ''){
						path = base+"/modules/"+res['module_name'];
					}else{
						path = base;
					}
					str+="<a title='"+res['item'][i]+"' href='javascript:select("+i+");'>";
					str+="<div class='fb_item' id='item"+i+"'>";
					if(isImage >= 0 ){
						str+="<img src='"+path+"/"+new_path+"/"+res['item'][i]+"'>";
					}else{
						if(fileExists(base+"/images/ico/"+ext[ext.length-1].toLowerCase()+".jpg")){
							str+="<img title='"+res['item'][i]+"' src='"+base+"/images/ico/"+ext[ext.length-1].toLowerCase()+".jpg'>";
						}else{
							str+="<img title='"+res['item'][i]+"' src='"+base+"/images/ico/default.jpg'>";
						}
					}
					delete ext[ext.length-1];
					ext = ext.join('.');
					ext = ext.substring(0,ext.length-1);
					str+="<div class='file_name'>"+ext+"</div>";
					str+="</div>";
					str+="</a>";
				}
			}
			$('.fb_content').append(str);

			if(res['module_name'] != ''){
				display_path = "modules/"+res['module_name']+"/"+new_path;
			}else{
				display_path = new_path;		
			}
			$('#yourPath').text(display_path);
			
			sub_path = new_path.split('/');

			delete sub_path[0];
			sub_path = sub_path.join('/');
			sub_path = sub_path.substring(1,sub_path.length);
		})
		.fail(function(res) {
			console.log("error");
			console.dir(res);
			$('.fb_content').html(res.responseText);
		});
	}
	function select(i){
		if(multiple){
			var arr_index = $.inArray(i, selected_arr);
			if(arr_index >= 0){
				delete selected_arr[arr_index];
				$("#item"+i).removeClass('selected');
			}else{
				selected_arr.push(i);
				$("#item"+i).addClass('selected');
			}
		}else{
			var old_i = selected_arr.pop();
			$("#item"+old_i).removeClass('selected');
			$("#item"+i).addClass('selected');
			selected_arr.push(i);
		}
		// console.dir(selected_arr);
	}
	function save(){
		console.log("save");
		console.log(sub_path);
		var select_file=[];
		var select_fileName=[];
		showID.empty();
		for (var i = 0; i < selected_arr.length; i++) {
			if(selected_arr[i] !== undefined){
				if(sub_path != ''){
					console.log(sub_path+'/'+all_file[selected_arr[i]]);
					select_file.push(sub_path+'/'+all_file[selected_arr[i]]);
				}else{
					console.log(all_file[selected_arr[i]]);
					select_file.push(all_file[selected_arr[i]]);
				}
				select_fileName.push(all_file[selected_arr[i]]);
				// showID.append('<li>'+all_file[selected_arr[i]]+'</li>');
			}
		};

		saveID.val(JSON.stringify(select_file));

		if(showID.prop('tagName') == 'IMG'){
			if(select_fileName[0] !== undefined)
				showID.attr('src', base+"/"+display_path+"/"+select_fileName[0]);
			else
				showID.attr('src', '');
		}else{
			editNameinput(select_fileName);
		}
		
		
		console.dir(selected_arr);
		console.dir(all_file);
		$.fancybox.close();
	}

	function editNameinput(input){
    	var countFiles = input.length;
	    var file_holder = showID;
	    file_holder.empty();
		    for (var i = 0; i < countFiles; i++) {
		    	var fname = input[i].split('.');
				delete fname[fname.length-1];
				fname = fname.join('.');
				fname = fname.substring(0,fname.length-1);
				$('<li>')
		        .append($("<span>", {"class": "th"})
		           	.append($('<input />',{'name': 'ND_Name['+i+'][TH]','type':'text','class':'txtinput in_medium'}).val(fname))
		           	.append('<br />')
		           	.append($('<textarea name="ND_Descript['+i+'][TH]"  placeholder="คำอธิบายเกี่ยวกับไฟล์">').addClass('txtarea ar_medium'))
		        )
		        .append($("<span>", {"class": "en"}).css('display', 'none')
		           	.append($('<input />',{'name': 'ND_Name['+i+'][EN]','type':'text','class':'txtinput in_medium'}).val(fname))
		           	.append('<br />')
		        	.append($('<textarea name="ND_Descript['+i+'][EN]"  placeholder="คำอธิบายเกี่ยวกับไฟล์">').addClass('txtarea ar_medium'))
		       )
	        .appendTo(file_holder);
		        file_holder.show();
		    }
    }

	function fileExists(url) {
	    if(url){
	        var req = new XMLHttpRequest();
	        req.open('GET', url, false);
	        req.send();
	        return req.status==200;
	    } else {
	        return false;
	    }
	}
</script>
<?php }?>