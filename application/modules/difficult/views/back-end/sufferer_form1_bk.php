<?php
set_session('pers_authen',array('authen_log_id'=>223,'pid'=>'3101701933555','cid'=>'0221004350953232','random_string'=>'80db7f660e7ef6255597fc5794be0093')); //for Test
?>
<script>
//Declear Info Reader PID
var user_id = '<?php echo get_session('user_id');?>';
var org_id = '<?php echo get_session('org_id');?>';
var pers_authen = JSON.parse('<?php echo json_encode(get_session('pers_authen'));?>');
console.log(pers_authen);
var reader_status = false;
var authen_log_id = 0;
//End Declear Info Reader PID
var csrf_hash='<?php echo @$csrf['hash'];?>';
</script>
<div class="row">
  <div class="col-lg-12">
    <div class="tabs-container">
      <ul class="nav nav-tabs">
        <li class="active">
          <?php
          $tmp = $this->admin_model->getOnce_Application(3);
          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else if($process_action!='Add'){?> href="<?php echo site_url('difficult/sufferer_form1/Edit/'.$diff_info['diff_id']);?>" <?php }?> data-toggle="tab" <?php if($usrpm['app_id']==3){?>aria-expanded="true" <?php }else{?> aria-expanded="false"<?php }?>> (1) แจ้งเรื่อง</a>
        </li>
        <li>
          <?php
          $tmp = $this->admin_model->getOnce_Application(4);
          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(4,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else if($process_action!='Add'){?> href="<?php echo site_url('difficult/sufferer_form2/Edit/'.$diff_info['diff_id']);?>" <?php }?> <?php if($usrpm['app_id']==4){?>aria-expanded="true" <?php }?>>(2) ตรวจเยี่ยม</a>
        </li>
        <li>
          <?php
          $tmp = $this->admin_model->getOnce_Application(5);
          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(5,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else if($process_action!='Add'){?> href="<?php echo site_url('difficult/sufferer_form3/Edit/'.$diff_info['diff_id']);?>" <?php }?> <?php if($usrpm['app_id']==5){?>aria-expanded="true" <?php }?>>(3) สงเคราะห์</a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="tab-1" <?php if($usrpm['app_id']==3){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
          <div class="panel-body">
            <!--
            <div class="row">
              <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
                <h2 style="color: #4e5f4d">ระบบฐานข้อมูลยากลำบาก</h2>
                <div class="col-lg-12 text-right  border-bottom">
                  <?php
                  if($process_action=='Edit') {
                  ?>
                  <a data-toggle="modal" data-target="#myPrint" style="color: #000; padding-left: 20px; padding-right: 20px;" title="พิมพ์แบบฟอร์ม" class="btn btn-default">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                  </a>
                  <?php
                  }
                  ?>
                  &nbsp;
                  <?php
                  $tmp = $this->admin_model->getOnce_Application(3);
                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                  ?>
                  <a <?php if(!isset($tmp1['perm_status'])) {?>
                    readonly
                    <?php }else{?> onclick="return opnCnfrom()" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="บันทึกช้อมูล" class="btn btn-default">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                  </a>
                  &nbsp;
                  <?php
                  $tmp = $this->admin_model->getOnce_Application(3);
                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                  ?>
                  <a onclick="return opnBck()" <?php if(!isset($tmp1['perm_status'])) {?>
                    readonly
                    <?php }else{?> href="<?php echo site_url('difficult/assist_list');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="ย้อนกลับ" class="btn btn-default">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </a>
                  <?php
                  if($process_action=='Edit') {
                  ?>
                  &nbsp;
                  <?php
                  $tmp = $this->admin_model->getOnce_Application(3);
                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                  ?>
                  <a data-id=<?php echo $diff_info['diff_id'];?> onclick="opn(this)" <?php if(!isset($tmp1['perm_status'])) {?>
                    readonly
                    <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="ลบข้อมูล" class="btn btn-default">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                  </a>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            -->
            <div id="tmp_menu" hidden='hidden'>
              <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="<?php echo site_url('difficult/assist_list');?>"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>
            </div>
            <script>
            setTimeout(function(){
            $("#menu_topright").html($("#tmp_menu").html());
            },300);
            </script>
            <div class="family_members_template" style="display: none;">
              <div class="panel-group family_members_items" style="margin-top: -10px;">
                <div class="panel panel-default" style="border: 0">
                  <div class="panel-heading clear-fix" style="background-color: initial;">
                  </div>
                  <div class="panel-body" style="background-color:#FBFBFB;border: 1px #eee solid; padding: 15px;">
                    <div class="row text-right">
                      <button type="button" class="btn btn-default delfamily_members" onclick="btDel_family_members(this)" style="margin-right: 16px;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-3 ">
                        <label for="" class="col-2 col-form-label" >เลขบัตรประจำตัวประชาชน</label>
                        <div class="input-group">
                            <input id="pid_myID" title="เลขบัตรประจำตัวประชาชน" placeholder="เลขบัตรประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text"/>
                            <div class="input-group-btn" style="left: 1px;">
                                  <button  type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_pid_myID"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
                             </div>
                        </div>

                        <input type="hidden" id="pers_id_myID" name="pers_family[pers_id][myID]">
                      </div>
                      <!-- <div class="col-xs-12 col-sm-1">
                        <label for="" class="col-2 col-form-label">&nbsp;</label>
                        <button title="ตรวจสอบ" class="btn btn-default" id="bt_req_pid">ตรวจสอบ</button>
                      </div> -->
                      <div class="col-xs-12 col-sm-6 dropdown">
                        <label for="example-text-input" class="col-2 col-form-label">สถานะการสมรส</label>
                        <div class="col-10">
                          <select id="marital_status_myID" title="สถานะการสมรส" placeholder="เลือกสถานะการสมรส" class="form-control" name="pers_family[marital_status][myID]">
                            <option value="">เลือกสถานะการสมรส</option>
                            <option value="โสด">โสด</option>
                            <option value="สมรส อยู่ด้วยกัน">สมรส อยู่ด้วยกัน</option>
                            <option value="สมรส แยกกันอยู่">สมรส แยกกันอยู่</option>
                            <option value="หย่าร้าง">หย่าร้าง</option>
                            <option value="ไม่ได้สมรส แต่อยู่ด้วยกัน">ไม่ได้สมรส แต่อยู่ด้วยกัน</option>
                            <option value="หม้าย (คู่สมรสเสียชีวิต)">หม้าย (คู่สมรสเสียชีวิต)</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">อายุ (ปี)</label>
                        <input title="อายุ" id="pers_age_myID" placeholder="ระบุอายุ (ปี)" class="form-control" type="text" value="" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">เกี่ยวของเป็น</label>
                        <input title="ความสัมพันธ์กับผู้สูงอายุ" placeholder="ระบุความสัมพันธ์กับผู้สูงอายุ" class="form-control" type="text" name="pers_family[fml_relation][myID]" />
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">อาชีพ</label>
                        <input title="อาชีพ" placeholder="ระบุอาชีพ" class="form-control" type="text" id="occupation_myID" name="pers_family[occupation][myID]" />
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">รายได้เฉลี่ย (บาท/เดือน)</label>
                        <input title="รายได้เฉลี่ย" placeholder="ระบุรายได้เฉลี่ย (บาท/เดือน)" class="form-control" type="text" id="mth_avg_income_myID" name="pers_family[mth_avg_income][myID]"/>
                      </div>
                      <div class="col-xs-12 col-sm-3 dropdown">
                        <label for="example-text-input" class="col-2 col-form-label">ระดับการศึกษา</label>
                        <div class="col-10">
                          <select title="ระดับการศึกษา" placeholder="เลือกระดับการศึกษา" class="form-control" id="edu_code_myID" name="pers_family[edu_code][myID]">
                            <option value="">เลือกระดับการศึกษา</option>
                            <?php $temp = $this->personal_model->getAll_edu_level();
                            foreach ($temp as $key => $row) { ?>
                            <option value="<?php echo $row['edu_code']; ?>"><?php echo $row['edu_title']; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-6">
                        <label for="" class="col-2 col-form-label">ปัญหาสุขภาพ</label>&nbsp;&nbsp;
                        <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ปกติ"><i></i>  ปกติ</label></div>&nbsp;&nbsp;&nbsp;
                        <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ผู้ผู้ป่วยเรื้อรัง"><i></i>  ผู้ป่วยเรื้อรัง</label></div>&nbsp;&nbsp;&nbsp;
                        <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ผู้พิการ"><i></i>  ผู้พิการ</label></div>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <label for="" class="col-2 col-form-label">ช่วยเหลือตนเอง</label>&nbsp;&nbsp;
                        <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][myID]" value="ได้"><i></i> ได้</label></div>
                        <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][myID]" value="ไม่ได้"><i></i> ไม่ได้</label></div>
                      </div>
                    </div>
                  </div>
                </div>

                <script>

                  icheck_loop();
                           
                </script>

                <script type="text/javascript">
                var inputpid_myID = "#pid_myID";
                var bt_spid_myID = "#bt_pid_myID";
                var setData_myID = "reqData_myID"; //Declear Name
                var reqData_myID = function(value) { //Set Structure Display Data
                console.dir(value);
                $("#pers_id_myID").val(value.pers_id);
                $("#marital_status_myID").val(value.marital_status);
                $("#pers_age_myID").val(value.age);
                $("#occupation_myID").val(value.occupation);
                $("#mth_avg_income_myID").val(value.mth_avg_income);
                $("#edu_code_myID").val(value.edu_code);
                $("input[name='pers_family[healthy][myID]']").filter('[value="'+value.healthy+'"]').attr('checked', true);
                $("input[name='pers_family[healthy_self_help][myID]']").filter('[value="'+value.healthy_self_help+'"]').attr('checked', true);
                }
                $(bt_spid_myID).click(function(){//On Click for Search
                if($(inputpid_myID).val()!='') {//pid not null
                
                $(bt_spid_myID).attr('disabled',true);
                if(pers_authen!=null) { //Check Personal Authen
                getPersInfo(inputpid_myID,bt_spid_myID,setData_myID); //Get Data
                }else if(!reader_status) { //Run Reader Personal
                run_readerPers();
                $(bt_spid_myID).attr('disabled',false);
                toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                }
                }else { //pid is null
                $(inputpid_myID).select();
                }
                });
                </script>
              </div>
            </div>
            <div class="form-group row">
              <?php
              $diff_id = '';
              if($process_action=='Add')$action = 'Added';
              if($process_action=='Edit'){$action = 'Edited'; $diff_id = '/'.$diff_info['diff_id'];}
              echo form_open_multipart('difficult/sufferer_form1/'.$action.$diff_id,array('id'=>'form1'));
              ?>
              <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->
              <input type="submit" value="submit" name="bt_submit" hidden="hidden">
              <?php echo validation_errors('<div class="error" style="font-size: 18px; padding-left: 20px">', '</div>'); ?>
              <div class="panel-group">
                <div class="panel panel-default" style="border: 0">
                  <div class="panel-heading"><h4>ข้อมูลผู้ยื่นคำขอ (ผู้แจ้งเรื่อง)</h4></div>
                  <div class="panel-body" style="border:0; padding: 20px;">
                    <div class="form-group row">
                           
				                      <div class="col-xs-12 col-sm-3">
				                        <img id="test2" src="<?php echo path('noProfilePic.jpg','member');?>" width="70%" class="img-responsive" style="margin: 0 auto;">
				                        <!-- <input id="inputImage" type="file" name=""> -->
				                        <!-- <input type="hidden" id="imgdata" name=""> -->
				                        
				                        
				                        <script type="text/javascript">
				                        // var $image = $(".image-crop > img")
				                        var $image = $("#test")
				                        $($image).cropper({
				                        aspectRatio: 1,
				                        preview: ".img-preview",
				                        done: function(data) {
				                        // Output the result data for cropping image.
				                        console.log(data);
				                        }
				                        });
				                        var $inputImage = $("#inputImage");
				                        if (window.FileReader) {
				                        $inputImage.change(function() {
				                        var fileReader = new FileReader(),
				                        files = this.files,
				                        file;
				                        if (!files.length) {
				                        return;
				                        }
				                        file = files[0];
				                        if (/^image\/\w+$/.test(file.type)) {
				                        fileReader.readAsDataURL(file);
				                        fileReader.onload = function () {
				                        $inputImage.val("");
				                        $image.cropper("reset", true).cropper("replace", this.result);
				                        };
				                        } else {
				                        showMessage("Please choose an image file.");
				                        }
				                        });
				                        } else {
				                        $inputImage.addClass("hide");
				                        }
				                        $("#download").click(function() {
				                        window.open($image.cropper("getDataURL"));
				                        });
				                        </script>
				                      </div>
		                        
                     
                             
                              
                      
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span></div>
		                      <div class="col-xs-12 col-sm-6 has-error " style="padding: 3px 15px;">
		                        
		                        <div class="input-group" style="width: 295px;">                                           
		                          <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text" value="<?php echo $diff_info['req_pid'];?>" name="diff_info[req_pid]" id="req_pid" autofocus required/>
		                          <div class="input-group-btn" style="padding-bottom: 5px;">
		                            <button type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_req_pid" style=" border-radius: 0px;"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
		                          </div>
		                          <input type="hidden" id="req_pers_id" name="diff_info[req_pers_id]" value="<?php echo $diff_info['req_pers_id'];?>">
		                        </div>

		                      </div>
		                      
		                      <script>
		                      var req_pers = null;
		                      var inputpid = "#req_pid";
		                      var bt_spid = "#bt_req_pid";
		                      var setData = "reqData"; //Declear Name
		                      var reqData = function(value) { //Set Structure Display Data
		                      req_pers = value;
		                      $("#req_name").html(value.name);
		                      $("#req_date_of_birth").html(value.date_of_birth);
		                      $("#req_gender_name").html(value.gender_name);
		                      $("#req_nation_name_th").html(value.nation_name_th);
		                      $("#req_relg_title").html(value.relg_title);
		                      $("#req_pers_id").val(value.pers_id);
		                      $("#req_reg_addr").text(value.reg_add_info);
		                      }
		                      $(bt_spid).click(function(){//On Click for Search
		                      if($(inputpid).val()!='') {//pid not null
		                      
		                      $(bt_spid).attr('disabled',true);
		                      if(pers_authen!=null) { //Check Personal Authen
		                      getPersInfo(inputpid,bt_spid,setData); //Get Data
		                      }else if(!reader_status) { //Run Reader Personal
		                      run_readerPers();
		                      $(bt_spid).attr('disabled',false);
		                      toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
		                      }
		                      }else { //pid is null
		                      $(inputpid).select();
		                      }
		                      });
		                      </script>
		                      <!-- <button title="กรณีไม่มีบัตร" type="button"  class="btn btn-default" style="width: 48%">กรณีไม่มีบัตร</button> -->
		                      
		                      
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ชื่อตัว/ชื่อสกุล</span></div>
		                      <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_name"> <?php echo $diff_info['req_name'];?> </div>
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
		                      <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_date_of_birth"> <?php echo $diff_info['req_date_of_birth'];?> </div>
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="req_gender_name"> <?php echo $diff_info['req_gender_name'];?> </span> </div>
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="req_nation_name_th"> <?php echo $diff_info['req_nation_name_th'];?> </span> </div>
		                      
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="req_relg_title"> <?php echo $diff_info['req_relg_title'];?> </span> </div>
		                      <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
		                      <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_reg_addr"> <?php echo @$diff_info['req_reg_add_info']; ?> </div>
		                    </div>


                    

                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-3">
                        <label for="datetimepicker1" class="col-2 col-form-label" style="color: red;">วันที่แจ้งเรื่อง </label>
                        <div id="datetimepicker1" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                          <input title="วันที่แจ้งเรื่อง" placeholder="เลือกวันที่" class="form-control" type="text" name="diff_info[date_of_req]" required/>
                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                        <script type="text/javascript">
                        <?php
                        $tmp = explode('-',$diff_info['date_of_req']);
                        ?>
                        $(function () {
                        $("#datetimepicker1").datepicker({
                        autoclose: true,
                        todayHighlight: true
                        }).datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));;
                        });
                        </script>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">ตำแหน่ง</label>
                        <input title="ตำแหน่ง" placeholder="ระบุตำแหน่ง" class="form-control" type="text" name="diff_info[req_position]" value="<?php echo $diff_info['req_position'];?>"/>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">หน่วยงาน</label>
                        <input title="หน่วยงานต้นสังกัด" placeholder="ระบุหน่วยงานต้นสังกัด" class="form-control" type="text" name="diff_info[req_org]" value="<?php echo $diff_info['req_org'];?>"/>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">เกี่ยวข้องเป็น</label>
                        <input title="ความสัมพันธ์กับผู้สูงอายุ" placeholder="ระบุความสัมพันธ์กับผู้สูงอายุ" class="form-control" type="text" name="diff_info[req_relation]" value="<?php echo $diff_info['req_relation'];?>"/>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                        <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="diff_info[req_tel_no_home]" value="<?php echo $diff_info['req_tel_no_home'];?>"/>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (มือถือ)</label>
                        <input title="เบอร์โทรศัพท์ (มือถือ)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="diff_info[req_tel_no_mobile]" value="<?php echo $diff_info['req_tel_no_mobile'];?>"/>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                        <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="diff_info[req_fax_no]" value="<?php echo $diff_info['req_fax_no'];?>"/>
                      </div>
                      <div class="col-xs-12 col-sm-3">
                        <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                        <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="diff_info[req_email_addr]" value="<?php echo $diff_info['req_email_addr'];?>"/>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-12 col-sm-6 dropdown">
                        <label for="example-text-input" class="col-2 col-form-label" style="color:red;">ช่องทางการแจ้งเรื่อง </label>
                        <div class="col-10 has-error">
                          <select title="เลือกช่องทางการแจ้งเรื่อง" name="diff_info[chn_code]" placeholder="เลือกช่องทางการแจ้งเรื่อง" class="form-control" required>
                            <option value="">เลือกช่องทางการแจ้งเรื่อง</option>
                            <?php
                            $tmps = $this->difficult_model->getAll_reqChanel();
                            foreach ($tmps as $key => $value) {
                            ?>
                            <option <?php if($diff_info['chn_code']==$value['chn_code']) {?> selected <?php }?> value="<?php echo $value['chn_code'];?>"><?php echo $value['chn_name'];?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-heading">
                    <h4>
                    <font >ข้อมูลผู้สูงอายุ (ผู้ขอรับการสงเคราะห์) (&nbsp;</font>
                      <div class="checkbox-inline i-checks" >
                          <label>
                           <input type="checkbox" name="elder_pers_chk"><i></i>  บุคคลเดียวกับผู้ยื่นคำขอ )
                           </label>
                      </div>&nbsp;


                        
                    
                     
                     

                      
                    
                      <!--
                      <button type="button" onclick="get_integration();" class="btn btn-default" style="float: right;padding-top: 0px; padding-bottom: 2px;">ข้อมูลบูรณาการ</button>-->
                      </h4>

                   

                      <script type="text/javascript">
                      function get_(argument) {
                      // body...
                      }
                      </script>
                    </div>
                    <div class="panel-body" style="border:0; padding: 20px;">
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3"><img src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" width="70%" style="margin: 0 auto;"></div>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span></div>
                        <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">

                         <div class="input-group" style="width: 295px;">
                            <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard elder_same_req" type="text" id="elder_pid" name="diff_info[pid]" value="<?php echo $diff_info['pid'];?>" required/>
                            <div class="input-group-btn" style="padding-bottom: 5px;">
                                  <button type="button" title="ตรวจสอบ" class="btn btn-default elder_same_req" id="bt_elder_pid" style="  border-radius: 0px;"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
                            </div>
                            <input type="hidden" id="pers_id" name="diff_info[pers_id]" value="<?php echo $diff_info['pers_id'];?>">
                          </div>
                        </div>
                        
                          <!-- <button class="btn btn-default elder_same_req" title="กรณีไม่มีบัตร" type="button" style="">กรณีไม่มีบัตร</button> -->
                        
                        <script>
                        var elder_pers = null;
                        var inputpid2 = "#elder_pid";
                        var bt_spid2 = "#bt_elder_pid";
                        var setData2 = "reqData2"; //Declear Name
                        var reqData2 = function(value) { //Set Structure Display Data
                        elder_pers = value;
                        $("#name").html(value.name);
                        $("#date_of_birth").html(value.date_of_birth);
                        $("#gender_name").html(value.gender_name);
                        $("#nation_name_th").html(value.nation_name_th);
                        $("#relg_title").html(value.relg_title);
                        $("#pers_id").val(value.pers_id);
                        $("#reg_addr_id").val(value.reg_addr_id);
                        $("#reg_addr").html(value.reg_add_info);
                        }
                        $(bt_spid2).click(function(){//On Click for Search
                        if($(inputpid2).val()!='') {//pid not null
                        
                        $(bt_spid2).attr('disabled',true);
                        if(pers_authen!=null) { //Check Personal Authen
                        getPersInfo(inputpid2,bt_spid2,setData2,true); //Get Data
                        }else if(!reader_status) { //Run Reader Personal
                        run_readerPers();
                        $(bt_spid2).attr('disabled',false);
                        toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                        }
                        }else { //pid is null
                        $(inputpid2).select();
                        }
                        });
                        </script>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ชื่อตัว/ชื่อสกุล</span></div>
                        <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;"  id="name"> <?php echo $diff_info['name'];?> </div>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                        <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="date_of_birth"> <?php echo $diff_info['date_of_birth'];?> </div>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="gender_name"> <?php echo $diff_info['gender_name'];?></span> </div>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="nation_name_th"> <?php echo $diff_info['nation_name_th'];?></span> </div>
                        
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="relg_title"> <?php echo $diff_info['relg_title'];?> </span> </div>
                        <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span><input type="hidden" id="reg_addr_id" name="pers_info[reg_addr_id]" value="<?php echo $diff_info['reg_addr_id']; ?>"></div>
                        <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="reg_addr"> <?php echo @$diff_info['reg_add_info']; ?> </div>
                      </div>

                      <div class="addr form-group row" >

                    <div class="col-lg-12" id="integration1" hidden='hidden'>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content" style="padding-bottom: 0px">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #459597; color: #fff">ข้อมูลบูรณาการ</th>
                                        <th style="background-color: #459597; color: #fff">หน่วยงาน</th>
                                        <th style="background-color: #459597; color: #fff">รายละเอียด</th>
                                        <th style="background-color: #459597; color: #fff">#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--
                                    <tr>
                                        <td>
                                            <label>ขึ้นทะเบียนผู้มีรายได้น้อย</label>
                                            <div style="font-size: 18px;">(กรมการปกครอง)</div>
                                        </td>
                                        <td>
                                            <label>วันที่ขึ้นทะเบียน</label>
                                            <div style="font-size: 18px;">-</div>                           
                                        </td>
                                        <td>
                                            <label>สถานะการได้รับความช่วยเหลือ</label>
                                            <div style="font-size: 18px; color: green;">-</div> 
                                        </td>
                                        <td></td>
                                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td>
                                            <b>อายุผู้ขอรับบริการ</b> วัน/เดือน/ปี/เกิด : <span id="row1_date_of_birth">-</span>                           
                                        </td>
                                        <td>
                                          กรมการปกครอง
                                        </td>
                                        <td>
                                            60 ปีขึ้นไป                                 
                                        </td>
                                        <td id="row1_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>สถานะการเสียชีวิต</b> วัน/เดือน/ปีเสียชีวิต : <span id="row2_date_of_death">-</span>                          
                                        </td>
                                        <td>
                                          กรมการปกครอง
                                        </td>
                                        <td>       
                                          มีชีวิตอยู่               
                                        </td>
                                        <td id="row2_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>ความจำเป็นพื้นฐาน (จปฐ.)</b> 
                                            <select class="form-control m-b" id="accountJPTH" style="overflow:auto;">
                                                <option>อาชีพ (ปัจจุบัน) : - รายได้เฉลี่ย - (บาท/เดือน) :  ที่มาของรายได้ : - </option>
                                            </select>                          
                                        </td>
                                        <td>
                                          กรมการพัฒนาชุมชน
                                        </td>
                                        <td>
                                            ไม่เกิน 38,000                     
                                        </td>
                                        <td id="row3_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>ทะเบียนจัดหางานผุ้สูงอายุ</b> วันที่ขึ้นทะเบียน : <span id="row4_date_of_reg_th">-</span> สถานะการได้รับงาน : <span id="row4_reg_status">-</span>                         
                                        </td>
                                        <td>
                                            กรมการจัดหางาน                                        
                                        </td>
                                        <td>                     
                                        </td>
                                        <td id="row4_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>กองทุนผู้สูงอายุ</b> ประวัติการกู้ยืมกองทุน : <span id="row5_loan_history">-</span> สถานะสัญญากู้ยืม : <span id="row5_contract_status">-</span>                     
                                        </td>
                                        <td>
                                          กรมกิจการผู้สูงอายุ
                                        </td>
                                        <td>
                                        </td>
                                        <td id="row5_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>การสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก</b> ประวัติการได้รับการสงเคราะห์ : <span id="row6_history">-</span> ภายในรอบปีนี้ <span id="row6_year_now_history">-</span> (ครั้ง) :                             
                                        </td>
                                        <td>
                                          กรมกิจการผู้สูงอายุ
                                        </td>
                                        <td>
                                        </td>
                                        <td id="row6_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td>
                                            <b>ศูนย์พัฒนาการจัดสวัสดิการสังคมฯ</b> ประวัติการได้รับบริการ : <span id="row7_history">-</span> ภายในรอบปีนี้ <span id="row7_year_now_history">-</span> (ครั้ง) ศูนย์ที่รับเข้ารับบริการ (ล่าสุด) : <span id="row7_req_org">-</span>                    
                                        </td>
                                        <td>
                                          กรมกิจการผู้สูงอายุ
                                        </td>
                                        <td>                      
                                        </td>
                                        <td id="row7_state"><i class="fa fa-times text-danger"></i></td>
                                    </tr>
                                    -->

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>


                        <div class="col-xs-12 col-sm-6"><font >ที่อยู่ (ปัจจุบัน) (&nbsp; </font> <div  class="checkbox-inline i-checks" ><label><input  type="checkbox" name="elder_addr_chk"> <i></i> ตรงกับที่อยู่ตามทะเบียนบ้าน )</label></div></div>
                        
                        <script>

                        setTimeout(icheck_loop,2000);

                         // iCheck 
                           function icheck_loop () {

                            $('.i-checks').iCheck({
                              checkboxClass: 'icheckbox_square-green',
                              radioClass: 'iradio_square-green',
                              increaseArea: '20%'
                            });

                            $("input[name='elder_pers_chk']").on('ifClicked',function(){
                              console.log(req_pers);
                              if(!$(this).prop('checked')) {
                                $("#pid").val(req_pers.pid);
                                $("#pers_id").val(req_pers.pers_id);
                                $("#name").html(req_pers.name);
                                $("#date_of_birth").html(req_pers.date_of_birth);
                                $("#gender_name").html(req_pers.gender_name);
                                $("#nation_name_th").html(req_pers.nation_name_th);
                                $("#relg_title").html(req_pers.relg_title);
                                $("#reg_addr_id").val(req_pers.reg_addr_id);
                                $("#reg_addr").html(req_pers.reg_add_info);
                                $(".elder_same_req").attr('disabled',true);
                              }else {
                                $("#pid").val("");
                                $("#pers_id").val("");
                                $("#elder_name").html(" - ");
                                $(".elder_same_req").attr('disabled',false);
                              }
                            });

                            <?php
                            if(($diff_info['reg_addr_id']==$diff_info['pre_addr_id']) && ($diff_info['reg_addr_id']!=''&&$diff_info['pre_addr_id']!='')) {
                              ?>
                              // console.log($("input[name='elder_addr_chk']").prop('checked'));
                              // setTimeout(function(){
                                $("input[name='elder_addr_chk']").parent().addClass('checked');
                                $("input[name='elder_addr_chk']").prop('checked',true);
                                $(".elder_addr_pre").attr('disabled',true);
                              // },500);
                              <?php
                            }
                            ?>


                            $('input[name="elder_addr_chk"]').on('ifClicked', function(event) {

                              console.log($(this).prop('checked'));
                              if($(this).prop('checked')) {
                                $(".elder_addr_pre").attr('disabled',false);
                              }else {
                                $(".elder_addr_pre").attr('disabled',true);
                              }
                            });

                         };


                        </script>

                        <div class="col-xs-12 col-sm-6">
                          <?php
                          $addr_gps = @$addr_info['addr_gps']; // Old Data $diff_info['addr_gps']
                          if($addr_gps=='') {
                          $addr_gps ='0,0'; // Set Default Data
                          }
                          $arr = explode(',',$addr_gps);
                          ?>
                          <script type="text/javascript">
                          var latitude = '<?php echo $arr[0];?>';
                          var longitude = '<?php echo $arr[1];?>';
                          //var latitude_center = latitude=='0'?'13.5847536':latitude;
                          //var longitude_center = longitude=='0'?'13.5847536':longitude;
                          var marker_img = '<?php echo path('map-marker.png','webconfig');?>';
                          if(latitude!='0' && longitude!='0') {
                          setTimeout(function(){
                          $("#lat_value").val(latitude);  // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
                          $("#lon_value").val(longitude);  // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value
                          //$("#zoom_value").val(map.getZoom());  // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_valu
                          },1500);
                          }
                          </script>
                          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_marker">
                          <i class="fa fa-map-marker" aria-hidden="true"></i> ตำแหน่งพิกัดภูมิศาสตร์
                          </button>
                          &nbsp;
                          <input type="hidden" name="pers_addr[addr_gps]" value="<?php echo $addr_gps;?>" id="addr_gps">
                          <span id="addr_gpg_txt"><?php if($addr_gps!='0,0') { echo '('.$addr_gps.')';}?></span>
                        </div>

                      </div>

                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-6 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">สถานะการพักอาศัย</label>
                          <div class="col-10">
                            <select title="สานะการพักอาศัย" placeholder="เลือกสถานะการพักอาศัย" class="form-control" name="pers_info[pre_addr_status]">
                              <option value="">เลือกสถานะการพักอาศัย</option>
                              <option value="บ้านตนเอง" <?php if(@$diff_info['pre_addr_status'] == 'บ้านตนเอง'){ echo "selected";} ?>>บ้านตนเอง</option>
                              <option value="อาศัยผู้อื่นอยู่" <?php if(@$diff_info['pre_addr_status'] == 'อาศัยผู้อื่นอยู่'){ echo "selected";} ?>>อาศัยผู้อื่นอยู่</option>
                              <option value="บ้านเช่า" <?php if(@$diff_info['pre_addr_status'] == 'บ้านเช่า'){ echo "selected";} ?>>บ้านเช่า</option>
                              <option value="อยู่กับผู้จ้าง" <?php if(@$diff_info['pre_addr_status'] == 'อยู่กับผู้จ้าง'){ echo "selected";} ?>>อยู่กับผู้จ้าง</option>
                              <option value="ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง" <?php if(@$diff_info['pre_addr_status'] == 'ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง'){ echo "selected";} ?>>ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">บ้านเลขที่</label>
                          <input type="hidden" name="pre_addr_id" value="<?php echo @$diff_info['pre_addr_id']; ?>">
                          <input title="บ้านเลขที่" placeholder="ตัวอย่าง xxx/xx" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_home_no]" value="<?php echo @$addr_info['addr_home_no']; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">หมู่ที่</label>
                          <input title="หมู่ที่" placeholder="" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_moo]" value="<?php echo @$addr_info['addr_moo']; ?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ตรอก</label>
                          <div class="col-10">
                            <select title="ตรอก" placeholder="เลือกตรอก" class="form-control elder_addr_pre" id="alley" name="pers_addr[addr_alley]">
                              <option value="">เลือกตรอก</option>
                              <?php $temp = $this->personal_model->getAll_alley();
                              foreach ($temp as $key => $row) { ?>
                              <option value="<?php echo $row['alley_code']; ?>"><?php echo $row['alley_name']; ?></option>
                              <?php  } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ซอย</label>
                          <div class="col-10">
                            <select title="ซอย" placeholder="เลือกซอย" class="form-control elder_addr_pre" id="lane" name="pers_addr[addr_lane]">
                              <option value="">เลือกซอย</option>
                              <?php //$temp = $this->personal_model->getAll_lane();
                              //foreach ($temp as $key => $row) { ?>
                              <!-- <option value="<?php //echo $row['lane_code']; ?>"><?php //echo $row['lane_name']; ?></option> -->
                              <?php  //} ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ถนน</label>
                          <div class="col-10">
                            <select title="ถนน" placeholder="เลือกถนน" class="form-control elder_addr_pre" id="road" name="pers_addr[addr_road]">
                              <option value="">เลือกถนน</option>
                              <?php //$temp = $this->personal_model->getAll_road();
                              //foreach ($temp as $key => $row) { ?>
                              <!-- <option value="<?php //echo $row['road_code']; ?>"><?php //echo $row['road_name']; ?></option> -->
                              <?php  //} ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">จังหวัด</label>
                          <div class="col-10">
                            <select title="จังหวัด" placeholder="เลือกจังหวัด" class="form-control elder_addr_pre" id="Province" name="pers_addr[addr_province]" onchange="optionGen(this,'Amphur',<?php echo @$addr_info['district_code']; ?>);">
                              <option value="">เลือกจังหวัด</option>
                              <?php $temp = $this->personal_model->getAll_Province();
                              foreach ($temp as $key => $row) { ?>
                              <option value="<?php echo $row['area_code']; ?>" ><?php echo $row['area_name_th']; ?></option>
                              <?php  } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">อำเภอ</label>
                          <div class="col-10">
                            <select title="อำเภอ" placeholder="เลือกอำเภอ" class="form-control elder_addr_pre" id="Amphur" name="pers_addr[addr_district]" onchange="optionGen(this,'Tambon',<?php echo @$addr_info['sub_district_code']; ?>);" disabled>
                              <option value="">เลือกอำเภอ</option>
                              <?php //$temp = $this->personal_model->getAll_Amphur();
                              //foreach ($temp as $key => $row) { ?>
                              <!-- <option value="<?php //echo $row['area_code']; ?>"><?php //echo $row['area_name_th']; ?></option> -->
                              <?php  //} ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ตำบล</label>
                          <div class="col-10">
                            <select title="ตำบล" placeholder="เลือกตำบล" class="form-control elder_addr_pre" id="Tambon" name="pers_addr[addr_sub_district]" disabled>
                              <option value="">เลือกตำบล</option>
                              <?php //$temp = $this->personal_model->getAll_Tambon();
                              //foreach ($temp as $key => $row) { ?>
                              <!-- <option value="<?php //echo $row['area_code']; ?>"><?php //echo $row['area_name_th']; ?></option> -->
                              <?php  //} ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">รหัสไปรษณีย์</label>
                          <input title="รหัสไปรษณีย์" placeholder="ระบุรหัสไปรษณีย์ (5 หลัก)" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_zipcode]" value="<?php echo @$addr_info['addr_zipcode']; ?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                          <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[tel_no_home]" value="<?php echo @$diff_info['tel_no_home'];?>"/>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (มือถือ)</label>
                          <input title="เบอร์โทรศัพท์ (มือถือ)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="pers_info[tel_no_mobile]" value="<?php echo @$diff_info['tel_no_mobile'];?>"/>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                          <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[fax_no]" value="<?php echo @$diff_info['fax_no'];?>"/>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                          <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="pers_info[email_addr]" value="<?php echo @$diff_info['email_addr'];?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-6 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">สถานะการสมรส</label>
                          <div class="col-10">
                            <select title="สถานะการสมรส" placeholder="เลือกสถานะการสมรส" class="form-control" name="pers_info[marital_status]">
                              <option value="">เลือกสถานะการสมรส</option>
                              <option value="โสด" <?php if(@$diff_info['marital_status'] == 'โสด'){ echo "selected"; } ?>>โสด</option>
                              <option value="สมรส อยู่ด้วยกัน" <?php if(@$diff_info['marital_status'] == 'สมรส อยู่ด้วยกั'){ echo "selected"; } ?>>สมรส อยู่ด้วยกัน</option>
                              <option value="สมรส แยกกันอยู่" <?php if(@$diff_info['marital_status'] == 'สมรส แยกกันอยู่'){ echo "selected"; } ?>>สมรส แยกกันอยู่</option>
                              <option value="หย่าร้าง" <?php if(@$diff_info['marital_status'] == 'หย่าร้าง'){ echo "selected"; } ?>>หย่าร้าง</option>
                              <option value="ไม่ได้สมรส แต่อยู่ด้วยกัน" <?php if(@$diff_info['marital_status'] == 'ไม่ได้สมรส แต่อยู่ด้วยกัน'){ echo "selected"; } ?>>ไม่ได้สมรส แต่อยู่ด้วยกัน</option>
                              <option value="หม้าย (คู่สมรสเสียชีวิต)" <?php if(@$diff_info['marital_status'] == 'หม้าย (คู่สมรสเสียชีวิต)'){ echo "selected"; } ?>>หม้าย (คู่สมรสเสียชีวิต)</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ระดับการศึกษา</label>
                          <div class="col-10">
                            <select title="ระดับการศึกษา" placeholder="เลือกระดับการศึกษา" class="form-control" name="pers_info[edu_code]">
                              <option value="">เลือกระดับการศึกษา</option>
                              <?php $temp = $this->personal_model->getAll_edu_level();
                              foreach ($temp as $key => $row) { ?>
                              <option value="<?php echo $row['edu_code']; ?>" <?php if(@$diff_info['edu_code'] == $row['edu_code']){ echo "selected"; } ?>><?php echo $row['edu_title']; ?></option>
                              <?php  } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">อาชีพ (ปัจจุบัน)</label>
                          <input title="อาชีพ (ปัจจุบัน)" placeholder="ระบุอาชีพ (ปัจจุบัน)" class="form-control" type="text" name="pers_info[occupation]" value="<?php echo @$diff_info['occupation']; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">รายได้เฉลี่ย (บาท/เดือน)</label>
                          <input title="รายได้เฉลี่ย (บาท/เดือน)" placeholder="ระบุรายได้เฉลี่ย (บาท/เดือน)" class="form-control" type="text" name="pers_info[mth_avg_income]" value="<?php echo @$diff_info['mth_avg_income']; ?>"/>
                        </div>
                        <div class="col-xs-12 col-sm-3 dropdown">
                          <label for="example-text-input" class="col-2 col-form-label">ที่มาของรายได้</label>
                          <div class="col-10">
                            <select title="ที่มาของรายได้" placeholder="เลือกที่มาของรายได้" class="form-control" name="pers_info[src_of_income]">
                              <option value="">เลือกที่มาของรายได้</option>
                              <option value="ด้วยตนเอง" <?php if($diff_info['src_of_income'] == 'ด้วยตนเอง'){ echo "selected"; } ?>>ด้วยตนเอง</option>
                              <option value="ผู้อื่นให้" <?php if($diff_info['src_of_income'] == 'ผู้อื่นให้'){ echo "selected"; } ?>>ผู้อื่นให้</option>
                              <option value="อื่น ๆ" <?php if($diff_info['src_of_income'] == 'อื่น ๆ'){ echo "selected"; } ?>>อื่น ๆ</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">&nbsp;</label>
                          <input title="ระบุ" placeholder="ระบุ" class="form-control" type="text" name="pers_info[src_of_income_identify]" value="<?php echo @$diff_info['src_of_income_identify']; ?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">สถานะหนี้สิน</label><br>
                          <div class="i-checks"><label><input type="radio" name="pers_info[dept_status]" value="ไม่มีหนี้สิน" <?php if(@$diff_info['dept_status'] == 'ไม่มีหนี้สิน') { echo "checked";} ?>><i></i> ไม่มีหนี้สิน</label></div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">&nbsp;</label><br>
                          <div class="i-checks"><label><input type="radio" name="pers_info[dept_status]" value="มีหนี้สิน" <?php if(@$diff_info['dept_status'] == 'มีหนี้สิน') { echo "checked";} ?>><i></i> มีหนี้สิน</label></div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">เงินกู้ในระบบ (บาท)</label>
                          <input title="เงินกู้ในระบบ" placeholder="ระบุจำนวนเงิน (บาท)" class="form-control" type="text" name="pers_info[dept_loan_system]" value="<?php echo @$diff_info['dept_loan_system']; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-3">
                          <label for="" class="col-2 col-form-label">เงินกู้นอกระบบ (บาท)</label>
                          <input title="เงินกู้นอกระบบ" placeholder="ระบุจำนวนเงิน (บาท)" class="form-control" type="text" name="pers_info[dept_loan_shark]"  value="<?php echo @$diff_info['dept_loan_shark']; ?>"/>
                        </div>
                      </div>
                      
                      
                      <div class="row">
                        <?php $count = count(@$pers_family);  ?>
                        <label>สมาชิกในครอบครัว (จำนวน <span id="nums_family_members"><?php echo $count; ?></span> คน)</label>
                        <script>
                        var nummf = <?php echo $count; ?>;
                        function btDel_family_members(node) {
                        $(node).parent().parent().parent().parent().remove();
                        $("#nums_family_members").html($(".family_members .family_members_items").length);
                        }
                        </script>
                        <div class="family_members" >
                          <?php if($process_action == 'Edit' && !empty($pers_family)){ ?>
                          <?php foreach ($pers_family as $key => $row) { ?>
                          <?php //dieArray($row); ?>
                          <div class="panel-group family_members_items" style="margin-top: -10px;">
                            <div class="panel panel-default" style="border: 0">
                              <div class="panel-heading clear-fix" style="background-color: initial;">
                              </div>
                              <div class="panel-body" style="background-color:#FBFBFB;border: 1px #eee solid; padding: 15px;">
                                <div class="row text-right">
                                  <button type="button" class="btn btn-default delfamily_members" onclick="btDel_family_members(this)" style="margin-right: 16px;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                </div>
                                <div class="form-group row">
                                  <div class="col-xs-12 col-sm-3">
                                    <label for="" class="col-2 col-form-label">เลขบัตรประจำตัวประชาชน</label>

                                    <div class="input-group">
                                        <input  id="pid_<?php echo $key;?>" value="<?php echo $row['pid'];?>" title="เลขบัตรประจำตัวประชาชน" placeholder="เลขบัตรประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text"/>
                                        <input type="hidden" id="pers_id_<?php echo $key;?>" name="pers_family[pers_id][<?php echo $key;?>]" value="<?php echo $row['ref_pers_id'];?>">
                                        <div class="input-group-btn" >
                                            <button  type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_pid_<?php echo $key;?>"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
                                        </div>
                                    <!-- <input  id="pid_myID" title="เลขบัตรประจำตัวประชาชน" placeholder="เลขบัตรประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text"/> -->
                                    <!-- <button style="display: inline-block;" type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_pid_myID"><i class="fa fa-id-card-o" aria-hidden="true"></i></button> -->
                                   </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 dropdown">
                                    <label for="example-text-input" class="col-2 col-form-label">สถานะการสมรส</label>
                                    <div class="col-10">
                                      <select id="marital_status_<?php echo $key;?>" title="สถานะการสมรส" placeholder="เลือกสถานะการสมรส" class="form-control" name="pers_family[marital_status][<?php echo $key;?>]">
                                        <option value="">เลือกสถานะการสมรส</option>
                                        <option value="โสด" <?php if($row['marital_status'] == 'โสด'){ echo "selected";} ?>>โสด</option>
                                        <option value="สมรส อยู่ด้วยกัน" <?php if($row['marital_status'] == 'สมรส อยู่ด้วยกัน'){ echo "selected";} ?>>สมรส อยู่ด้วยกัน</option>
                                        <option value="สมรส แยกกันอยู่" <?php if($row['marital_status'] == 'สมรส แยกกันอยู่'){ echo "selected";} ?>>สมรส แยกกันอยู่</option>
                                        <option value="หย่าร้าง" <?php if($row['marital_status'] == 'หย่าร้าง'){ echo "selected";} ?>>หย่าร้าง</option>
                                        <option value="ไม่ได้สมรส แต่อยู่ด้วยกัน" <?php if($row['marital_status'] == 'ไม่ได้สมรส แต่อยู่ด้วยกัน'){ echo "selected";} ?>>ไม่ได้สมรส แต่อยู่ด้วยกัน</option>
                                        <option value="หม้าย (คู่สมรสเสียชีวิต)" <?php if($row['marital_status'] == 'หม้าย (คู่สมรสเสียชีวิต)'){ echo "selected";} ?>>หม้าย (คู่สมรสเสียชีวิต)</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-3">
                                    <label for="" class="col-2 col-form-label">อายุ (ปี)</label>
                                    <input title="อายุ" id="pers_age_<?php echo $key;?>" placeholder="ระบุอายุ (ปี)" class="form-control" type="text" value="<?php echo @$row['age'];?>" />
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-xs-12 col-sm-3">
                                    <label for="" class="col-2 col-form-label">เกี่ยวของเป็น</label>
                                    <input title="ความสัมพันธ์กับผู้สูงอายุ" placeholder="ระบุความสัมพันธ์กับผู้สูงอายุ" class="form-control" type="text" name="pers_family[fml_relation][<?php echo $key;?>]" value="<?php echo $row['fml_relation'];?>"/>
                                  </div>
                                  <div class="col-xs-12 col-sm-3">
                                    <label for="" class="col-2 col-form-label">อาชีพ</label>
                                    <input title="อาชีพ" placeholder="ระบุอาชีพ" class="form-control" type="text" id="occupation_<?php echo $key;?>" name="pers_family[occupation][<?php echo $key;?>]" value="<?php echo $row['occupation'];?>"/>
                                  </div>
                                  <div class="col-xs-12 col-sm-3">
                                    <label for="" class="col-2 col-form-label">รายได้เฉลี่ย (บาท/เดือน)</label>
                                    <input title="รายได้เฉลี่ย" placeholder="ระบุรายได้เฉลี่ย (บาท/เดือน)" class="form-control" type="text" id="mth_avg_income_<?php echo $key;?>" name="pers_family[mth_avg_income][<?php echo $key;?>]" value="<?php echo $row['mth_avg_income'];?>"/>
                                  </div>
                                  <div class="col-xs-12 col-sm-3 dropdown">
                                    <label for="example-text-input" class="col-2 col-form-label">ระดับการศึกษา</label>
                                    <div class="col-10">
                                      <select title="ระดับการศึกษา" placeholder="เลือกระดับการศึกษา" class="form-control" id="edu_code_<?php echo $key;?>" name="pers_family[edu_code][<?php echo $key;?>]" >
                                        <option value="">เลือกระดับการศึกษา</option>
                                        <?php $temp = $this->personal_model->getAll_edu_level();
                                        foreach ($temp as $eduRow) { ?>
                                        <option value="<?php echo $eduRow['edu_code']; ?>" <?php if($eduRow['edu_code'] == $row['edu_code']){ echo "selected";} ?>><?php echo $eduRow['edu_title']; ?></option>
                                        <?php  } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-xs-12 col-sm-6">
                                    <label for="" class="col-2 col-form-label">ปัญหาสุขภาพ</label>&nbsp;&nbsp;
                                    <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ปกติ" <?php if($row['healthy'] == 'ปกติ'){ echo "checked";} ?>><i></i> ปกติ</label></div>&nbsp;&nbsp;&nbsp;
                                    <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ผู้ป่วยเรื้อรัง" <?php if($row['healthy'] == 'ผู้ป่วยเรื้อรัง'){ echo "checked";} ?>><i></i> ผู้ป่วยเรื้อรัง</label></div>&nbsp;&nbsp;&nbsp;
                                    <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ผู้พิการ" <?php if($row['healthy'] == 'ผู้พิการ'){ echo "checked";} ?>><i></i> ผู้พิการ</label></div>
                                  </div>
                                  <div class="col-xs-12 col-sm-6">
                                    <label for="" class="col-2 col-form-label">ช่วยเหลือตนเอง</label>&nbsp;&nbsp;
                                    <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][<?php echo $key;?>]" value="ได้" <?php if($row['healthy_self_help'] == 'ได้'){ echo "checked";} ?>><i></i> ได้</label></div>&nbsp;&nbsp;&nbsp;
                                    <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][<?php echo $key;?>]" value="ไม่ได้" <?php if($row['healthy_self_help'] == 'ไม่ได้'){ echo "checked";} ?>><i></i> ไม่ได้</label></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <script type="text/javascript">
                            var inputpid_<?php echo $key;?> = "#pid_<?php echo $key;?>";
                            var bt_spid_<?php echo $key;?> = "#bt_pid_<?php echo $key;?>";
                            var setData_<?php echo $key;?> = "reqData_<?php echo $key;?>"; //Declear Name
                            var reqData_<?php echo $key;?> = function(value) { //Set Structure Display Data
                            $("#pers_id_<?php echo $key;?>").val(value.pers_id);
                            $("#marital_status_<?php echo $key;?>").val(value.marital_status);
                            $("#pers_age_<?php echo $key;?>").val(value.age);
                            $("#occupation_<?php echo $key;?>").val(value.occupation);
                            $("#mth_avg_income_<?php echo $key;?>").val(value.mth_avg_income);
                            $("#edu_code_<?php echo $key;?>").val(value.edu_code);
                            $("input[name='pers_family[healthy][<?php echo $key;?>]']").filter('[value="'+value.healthy+'"]').attr('checked', true);
                            $("input[name='pers_family[healthy_self_help][<?php echo $key;?>]']").filter('[value="'+value.healthy_self_help+'"]').attr('checked', true);
                            }
                            $(bt_spid_<?php echo $key;?>).click(function(){//On Click for Search
                            if($(inputpid_<?php echo $key;?>).val()!='') {//pid not null
                            
                            $(bt_spid_<?php echo $key;?>).attr('disabled',true);
                            if(pers_authen!=null) { //Check Personal Authen
                            getPersInfo(inputpid_<?php echo $key;?>,bt_spid_<?php echo $key;?>,setData_<?php echo $key;?>); //Get Data
                            }else if(!reader_status) { //Run Reader Personal
                            run_readerPers();
                            $(bt_spid_<?php echo $key;?>).attr('disabled',false);
                            toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                            }
                            }else { //pid is null
                            $(inputpid_<?php echo $key;?>).select();
                            }
                            });
                            </script>
                          </div>
                          
                          <?php } ?>
                          <?php } ?>
                        </div>
                        <button type="button" class="btn btn-default" id="btAdd_family_members"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        <script>
                        var cloneTmp = $('.family_members_template').clone();
                        // setTimeout(function(){addFmlyMember();},500);
                        function addFmlyMember() {
                        var cloneTmp1 = cloneTmp.html().replace(new RegExp("myID", 'g'), nummf);
                        nummf = nummf+1;
                        $(cloneTmp1).clone().appendTo('.family_members');
                        $("#nums_family_members").html($(".family_members .family_members_items").length);
                        }
                        $("#btAdd_family_members").click(function(){ //Add
                        addFmlyMember();
                        });
                        </script>
                      </div>
                      
                    </div>
                    

                    </div>
                  </div>
                  <?php
                  echo form_close();
                  ?>
                </div>

                 <hr>
                    <div class="row">
                      <div class="col-xs-12 col-sm-8">&nbsp;</div>
                      <div class="col-xs-12 col-sm-2">
                        <button style="width: 100%;" type="button" class="btn btn-primary btn-md" onclick="return opnCnfrom()"> บันทึก</button>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <button style="width: 100%;" type="button" class="btn btn-primary btn-md" onclick="window.location.href='<?php echo site_url('difficult/assist_list');?>'"> ล้างค่า</button>
                      </div>
                    </div><!-- close class row-->
                
              </div>

            </div>
            <div id="tab-2" <?php if($usrpm['app_id']==4){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
              <div class="panel-body">
                <strong>Tab-3</strong>
              </div>
            </div>
            <div id="tab-3" <?php if($usrpm['app_id']==5){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
              <div class="panel-body">
                <strong>Tab-3</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
    <?php if($process_action == 'Edit'){ ?>
    setTimeout(function(){$("#Province").val('<?php echo @$addr_info['province_code']; ?>').trigger('change');},200);
    // setTimeout(function(){$("#Amphur").val('<?php echo @$addr_info['district_code']; ?>').trigger('change');},300);
    // setTimeout(function(){$("#Tambon").val('<?php echo @$addr_info['sub_district_code']; ?>').trigger('change');},400);
    <?php } ?>
    function set_enable(elem,target='') {
    if(elem.prop('checked') == true) {
    $(target).prop('disabled', false ).focus();
    }else{
    $(target).val('');
    $(target).prop('disabled', true );
    }
    }
    function optionGen(code,target,opSelect) {
    // alert(code.value);
    // alert(target);
    $.ajax({
    url: base_url+'personals/get_Area_option',
    type: 'POST',
    dataType: 'json',
    data: {
    'code': code.value,
    'type': target,
    <?php echo $csrf['name'];?>: '<?php echo $csrf['hash'];?>'
    },
    })
    .done(function(ret) {
    console.log("success");
    console.dir(ret);
    $('#'+target).empty();
    if($("input[name='elder_addr_chk']").prop('checked') == true){
    $('#'+target).prop('disabled', true);
    }else{
    $('#'+target).prop('disabled', false);
    }
    if(target == 'Amphur'){
    str = "เลือกอำเภอ";
    }else if(target == 'Tambon'){
    str = "เลือกตำบล";
    }
    $('#'+target).append($('<option>', {
      value: '',
      text : str
      }));
      for (var i = 0; i < ret.length ; i++) {
      // if(ret[i].area_code == opSelect){
      $('#'+target).append($('<option>', {
        value: ret[i].area_code,
        text : ret[i].area_name_th
        }));
        // }else{
        //   $('#'+target).append($('<option>', {
          //     value: ret[i].area_code,
          //     text : ret[i].area_name_th
          //   }));
          // }
          }
          $('#'+target).val(opSelect).trigger('change');
          })
          .fail(function() {
          console.log("error");
          });
          }
          function get_integration() {
          if($("#pers_id").val() != ''){
            $.ajax({
              url: '<?php echo base_url("personals/getIntegration"); ?>',
              type: 'POST',
              dataType: 'json',
              data: {
              'pers_id': $("#pers_id").val(),
              'csrf_dop': csrf_hash,
            },
            }).done(function(ret) {
              console.log("success");
              console.log(ret);

              // จ้างงาน ///////////////////////////////////
              $("#job_req").text(ret.job_info.date_of_reg);
              if(ret.job_info.reg_status == "ยังไม่ได้งาน"){
              $("#job_stat").text(ret.job_info.reg_status).css('color', '#D1813F');
              }else{
              $("#job_stat").text(ret.job_info.reg_status).css('color', 'green');
              }
              $("#job_org").text('('+ret.job_info.rec_source+')');
              //////////////////////////////////////////////
            })
            .fail(function() {
              console.log("error");
            });
            
              $('#integration').modal('show');
            }
          }
          </script>

     


          <!-- Modal -->
          <div class="modal fade" id="modal_marker" role="dialog">
            <div class="modal-dialog modal-lg">
              
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(56,145,209);color: white;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-map-marker" aria-hidden="true"></i> Search Location</h4>
                </div>
                <div class="modal-body">
                  <form name="form_search" method="post" action="">
                    <b>Location</b>
                    <div class="row">
                      <div class="col-xs-12 col-sm-10">
                        <input name="namePlace" class="form-control" size="70" type="text" id="namePlace" size="30" />
                        <input type="hidden" name="address" id="namePlace2">
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <input type="button" class="btn btn-default" style="width: 100%; margin-top: -5px" name="SearchPlace" id="SearchPlace" value="Search" />
                      </div>
                    </div>
                  </form>
                  <hr />
                  <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">
                    <div class="row">
                      <div class="col-xs-6 col-sm-5">
                        Latitude <input class="form-control" name="lat_value" type="text" id="lat_value" value="0" size="20" readonly />
                      </div>
                      <div class="col-xs-6 col-sm-5">
                        Longitude <input class="form-control" name="lon_value" type="text" id="lon_value" value="0" size="20" readonly />
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <input type="button" class="btn btn-default" style="margin-top: 22px; width: 100%" name="button" id="button" onclick="select_location();" value="Save" />
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12">
                      <!-- show map -->
                      <div id="map_canvas" style="width:100%;height:400px;margin:auto;margin-top:10px;"></div>
                    </div>
                  </div>
                </div>
                <!--
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                -->
              </div>
              
            </div>
          </div>
          <!-- Info Modal -->
          <div class="modal fade" id="integration" role="dialog">
            <div class="modal-dialog" style="width: 1000px;">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #eee">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title text-left">ผู้สูงอายุที่เข้าร่วม</h3>
                </div>
                <div class="modal-body">
                  <div style="font-size: 24px;color: #A7A7A7;margin-bottom: 10px; border-top: 1px solid #EDEDED;border-bottom: 1px solid #EDEDED;">
                    ข้อมูลบูรณาการ
                  </div>
                  <!-- <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>ขึ้นทะเบียนผู้มีรายได้น้อย</label>
                      <div>(กรมการปกครอง)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>วันที่ขึ้นทะเบียน</label>
                      <div>20 สิงหาคม 2559</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>สถานะการได้รับความช่วยเหลือ</label>
                      <div style="color: green;">ได้รับ</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label></label>
                      <div></div>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>ความจำเป็นพื้นฐาน (จปฐ.)</label>
                      <div>(กรมการพัฒนาชุมชน)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>อาชีพ (ปัจจุบัน)</label>
                      <div>เกษตรกร</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>รายได้เฉลี่ยน (บาท/เดือน)</label>
                      <div style="color: #D1813F;">3,800</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ที่มาของรายได้</label>
                      <div  style="color: green;">ด้วยตนเอง</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>ทะเบียนจัดหางานผุ้สูงอายุ</label>
                      <div id="job_org">(กรมการจัดหางาน)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>วันที่ขึ้นทะเบียน</label>
                      <div id="job_req">16 มกราคม 2560</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>สถานะการได้รับงาน</label>
                      <div  style="color: green;" id="job_stat">ได้งานทำแล้ว</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label></label>
                      <div></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>กองทุนผู้สูงอายุ</label>
                      <div>(กรมกิจการผู้สูงอายุ)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ประวัติการกู้ยืมกองทุน</label>
                      <div style="color: green">มีประวัติ</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>สถานะสัญญากู้ยืม</label>
                      <div style="color: #D1813F;">ยังมีสัญญา</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label></label>
                      <div></div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>การสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก</label>
                      <div>(กรมกิจการผู้สูงอายุ)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ประวัติการได้รับการสงเราะห์</label>
                      <div style="color: green" >เคยได้รับ</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ภายในรอบปีนี้ (ครั้ง)</label>
                      <div style="color: red;">3 (ได้รับครบ 3 ครั้ง ภายในรอบ 1 ปี)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label></label>
                      <div></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-3">
                      <label>ศูนย์พัฒนาการจัดสวัสดิการสังคมฯ</label>
                      <div>(กรมกิจการผู้สูงอายุ)</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ประวัติการได้รับบริการ</label>
                      <div style="color: green">เคยได้รับ</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ภายในรอบปีนี้ (ครั้ง)</label>
                      <div style="color: #D1813F;">1</div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                      <label>ศูนย์ที่รับเข้ารับบริการ (ล่าสุด)</label>
                      <div>ศูนย์พัฒนาฯ บางละมุง (จำหน่ายแล้ว)</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Info Modal -->
          <!-- Delete Modal -->
          <div id="dltModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #333; font-size: 20px;">หน้าต่างแจ้งเตือนเพื่อยืนยัน</h4>
                </div>
                <div class="modal-body">
                  <?php $str = getMsg('034');?>
                  <p><?php echo $str;?></p>
                  <!--<p>ยืนยันการลบ?</p>-->
                </div>
                <div class="modal-footer">
                  <button id="dltbtnYes" type="button" class="btn btn-danger">ตกลง</button>
                  <button type="button" style="margin-bottom: 5px;"  aria-hidden="true" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Delete Model -->
          <!-- Confirm Save Form  Modal -->
          <div id="sbmCnfrm" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #333; font-size: 20px;">หน้าต่างแจ้งเตือนเพื่อยืนยัน</h4>
                </div>
                <div class="modal-body">
                  <?php $str = getMsg('054');?>
                  <p><?php echo $str;?></p>
                  <!--<p>ยืนยันการลบ?</p>-->
                </div>
                <div class="modal-footer">
                  <button id="savbtnYes" type="button" class="btn btn-success" data-dismiss="modal">ตกลง</button>
                  <button type="button" style="margin-bottom: 5px;" aria-hidden="true" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Confirm Save Form  Modal -->
          <!-- Confirm Back Modal -->
          <div id="bckCnfrm" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #333; font-size: 20px;">หน้าต่างแจ้งเตือนเพื่อยืนยัน</h4>
                </div>
                <div class="modal-body">
                  <?php $str = getMsg('061');?>
                  <p><?php echo $str;?></p>
                  <!--<p>ยืนยันการลบ?</p>-->
                </div>
                <div class="modal-footer">
                  <button id="bckbtnYes" type="button" class="btn btn-warning">ตกลง</button>
                  <button type="button" style="margin-bottom: 5px;" aria-hidden="true" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Confirm Back Modal -->
          <!-- Print Modal -->
          <div id="myPrint"  class="modal fade" role="dialog">
            <div class="modal-dialog">
              
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: #333; font-size: 20px;">พิมพ์แบบฟอร์ม</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <?php
                    $tmp = $this->admin_model->getOnce_Application(7);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(7,get_session('user_id')); //Check User Permission
                    ?>
                    <div class="col-xs-12 col-sm-12" style="margin-bottom: 10px;"
                      <?php
                      if(!isset($tmp1['perm_status'])) { ?>
                      class="disabled"
                      <?php
                      }else if($usrpm['app_id']==7) {
                      ?>
                      class="active"
                      <?php
                      }
                      ?>
                      >
                      <a style="color: #333; font-size: 20px;" target="_blank" href="<?php echo site_url('report/A1?id='.$diff_info['diff_id']);?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
                      </a>
                    </div>
                    <?php
                    $tmp = $this->admin_model->getOnce_Application(8);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(8,get_session('user_id')); //Check User Permission
                    ?>
                    <div class="col-xs-12 col-sm-12" style="margin-bottom: 10px;"
                      <?php
                      if(!isset($tmp1['perm_status'])) { ?>
                      class="disabled"
                      <?php
                      }else if($usrpm['app_id']==8) {
                      ?>
                      class="active"
                      <?php
                      }
                      ?>
                      >
                      <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A2?id='.$diff_info['diff_id']);?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
                      </a>
                    </div>
                    <?php
                    $tmp = $this->admin_model->getOnce_Application(9);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(9,get_session('user_id')); //Check User Permission
                    ?>
                    <div class="col-xs-12 col-sm-12" style="margin-bottom: 10px;"
                      <?php
                      if(!isset($tmp1['perm_status'])) { ?>
                      class="disabled"
                      <?php
                      }else if($usrpm['app_id']==9) {
                      ?>
                      class="active"
                      <?php
                      }
                      ?>
                      >
                      <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A3?id='.$diff_info['diff_id']);?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
                      </a>
                    </div>
                    <?php
                    $tmp = $this->admin_model->getOnce_Application(10);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(10,get_session('user_id')); //Check User Permission
                    ?>
                    <div class="col-xs-12 col-sm-12" style="margin-bottom: 10px;"
                      <?php
                      if(!isset($tmp1['perm_status'])) { ?>
                      class="disabled"
                      <?php
                      }else if($usrpm['app_id']==10) {
                      ?>
                      class="active"
                      <?php
                      }
                      ?>
                      >
                      <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A4?id='.$diff_info['diff_id']);?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
                      </a>
                    </div>
                  </div>
                  <br/>
                </div>
              </div>
              
            </div>
          </div>
          <!-- End Print Modal -->

<script>
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

var integration1 = function(info) {
  $("#integration1").show();//Show Dialog

  //Service 1
  if(info.age>=60) {
    info.date_of_birth = info.date_of_birth==''?'-':info.date_of_birth;
    $("#row1_date_of_birth").html("<span style='color:green'>"+info.date_of_birth+"</span>");
    $("#row1_state").html("<i class='fa fa-check text-navy'></i>");
  }else {
    info.date_of_birth = info.date_of_birth==''?'-':info.date_of_birth;
    $("#row1_date_of_birth").html("<span style='color:red'>"+info.date_of_birth+"</span>");
    $("#row1_state").html("<i class='fa fa-times text-danger'></i>");
  }
  //$("#pers_old").html(info.age);
  //End Service 1
  
  //Service 2
  if(info.date_of_death!='') {
    info.date_of_death = info.date_of_death==''?'-':info.date_of_death;
    $("#row2_date_of_death").html("<span style='color:red'>"+info.date_of_death+"</span>");
    $("#row2_state").html("<i class='fa fa-times text-danger'></i>");
  }else {
    info.date_of_death = info.date_of_death==''?'-':info.date_of_death;
    $("#row2_date_of_death").html("<span style='color:green'>"+info.date_of_death+"</span>");
    $("#row2_state").html("<i class='fa fa-check text-navy'></i>");
  }
  //End Service 2
  info.reg_addr.addr_home_no = info.reg_addr.addr_home_no==null?'-':info.reg_addr.addr_home_no;
  info.reg_addr.addr_sub_district = info.reg_addr.addr_sub_district==null?'-':info.reg_addr.addr_sub_district;
  //Service 3
    $.ajax({
    url: 'https://gateway.dop.go.th/transfer/import/RequestElderyJPTH',
    type: 'POST',
    dataType: 'json',
    data: {
        'Username': 'dopjpth',
        'Password': 'dpuser',
        'OfficerPID': pers_authen.pid,
        'addr_home_no': info.reg_addr.addr_home_no,
        'addr_sub_district': info.reg_addr.addr_sub_district,
        'csrf_dop': csrf_hash
    },
      success: function (value) { //Result True
        //console.log("success");console.dir(value);
        if(Object.keys(value).length) {
          console.log(value);
          if(value[0].message!='') {
            toastr.warning("ไม่พบข้อมูลความจำเป็นพื้นฐาน (จปฐ.)","หน้าต่างแจ้งเตือน");
            $("#accountJPTH").html("ไม่พบข้อมูล.");
            $("#row3_state").html("<i class='fa fa-exclamation-triangle text-warning'></i>");
          }else {
            //toastr.success("ดึงข้อมูลความจำเป็นพื้นฐาน (จปฐ.)เสร็จสิ้น","หน้าต่างแจ้งเตือน");
            $("#accountJPTH").html("");
            $("#accountJPTH").attr("size",Object.size(value));
            $(value).each(function(key,data) {
              console.log(data);
              $("<option value="+data.Q23AvgIncome+">อาชีพ (ปัจจุบัน) : "+data.Career+" รายได้เฉลี่ย "+numberWithCommas(data.Q23AvgIncome)+" (บาท/เดือน) :  ที่มาของรายได้ : - *("+data.MemberName+" "+data.MemberLastName+") บ้านเลขที่"+data.HHNumber+" หมู่บ้าน "+data.VillName+" ซอย "+data.Soi+" ถนน "+data.Tanon+"</option>").appendTo($("#accountJPTH"));
            });
          }
        }else { //Result no Data
          toastr.warning("ไม่พบข้อมูลความจำเป็นพื้นฐาน (จปฐ.)","หน้าต่างแจ้งเตือน");
          $("#accountJPTH").html("ไม่พบข้อมูล.");
          $("#row3_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ดึงข้อมูลความจำเป็นพื้นฐาน (จปฐ.)ล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#accountJPTH").html("ไม่พบข้อมูล.");
        $("#row3_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
      },
    });
    $("#accountJPTH").change(function() {
      console.log();
      if($(this).val()>38000) {
        $("#row3_state").html("<i class='fa fa-times text-danger'></i>");
      }else {
        $("#row3_state").html("<i class='fa fa-check text-navy'></i>");
      }
    }); 
  //End Service 3

  //Service 4
    $.ajax({
    url: 'https://gateway.dop.go.th/transfer/import/RequestOlderEmploymentRegistration',
    type: 'POST',
    dataType: 'json',
    data: {
        'eldery_pid': info.pid,
        'csrf_dop': csrf_hash
    },
      success: function (value) { //Result True
        //console.log("success");console.dir(value);
        if(Object.keys(value).length) {
          console.log(value);
          if(value[0].message!='') {
            toastr.warning("ไม่พบข้อมูลทะเบียนจัดหางานผุ้สูงอายุ","หน้าต่างแจ้งเตือน");
            $("#row4_date_of_reg_th").html("<span>-</span>");
            $("#row4_reg_status").html("<span>-</span>");
            $("#row4_state").html("<i class='fa fa-exclamation-triangle text-warning'></i>");
          }else {
            //toastr.success("ดึงข้อมูลทะเบียนจัดหางานผุ้สูงอายุเสร็จสิ้น","หน้าต่างแจ้งเตือน");
            if(value[0].date_of_reg!='') {
              $("#row4_date_of_reg_th").html("<span style='color:green'>"+value[0].date_of_reg_th+"</span>");
            }
            if(value[0].reg_status=="ยังไม่ได้งาน") {
              $("#row4_reg_status").html("<span style='color:#D25200'>"+value[0].reg_status+"</span>");
            }else {
              $("#row4_reg_status").html("<span style='color:green'>"+value[0].reg_status+"</span>");
            }
            $("#row4_state").html("<i class='fa fa-check text-navy'></i>");
          }
        }else { //Result no Data
          toastr.warning("ไม่พบข้อมูลทะเบียนจัดหางานผุ้สูงอายุ","หน้าต่างแจ้งเตือน");
          $("#row4_date_of_reg_th").html("<span>-</span>");
          $("#row4_reg_status").html("<span>-</span>");
          $("#row4_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ดึงข้อมูลทะเบียนจัดหางานผุ้สูงอายุล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#row4_date_of_reg_th").html("<span>-</span>");
        $("#row4_reg_status").html("<span>-</span>");
        $("#row4_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
      },
    });
  //End Service 4

  //Service 5
    $.ajax({
    url: 'https://gateway.dop.go.th/transfer/import/RequestElderyFoundation',
    type: 'POST',
    dataType: 'json',
    data: {
        'Username': 'dopuser',
        'Password': 'dpuser',
        'OfficerPID': pers_authen.pid,
        'TargetPID': info.pid,
        'csrf_dop': csrf_hash
    },
      success: function (value) { //Result True
        //console.log("success");console.dir(value);
        if(Object.keys(value).length) {
          console.log(value);
          if(value.message!='') {
            toastr.warning("ไม่พบข้อมูลประวัติการกู้ยืมกองทุน","หน้าต่างแจ้งเตือน");
            $("#row5_loan_history").html("<span>-</span>");
            $("#row5_contract_status").html("<span>-</span>");
            $("#row5_state").html("<i class='fa fa-exclamation-triangle text-warning'></i>");
          }else {
            //toastr.success("ดึงข้อมูลประวัติการกู้ยืมกองทุนเสร็จสิ้น","หน้าต่างแจ้งเตือน");
            if(value.loan_history=='มีประวัติ') {
              $("#row5_loan_history").html("<span style='color:green'>"+value.loan_history+"</span>");
            }else {
              $("#row5_loan_history").html("<span style='color:#D25200'>"+value.loan_history+"</span>");
            }
            if(value.contract_status=="ปิดสัญญาแล้ว") {
              $("#row5_contract_status").html("<span style='color:#D25200'>"+value.contract_status+"</span>");
            }else {
              $("#row5_contract_status").html("<span style='color:green'>"+value.contract_status+"</span>");
            }
            $("#row5_state").html("<i class='fa fa-check text-navy'></i>");
          }
        }else { //Result no Data
          toastr.warning("ไม่พบข้อมูลประวัติการกู้ยืมกองทุน","หน้าต่างแจ้งเตือน");
          $("#row5_loan_history").html("<span>-</span>");
          $("#row5_contract_status").html("<span>-</span>");
          $("#row5_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ดึงข้อมูลประวัติการกู้ยืมกองทุนล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#row5_loan_history").html("<span>-</span>");
        $("#row5_contract_status").html("<span>-</span>");
        $("#row5_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
      },
    });
  //End Service 5

  //Service 6
    $.ajax({
    url: base_url+'difficult/getHistory',
    type: 'POST',
    dataType: 'json',
    data: {
        'pers_id': info.pers_id,
        'csrf_dop': csrf_hash
    },
      success: function (value) { //Result True
        //console.log("success");console.dir(value);
        if(Object.keys(value).length) {
          console.log(value);
          if(value.message!='') {
            toastr.warning("ไม่พบข้อมูลการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก","หน้าต่างแจ้งเตือน");
            $("#row6_history").html("<span>-</span>");
            $("#row6_year_now_history").html("<span>-</span>");
            $("#row6_state").html("<i class='fa fa-exclamation-triangle text-warning'></i>");
          }else {
            //toastr.success("ตรวจสอบข้อมูลการสงเคราะห์ผู้สูงอายุในภาวะยากลำบากเสร็จสิ้น","หน้าต่างแจ้งเตือน");
            if(value.history=='มีประวัติ') {
              $("#row6_history").html("<span style='color:#D25200'>"+value.history+"</span>");
            }else {
              $("#row6_history").html("<span style='color:green'>"+value.history+"</span>");
            }
            if(value.year_now_history>0) {
              $("#row6_year_now_history").html("<span style='color:red'>"+value.year_now_history+"</span>");
            }else {
              $("#row6_year_now_history").html("<span style='color:green'>"+value.year_now_history+"</span>");
            }
            $("#row6_state").html("<i class='fa fa-check text-navy'></i>");
          }
        }else { //Result no Data
          toastr.warning("ไม่พบข้อมูลการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก","หน้าต่างแจ้งเตือน");
          $("#row6_history").html("<span>-</span>");
          $("#row6_year_now_history").html("<span>-</span>");
          $("#row6_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ตรวจสอบข้อมูลการสงเคราะห์ผู้สูงอายุในภาวะยากลำบากล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#row6_history").html("<span>-</span>");
        $("#row6_year_now_history").html("<span>-</span>");
        $("#row6_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
      },
    });
  //End Service 6

/*  //Service 7
    $.ajax({
    url: base_url+'welfare/getHistory',
    type: 'POST',
    dataType: 'json',
    data: {
        'pers_id': info.pers_id,
        'csrf_dop': csrf_hash
    },
      success: function (value) { //Result True
        //console.log("success");console.dir(value);
        if(Object.keys(value).length) {
          console.log(value);
          if(value.message!='') {
            toastr.warning("ไม่พบข้อมูลการรับบริการศูนย์พัฒนาการจัดสวัสดิการสังคมฯ","หน้าต่างแจ้งเตือน");
            $("#row7_history").html("<span>-</span>");
            $("#row7_year_now_history").html("<span>-</span>");
            $("#row7_req_org").html("<span>-</span>");
            $("#row7_state").html("<i class='fa fa-exclamation-triangle text-warning'></i>");
          }else {
            //toastr.success("ตรวจสอบข้อมูลการรับบริการศูนย์พัฒนาการจัดสวัสดิการสังคมฯเสร็จสิ้น","หน้าต่างแจ้งเตือน");
            if(value.history=='มีประวัติ') {
              $("#row7_history").html("<span style='color:#D25200'>"+value.history+"</span>");
            }else {
              $("#row7_history").html("<span style='color:green'>"+value.history+"</span>");
            }
            if(value.year_now_history>0) {
              $("#row7_year_now_history").html("<span style='color:red'>"+value.year_now_history+"</span>");
            }else {
              $("#row7_year_now_history").html("<span style='color:green'>"+value.year_now_history+"</span>");
            }

            value.req_org = value.req_org==null?'-':value.req_org;
            $("#row7_req_org").html("<span>"+value.req_org+"</span>");
            $("#row7_state").html("<i class='fa fa-check text-navy'></i>");
          }
        }else { //Result no Data
          toastr.warning("ไม่พบข้อมูลการรับบริการศูนย์พัฒนาการจัดสวัสดิการสังคมฯ","หน้าต่างแจ้งเตือน");
          $("#row7_history").html("<span>-</span>");
          $("#row7_year_now_history").html("<span>-</span>");
          $("#row7_req_org").html("<span>-</span>");
          $("#row7_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ตรวจสอบข้อมูลการรับบริการศูนย์พัฒนาการจัดสวัสดิการสังคมฯล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#row7_history").html("<span>-</span>");
        $("#row7_year_now_history").html("<span>-</span>");
        $("#row7_req_org").html("<span>-</span>");
        $("#row7_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
      },
    });
  //End Service 7*/

}
</script>