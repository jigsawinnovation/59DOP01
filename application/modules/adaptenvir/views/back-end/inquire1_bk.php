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
                                $tmp = $this->admin_model->getOnce_Application(30);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                              ?>
                                <a <?php if(!isset($tmp1['perm_status'])) {?>
                                    readonly
                                  <?php }else if($process_action!='Add'){?> href="<?php echo site_url('adaptenvir/inquire1/Edit/'.$impv_home_info['imp_home_id']);?>" <?php }?> data-toggle="tab" <?php if($usrpm['app_id']==30){?>aria-expanded="true" <?php }else{?> aria-expanded="false"<?php }?>> (1) สอบถาม</a>
                            </li>
                            <li>
                              <?php
                                $tmp = $this->admin_model->getOnce_Application(31);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(31,$user_id); //Check User Permission
                              ?>
                                <a <?php if(!isset($tmp1['perm_status'])) {?>
                                    readonly
                                  <?php }else if($process_action!='Add'){?> href="<?php echo site_url('adaptenvir/agree2/Edit/'.$impv_home_info['imp_home_id']);?>" <?php }?> <?php if($usrpm['app_id']==31){?>aria-expanded="true" <?php }?>>(2) ยินยอม</a>
                            </li>
                            <li>
                              <?php
                                $tmp = $this->admin_model->getOnce_Application(32);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(32,$user_id); //Check User Permission
                              ?>
                                <a <?php if(!isset($tmp1['perm_status'])) {?>
                                    readonly
                                  <?php }else if($process_action!='Add'){?> href="<?php echo site_url('adaptenvir/assist3/Edit/'.$impv_home_info['imp_home_id']);?>" <?php }?> <?php if($usrpm['app_id']==32){?>aria-expanded="true" <?php }?>>(3) สงเคราะห์</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-1" <?php if($usrpm['app_id']==30){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
                                <div class="panel-body">

                                    <!--
                                    <div class="row">
                                        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
                                            <h2 style="color: #4e5f4d"></h2>
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
                                                    $tmp = $this->admin_model->getOnce_Application(30);
                                                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                                                  ?>
                                                  <a <?php if(!isset($tmp1['perm_status'])) {?>
                                                    readonly
                                                  <?php }else{?> onclick="return opnCnfrom()" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="บันทึกช้อมูล" class="btn btn-default">
                                                      <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                                  </a>


                                                  &nbsp;
                                                  <?php
                                                    $tmp = $this->admin_model->getOnce_Application(30);
                                                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                                                  ?>
                                                  <a onclick="return opnBck()" <?php if(!isset($tmp1['perm_status'])) {?>
                                                    readonly
                                                  <?php }else{?> href="<?php echo site_url('adaptenvir/adaptenvir_list');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="ย้อนกลับ" class="btn btn-default">
                                                      <i class="fa fa-undo" aria-hidden="true"></i>
                                                  </a>

                                                  <?php
                                                  if($process_action=='Edit') {
                                                  ?>
                                                  &nbsp;
                                                  <?php
                                                    $tmp = $this->admin_model->getOnce_Application(30);
                                                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                                                  ?>
                                                  <a data-id=<?php echo $impv_home_info['imp_home_id'];?> onclick="opn(this)" <?php if(!isset($tmp1['perm_status'])) {?>
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
                                       <!--
                                        <?php
                                         if($process_action=='Edit') {
                                        ?>
                                          <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="" data-toggle="modal" data-target="#myPrint">
                                          <i class="fa fa-file-text" aria-hidden="true"></i> </a>
                                        <?php }?>

                                        <?php
                                          $tmp = $this->admin_model->getOnce_Application(30); 
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                                        ?>
                                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" 
                                        <?php if(!isset($tmp1['perm_status'])) {?>
                                                readonly 
                                              <?php }else{?> onclick="return opnCnfrom()" 
                                        <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> </a>
                                        -->

                                        <?php
                                          $tmp = $this->admin_model->getOnce_Application(30); 
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
                                        ?>
                                        <a  class="navbar-minimalize minimalize-styl-2 btn btn-primary" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" 
                                        <?php if(!isset($tmp1['perm_status'])) {?>
                                                readonly 
                                              <?php }else{?> href="<?php echo site_url('adaptenvir/adaptenvir_list');?>" 
                                        <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
                                        <i class="fa fa-caret-left" aria-hidden="true"></i> </a>
                                        
                                        <!--
                                        <?php
                                         if($process_action=='Edit') {
                                          $tmp = $this->admin_model->getOnce_Application(6); 
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(6,$user_id); //Check User Permission
                                        ?>
                                        <a data-id=<?php echo $impv_home_info['imp_home_id'];?> onclick="opn(this)" class="navbar-minimalize minimalize-styl-2 btn btn-primary" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" 
                                        <?php if(!isset($tmp1['perm_status'])) {?>
                                                readonly 
                                              <?php }else{?>  
                                        <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                        <?php } ?>
                                        
                                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>
                                        -->
                                    </div>
                                    <script>
                                      setTimeout(function(){
                                        $("#menu_topright").html($("#tmp_menu").html());
                                      },300);
                                    </script>

                                    <div class="family_members_template" hidden='hidden'>
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
                                                          <input  id="pid_myID" title="เลขบัตรประจำตัวประชาชน" placeholder="เลขบัตรประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text"/>                   
                                                          <input type="hidden" id="pers_id_myID" name="pers_family[pers_id][myID]">
                                                           <div class="input-group-btn"> 
                                                            <button  type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_pid_myID"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
                                                           </div>
                                                      </div>
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
                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ปกติ"> ปกติ</label></div>&nbsp;&nbsp;&nbsp;
                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ผู้ผู้ป่วยเรื้อรัง"> ผู้ป่วยเรื้อรัง</label></div>&nbsp;&nbsp;&nbsp;
                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][myID]" value="ผู้พิการ"> ผู้พิการ</label></div>
                                                  </div>
                                                  <div class="col-xs-12 col-sm-6">
                                                      <label for="" class="col-2 col-form-label">ช่วยเหลือตนเอง</label>&nbsp;&nbsp;
                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][myID]" value="ได้"> ได้</label></div>&nbsp;&nbsp;&nbsp;
                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][myID]" value="ไม่ได้"> ไม่ได้</label></div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">

                                          icheck_loop();

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
                                    $imp_home_id = '';

                                    if($process_action=='Add')$process_action = 'Added';
                                    if($process_action=='Edit'){$process_action = 'Edited'; $imp_home_id = '/'.$impv_home_info['imp_home_id'];}

                                    echo form_open_multipart('adaptenvir/inquire1/'.$process_action.$imp_home_id,array('id'=>'form1'));
                                    ?>

                                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->

                                    <input type="submit" value="submit" name="bt_submit" hidden="hidden">


                                    <?php echo validation_errors('<div class="error" style="font-size: 18px; padding-left: 20px">', '</div>'); ?>

                                    <div class="panel-group">
                                          <div class="panel panel-default" style="border: 0">

                                              <div class="panel-heading">
                                                <h4>ข้อมูลผู้สูงอายุ (ผู้สูงอายุที่มีความต้องการปรับปรุงบ้าน) <label>&nbsp;</label>
                                                  <!--
                                                  <button type="button" onclick="$('#integration').modal('show');return false;" class="btn btn-default" style="float: right;">ข้อมูลบูรณาการ</button>
                                                  -->
                                                </h4>
                                              </div>

                                              <div class="panel-body" style="border:0; padding: 20px;">
                                          <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3"><img width="70%" src="<?php echo path("noProfilePic.jpg",'member');?>" class="img-responsive" style="margin: 0 auto;"></div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span> </div>
                                                    <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">
                                                      <div class="input-group" style="width: 295px;"> 
                                                          <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard elder_same_req" type="text" id="pid" name="impv_home_info[pid]" value="<?php echo $impv_home_info['pid'];?>" required="required" />
                                                          <input type="hidden" id="pers_id" name="impv_home_info[pers_id]" value="<?php echo $impv_home_info['pers_id'];?>">
                                                     
                                                        <div class="input-group-btn" style="padding-bottom: 5px;">
                                                          <button type="button" title="ตรวจสอบ" class="btn btn-default elder_same_req" id="bt_elder_pid" style="  border-radius: 0px; left: 1px;"><i class="fa fa-id-card-o" aria-hidden="true"></i></button>
                                                          <!-- <button class="btn btn-default elder_same_req" title="กรณีไม่มีบัตร" style="">กรณีไม่มีบัตร</button> -->
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <script>
                                                        var elder_pers = null;
                                                        var inputpid2 = "#pid";
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
                                                              getPersInfo(inputpid2,bt_spid2,setData2); //Get Data 
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
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;"  id="name"> <?php echo $impv_home_info['name'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="date_of_birth"> <?php echo $impv_home_info['date_of_birth'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="gender_name"> <?php echo $impv_home_info['gender_name'];?></span> </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="nation_name_th"> <?php echo $impv_home_info['nation_name_th'];?></span> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="relg_title"> <?php echo $impv_home_info['relg_title'];?> </span> </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="reg_addr"> <?php echo $impv_home_info['reg_add_info'];?> </div>
                                                    <input type="hidden" id="reg_addr_id" name="pers_info[reg_addr_id]" value="<?php echo $impv_home_info['reg_addr_id']; ?>">

                                                  </div>

                                                  <div class="form-group row">
                                                        <div class="col-xs-12 col-sm-3">
                                                            <label for="datetimepicker1" class="col-2 col-form-label" style="color: red;">วันที่สอบถาม </label>
                                                              <div id="datetimepicker1" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                                  <input title="วันที่สอบถาม" placeholder="เลือกวันที่" class="form-control" type="text" name="impv_home_info[date_of_svy]" value="<?php echo $impv_home_info['date_of_svy']; ?>" required>
                                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                              </div>
                                                                <script type="text/javascript">
                                                                $(function () {
                                                                  $("#datetimepicker1").datepicker({
                                                                      autoclose: true,
                                                                      todayHighlight: true
                                                                  });
                                                                });
                                                                </script>
                                                        </div>
                                                    </div>


                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-6">ที่อยู่ (ปัจจุบัน) ( <div class="checkbox-inline i-checks"><label><input type="checkbox" name="elder_addr_chk"> ตรงกับที่อยู่ตามทะเบียนบ้าน</label></div> )</div>
                                                    <script>

                                                      setTimeout(icheck_loop,2000);

                                                    function icheck_loop () {

                                                      $('.i-checks').iCheck({
                                                        checkboxClass: 'icheckbox_square-green',
                                                        radioClass: 'iradio_square-green',
                                                        increaseArea: '20%'
                                                      });

                                                      $("input[name='elder_addr_chk']").on('ifClicked',function(){

                                                        if(!$(this).prop('checked')) {
                                                          $(".elder_addr_pre").attr('disabled',true);
                                                        }else {
                                                          $(".elder_addr_pre").attr('disabled',false);
                                                        }

                                                      });

                                                      <?php
                                                      if(($impv_home_info['reg_addr_id']==$impv_home_info['pre_addr_id']) && ($impv_home_info['reg_addr_id']!=''&&$impv_home_info['pre_addr_id']!='')) {
                                                      ?>
                                                      
                                                          $("input[name='elder_addr_chk']").parent().addClass('checked');
                                                          $("input[name='elder_addr_chk']").prop('checked',true);
                                                          $(".elder_addr_pre").attr('disabled',true);
                                                       
                                                      <?php
                                                      }
                                                      ?>

                                                      <?php $home_condition = $this->common_model->custom_query("SELECT * FROM std_home_condition ORDER BY hcond_code ASC"); ?>
                                                      <?php foreach ($home_condition as $key => $condition) { ?>
                                                       $("input[name='impv_home_condition[hcond_code][<?php echo $condition['hcond_code']; ?>]']").on('ifChanged',function(){

                                                        if($(this).prop('checked')){
                                                         $("input[name='impv_home_condition[hcond_remark][<?php echo $condition['hcond_code']; ?>]']").prop('disabled',false).focus();
                                                       }else{
                                                         $("input[name='impv_home_condition[hcond_remark][<?php echo $condition['hcond_code']; ?>]']").prop('disabled',true);
                                                       }

                                                     });

                                                       <?php } ?>

                                                       $("input[name='impv_home_info[land_tenure]']").on('ifChanged',function(){
                                                           if($("input[value='ที่ดินเช่า']").prop('checked')){
                                                             $("input[name='impv_home_info[land_tenure_remark]']").prop('disabled',false).focus();
                                                           }else{
                                                             $("input[name='impv_home_info[land_tenure_remark]']").prop('disabled',true);
                                                           }
                                                       });

                                                       $("input[name='impv_home_info[staff_review]']").on('ifChanged',function(){
                                                         if($("input[value='เห็นควรให้ความช่วยเหลือ']").prop('checked')){
                                                           $('#staff_review_remark-1').prop('disabled',false).focus();
                                                           $('#staff_review_remark-2').prop('disabled',true);
                                                         }else{
                                                          $('#staff_review_remark-2').prop('disabled',false).focus();
                                                          $('#staff_review_remark-1').prop('disabled',true);
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
                                                              <option value="บ้านตนเอง" <?php if(@$pers_info['pre_addr_status'] == 'บ้านตนเอง'){ echo "selected";} ?>>บ้านตนเอง</option>
                                                              <option value="อาศัยผู้อื่นอยู่" <?php if(@$pers_info['pre_addr_status'] == 'อาศัยผู้อื่นอยู่'){ echo "selected";} ?>>อาศัยผู้อื่นอยู่</option>
                                                              <option value="บ้านเช่า" <?php if(@$pers_info['pre_addr_status'] == 'บ้านเช่า'){ echo "selected";} ?>>บ้านเช่า</option>
                                                              <option value="อยู่กับผู้จ้าง" <?php if(@$pers_info['pre_addr_status'] == 'อยู่กับผู้จ้าง'){ echo "selected";} ?>>อยู่กับผู้จ้าง</option>
                                                              <option value="ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง" <?php if(@$pers_info['pre_addr_status'] == 'ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง'){ echo "selected";} ?>>ไม่มีที่อยู่อาศัยเป็นหลักแหล่ง</option>
                                                          </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">บ้านเลขที่</label>
                                                        <input type="hidden" name="pre_addr_id" value="<?php echo @$pers_info['pre_addr_id']; ?>">
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
                                                        <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[tel_no_home]" value="<?php echo @$pers_info['tel_no_home'];?>"/>                   
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (มือถือ)</label>
                                                        <input title="เบอร์โทรศัพท์ (มือถือ)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="pers_info[tel_no_mobile]" value="<?php echo @$pers_info['tel_no_mobile'];?>"/>                    
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                                                        <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[fax_no]" value="<?php echo @$pers_info['fax_no'];?>"/>                   
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                                                        <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="pers_info[email_addr]" value="<?php echo @$pers_info['email_addr'];?>"/>                    
                                                    </div>
                                                  </div>


                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">อาชีพ (ปัจจุบัน)</label>
                                                      <input title="อาชีพ (ปัจจุบัน)" placeholder="ระบุอาชีพ (ปัจจุบัน)" class="form-control" type="text" name="pers_info[occupation]" value="<?php echo @$pers_info['occupation']; ?>" />                   
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">รายได้เฉลี่ย (บาท/เดือน)</label>
                                                      <input title="รายได้เฉลี่ย (บาท/เดือน)" placeholder="ระบุรายได้เฉลี่ย (บาท/เดือน)" class="form-control" type="text" name="pers_info[mth_avg_income]" value="<?php echo @$pers_info['mth_avg_income']; ?>"/>                   
                                                    </div>

                                                    <div class="col-xs-12 col-sm-3 dropdown">
                                                      <label for="example-text-input" class="col-2 col-form-label">ที่มาของรายได้</label>
                                                      <div class="col-10">
                                                        <select title="ที่มาของรายได้" placeholder="เลือกที่มาของรายได้" class="form-control" name="pers_info[src_of_income]">
                                                          <option value="">เลือกที่มาของรายได้</option>
                                                          <option value="ด้วยตนเอง" <?php if(@$pers_info['src_of_income'] == 'ด้วยตนเอง'){ echo "selected";} ?>>ด้วยตนเอง</option>
                                                          <option value="ผู้อื่นให้" <?php if(@$pers_info['src_of_income'] == 'ผู้อื่นให้'){ echo "selected";} ?>>ผู้อื่นให้</option>
                                                          <option value="อื่น ๆ" <?php if(@$pers_info['src_of_income'] == 'อื่น ๆ'){ echo "selected";} ?>>อื่น ๆ</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">&nbsp;</label>
                                                      <input title="ระบุ" placeholder="ระบุ" class="form-control" type="text" name="pers_info[src_of_income_identify]" value="<?php echo @$pers_info['src_of_income_identify']; ?>"/>                   
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
                                                                     <div class="input-group">
                                                                          <label for="" class="col-2 col-form-label">เลขบัตรประจำตัวประชาชน</label>
                                                                          <input  id="pid_<?php echo $key;?>" value="<?php echo $row['pid'];?>" title="เลขบัตรประจำตัวประชาชน" placeholder="เลขบัตรประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text"/>                   
                                                                          <input type="hidden" id="pers_id_<?php echo $key;?>" name="pers_family[pers_id][<?php echo $key;?>]" value="<?php echo $row['ref_pers_id'];?>">
                                                                        <div class="input-group-btn" >
                                                                          <button  type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_pid_<?php echo $key;?>" onclick="return false;">ตรวจสอบ</button>
                                                                        </div>
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
                                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ปกติ" <?php if($row['healthy'] == 'ปกติ'){ echo "checked";} ?>> ปกติ</label></div>&nbsp;&nbsp;&nbsp;
                                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ผู้ป่วยเรื้อรัง" <?php if($row['healthy'] == 'ผู้ป่วยเรื้อรัง'){ echo "checked";} ?>> ผู้ป่วยเรื้อรัง</label></div>&nbsp;&nbsp;&nbsp;
                                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy][<?php echo $key;?>]" value="ผู้พิการ" <?php if($row['healthy'] == 'ผู้พิการ'){ echo "checked";} ?>> ผู้พิการ</label></div>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-6">
                                                                      <label for="" class="col-2 col-form-label">ช่วยเหลือตนเอง</label>&nbsp;&nbsp;
                                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][<?php echo $key;?>]" value="ได้" <?php if($row['healthy_self_help'] == 'ได้'){ echo "checked";} ?>> ได้</label></div>&nbsp;&nbsp;&nbsp;
                                                                      <div class="checkbox-inline i-checks"><label><input type="radio" name="pers_family[healthy_self_help][<?php echo $key;?>]" value="ไม่ได้" <?php if($row['healthy_self_help'] == 'ไม่ได้'){ echo "checked";} ?>> ไม่ได้</label></div>
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


                                           <!--<button class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i></button>-->

                                          <br>
                                          <div class="form-group row"><!-- row leverl 2-->
                                            <label>สภาพบ้านที่ต้องการปรับปรุง</label>
                                             <div class="col-xs-12 col-sm-12"><br></div>
                                             <?php $home_condition = $this->common_model->custom_query("SELECT * FROM std_home_condition ORDER BY hcond_code ASC"); ?>
                                             <?php foreach ($home_condition as $key => $condition) { ?>
                                               <div class="col-xs-12 col-sm-6"><div class="i-checks"><label><input onChange="set_enable($(this),'#rem-<?php echo $condition['hcond_code']; ?>');" type="checkbox" name="impv_home_condition[hcond_code][<?php echo $condition['hcond_code']; ?>]" value="<?php echo $condition['hcond_code']; ?>" <?php if(@$impv_home_condition[$condition['hcond_code']]['hcond_code'] == $condition['hcond_code']){ echo "checked";} ?>> <?php echo $condition['hcond_title']; ?></label></div></div>
                                               <div class="col-xs-12 col-sm-6"><input type="text" id="rem-<?php echo $condition['hcond_code']; ?>" class="form-control" placeholder="ความคิดเห็นเจ้าหน้าที่ (ผู้สอบถาม)" name="impv_home_condition[hcond_remark][<?php echo $condition['hcond_code']; ?>]" value="<?php echo @$impv_home_condition[$condition['hcond_code']]['hcond_remark'];?>" <?php if(!isset($impv_home_condition[$condition['hcond_code']]['hcond_remark'])){ echo "disabled"; } ?>></div>
                                               <div class="col-xs-12 col-sm-12"><br></div>
                                             <?php } ?>
                                          </div>

                                           
                                          

                                          <div class="form-group row"><!-- row leverl 2-->
                                            <label>ลักษณะการครอบครองที่ดิน</label>
                                            <div class="col-xs-12 col-sm-12"><br></div>
                                            <div class="col-xs-12 col-sm-6"><div class="i-checks"><label><input type="radio" name="impv_home_info[land_tenure]" value="ที่ดินของตนเอง" <?php if(@$impv_home_info['land_tenure'] == "ที่ดินของตนเอง"){ echo "checked";} ?>>  ที่ดินของตนเอง</label></div></div>
                                            <div class="col-xs-12 col-sm-6"></div>
                                            <div class="col-xs-12 col-sm-12"><br></div>
                                            <div class="col-xs-12 col-sm-6"><div class="i-checks"><label><input type="radio" name="impv_home_info[land_tenure]" value="ที่ดินเช่า" <?php if(@$impv_home_info['land_tenure'] == "ที่ดินเช่า"){ echo "checked";} ?>>  ที่ดินเช่า</label></div></div>
                                            <div class="col-xs-12 col-sm-6"><input type="text" id="land_tenure_remark" class="form-control" placeholder="ที่ดินเช่าจาก (ระบุ)" name="impv_home_info[land_tenure_remark]" value="<?php if(@$impv_home_info['land_tenure'] == "ที่ดินเช่า"){ echo @$impv_home_info['land_tenure_remark']; }?>" <?php if(@$impv_home_info['land_tenure'] != "ที่ดินเช่า"){ echo "disabled"; } ?>></div>
                                          </div>

                                          <div class="form-group row"><!-- row leverl 2-->
                                            <label>ความคิดเห็นเจ้าหน้าที่</label>
                                            <div class="col-xs-12 col-sm-12"><br></div>
                                            <div class="col-xs-12 col-sm-6"><div class="i-checks"><label><input type="radio" name="impv_home_info[staff_review]" value="เห็นควรให้ความช่วยเหลือ" <?php if(@$impv_home_info['staff_review'] == "เห็นควรให้ความช่วยเหลือ"){ echo "checked";} ?>>  เห็นควรให้ความช่วยเหลือ</label></div></div>
                                            <div class="col-xs-12 col-sm-6"><input type="text" id="staff_review_remark-1" class="form-control" placeholder="ความคิดเห็นเจ้าหน้าที่ (ผู้สอบถาม)" name="impv_home_info[staff_review_remark]" value="<?php if(@$impv_home_info['staff_review'] == "เห็นควรให้ความช่วยเหลือ" ){ echo @$impv_home_info['staff_review_remark']; } ?>" <?php if(@$impv_home_info['staff_review'] != "เห็นควรให้ความช่วยเหลือ" ){ echo "disabled"; } ?>></div>
                                            <div class="col-xs-12 col-sm-12"><br></div>
                                            <div class="col-xs-12 col-sm-6"><div class="i-checks"><label><input type="radio" name="impv_home_info[staff_review]" value="เห็นควรให้ความช่วยเหลืออย่างด่วน" <?php if(@$impv_home_info['staff_review'] == "เห็นควรให้ความช่วยเหลืออย่างด่วน"){ echo "checked";} ?>>  เห็นควรให้ความช่วยเหลืออย่างด่วน</label></div></div>
                                            <div class="col-xs-12 col-sm-6"><input type="text" id="staff_review_remark-2" class="form-control" placeholder="ความคิดเห็นเจ้าหน้าที่ (ผู้สอบถาม)" name="impv_home_info[staff_review_remark]" value="<?php if(@$impv_home_info['staff_review'] == "เห็นควรให้ความช่วยเหลืออย่างด่วน" ){ echo @$impv_home_info['staff_review_remark']; } ?>" <?php if(@$impv_home_info['staff_review'] != "เห็นควรให้ความช่วยเหลืออย่างด่วน"){ echo "disabled"; } ?>></div>
                                          </div>


                                         
                                          

                                              </div>
                                          </div>
                                      </div>

                                  </div>
                                    
                                  <hr>
                                  <div class="row">
                                   <div class="col-xs-12 col-sm-8">&nbsp;</div>
                                   <div class="col-xs-12 col-sm-2">
                                    <button style="width: 100%;" type="button" class="btn btn-primary btn-md" onclick="return opnCnfrom()"> บันทึก</button>
                                  </div>
                                  <div class="col-xs-12 col-sm-2">
                                    <button style="width: 100%;" type="button" class="btn btn-primary btn-md" onclick="window.location.href='<?php echo site_url('adaptenvir/adaptenvir_list');?>'"> ล้างค่า</button>
                                  </div>
                                </div><!-- close class row-->

                                </div>
                            </div>

                            <div id="tab-2" <?php if($usrpm['app_id']==31){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
                                <div class="panel-body">
                                    <strong>Tab-3</strong>
                                </div><!-- close panel-body tab-2-->
                            </div>

                            <div id="tab-3" <?php if($usrpm['app_id']==32){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
                                <div class="panel-body">
                                    <strong>Tab-3</strong>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
<script type="text/javascript">
  function set_enable(elem,target='') {
    if(elem.prop('checked') == true) {
      $(target).prop('disabled', false ).focus();
    }else{
      $(target).val('');
      $(target).prop('disabled', true );
    }
  }
  
  $("input[name='impv_home_info[land_tenure]']").change(function(){
    if($(this).val() == 'ที่ดินเช่า'){
      $("#land_tenure_remark").prop('disabled', false ).focus();
    }else{
      $("#land_tenure_remark").val('');
      $("#land_tenure_remark").prop('disabled', true );
    }
  });

  $("input[name='impv_home_info[staff_review]']").change(function(){
    if($(this).val() == 'เห็นควรให้ความช่วยเหลือ'){
      $("#staff_review_remark-1").prop('disabled', false ).focus();
      $("#staff_review_remark-2").val('');
      $("#staff_review_remark-2").prop('disabled', true );
    }else{
      $("#staff_review_remark-2").prop('disabled', false ).focus();
      $("#staff_review_remark-1").val('');
      $("#staff_review_remark-1").prop('disabled', true );
    }
  });

  <?php if($process_action == 'Edited'){ ?>
    setTimeout(function(){$("#Province").val('<?php echo @$addr_info['province_code']; ?>').trigger('change');},200);
    // setTimeout(function(){$("#Amphur").val('<?php echo @$addr_info['district_code']; ?>').trigger('change');},300);
    // setTimeout(function(){$("#Tambon").val('<?php echo @$addr_info['sub_district_code']; ?>').trigger('change');},400);
  <?php } ?>
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
        <h2 class="modal-title text-left">ผู้สูงอายุที่เข้าร่วม</h2>
      </div>
      <div class="modal-body">
        <div style="font-size: 24px;color: #A7A7A7;margin-bottom: 10px; border-top: 1px solid #EDEDED;border-bottom: 1px solid #EDEDED;">
          ข้อมูลบูรณาการ
        </div>
        <div class="row">
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
        </div>
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
            <div>(กรมการจัดหางาน)</div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <label>วันที่ขึ้นทะเบียน</label>
            <div>16 มกราคม 2560</div>
          </div>

          <div class="col-xs-12 col-sm-3">
            <label>สถานะการได้รับงาน</label>
            <div  style="color: green;">ได้งานทำแล้ว</div>
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
            <div style="color: green">เคยได้รับ</div>
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
            <a style="color: #333; font-size: 20px;" target="_blank" href="<?php echo site_url('report/A1');?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
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
            <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A2');?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
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
            <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A3');?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
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
            <a style="color: #333; font-size: 20px; margin-bottom: 50px;" target="_blank" href="<?php echo site_url('report/A4');?>"><i class="fa fa-print" aria-hidden="true"></i> <?php if(isset($tmp1['perm_status'])) {echo $tmp1['app_name']; }?>
            </a>
          </div>

         </div>
         <br/>

      </div>
    </div>

  </div>
 </div>
 <!-- End Print Modal -->

