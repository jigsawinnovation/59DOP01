<?php
//set_session('pers_authen',array('authen_log_id'=>223,'pid'=>'3101701933555','cid'=>'0221004350953232','random_string'=>'80db7f660e7ef6255597fc5794be0093')); //for Test
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
                                $tmp = $this->admin_model->getOnce_Application(22);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(22,$user_id); //Check User Permission
                              ?>
                                <a <?php if(!isset($tmp1['perm_status'])) {?>
                                    readonly
                                  <?php }else if($process_action!='Add'){?> href="<?php echo site_url('funeral/inform1/Edit/'.$fnrl_info['fnrl_id']);?>" <?php }?> data-toggle="tab" <?php if($usrpm['app_id']==22){?>aria-expanded="true" <?php }else{?> aria-expanded="false"<?php }?>> (1) แจ้งเรื่อง</a>
                            </li>

                            <li>
                              <?php
                                $tmp = $this->admin_model->getOnce_Application(23);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(23,$user_id); //Check User Permission
                              ?>
                                <a <?php if(!isset($tmp1['perm_status'])) {?>
                                    readonly
                                  <?php }else if($process_action!='Add'){?> href="<?php echo site_url('funeral/assist2/Edit/'.$fnrl_info['fnrl_id']);?>" <?php }?> <?php if($usrpm['app_id']==23){?>aria-expanded="true" <?php }?>>(2) สงเคราะห์</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-1" <?php if($usrpm['app_id']==22){?> class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
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
                                                  <?php }else{?> href="<?php echo site_url('funeral/funeral_list');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="ย้อนกลับ" class="btn btn-default">
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
                                                  <a data-id=<?php echo $fnrl_info['fnrl_id'];?> onclick="opn(this)" <?php if(!isset($tmp1['perm_status'])) {?>
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
                                          <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="" data-toggle="modal" data-target="#myPrint">
                                          <i class="fa fa-file-text" aria-hidden="true"></i> </a>
                                        <?php }?>

                                        <?php
                                          $tmp = $this->admin_model->getOnce_Application(6);
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(6,$user_id); //Check User Permission
                                        ?>
                                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;"
                                        <?php if(!isset($tmp1['perm_status'])) {?>
                                                readonly
                                              <?php }else{?> onclick="return opnCnfrom()"
                                        <?php }?> title="บันทึก">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> </a>
                                         -->
                                        <?php
                                          $tmp = $this->admin_model->getOnce_Application(6);
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(6,$user_id); //Check User Permission
                                        ?>

                                        <!--
                                        <?php
                                         if($process_action=='Edit') {
                                          $tmp = $this->admin_model->getOnce_Application(6);
                                          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(6,$user_id); //Check User Permission
                                        ?>
                                        <a data-id=<?php echo $fnrl_info['fnrl_id'];?> onclick="opn(this)" class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;"
                                        <?php if(!isset($tmp1['perm_status'])) {?>
                                                readonly
                                              <?php }else{?>
                                        <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                        <?php } ?>

                                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>
                                        -->
                                    </div>
                                    <script>
                                      setTimeout(function(){
                                        $("#menu_topright").html($("#tmp_menu").html());
                                      },300);
                                    </script>

                                    <div class="form-group row">

                                    <?php
                                    $fnrl_id = '';

                                    if($process_action=='Add')$process_action = 'Added';
                                    if($process_action=='Edit'){$process_action = 'Edited'; $fnrl_id = '/'.$fnrl_info['fnrl_id'];}

                                    echo form_open_multipart('funeral/inform1/'.$process_action.$fnrl_id,array('id'=>'form1'));
                                    ?>

                                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->

                                    <input type="submit" value="submit" name="bt_submit" hidden="hidden">


                                    <?php echo validation_errors('<div class="error" style="font-size: 18px; padding-left: 20px">', '</div>'); ?>

                                    <div class="panel-group" style="margin-bottom: 0px;">
                                          <div class="panel panel-default" style="border: 0">
                                              <div class="panel-heading"><h4>ข้อมูลผู้ยืนคำขอ (ผู้ยื่นขอรับเงินสงเคราะห์ในการจัดงานศพผู้สูงอายุตามประเพณี)</h4></div>
                                              <div class="panel-body" style="border:0; padding: 20px;">
                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3">
                                                            <img width="70%" src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" style="margin: 0 auto;">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span> </div>
                                                    <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">
                                                      <div class="input-group" style="width: 295px;">
                                                              <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text" value="<?php echo $fnrl_info['req_pid'];?>" name="fnrl_info[req_pid]" id="req_pid" autofocus required/>
                                                           <div class="input-group-btn" style="padding-bottom: 5px;">
                                                              <button title="ตรวจสอบ" class="btn btn-default" id="bt_req_pid" style="background-color:#F2DEDE; border-radius: 0px; border-color: #ed5565; color: #ed5565;padding:5px 12px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                           </div>
                                                              <input type="hidden" id="req_pers_id" name="fnrl_info[req_pers_id]" value="<?php echo $fnrl_info['req_pers_id'];?>">
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

                                                      <!-- <button title="กรณีไม่มีบัตร" class="btn btn-default" style="">กรณีไม่มีบัตร</button> -->



                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ชื่อตัว/ชื่อสกุล</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_name"> <?php echo $fnrl_info['req_name'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_date_of_birth"> <?php echo $fnrl_info['req_date_of_birth'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="req_gender_name"> <?php echo $fnrl_info['req_gender_name'];?> </span> </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="req_nation_name_th"> <?php echo $fnrl_info['req_nation_name_th'];?> </span> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="req_relg_title"> <?php echo $fnrl_info['req_relg_title'];?> </span> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_reg_addr"> - </div>
                                                  </div>
                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="datetimepicker1" class="col-2 col-form-label" style="color: red;">วันที่แจ้งเรื่อง </label>
                                              <div id="datetimepicker1" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                  <input title="วันที่แจ้งเรื่อง" placeholder="เลือกวันที่" class="form-control" type="text" name="fnrl_info[date_of_req]" required />
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                              </div>
                                                <script type="text/javascript">
                                                <?php
                                                $tmp = explode('-',@$fnrl_info['date_of_req']);
                                                ?>
                                                $(function () {
                                                $("#datetimepicker1").datepicker({
                                                  autoclose: true,
                                                  todayHighlight: true,
                                                  format: 'dd/mm/yyyy',
                                                   todayBtn: true,
                                                   language: 'th',
                                                   thaiyear: true
                                                })<?php if(count($tmp)==3){?>.datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));<?php }?>
                                                });
                                                </script>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">ตำแหน่ง</label>
                                              <input title="ตำแหน่ง" placeholder="ระบุตำแหน่ง" class="form-control" type="text" name="fnrl_info[req_position]" value="<?php echo $fnrl_info['req_position'];?>"/>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">หน่วยงาน</label>
                                              <input title="หน่วยงานต้นสังกัด" placeholder="ระบุหน่วยงานต้นสังกัด" class="form-control" type="text" name="fnrl_info[req_org]" value="<?php echo $fnrl_info['req_org'];?>"/>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">เกี่ยวข้องเป็น</label>
                                              <input title="ความสัมพันธ์กับผู้สูงอายุ" placeholder="ระบุความสัมพันธ์กับผู้สูงอายุ" class="form-control" type="text" name="fnrl_info[req_relation]" value="<?php echo $fnrl_info['req_relation'];?>"/>
                                                    </div>
                                          </div>
                                          <div class="form-group row">
                                           <!--  <div class="col-xs-12 col-sm-3">
                                              <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                                              <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[req_tel_no_home]" value="<?php echo $fnrl_info['req_tel_no_home'];?>"/>
                                            </div> -->
                                            <div class="col-xs-12 col-sm-3">
                                              <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (ที่ติดต่อได้)</label>
                                              <input title="เบอร์โทรศัพท์ (ที่ติดต่อได้)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="fnrl_info[req_tel_no_mobile]" value="<?php echo $fnrl_info['req_tel_no_mobile'];?>"/>
                                            </div>
                                         <!--    <div class="col-xs-12 col-sm-3">
                                              <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                                              <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[req_fax_no]" value="<?php echo $fnrl_info['req_fax_no'];?>"/>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                              <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                                              <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="fnrl_info[req_email_addr]" value="<?php echo $fnrl_info['req_email_addr'];?>"/>
                                            </div> -->
                                          </div>

                                        </div>

                                              <div class="panel-heading">
                                                <h4>ข้อมูลผู้สูงอายุ (ผู้สูงอายุที่เสียชีวิต)
                                                  <label>&nbsp;</label>
                                                  <!--
                                                  <button type="button" class="btn btn-default" style="float: right;">ข้อมูลบูรณาการ</button>
                                                  -->
                                                </h4>
                                              </div>

                                              <div class="panel-body" style="border:0; padding: 20px;">
                                          <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3">
                                                            <img width="70%" src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" style="margin: 0 auto;">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span> </div>
                                                    <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">
                                                         <div class="input-group" style="width: 295px;">
                                                           <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard elder_same_req" type="text" id="pid" name="fnrl_info[pid]" value="<?php echo $fnrl_info['pid'];?>" required/>
                                                           <input  type="hidden" id="pers_id" name="fnrl_info[pers_id]" value="<?php echo $fnrl_info['pers_id'];?>">
                                                          <div class="input-group-btn" style="padding-bottom: 5px;">
                                                              <button title="ตรวจสอบ" class="btn btn-default elder_same_req" id="bt_elder_pid" style="background-color:#F2DEDE; border-radius: 0px; border-color: #ed5565; color: #ed5565;padding:5px 12px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                          </div>
                                                        </div>
                                                    </div>

                                                      <!-- <button class="btn btn-default elder_same_req" title="กรณีไม่มีบัตร" style="">กรณีไม่มีบัตร</button> -->

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
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;"  id="name"> <?php echo $fnrl_info['name'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="date_of_birth"> <?php echo $fnrl_info['date_of_birth'];?> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="gender_name"> <?php echo $fnrl_info['gender_name'];?></span> </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="nation_name_th"> <?php echo $fnrl_info['nation_name_th'];?></span> </div>

                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="relg_title"> <?php echo $fnrl_info['relg_title'];?> </span> </div>
                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="reg_addr"> - </div>
                                                    <input type="hidden" id="reg_addr_id" name="pers_info[reg_addr_id]" value="<?php echo $fnrl_info['reg_addr_id']; ?>">
                                                  </div>

                                                  <div class="form-group row">


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
                                    <!--
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
                                    -->
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



                                                    <div class="col-xs-12 col-sm-6">ที่อยู่ (ปัจจุบัน) ( <div class="checkbox-inline i-checks"><label><input type="checkbox" name="elder_addr_chk"> ตรงกับที่อยู่ตามทะเบียนบ้าน</label></div> )</div>
                                                    <script>
                                                      $("input[name='elder_addr_chk']").on('ifClicked',function(){
                                                        if(!$(this).prop('checked')) {
                                                          $(".elder_addr_pre").attr('disabled',true);
                                                        }else {
                                                          $(".elder_addr_pre").attr('disabled',false);
                                                        }
                                                      });

                                                    </script>

                                                      <?php
                                                       if(($fnrl_info['reg_addr_id']==$fnrl_info['pre_addr_id']) && ( ($fnrl_info['reg_addr_id']!='') && ($fnrl_info['pre_addr_id']!='') ) ) {
                                                       // echo $fnrl_info['reg_addr_id']."<br>".$fnrl_info['pre_addr_id'];
                                                      // if(($fnrl_info['reg_addr_id']==$fnrl_info['pre_addr_id'])) {

                                                      ?>
                                                       <script type="text/javascript">
                                                         $(function(){
                                                            $("input[name='elder_addr_chk']").parent().addClass('checked');
                                                            $("input[name='elder_addr_chk']").prop('checked',true);
                                                            $(".elder_addr_pre").attr('disabled',true);
                                                        });
                                                       </script>
                                                      <?php
                                                      }
                                                      ?>


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
                                                          <input id="alley" title="ตรอก" placeholder="ตัวอย่าง บ้านหล่อ" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_alley]" value="<?php echo @$addr_info['addr_alley']; ?>" />
                                                      </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3 dropdown">
                                                      <label for="example-text-input" class="col-2 col-form-label">ซอย</label>
                                                      <div class="col-10">
                                                        <input id="lane" title="ซอย" placeholder="ตัวอย่าง วรพงษ์" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_lane]" value="<?php echo @$addr_info['addr_lane']; ?>" />
                                                      </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 dropdown">
                                                      <label for="example-text-input" class="col-2 col-form-label">ถนน</label>
                                                      <div class="col-10">
                                                        <input id="road" title="ถนน" placeholder="ตัวอย่าง ปรินายก" class="form-control elder_addr_pre" type="text" name="pers_addr[addr_road]" value="<?php echo @$addr_info['addr_road']; ?>" />
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
                                                    <!-- <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                                                      <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[tel_no_home]" value="<?php echo @$pers_info['tel_no_home'];?>"/>
                                                    </div> -->
                                                    <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (ที่ติดต่อได้)</label>
                                                      <input title="เบอร์โทรศัพท์ (ที่ติดต่อได้)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="pers_info[tel_no_mobile]" value="<?php echo @$pers_info['tel_no_mobile'];?>"/>
                                                    </div>
                                                   <!--  <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                                                      <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="pers_info[fax_no]" value="<?php echo @$pers_info['fax_no'];?>"/>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                      <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                                                      <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="pers_info[email_addr]" value="<?php echo @$pers_info['email_addr'];?>"/>
                                                    </div> -->
                                                    <div class="col-xs-12 col-sm-3">
                                                           <label for="datetimepicker2" class="col-2 col-form-label" style="color: red;">วันที่เสียชีวิต </label>
                                                         <div id="datetimepicker2" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                             <input title="วันที่เสียชีวิต" placeholder="เลือกวันที่" class="form-control" type="text" name="pers_info[date_of_death]"  required>
                                                             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                         </div>
                                                          <script type="text/javascript">
                                                          <?php
                                                          $tmp = explode('-',@$pers_info['date_of_death']);
                                                          ?>
                                                          $(function () {
                                                          $("#datetimepicker2").datepicker({
                                                            autoclose: true,
                                                            todayHighlight: true,
                                                            format: 'dd/mm/yyyy',
                                                             todayBtn: true,
                                                             language: 'th',
                                                             thaiyear: true
                                                          })<?php if(count($tmp)==3){?>.datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));<?php }?>
                                                          });
                                                          </script>
                                                      </div>
                                                      <div class="col-xs-12 col-sm-6">
                                                        <label>ถึงแก่กรรมด้วยสาเหตุ</label>
                                                         <input type="text" class="form-control" name="fnrl_info[death_cause]" value="<?php echo @$fnrl_info[death_cause]; ?>" placeholder="ระบุสาเหตุการถึงแก่กรรม">
                                                      </div>
                                                  </div>


                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <label for="" class="col-2 col-form-label">ตามใบมรณะบัตรเลขที่</label><br>
                                                        <input type="text" class="form-control" name="fnrl_info[death_certificate_no]" value="<?php echo @$fnrl_info['death_certificate_no']; ?>" placeholder="ระบุใบมรณบัตร">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <label for="" class="col-2 col-form-label">ออกให้โดย</label><br>
                                                        <input type="text" class="form-control" name="fnrl_info[death_certificate_org]" value="<?php echo @$fnrl_info['death_certificate_org']; ?>" placeholder="ระบุหน่วยงานที่ออกใบมรณบัตร">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                         <label for="datetimepicker3" class="col-2 col-form-label" style="color: red;">วันที่ออกใบมรณบัตร </label>
                                                       <div id="datetimepicker3" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                           <input title="วันที่ออกใบมรณบัตร" placeholder="เลือกวันที่" class="form-control" type="text" name="fnrl_info[date_of_death_certificate]" required>
                                                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                       </div>
                                                        <script type="text/javascript">
                                                          <?php
                                                          $tmp = explode('-',@$fnrl_info['date_of_death_certificate']);
                                                          ?>
                                                          $(function () {
                                                          $("#datetimepicker3").datepicker({
                                                            autoclose: true,
                                                            todayHighlight: true,
                                                            format: 'dd/mm/yyyy',
                                                             todayBtn: true,
                                                             language: 'th',
                                                             thaiyear: true
                                                          })<?php if(count($tmp)==3){?>.datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));<?php }?>
                                                          });
                                                        </script>
                                                    </div>

                                                    </div>
                                                  </div>
                                              </div>
                                          </div><!-- close panel-group-->

                                          <div class="panel-group" style="margin-bottom: 0px;">
                                                <div class="panel panel-default" style="border: 0">
                                                    <div class="panel-heading"><h4>ข้อมูลผู้รับรอง (ให้การรับรองผู้รับผิดชอบในการจัดงานศพผู้สูงอายุตามประเพณี)</h4></div>
                                                    <div class="panel-body" style="border:0; padding: 20px;">
                                                        <div class="form-group row">
                                                          <div class="col-xs-12 col-sm-3">
                                                              <img width="70%" src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" style="margin: 0 auto;">
                                                         </div>
                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span> </div>
                                                          <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">
                                                               <div class="input-group" style="width: 295px;">
                                                                    <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text" value="<?php echo @$fnrl_info['req_pers_aprv_pid'];?>" name="fnrl_info[req_pers_aprv_pid]" id="req_pers_aprv_pid" autofocus required/>
                                                                  <div class="input-group-btn" style="padding-bottom: 5px;">
                                                                    <button type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_req_pers_aprv_pid" style="background-color:#F2DEDE; border-radius: 0px; border-color: #ed5565; color: #ed5565;padding:5px 12px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                                  </div>
                                                               </div>
                                                            <input type="hidden" id="req_pers_aprv_pers_id" name="fnrl_info[req_pers_aprv_pers_id]" value="<?php echo $fnrl_info['req_pers_aprv_pers_id'];?>">
                                                          </div>

                                                            <script>
                                                              var req_pers_aprv_pers = null;
                                                              var inputpid3 = "#req_pers_aprv_pid";
                                                              var bt_spid3 = "#bt_req_pers_aprv_pid";
                                                              var setData3 = "reqData3"; //Declear Name
                                                              var reqData3 = function(value) { //Set Structure Display Data
                                                                req_pers_aprv_pers = value;
                                                                $("#req_pers_aprv_name").html(value.name);
                                                                $("#req_pers_aprv_date_of_birth").html(value.date_of_birth);
                                                                $("#req_pers_aprv_gender_name").html(value.gender_name);
                                                                $("#req_pers_aprv_nation_name_th").html(value.nation_name_th);
                                                                $("#req_pers_aprv_relg_title").html(value.relg_title);
                                                                $("#req_pers_aprv_pers_id").val(value.pers_id);
                                                                $("#req_pers_aprv_reg_addr").text(value.reg_add_info);
                                                              }
                                                              $(bt_spid3).click(function(){//On Click for Search
                                                                if($(inputpid3).val()!='') {//pid not null

                                                                 $(bt_spid3).attr('disabled',true);

                                                                  if(pers_authen!=null) { //Check Personal Authen
                                                                    getPersInfo(inputpid3,bt_spid3,setData3); //Get Data
                                                                  }else if(!reader_status) { //Run Reader Personal
                                                                    run_readerPers();
                                                                    $(bt_spid3).attr('disabled',false);
                                                                    toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                                                                  }

                                                                }else { //pid is null
                                                                  $(inputpid3).select();
                                                                }
                                                              });
                                                            </script>
                                                            <!-- <button type="button" title="กรณีไม่มีบัตร" class="btn btn-default" style="">กรณีไม่มีบัตร</button> -->



                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ชื่อตัว/ชื่อสกุล</span></div>
                                                          <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_pers_aprv_name"> <?php echo @$fnrl_info['req_pers_aprv_name'];?> </div>

                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                                                          <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_pers_aprv_date_of_birth"> <?php echo @$fnrl_info['req_pers_aprv_date_of_birth'];?> </div>

                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="req_pers_aprv_gender_name"> <?php echo @$fnrl_info['req_pers_aprv_gender_name'];?> </span> </div>
                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="req_pers_aprv_nation_name_th"> <?php echo @$fnrl_info['req_pers_aprv_nation_name_th'];?> </span> </div>

                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="req_pers_aprv_relg_title"> <?php echo @$fnrl_info['req_pers_aprv_relg_title'];?> </span> </div>

                                                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
                                                          <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="req_pers_aprv_reg_addr"> <?php echo @$fnrl_info['req_pers_aprv_relg_title'];?> </div>
                                                        </div>
                                                        <div class="form-group row">
                                                          <div class="col-xs-12 col-sm-3">
                                                              <label for="datetimepicker4" class="col-2 col-form-label" style="color: red;">วันที่รับรอง </label>
                                                    <div id="datetimepicker4" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                        <input title="วันที่รับรอง" placeholder="เลือกวันที่" class="form-control" type="text" name="fnrl_info[date_of_req_pers_aprv]"  required/>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                      <script type="text/javascript">
                                                                <?php
                                                                $tmp = explode('-',@$fnrl_info['date_of_req_pers_aprv']);
                                                                ?>
                                                                $(function () {
                                                                $("#datetimepicker4").datepicker({
                                                                  autoclose: true,
                                                                  todayHighlight: true,
                                                                  format: 'dd/mm/yyyy',
                                                                   todayBtn: true,
                                                                   language: 'th',
                                                                   thaiyear: true
                                                                })<?php if(count($tmp)==3){?>.datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));<?php }?>
                                                                });
                                                      </script>
                                                          </div>
                                                          <div class="col-xs-12 col-sm-3">
                                                              <label for="" class="col-2 col-form-label">ตำแหน่ง</label>
                                                              <input title="ตำแหน่ง" placeholder="ระบุตำแหน่ง" class="form-control" type="text" name="fnrl_info[req_pers_aprv_position]" value="<?php echo $fnrl_info['req_pers_aprv_position'];?>"/>
                                                          </div>
                                                          <div class="col-xs-12 col-sm-6">
                                                              <label for="" class="col-2 col-form-label">หน่วยงาน</label>
                                                              <input title="หน่วยงานต้นสังกัด" placeholder="ระบุหน่วยงานต้นสังกัด" class="form-control" type="text" name="fnrl_info[req_pers_aprv_org]" value="<?php echo $fnrl_info['req_pers_aprv_org'];?>"/>
                                                          </div>

                                                </div>
                                                <div class="form-group row">
                                                  <!-- <div class="col-xs-12 col-sm-3">
                                                    <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                                                    <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[req_pers_aprv_tel_no_home]" value="<?php echo $fnrl_info['req_pers_aprv_tel_no_home'];?>"/>
                                                  </div> -->
                                                  <div class="col-xs-12 col-sm-3">
                                                    <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (ที่ติดต่อได้)</label>
                                                    <input title="เบอร์โทรศัพท์ (ที่ติดต่อได้)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="fnrl_info[req_pers_aprv_tel_no_mobile]" value="<?php echo $fnrl_info['req_pers_aprv_tel_no_mobile'];?>"/>
                                                  </div>
                                                 <!--  <div class="col-xs-12 col-sm-3">
                                                    <label for="" class="col-2 col-form-label">เบอร์โทรสาร (แฟกซ์)</label>
                                                    <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[req_pers_aprv_fax_no]" value="<?php echo $fnrl_info['req_pers_aprv_fax_no'];?>"/>
                                                  </div>
                                                  <div class="col-xs-12 col-sm-3">
                                                    <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                                                    <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="fnrl_info[req_pers_aprv_email_addr]" value="<?php echo $fnrl_info['req_pers_aprv_email_addr'];?>"/>
                                                  </div> -->
                                                </div>

                                                    </div><!-- close panel-group-->

                                                    <div class="panel-group" style="margin-bottom: 0px;">
                                                          <div class="panel panel-default" style="border: 0">
                                                              <div class="panel-heading"><h4>ข้อมูลผู้รับรอง (กรณีไม่ได้รับการสำรวจข้อมูลความจำเป็นพื้นฐาน (จปฐ.) ในปีที่เสียชีวิต)</h4></div>
                                                              <div class="panel-body" style="border:0; padding: 20px;">
                                                                  <div class="form-group row">
                                                                    <div class="col-xs-12 col-sm-3">
                                                                          <img width="70%" src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" style="margin: 0 auto;">
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold; color: red;">เลขประจำตัวประชาชน</span> </div>
                                                                    <div class="col-xs-12 col-sm-6 has-error" style="padding: 3px 15px;">
                                                                      <div class="input-group" style="width: 295px;">
                                                                           <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard" type="text" value="<?php echo @$fnrl_info['not_survey_aprv_pid'];?>" name="fnrl_info[not_survey_aprv_pid]" id="not_survey_aprv_pid" autofocus required/>
                                                                           <input type="hidden" id="not_survey_aprv_pers_id" name="fnrl_info[not_survey_aprv_pers_id]" value="<?php echo @$fnrl_info['not_survey_aprv_pers_id'];?>">

                                                                          <div class="input-group-btn" style="padding-bottom: 5px;">
                                                                             <button type="button" title="ตรวจสอบ" class="btn btn-default" id="bt_not_survey_aprv_pid" style="background-color:#F2DEDE; border-radius: 0px; border-color: #ed5565; color: #ed5565;padding:5px 12px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                                          </div>
                                                                      </div>
                                                                      </div>
                                                                      <script>
                                                                        var req_pers_aprv_pers = null;
                                                                        var inputpid4 = "#not_survey_aprv_pid";
                                                                        var bt_spid4 = "#bt_not_survey_aprv_pid";
                                                                        var setData4 = "reqData4"; //Declear Name
                                                                        var reqData4 = function(value) { //Set Structure Display Data
                                                                          req_pers_aprv_pers = value;
                                                                          $("#not_survey_aprv_name").html(value.name);
                                                                          $("#not_survey_aprv_date_of_birth").html(value.date_of_birth);
                                                                          $("#not_survey_aprv_gender_name").html(value.gender_name);
                                                                          $("#not_survey_aprv_nation_name_th").html(value.nation_name_th);
                                                                          $("#not_survey_aprv_relg_title").html(value.relg_title);
                                                                          $("#not_survey_aprv_pers_id").val(value.pers_id);
                                                                          $("#not_survey_aprv_reg_addr").text(value.reg_add_info);
                                                                        }
                                                                        $(bt_spid4).click(function(){//On Click for Search
                                                                          if($(inputpid4).val()!='') {//pid not null

                                                                           $(bt_spid4).attr('disabled',true);

                                                                            if(pers_authen!=null) { //Check Personal Authen
                                                                              getPersInfo(inputpid4,bt_spid4,setData4); //Get Data
                                                                            }else if(!reader_status) { //Run Reader Personal
                                                                              run_readerPers();
                                                                              $(bt_spid4).attr('disabled',false);
                                                                              toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                                                                            }

                                                                          }else { //pid is null
                                                                            $(inputpid4).select();
                                                                          }
                                                                        });
                                                                      </script>

                                                                      <!-- <button type="button" title="กรณีไม่มีบัตร" class="btn btn-default" style="">กรณีไม่มีบัตร</button> -->



                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ชื่อตัว/ชื่อสกุล</span></div>
                                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="not_survey_aprv_name"> <?php echo @$fnrl_info['not_survey_aprv_name'];?> </div>

                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">วันเดือนปีเกิด</span></div>
                                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="not_survey_aprv_date_of_birth"> <?php echo @$fnrl_info['not_survey_aprv_date_of_birth'];?> </div>

                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เพศ</span> <span id="not_survey_aprv_gender_name"> <?php echo @$fnrl_info['not_survey_aprv_gender_name'];?> </span> </div>
                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="not_survey_aprv_nation_name_th"> <?php echo @$fnrl_info['not_survey_aprv_nation_name_th'];?> </span> </div>

                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="not_survey_aprv_relg_title"> <?php echo @$fnrl_info['not_survey_aprv_relg_title'];?> </span> </div>

                                                                    <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ตามทะเบียนบ้าน</span></div>
                                                                    <div class="col-xs-12 col-sm-6" style="padding: 7px 15px;" id="not_survey_aprv_reg_addr"> - </div>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                    <div class="col-xs-12 col-sm-3">
                                                                        <label for="datetimepicker5" class="col-2 col-form-label" style="color: red;">วันที่รับรอง </label>
                                                              <div id="datetimepicker5" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                                                                  <input title="วันที่รับรอง" placeholder="เลือกวันที่" class="form-control" type="text" name="fnrl_info[date_of_not_survey_aprv]" required/>
                                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                              </div>
                                                                <script type="text/javascript">
                                                                <?php
                                                                $tmp = explode('-',@$fnrl_info['date_of_not_survey_aprv']);
                                                                ?>
                                                                $(function () {
                                                                $("#datetimepicker5").datepicker({
                                                                  autoclose: true,
                                                                  todayHighlight: true,
                                                                  format: 'dd/mm/yyyy',
                                                                   todayBtn: true,
                                                                   language: 'th',
                                                                   thaiyear: true
                                                                })<?php if(count($tmp)==3){?>.datepicker('update', new Date(Date.UTC(<?php echo $tmp[2];?>,<?php echo $tmp[1];?>-1,<?php echo $tmp[0];?>)));<?php }?>
                                                                });
                                                                </script>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-3">
                                                                        <label for="" class="col-2 col-form-label">ตำแหน่ง</label>
                                                                        <input title="ตำแหน่ง" placeholder="ระบุตำแหน่ง" class="form-control" type="text" name="fnrl_info[not_survey_aprv_position]" value="<?php echo @$fnrl_info['not_survey_aprv_position'];?>"/>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-6">
                                                                        <label for="" class="col-2 col-form-label">หน่วยงาน</label>
                                                                        <input title="หน่วยงานต้นสังกัด" placeholder="ระบุหน่วยงานต้นสังกัด" class="form-control" type="text" name="fnrl_info[not_survey_aprv_org]" value="<?php echo @@$fnrl_info['not_survey_aprv_org'];?>"/>
                                                                    </div>

                                                          </div>
                                                          <div class="form-group row">
                                                            <!-- <div class="col-xs-12 col-sm-3">
                                                              <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (บ้าน)</label>
                                                              <input title="เบอร์โทรศัพท์ (บ้าน)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[not_survey_aprv_tel_no_home]" value="<?php echo @$fnrl_info['not_survey_aprv_tel_no_home'];?>"/>
                                                            </div> -->
                                                            <div class="col-xs-12 col-sm-3">
                                                              <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (ที่ติดต่อได้)</label>
                                                              <input title="เบอร์โทรศัพท์ (ที่ติดต่อได้)" placeholder="ตัวอย่าง 08XXXXXXXX" class="form-control" type="text" name="fnrl_info[not_survey_aprv_tel_no_mobile]" value="<?php echo @$fnrl_info['not_survey_aprv_tel_no_mobile'];?>"/>
                                                            </div>
                                                            <!-- <div class="col-xs-12 col-sm-3">
                                                              <label for="" class="col-2 col-form-ที่ติดต่อได้abel">เบอร์โทรสาร (แฟกซ์)</label>
                                                              <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="fnrl_info[not_survey_aprv_fax_no]" value="<?php echo @$fnrl_info['not_survey_aprv_fax_no'];?>"/>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3">
                                                              <label for="" class="col-2 col-form-label">ที่อยู่อีเมล</label>
                                                              <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="fnrl_info[not_survey_aprv_email_addr]" value="<?php echo @$fnrl_info['not_survey_aprv_email_addr'];?>"/>
                                                            </div> -->
                                                          </div>

                                                              </div><!-- close panel-group-->
<!--
                                          <div class="panel-group" style="margin-bottom: 0px;">
                                                <div class="panel panel-default" style="border: 0">
                                                    <div class="panel-heading"><h4>เอกสารแนบ</h4></div>
                                                    <div class="panel-body" style="border:0; padding: 20px;">
                                                      <div class="form-group row">
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <label for="" class="col-2 col-form-label">สำเนาบัตรประจำตัวประชาชน (ของผู้สูงอายุที่เสียชีวิต)</label>

                                                                </div>
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <input type="file">
                                                                </div>
                                                        </div>
                                                      <div class="form-group row">
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <label for="" class="col-2 col-form-label">สำเนาใบมรณบัตร (ของผู้สูงอายุที่เสียชีวิต)</label>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <input type="file">
                                                                </div>
                                                        </div>
                                                      <div class="form-group row">
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <label for="" class="col-2 col-form-label">แบบคำขอรับเงินสงเคราะห์ในการจัดการงานศพผู้สูงอายุตามประเพณี (แบบ ศผส.01)</label>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6">
                                                                    <input type="file">
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                          </div>
-->



                                                    </div>
                                                </div>
                                      </div>

                                    <?php
                                    echo form_close();
                                    ?>

                                    </div>


                                </div>

                                <hr style="margin-top: 0px;">
                                <div class="row">
                                 <div class="col-xs-12 col-sm-8">&nbsp;</div>
                                 <div class="col-xs-12 col-sm-2">
                                  <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-save" onclick="return opnCnfrom()"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                  <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-cancel" onclick="window.location.href='<?php echo site_url('funeral/funeral_list');?>'"><i class="fa fa-undo" aria-hidden="true"></i> ย้อนกลับ</button>
                                </div>
                              </div><!-- close class row-->

                            </div>

                           </div>
                            <div id="tab-2" <?php if($usrpm['app_id']==23){?> class="tab-pane active" <?php }else{?> class="tab-pane"<?php } ?>>
                                <div class="panel-body">
                                    <strong>Tab-2</strong>
                                </div>
                            </div>






                    </div>
                </div>
            </div>
<script type="text/javascript">

  $(document).ready(function () {
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
      increaseArea: '20%'
    });
  });

  function set_enable(elem,target='') {
    if(elem.prop('checked') == true) {
      $(target).prop('disabled', false ).focus();
    }else{
      $(target).val('');
      $(target).prop('disabled', true );
    }
  }

  <?php if($process_action == 'Edited'){ ?>
    setTimeout(function(){$("#Province").val('<?php echo @$addr_info['province_code']; ?>').trigger('change');},200);
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

 <!-- Modal -->
  <div class="modal fade" id="modal_marker" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(56,145,209);color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-map-marker" aria-hidden="true"></i> ค้นหาสถานที่</h4>
        </div>
        <div class="modal-body">

      <form name="form_search" method="post" action="">

      <b>ชื่อสถานที่</b>
        <div class="row">
          <div class="col-xs-12 col-sm-10">
              <input name="namePlace" class="form-control" size="70" type="text" id="namePlace" size="30" />
              <input type="hidden" name="address" id="namePlace2">
          </div>
          <div class="col-xs-12 col-sm-2">
                        <a href="#" class="btn btn-default btn-search" style="width: 100%; margin-top: 0px; color:#fff" name="SearchPlace" id="SearchPlace" value="ค้นหา" ><i style='font-size:14px;' class="fa fa-search" aria-hidden="true"></i> ค้นหา
                        </a>
            </div>
        </div>
       </form>

      <hr />

      <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">
        <div class="row">
          <div class="col-xs-6 col-sm-5">
            ละติจูด <input class="form-control" name="lat_value" type="text" id="lat_value" value="0" size="20" readonly />
          </div>
          <div class="col-xs-6 col-sm-5">
            ลองจิจูด <input class="form-control" name="lon_value" type="text" id="lon_value" value="0" size="20" readonly />
          </div>
          <div class="col-xs-12 col-sm-2">
                        <a href="#" class="btn btn-default btn-save" style="margin-top: 22px; width: 100%; color:#fff" name="button" id="button" onclick="select_location();" value="บันทึก" ><i style='font-size:14px;' class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                        </a>
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
    $("#row2_date_of_death").html("<span style='color:green'>"+info.date_of_death+"</span>");
    $("#row2_state").html("<i class='fa fa-check text-navy'></i>");
  }else {
    info.date_of_death = info.date_of_death==''?'-':info.date_of_death;
    $("#row2_date_of_death").html("<span style='color:red'>"+info.date_of_death+"</span>");
    $("#row2_state").html("<i class='fa fa-times text-danger'></i>");
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
            $("#accountJPTH").html("");
            $("<option value=''>ไม่พบข้อมูล.</option>").appendTo($("#accountJPTH"));
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
          $("#accountJPTH").html("");
          $("<option value=''>ไม่พบข้อมูล.</option>").appendTo($("#accountJPTH"));
          $("#row3_state").html("<i class='fa fa-exclamation-triangle text-danger'></i>");
        }
      },
      error:function() { //Result Error
        toastr.error("ดึงข้อมูลความจำเป็นพื้นฐาน (จปฐ.)ล้มเหลว","หน้าต่างแจ้งเตือน");
        $("#accountJPTH").html("");
        $("<option value=''>ไม่พบข้อมูล.</option>").appendTo($("#accountJPTH"));
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

  /*
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
  */

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
