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
var csrf_hash ='<?php echo @$csrf['hash'];?>';
var proj_id   = <?php echo uri_seg(4); ?>
</script>

<?php //diearray($wisd_proj_info);?>
<div class="row">
  <div class="col-lg-12">
    <div class="tabs-container">
      <ul class="nav nav-tabs">
      </ul>

      <div class="tab-content">
        <div id="tab-1">
          <div class="panel-body" style="font-size: 16px;">

            <?php
                $wisd_id = '';
                if($process_action=='Add')$process_action = 'Added';
                if($process_action=='Edit'){$process_action = 'Edited'; $wisd_id = '/'.uri_seg(4);}
                echo form_open_multipart('intelprop/intelprop_info/'.$process_action.$wisd_id);
                ?>
                <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->
                <input type="text" value="submit" name="bt_submit" hidden="hidden">

                <?php echo validation_errors('<div class="error fontrequired" style="font-size: 18px; padding-left: 20px">', '</div>'); ?>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 "><font class="fontrequired">ชื่อโครงการ/กิจกรรม:</font></div>
             <div class="col-xs-12 col-sm-9 has-error"><input type="text" class="form-control" name="wisd_proj_info[proj_title]" value="<?php echo $wisd_proj_info['proj_title']; ?>"></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 "><font class="fontrequired">พื้นที่ดำเนินการ:</font></div>
             <div class="col-xs-12 col-sm-9 has-error"><input type="text" class="form-control" name="wisd_proj_info[operation_area]" value="<?php echo $wisd_proj_info['operation_area']; ?>" placeholder="ระบุชื่อสถานที่ดำเนินการ" ></div>
           </div>

           <div class="form-group row">
              <div class="col-xs-12 col-sm-3 col-sm-offset-3">
                <label for="" class="col-2 col-form-label"><font class="fontrequired">บ้านเลขที่</font></label>
              </div>
              <div class="col-xs-12 col-sm-3 ">

               <input title="บ้านเลขที่" placeholder="ตัวอย่าง xxx/xx" class="form-control " type="text" name="wisd_proj_info[addr_home_no]" id="addr_home_no" value="<?php echo @$wisd_proj_info['addr_home_no']; ?>"  required/>
             </div>
             <div class="col-xs-12 col-sm-1">
              <label for="" class="col-2 col-form-label"><font class="fontrequired">หมู่ที่</font></label>
            </div>
            <div class="col-xs-12 col-sm-1 ">
              <input title="หมู่ที่" placeholder="" class="form-control elder_addr_pre" type="text" name="wisd_proj_info[addr_moo]" id="addr_moo" value="<?php echo @$wisd_proj_info['addr_moo']; ?>" required/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xs-12 col-sm-3 col-sm-offset-3 dropdown">
              <label for="example-text-input" class="col-2 col-form-label"><font class="fontrequired">ตรอก</font></label>
            </div>
            <div class="col-xs-12 col-sm-6 dropdown ">
             <input id="alley" title="ตรอก" placeholder="ตัวอย่าง บ้านหล่อ" class="form-control elder_addr_pre" type="text" name="wisd_proj_info[addr_alley]" value="<?php echo @$wisd_proj_info['addr_alley']; ?>" required/>
           </div>
         </div>

         <div class="form-group row">
          <div class="col-xs-12 col-sm-3 col-sm-offset-3 dropdown">
            <label for="example-text-input" class="col-2 col-form-label"><font class="fontrequired">ซอย</font></label>
          </div>
          <div class="col-xs-12 col-sm-6 dropdown ">
            <input id="lane" title="ซอย" placeholder="ตัวอย่าง วรพงษ์" class="form-control elder_addr_pre" type="text" name="wisd_proj_info[addr_lane]" value="<?php echo @$wisd_proj_info['addr_lane']; ?>" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3 col-sm-offset-3 dropdown">
            <label for="example-text-input" class="col-2 col-form-label"><font class="fontrequired">ถนน</font></label>
          </div>
          <div class="col-xs-12 col-sm-6 dropdown ">
            <input id="road" title="ถนน" placeholder="ตัวอย่าง ปรินายก" class="form-control elder_addr_pre" type="text" name="wisd_proj_info[addr_road]" value="<?php echo @$wisd_proj_info['addr_road']; ?>" />
          </div>
        </div>

        <div class="form-group row">
           <div class="col-xs-12 col-sm-3 col-sm-offset-3 "><font class="fontrequired">จังหวัด</font></div>
             <div class="col-xs-12 col-sm-3 ">
               <select title="จังหวัด" placeholder="เลือกจังหวัด" class="form-control elder_addr_pre" id="Province" name="wisd_proj_info[addr_province]" onchange="optionGen(this,'Amphur',<?php echo @$wisd_proj_info['district_code']; ?>);">
                <option value="">เลือกจังหวัด</option>
                <?php $temp = $this->personal_model->getAll_Province();
                foreach ($temp as $key => $row) { ?>
                <option value="<?php echo $row['area_code']; ?>" ><?php echo $row['area_name_th']; ?></option>
                <?php  } ?>
              </select>
             </div>
        </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3 "><font class="fontrequired">อำเภอ</font></div>
             <div class="col-xs-12 col-sm-3 ">
               <select title="อำเภอ" placeholder="เลือกอำเภอ" class="form-control elder_addr_pre" id="Amphur" name="wisd_proj_info[addr_district]" onchange="optionGen(this,'Tambon',<?php echo @$wisd_proj_info['sub_district_code']; ?>);" disabled>
                 <option value="">เลือกอำเภอ</option>
               </select>
             </div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3 "><font class="fontrequired">ตำบล</font></div>
             <div class="col-xs-12 col-sm-3">
               <select title="ตำบล" placeholder="เลือกตำบล" class="form-control elder_addr_pre" id="Tambon" name="wisd_proj_info[addr_sub_district]" disabled>
                  <option value="">เลือกตำบล</option>
               </select>
             </div>
              <div class="col-xs-12 col-sm-2 dropdown" style="width: 10%">
                  <label for="" class="col-2 col-form-label">รหัสไปรษณีย์</label>
                </div>
                <div class="col-xs-12 col-sm-1 " style="width: 15%">
                  <input title="รหัสไปรษณีย์" placeholder="ระบุรหัสไปรษณีย์" class="form-control numberZipcode" type="text" name="wisd_proj_info[addr_zipcode]" id="addr_zipcode" value="<?php echo @$wisd_proj_info['addr_zipcode']; ?>" />
                </div>
           </div>

           <div class="form-group row">
            <div class="col-xs-12 col-sm-3">
              <font for="datetimepicker1" class="col-2 col-form-label fontrequired" >วันที่ดำเนินการ:</font>
            </div>
            <div class="col-xs-12 col-sm-3">
              <div id="datetimepicker1" class="col-10 input-group date has-error" data-date-format="dd-mm-yyyy">
                <input title="วันที่ดำเนินการ" placeholder="เลือกวันที่" class="form-control" type="text" name="wisd_proj_info[date_of_operate]" value="" required="">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
              <script type="text/javascript">
                $(function () {
                  $("#datetimepicker1").datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    todayBtn: true,
                    language: 'th',
                    thaiyear: true
                  }).datepicker('update', new Date(Date.UTC(2017,09-1,25)));});
                </script>
              </div>
            </div>

            <div class="form-group row">
             <div class="col-xs-12 col-sm-3"><font>งบประมาณที่ใช้ (บาท):</font></div>
             <div class="col-xs-12 col-sm-3 "><input type="text" class="form-control numeric" name="wisd_proj_info[proj_budget]" value="<?php echo $wisd_proj_info['proj_budget']; ?>"  placeholder="0,000.00"></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3"><font>ผู้รับผิดชอบโครงการ:</font></div>
             <div class="col-xs-12 col-sm-3 ">
                <select class="form-control selectized" id="user_prename" name="wisd_proj_info[resp_pren_code]" tabindex="-1" >
                  <option value="">เลือกคำนำหน้า</option>
                  <?php foreach($prename as $key=>$value) {?>
                  <option value="<?php echo $value['pren_code']; ?>" <?php if($wisd_proj_info['resp_pren_code']==$value['pren_code']){ echo "selected"; } ?> ><?php echo $value['prename_th']; ?></option>
                  <?php } ?>
                </select>
             </div>
             <div class="col-xs-12 col-sm-3 ">
                <input type="text" name="wisd_proj_info[resp_firstname_th]" value="<?php echo $wisd_proj_info['resp_firstname_th']; ?>" class="form-control" value="" placeholder="ระบุชื่อตัว">
             </div>
             <div class="col-xs-12 col-sm-3 ">
                <input type="text" name="wisd_proj_info[resp_lastname_th]" value="<?php echo $wisd_proj_info['resp_lastname_th']; ?>" class="form-control" value="" placeholder="ระบุนามสกุล">
             </div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>ตำแหน่ง</font></div>
             <div class="col-xs-12 col-sm-6 "><input type="text" class="form-control" name="" placeholder="ระบุตำแหน่ง"></div>
           </div>

            <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>เบอร์โทรศัพท์ (ที่ติดต่อได้)</font></div>
             <div class="col-xs-12 col-sm-3 "><input type="text" title="เบอร์โทรศัพท์ (ที่ติดต่อได้)" class="form-control" name="wisd_proj_info[tel_no]" value="<?php echo $wisd_proj_info['tel_no']; ?>" placeholder="ตัวอย่าง 08XXXXXXXX"></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>ที่อยู่อีเมล</font></div>
             <div class="col-xs-12 col-sm-3 "><input type="text" title="ที่อยู่อีเมล" class="form-control" name="wisd_proj_info[email_addr]" value="<?php echo $wisd_proj_info['email_addr']; ?>" placeholder="ตัวอย่าง me@gmail.com"></div>
           </div>

           <hr>
           <div class="form-group row">
             <div class="col-xs-12 col-sm-3"><font>วิทยากรภูมิปัญญา:</font></div>
             <div class="col-xs-12 col-sm-2 col-sm-offset-7">
                    <!-- <button class="btn btn-default form-control" ><i style="font-size:14px;" class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button>              -->
               <button type="button" class=" btn btn-primary btn-add" title="เพิ่มรายการ" style="float: right;" data-toggle="modal" data-target="#add_intelprop"><i style="font-size:14px;" class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button>
             </div>
           </div>

            <div class="form-group row">
             <div class="col-xs-12 col-sm-9 col-sm-offset-3">
              <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" style="margin-top: 0px !important; width:100% !important;">
                <thead style="font-size: 15px;">
                  <tr>
                    <th style="width:20% !important; border-left-color: #072b42;">เลขประจำตัว ปชช.</th>
                    <th style="width:24% !important;">(คำนำหน้า) ชื่อตัว-ชื่อสกุล</th>
                    <th style="width:7% !important;">อายุ (ปี)</th>
                    <th style="width:14% !important;">เบอร์โทรศัพท์</th>
                    <th style="width:23% !important;">เชี่ยวชาญเรื่อง</th>
                    <th style="width:2% !important;">&nbsp;</th>
                  </tr>
                </thead>
                <tbody id="content_expert">

                </tbody>
              </table>
             </div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3"><font>กลุ่มเป้าหมายที่เข้าร่วม(ราย):</font></div>
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>(เพศชาย)</font></div>
             <div class="col-xs-12 col-sm-3 "><font>(เพศหญิง)</font></div>
           </div>

          <?php
                $age = array("กลุ่มอายุ (0-18 ปี)","กลุ่มอายุ (19-25 ปี)","กลุ่มอายุ (26-59 ปี)","กลุ่มอายุ (60 ปีขึ้นไป)");
                $name_man = array("target_grp_male_0_18","target_grp_male_19_25","target_grp_male_26_59","target_grp_male_60");
                $name_female = array("target_grp_female_0_18","target_grp_female_19_25","target_grp_female_26_59","target_grp_female_60");
                foreach ($age as $key => $value) {
          ?>
           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font><?php echo $value; ?></font></div>
               <div class="col-xs-12 col-sm-3 "><input  type="text"  class="form-control check_man_fe"  name="wisd_proj_info[<?php echo $name_man[$key]; ?>]"    value="<?php echo $wisd_proj_info[$name_man[$key]]; ?>"       placeholder="จำนวน(ราย)"></div>
               <div class="col-xs-12 col-sm-3 "><input  type="text"  class="form-control check_man_fe"  name="wisd_proj_info[<?php echo $name_female[$key]; ?>]" value="<?php echo $wisd_proj_info[$name_female[$key]]; ?>"    placeholder="จำนวน(ราย)"></div>

           </div>
           <?php } ?>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>รวมทั้งหมด</font></div>
             <div class="col-xs-12 col-sm-6 "><font id="sum_target_grp"></font></div>
           </div>

           <hr>
           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 "><font>ขั้นตอนการติดตามผล:</font></div>
             <div class="col-xs-12 col-sm-9 "><textarea rows="5" name="wisd_proj_info[follow_up_process]" value="" class="form-control"><?php echo $wisd_proj_info['follow_up_process']; ?></textarea></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 "><font>ผลสัมฤทธิ์:</font></div>
             <div class="col-xs-12 col-sm-3 "><font>ผลผลิต:</font></div>
             <div class="col-xs-12 col-sm-6 "><textarea rows="5" name="wisd_proj_info[proj_achv_product]" value="" class="form-control"><?php echo $wisd_proj_info['proj_achv_product']; ?></textarea></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font>ผลลัพธ์:</font></div>
             <div class="col-xs-12 col-sm-6 "><textarea rows="5" name="wisd_proj_info[proj_achv_result]" value="" class="form-control"><?php echo $wisd_proj_info['proj_achv_result']; ?></textarea></div>
           </div>

           <div class="form-group row">
             <div class="col-xs-12 col-sm-3 "><font>การวิเคราะห์จุดแข็ง/จุดอ่อน:<br>(SWAT Analysis)</font></div>
             <div class="col-xs-12 col-sm-3 "><font>จุดแข็ง (Strengths)</font></div>
             <div class="col-xs-12 col-sm-6"><textarea rows="5" name="wisd_proj_info[swat_strengths]" value="" class="form-control"><?php echo $wisd_proj_info['swat_strengths']; ?></textarea></div>
           </div>

           <?php
           $analysis = array("จุดอ่อน (Weaknesses)","โอกาส (Opportunities)","อุปสรรค (Threats)","สรุปแนวทางแก้ไขให้ยั่งยืน");
           $name_analysis = array("swat_weaknesses","swat_opportunities","swat_threats","swat_suggestion");
           foreach ($analysis as $key => $value) {
            ?>
            <div class="form-group row">
             <div class="col-xs-12 col-sm-3 col-sm-offset-3"><font><?php echo $value; ?></font></div>
             <div class="col-xs-12 col-sm-6"><textarea rows="5" name="wisd_proj_info[<?php echo $name_analysis[$key]; ?>]" class="form-control"><?php echo $wisd_proj_info[$name_analysis[$key]]; ?></textarea></div>

           </div>

           <?php } ?>


           <hr>
           <div class="row">
            <div class="col-xs-12 col-sm-8">&nbsp;</div>
            <div class="col-xs-12 col-sm-2">
              <button style="height: 40px;width: 100% !important;" type="submit" class="btn btn-primary btn-save" ><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
            </div>
            <div class="col-xs-12 col-sm-2">
              <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-cancel" onclick="window.location.href='<?php echo site_url('intelprop/intelprop_list1');?>'"><i class="fa fa-undo" aria-hidden="true"></i> ย้อนกลับ</button>
            </div>
          </div><!-- close class row-->
           <?php echo form_close(); ?>

          </div> <!-- END panel-body -->
        </div> <!-- END tab-1 -->
      </div> <!-- END tab-content -->

    </div><!-- END tabs-container-->

  </div> <!-- END col-lg-12 -->
</div> <!-- END ROW -->

<script>
    // $('.check_man_fe').focus(function(){
    //      var sum=0;
    //      $('.check_man_fe').each(function(){
    //         sum += parseInt($(this).val());
    //     });
    //      $('#sum').text(sum+' ราย');
    // });
</script>

<!-- onclick="return opnCnfrom()" -->
  <!--  Modal -->

  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="add_intelprop">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h6 class="modal-title">วิทยากรภูมิปัญญา</h6>
        </div>
        <div class="modal-body" style="font-size: 16px;">


         <div class="form-group row">
          <!-- <div class="col-xs-12 col-sm-3"><img src="<?php echo path('noProfilePic.jpg','member');?>" class="img-responsive" style="margin: 0 auto; width: 70%;"></div> -->
          <div class="col-xs-12 col-sm-3"><font class="fontrequired" >เลขประจำตัวประชาชน:</font></div>
          <div class="col-xs-12 col-sm-5 has-error">
            <div class="input-group">
              <input  title="เลขประจำตัวประชาชน" placeholder="เลขประจำตัวประชาชน (13 หลัก)" class="form-control input_idcard elder_same_req" type="text" id="req_pid" name="" value="" />
              <input type="hidden" id="pers_id" name="wisd_info[pers_id]" value="">

              <div class="input-group-btn" style=" padding-bottom: 5px;">
                <button type="button" title="ตรวจสอบ" class="btn btn-default elder_same_req " id="bt_req_pid" style="background-color:#F2DEDE;  border-radius: 0px; border-color: #ed5565;color: #ed5565;padding:5px 12px;"><i class="fa fa-search" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3"></div>
        </div>

        <div class="content_view_search" style="display: none;">
                  <div class="form-group row">
                    <div class="col-xs-12 col-sm-3" ><span style="font-weight: bold;">(คำนำหน้า) ชื่อตัว-ชื่อสกุล:</span></div>
                    <div class="col-xs-12 col-sm-3"  id="name"></div>
                    <div class="col-xs-12 col-sm-3"><span style="font-weight: bold;">เพศ</span> <span id="gender_name"></span> </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-xs-12 col-sm-3" ><span style="font-weight: bold;">วันเดือนปีเกิด:</span></div>
                    <div class="col-xs-12 col-sm-6"  id="date_of_birth"></div>
                  </div>

                  <div class="form-group row">
                        <!-- <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">สัญชาติ</span> <span id="nation_name_th"> <?php echo @$wisd_info['nation_name_th'];?></span> </div>
                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ศาสนา</span> <span id="relg_title"> <?php echo @$wisd_info['relg_title'];?> </span> </div> -->
                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">ที่อยู่ (ตามทะเบียนบ้าน):</span><input type="hidden" id="reg_addr_id" name="" value=""></div>
                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;">เลขรหัสประจำบ้าน</span></div>
                          <div class="col-xs-12 col-sm-3" style="padding: 7px 15px;"><span style="font-weight: bold;" id="addr_code">xxxx-xxxxxx-x</span></div>
                  </div>

                  <div class="form-group row">
                   <div class="col-xs-12 col-sm-6 col-sm-offset-3" style="padding: 7px 15px;" id="reg_addr"></div>
                 </div>

                  <div class="form-group row">
                      <div class="col-xs-12 col-sm-3 " style="padding: 7px 15px;" ><span style="font-weight: bold;">เบอร์โทรศัพท์(ที่ติดต่อได้):</span></div>
                      <div class="col-xs-12 col-sm-3 " style="padding: 7px 15px;" ><font id="tel_mobile"></font></div>
                 </div>

                 <div class="form-group row" id="content_branch" style="display: none;">
                   <div class="col-xs-12 col-sm-12">

                      <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" style="margin-top: 0px !important; width:100% !important;">
                        <thead style="font-size: 15px;">
                          <tr>
                            <th style="width:4% !important; border-left-color: #072b42;">#</th>
                            <th style="width:20% !important;">ภาพถ่าย</th>
                            <th style="width:38% !important;">สาขาภูมิปัญญา</th>
                            <th style="width:38% !important;">เชี่ยวชาญเรื่อง/วันที่ขึ้นทะเบียน</th>
                          </tr>
                        </thead>
                        <tbody id="content_bodytable">
                      </tbody>
                    </table>

                   </div>
                 </div>

          </div> <!-- content_view_search -->


        </div>
        <div class="modal-footer">
            <div class="row">
              <div class="col-xs-12 col-sm-2 col-sm-offset-10">
                    <button style="height: 40px;width: 100% !important;" type="button" data-dismiss="modal" class="btn btn-primary btn-save" id="btn_expert"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
              </div>
            </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- END Modal -->

<!-- *****************************************************body*js*********************************************************************************** -->
<script type="text/javascript">
   $(function(){
      $('select.elder_addr_pre').select2();
   });

  <?php if($process_action == 'Edited'){ ?>
    setTimeout(function(){$("#Province").val('<?php echo @$wisd_proj_info['addr_province']; ?>').trigger('change');},200);
    setTimeout(function(){$("#Amphur").val('<?php echo @$wisd_proj_info['addr_district']; ?>').trigger('change');},3000);
    setTimeout(function(){$("#Tambon").val('<?php echo @$wisd_proj_info['addr_sub_district']; ?>').trigger('change');},5000);

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
    //console.dir(ret);
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
              //console.log(ret);

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

          //set font red
          $('.fontrequired').each(function(){
            $(this).css({"color":"red","font-weight":"600"});
          });
        </script>

        <script type="text/javascript">
            setInterval(function(){
                       var sum=0;
                       $('.check_man_fe').each(function(){

                           if($(this).val()!=''){
                              sum+=parseInt($(this).val());
                           }
                       });
                       $('#sum_target_grp').text(sum.toLocaleString()+" ราย");
            },1000);
        </script>

          <script>
                          var req_pers = null;
                          var inputpid = "#req_pid";
                          var bt_spid = "#bt_req_pid";
                          var setData = "reqData"; //Declear Name

                      // $("input[name='elder_addr_chk']").prop('disabled',true);

                      var reqData = function(value) { //Set Structure Display Data
                        req_pers = value;

                        $("#name").html(value.name);
                        $("#date_of_birth").html(value.date_of_birth);
                        $("#gender_name").html(value.gender_name);
                        // $("#nation_name_th").html(value.nation_name_th);
                        // $("#relg_title").html(value.relg_title);
                        $("#pers_id").val(value.pers_id);
                        $("#reg_addr_id").val(req_pers.reg_addr_id);
                        $("#reg_addr").text(value.reg_add_info);

                        $('#addr_code').text(req_pers.reg_addr.addr_code);
                        $('#gps_addr').text(req_pers.reg_addr.addr_gps);

                        $('#tel_mobile').text(req_pers.tel_no);

                    }


                      $(bt_spid).click(function(){//On Click for Search
                          if($(inputpid).val()!='') {//pid not null

                                check_pid_persinfo(inputpid);
                          }else { //pid is null
                            $(inputpid).select();
                          }
                        });

                      <?php
                      if(isset($Valid)){
                        ?>
                        setTimeout(function(){$('#bt_req_pid').trigger('click');},1000);

                        <?php
                      }
                      ?>
                    </script>

                    <script type="text/javascript">

                          var content_bodytable   = $('#content_bodytable');
                          var content_view_search = $('.content_view_search');
                          var content_expert      = $('#content_expert');
                          var content_branch      = $('#content_branch');
                          var btn_expert          = $('#btn_expert');
                          var pers_id             = $('#pers_id');

                      function check_pid_persinfo(pid){
                        var pid_val = $(pid).val();
                        $.ajax({
                          url: base_url+'intelprop/check_pid_persinfo',
                          type: 'POST',
                          dataType: 'json',
                          data: {
                            'proj_id' : proj_id,
                            'pid'     : pid_val,
                            'csrf_dop': csrf_hash
                          },
                                    success: function (value) { //Result True
                                      // console.log(value);
                                                  // console.log(value.data_persinfo);
                                                  if(value.data_persinfo=='true'){
                                                          if(value.repeat_expert=='true'){
                                                             btn_expert.prop('disabled',true);
                                                           toastr.warning("หมายเลขบัตรประจำตัวประชาชนนี้ ได้ขึ้นทะเบียนวิทยากรภูมิปัญญาแล้ว");
                                                         }else{
                                                           toastr.success("พบข้อมูลตามหมายเลขบัตรประจำตัวประชาชน");
                                                         }

                                                         content_view_search.css('display','block');
                                                         var get_value              = value.pers_info;
                                                         if(value.pers_info.gender_name!=null){
                                                           var gender_name        = value.pers_info.gender_name.split(" ");
                                                           get_value.gender_name  = gender_name[0];
                                                         }else{
                                                           get_value.gender_name  = '';
                                                         }

                                                          get_value.reg_addr     = value.addr_info.reg_addr;
                                                          get_value.reg_add_info = value.addr_info.reg_add_info;
                                                          // console.log(get_value);
                                                          reqData(get_value);

                                                          if(value.data_branch=='true'){
                                                             content_branch.css('display','block');
                                                                  var i = 1;
                                                                  for(var key of value.wisd_branch){

                                                                     var text_tr =  '<tr>\
                                                                               <td style="border-left-color: #072b42;">'+i+'</td>'+
                                                                               '<td>';

                                                                                if(key.wisdom_photo_file==null){
                                                                                    text_tr = text_tr+'<div style="background-color: #607D8B;padding: 30px;text-align: center;color: aliceblue;">ภาพถ่าย<br>(หน้าปก)</div>';
                                                                                }else{
                                                                                    text_tr = text_tr+'<img src="<?php echo base_url('assets/modules/intelprop/images');?>'+'/'+key.wisdom_photo_file+'" style="width: 200px;">';
                                                                                 }
                                                                          text_tr = text_tr+'</td><td>'+key.wis_name+'</td><td>'+key.wisd_sp_title+'</td></tr>';




                                                                     content_bodytable.append(text_tr);
                                                                  }
                                                              }



                                                    }else{
                                                         $('.content_view_search').css('display','none');
                                                    // check_authen
                                                    $(bt_spid).attr('disabled',true);
                                                    $("input[name='elder_addr_chk']").prop('disabled',false);
                                                        if(pers_authen!=null) { //Check Personal Authen
                                                            getPersInfo(inputpid,bt_spid,setData,true); //Get Data
                                                        }else if(!reader_status) { //Run Reader Personal
                                                          run_readerPers();
                                                          $(bt_spid).attr('disabled',false);
                                                          toastr.warning("ท่านยังไม่ได้ Authen เข้าใช้งานในฐานะเจ้าหน้าที่ ระบบกำลังเชื่อมโยงข้อมูลกับฐานข้อมูลหลัก","Authentications");
                                                        }

                                                      }

                                                    },
                                                  });
                                          }

                                          function clear_content(){
                                             $(inputpid).val('');
                                             pers_id.val('');
                                             content_view_search.css('display','none');
                                             content_branch.css('display','none');
                                             // content_bodytable.children().remove();

                                             if(btn_expert.prop('disabled')){
                                               btn_expert.prop('disabled',false);
                                             }

                                          }

                                          btn_expert.click(function(){
                                              if($(inputpid).val()!='') {//pid not null
                                                 if(pers_id.val()!=''){
                                                  $.ajax({
                                                    url: base_url+'intelprop/insert_proj_expert',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                      'proj_id' : proj_id,
                                                      'pers_id' : pers_id.val(),
                                                      'csrf_dop': csrf_hash
                                                    },
                                                    success: function (value) { //Result True

                                                    }
                                                  });
                                                  clear_content()
                                                  show_table_expert();
                                                 }
                                              }
                                          });

                                          function show_table_expert(){
                                             content_expert.children().remove();
                                             $.ajax({
                                                    url: base_url+'intelprop/show_proj_expert',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                      'proj_id' : proj_id,
                                                      'csrf_dop': csrf_hash
                                                    },
                                                    success: function (value) { //Result True
                                                       console.log(value);
                                                          var tel ='';
                                                          if(value.data_expert=='true'){
                                                             var i=1;
                                                             for(var key of value[0]){
                                                                // console.log(key);
                                                                 if(key.tel_no!=null){
                                                                   tel = key.tel_no;
                                                                 }

                                                                 var text_tr = '<tr>\
                                                                        <td style="border-left-color: #072b42;"><font>'+key.pid+'</font></td>\
                                                                        <td><font>'+key.prename_th+key.name+'</font></td>\
                                                                        <td class="text-center"><font>'+key.date_of_birth+'</font></td>\
                                                                        <td class="text-center"><font>'+tel+'</font></td>\
                                                                        <td><font>';
                                                                         if(key.wisd_branch!='false'){
                                                                             for(var val of key.wisd_branch){
                                                                                  text_tr = text_tr+val.wisd_sp_title+'<br>';
                                                                             }
                                                                         }

                                                                      text_tr = text_tr+'</font></td>\
                                                                        <td>\
                                                                              <div class="btn-group" style="cursor: pointer;">\
                                                                              <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>\
                                                                              <ul class="dropdown-menu" style="position: absolute;left: -150px;">\
                                                                                <!-- <li><a style="font-size:16px;"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>-->\
                                                                                <li><a style="font-size:16px;"  onclick="del_expert('+key.pers_id+');" title="ลบ" ><i class="fa fa-trash" style="color: #000"></i> ลบรายการ</a></li>\
                                                                              </ul>\
                                                                            </div>\
                                                                        </td>\
                                                                      </tr>';
                                                                       content_expert.append(text_tr);
                                                              }
                                                          }
                                                       }


                                                  });
                                          }

                                          function del_expert(pers_id){
                                            // console.log(pers_id);
                                               $.ajax({
                                                    url: base_url+'intelprop/del_proj_expert',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                      'proj_id' : proj_id,
                                                      'pers_id' : pers_id,
                                                      'csrf_dop': csrf_hash
                                                    },
                                                    success: function (value) { //Result True

                                                    }

                                                  });
                                               show_table_expert();
                                          }

                                          $('#close_modal').click(function (){
                                               clear_content();
                                          });

                                          <?php if($process_action == 'Edited'){ ?>
                                                      show_table_expert();

                                          <?php }?>
                    </script>
