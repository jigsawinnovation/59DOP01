

<div class="row">
  <div class="col-lg-12">
    <div class="tabs-container">
      <ul class="nav nav-tabs">
          <li >
          <?php
          $tmp = $this->admin_model->getOnce_Application(161);
          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(161,$user_id); //Check User Permission
          ?>
          <!-- <a <?php if(!isset($tmp1['perm_status'])) {?> -->
            <!-- readonly -->
          <!-- <?php }else if($process_action!='Add'){?> href="<?php echo site_url('difficult/sufferer_form1/Edit/'.$diff_info['diff_id']);?>" <?php }?> data-toggle="tab" <?php if($usrpm['app_id']==161){?>aria-expanded="true" <?php }else{?> aria-expanded="false"<?php }?>> ข้อมูลผู้สูงอายุ</a> -->
<<<<<<< HEAD

=======
                   
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          <a  href="<?php echo site_url('intelprop/olderp_info/Edit/'.uri_seg(4));?>"  > ข้อมูลผู้สูงอายุ</a>

        </li>

        <li class="active">
          <?php
          $tmp = $this->admin_model->getOnce_Application(161);
          $tmp1 = $this->admin_model->chkOnce_usrmPermiss(161,$user_id); //Check User Permission
          ?>
<!--           <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else if($process_action!='Add'){?> href="<?php echo site_url('difficult/sufferer_form2/Edit/'.$diff_info['diff_id']);?>" <?php }?> <?php if($usrpm['app_id']==161){?>aria-expanded="true" <?php }?>> ภูมิปัญญา () </a>
<<<<<<< HEAD
 -->
=======
 -->        
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          <a  href="<?php echo site_url('intelprop/olderp_info2/Edit/'.uri_seg(4));?>" > ภูมิปัญญา  </a>

        </li>

      </ul>

      <div class="tab-content">
        <div id="tab-1" <?php if($usrpm['app_id']==161){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
          <div class="panel-body">
<<<<<<< HEAD

=======
              
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
            <div class="from-group row">
             <div class="col-xs-12 col-sm-12">
               <a class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-add" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px; float: right;"  title="เพิ่มรายการ" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ
              </a>
            </div>
          </div>
<<<<<<< HEAD

=======
              
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04

              <div class="table-responsive">
                <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" style="margin-top: 0px !important; width:100% !important;">
                  <thead style="font-size: 15px;">
                    <tr>
                      <th style="width:3% !important; border-left-color: #072b42;">#</th>
                      <th style="width:20% !important;">ภาพถ่าย</th>
<<<<<<< HEAD
                      <th style="width:37% !important;">สาขาภูมิปัญญา</th>
                      <th style="width:37% !important;">เชี่ยวชาญเรื่อง/วันที่ขึ้นทะเบียน</th>
=======
                      <th style="width:37% !important;">สาขาภูมิปัญญา</th>                
                      <th style="width:37% !important;">เชี่ยวชาญเรื่อง/วันที่ขึ้นทะเบียน</th>            
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                      <th style="width:3% !important;">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
<<<<<<< HEAD
                    <?php
                       if(!empty($wisd_branch)){
                           // dieArray($wisd_branch);
                         $i=1;
                         foreach ($wisd_branch as $key => $value) {
                      ?>
                     <tr>
                       <td style="border-left-color: #072b42;" class="text-center"><?php echo $i++; ?></td>
                       <td>
                           <?php

                           $img_head = $this->wisd_model->get_photo_head($value['branch_id']);
                              // dieArray($img_head);

                            if($img_head[0]['result']==0){
=======
                    <?php 
                       if(!empty($wisd_branch)){
                        // dieArray($wisd_branch);
                         $i=0;
                         foreach ($wisd_branch as $key => $value) {
          
                      ?>
                     <tr>
                       <td style="border-left-color: #072b42;"><?php echo $i++; ?></td>
                       <td>
                           <?php 
                           $img_head = $this->common_model->custom_query("SELECT * FROM wisd_photo WHERE branch_id={$value['branch_id']}"); 
                            if(empty($img_head)){
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                            ?>
                           <div style="background-color: #607D8B;padding: 30px;text-align: center;color: aliceblue;">ภาพถ่าย<br>(หน้าปก)</div>
                           <?php }else{ ?>
                           <img src="<?php echo base_url('assets/modules/intelprop/images/'.$img_head[0]['wisdom_photo_file']);?>" style="width: 200px;">
                           <?php } ?>
                       </td>
                       <td><?php echo $value['wis_name']; ?></td>
<<<<<<< HEAD
                       <td><?php echo $value['wisd_sp_title']; ?><br>(วันที่ขึ้นทะเบียน <?php echo $this->wisd_model->convert_date($value['insert_datetime'],'NoAge');?>)</td>
                           <?php
                                $download_file = $this->wisd_model->download_file_branch($value['knwl_id']);
                                // dieArray($download_file);
                            ?>
                       <td class="text-center">
                        <!-- Single button -->
                        <div class="btn-group" style="cursor: pointer;">
                          <i data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>
                          <ul class="dropdown-menu" style="position: absolute;left: -150px;">
                            <li><a style="font-size:16px;"  title="เอกสารแนบ" href="<?php echo base_url('assets/modules/intelprop/uploads/'.$download_file['wisd_sp_file']); ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> เอกสารแนบ</a></li>
                            <li><a style="font-size:16px;" href="<?php echo $value['wisd_sp_url']; ?>" target="_blank" title="ลิงค์ภูมิปัญญา" ><i class="fa fa-chain" style="color: #000"></i> ลิงค์ภูมิปัญญา</a></li>
                            <li><a style="font-size:16px;" onclick="edit_modal(<?php echo $value['knwl_id']; ?>);" title="แก้ไขรายการ"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>
                            <li><a style="font-size:16px;"  title="ลบ" href="<?php echo base_url('intelprop/olderp_info2/Delete/'.$value['branch_id']);?>"><i class="fa fa-trash" style="color: #000"></i> ลบรายการ</a></li>
=======
                       <td><?php echo $value['wisd_sp_title']; ?><!-- <br>(วันที่ขึ้นทะเบียน 23 กันยายน 2560) --></td>
                       <td>
                        <!-- Single button -->
                        <div class="btn-group" style="cursor: pointer;">
                          <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>
                          <ul class="dropdown-menu" style="position: absolute;left: -150px;">
                            <!-- <li><a style="font-size:16px;"  title="พิมพ์แบบฟอร์ม" ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> เอกสารแนบ</a></li> -->
                            <!-- <li><a style="font-size:16px;"  title="ลบ" ><i class="fa fa-chain" style="color: #000"></i> ลิงค์ภูมิปัญญา</a></li> -->
                            <li><a style="font-size:16px;"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>
                            <li><a style="font-size:16px;"  title="ลบ" ><i class="fa fa-trash" style="color: #000"></i> ลบรายการ</a></li>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                          </ul>
                        </div>
                      </td>
                     </tr>
<<<<<<< HEAD
                     <?php
                        }
                      }else{
                     ?>
                     <tr>
                       <td colspan="5" class="text-center">ไม่พบข้อมูล</td>
=======
                     <?php 
                        }
                      }else{ 
                     ?>
                     <tr>
                       <td colspan="5" class="text-center">ไม่พบข้อมูล</td>
                     
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                     </tr>
                     <?php } ?>
                  </tbody>
                </table>
              </div> <!-- END table-responsive -->


          </div> <!-- END panel-body -->
        </div> <!-- END tab-1 -->
      </div> <!-- END tab-content -->

    </div><!-- END tabs-container-->

  </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" id="myModal" >
<<<<<<< HEAD
  <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
=======
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
        <h5 class="modal-title">สาขาภูมิปัญญาและความเชี่ยวชาญ</h5>
      </div>
      <div class="modal-body" style="font-size: 15px;">

           <?php
                $wisd_id = '';
                if($process_action=='Add')$process_action = 'Added';
                if($process_action=='Edit'){$process_action = 'Edited'; $wisd_id = '/'.uri_seg(4);}
                echo form_open_multipart('intelprop/olderp_info2/'.$process_action.$wisd_id);
                ?>
                <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->
                <input type="submit" value="submit" name="bt_submit" hidden="hidden">
<<<<<<< HEAD
                <input type="hidden" value="" name="branch_id" id="branch_id">

=======
         
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          <div class="form-group row">
             <div class="col-xs-12 col-sm-3 ">
                <font color="red">สาขาภูมิปัญญา:</font>
             </div>
             <div class="col-xs-12 col-sm-9 has-error">
<<<<<<< HEAD
                  <select title="สาขาภูมิปัญญา" placeholder="เลือกสาขาภูมิปัญญา" class="form-control" name="wisd_branch[wisd_code]" id="wisd_branch_wisd_code">
=======
                  <select title="สาขาภูมิปัญญา" placeholder="เลือกสาขาภูมิปัญญา" class="form-control" name="wisd_branch[wisd_code]">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                      <option value="">เลือกสาขาภูมิปัญญา</option>
                      <?php
                      $wisdom = $this->common_model->custom_query("SELECT * FROM std_wisdom ");
                      foreach ($wisdom as $key => $value){
                        ?>
                        <option value="<?php echo $value['wis_code'];?>" <?php if($value_branch['wisd_code']==$value['wis_code']){ echo "selected"; }?> >
                          <?php echo $value['wis_name']; ?></option>
                          <?php }?>
                  </select>
             </div>
          </div>
<<<<<<< HEAD

          <div class="form-group row ">
            <div class="col-xs-12 col-sm-3 ">
              <font color="red">เชี่ยวชาญเรื่อง:</font>
            </div>
            <div class="col-xs-12 col-sm-9 has-error">
              <textarea rows="2" cols="50" class="form-control" placeholder="ระบุชื่อเรื่องความเชี่ยวชาญ"  name="wisd_branch[wisd_sp_title]" id="wisd_branch_wisd_sp_title"></textarea>
=======
           
          <div class="form-group row ">
            <div class="col-xs-12 col-sm-3 ">
              <font color="red">เชี่ยวชาญเรื่อง:</font>             
            </div>
            <div class="col-xs-12 col-sm-9 has-error">
              <textarea rows="2" cols="50" class="form-control" placeholder="ระบุชื่อเรื่องความเชี่ยวชาญ"  name="wisd_branch[wisd_sp_title]"></textarea>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
            </div>
          </div>

          <div class="form-group row ">
            <div class="col-xs-12 col-sm-3 ">
<<<<<<< HEAD
              <font color="red">ลิงค์ภูมิปัญญา:</font>
            </div>
            <div class="col-xs-12 col-sm-9 has-error">
              <input type="text" class="form-control" placeholder="ระบุลิงค์ภูมิปัญญา" name="wisd_branch[wisd_sp_url]" id="wisd_branch_wisd_sp_url">

            </div>
          </div>

           <div id="content_file"></div>

           <div class="form-group row">
            <div class="col-xs-12 col-sm-2 col-sm-offset-3">
              <button class="btn btn-primary" type="button" onclick="add_file(this);" style="font-size: 15px !important; width: 100%;"><i class="fa fa-plus"></i> เพิ่มไฟล์</button>
            </div>
          </div>

           <div class="form-group row">
            <div class="col-xs-12 col-sm-3">
              <font>ภาพถ่าย(หน้าปก):</font>
            </div>
            <div class="col-xs-12 col-sm-5" style="width: 51%;padding-right: 5px;">
              <div class="input-group" >
               <input type="text" id="txt_photo_head" class="form-control" placeholder="ไฟล์ชนิด .jpg,.jpeg,.png และจำกัดขนาดไม่เกิน 5MB" value="">
               <input type="file"  name="wisd_photo_head" onchange="imgchange(this);"  style="display: none;" />
               <span class="input-group-btn"><button type="button" id="btn_photo_head" class="btn btn-primary" onclick="triger_file(this);" style="padding-bottom: 4px;">เลือกไฟล์</button></span>
             </div>
              <!--  <div class="fileinput fileinput-new input-group" data-provides="fileinput">
=======
              <font color="red">ลิงค์ภูมิปัญญา:</font>             
            </div>
            <div class="col-xs-12 col-sm-9 has-error">
              <input type="text" class="form-control" placeholder="ระบุลิงค์ภูมิปัญญา" name="wisd_branch[wisd_sp_url]">
              
            </div>
          </div>

           <div id="content_file"></div>   

           <div class="form-group row">
            <div class="col-xs-12 col-sm-3">
              <font>ภาพถ่าย(หน้าปก):</font>      
            </div>
            <div class="col-xs-12 col-sm-9">
               <div class="fileinput fileinput-new input-group" data-provides="fileinput">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                    <div class="form-control" data-trigger="fileinput">
                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                      <span class="fileinput-filename" style="color: #99999c;">ไฟล์ชนิด .jpg,.jpeg,.png และจำกัดขนาดไม่เกิน 5MB</span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                      <span class="fileinput-new">เลือกไฟล์</span>
                      <span class="fileinput-exists">แก้ไข</span>
<<<<<<< HEAD
                      <input type="file" accept="" name="wisd_photo_head"  onchange="imgchange(this); "/>
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                  </div> -->
            </div>

            <div class="col-xs-12 col-sm-2" style="width: 12%;padding-right: 5px;">
                  <a class="btn btn-info " id="link_photo_head" href="" style="font-size: 15px !important; width: 100%;" title="ดาวน์โหลด" download><i class="fa fa-download"></i> ดาวน์โหลด</a>&nbsp;
            </div>
            <div class="col-xs-12 col-sm-2" style="width: 12%;padding-left: 5px;">
                  <button class="btn btn-danger" id="del_photo_head" type="button"   onclick="del_imges(this);" style="font-size: 15px !important; width: 100%;" title="ลบไฟล์"><i class="fa fa-trash"></i> ลบไฟล์</button>
            </div>

          </div>
          <hr>

         <div id="content_img"></div>

          <div class="form-group row">
            <div class="col-xs-12 col-sm-2 col-sm-offset-3"><button type="button"  class="btn btn-primary " onclick="add_img(this);" style="font-size: 15px !important; width: 100%;"><i class="fa fa-plus"></i> เพิ่มไฟล์</button></div>
          </div>

=======
                      <input type="file" accept="" name="wisd_photo_head"  onchange="imgchange(this); "/>               
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                  </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-sm-offset-3">
              <button class="btn btn-default form-control" style="font-size: 15px !important;">ดาวน์โหลด</button>      
            </div>
             <div class="col-xs-12 col-sm-2">
              <button class="btn btn-default form-control" type="button" style="font-size: 15px !important;">ลบไฟล์</button>      
            </div>
            <div class="col-xs-12 col-sm-2"><img src="" class="img-responsive" style="width: 50%;"></div>   
          </div>
          <hr>

         <div id="content_img"></div> 

          <div class="form-group row">
            <div class="col-xs-12 col-sm-2 col-sm-offset-3"><button type="button" class="btn btn-default form-control" onclick="add_img(this);" style="font-size: 15px !important;">เพิ่มไฟล์</button></div>
          </div>

          

>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-8">&nbsp;</div>
          <div class="col-xs-12 col-sm-2">
            <button style="height: 40px;width: 100% !important;" type="submit" class="btn btn-primary btn-save" ><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
          </div>
          <div class="col-xs-12 col-sm-2">
<<<<<<< HEAD
            <button  style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-cancel" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> ย้อนกลับ</button>
=======
            <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-cancel" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> ย้อนกลับ</button>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          </div>
        </div>
      </div>

      <?php echo form_close();?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END Modal -->

<div id="view_file" style="display: none;">
<<<<<<< HEAD
    <div class="row add_file">
      <div class="col-xs-12 col-sm-3">
        <font>เอกสารแนบ:</font>
      </div>
      <div class="col-xs-12 col-sm-5" style="width: 51%;padding-right: 5px;">
        <div class="input-group">
           <input type="text" class="form-control" placeholder="ไฟล์ชนิด .PDF และจำกัดขนาดไม่เกิน 25MB" value="">
           <input type="file"  name="wisd_file[]" onchange="filechange(this);"  style="display: none;" />
           <span class="input-group-btn"><button type="button" class="btn btn-primary" onclick="triger_file(this);" style="padding-bottom: 4px;">เลือกไฟล์</button></span>
       </div>

       <!-- <div class="fileinput fileinput-new input-group" data-provides="fileinput" >
=======
    <div class="form-group row">
      <div class="col-xs-12 col-sm-3">
        <font>เอกสารแนบ:</font>      
      </div>
      <div class="col-xs-12 col-sm-9">
       <div class="fileinput fileinput-new input-group" data-provides="fileinput">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
        <div class="form-control" data-trigger="fileinput">
          <i class="glyphicon glyphicon-file fileinput-exists"></i>
          <span class="fileinput-filename" style="color: #99999c;" >ไฟล์ชนิด .PDF และจำกัดขนาดไม่เกิน 25MB</span>
        </div>
<<<<<<< HEAD
        <span class="input-group-addon btn btn-default btn-file" >
=======
        <span class="input-group-addon btn btn-default btn-file">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          <span class="fileinput-new">เลือกไฟล์</span>
          <span class="fileinput-exists">แก้ไข</span>
          <input type="file"  name="wisd_file[]"  />
        </span>
        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
<<<<<<< HEAD
      </div> -->
    </div>
    <div class="col-xs-12 col-sm-2" style="width: 12%;padding-right: 5px;">
      <a class="btn btn-info " href="" style="font-size: 15px !important; width: 100%;" title="ดาวน์โหลด" download><i class="fa fa-download"></i> ดาวน์โหลด</a>&nbsp;
    </div>
    <div class="col-xs-12 col-sm-2" style="width: 12%;padding-left: 5px;">
     <button class="btn btn-danger fileinput-exists " type="button"   onclick="del_file(this,'file');" style="font-size: 15px !important; width: 100%;" title="ลบไฟล์"><i class="fa fa-trash"></i> ลบไฟล์</button>
    </div>

=======
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-sm-offset-3">
      <button class="btn btn-default form-control" style="font-size: 15px !important;">ดาวน์โหลด</button>      
    </div>
    <div class="col-xs-12 col-sm-2">
      <button class="btn btn-default form-control" type="button" onclick="del_file(this);" style="font-size: 15px !important;">ลบไฟล์</button>      
    </div>
    <div class="col-xs-12 col-sm-2">
      <button class="btn btn-default form-control" type="button" onclick="add_file(this);" style="font-size: 15px !important;">เพิ่มไฟล์</button>      
    </div>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
  </div>
</div>

<div id="view_formupload" style="display: none;">
  <div class="form-group row add_img">
    <div class="col-xs-12 col-sm-3">
<<<<<<< HEAD
      <font>ภาพถ่าย(ประกอบภูมิปัญญา):</font>
    </div>
    <div class="col-xs-12 col-sm-5" style="width: 51%;padding-right: 5px;">
       <div class="input-group" >
           <input type="text" class="form-control" placeholder="ไฟล์ชนิด .jpg,.jpeg,.png และจำกัดขนาดไม่เกิน 5MB" value="">
           <input type="file"  name="wisd_wisd_photo[]" onchange="imgchange(this);"  style="display: none;" />
           <span class="input-group-btn"><button type="button" class="btn btn-primary" onclick="triger_file(this);" style="padding-bottom: 4px;">เลือกไฟล์</button></span>
       </div>
    <!--  <div class="fileinput fileinput-new input-group" data-provides="fileinput">
=======
      <font>ภาพถ่าย(ประกอบภูมิปัญญา):</font>      
    </div>
    <div class="col-xs-12 col-sm-9">
     <div class="fileinput fileinput-new input-group" data-provides="fileinput">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
      <div class="form-control" data-trigger="fileinput">
        <i class="glyphicon glyphicon-file fileinput-exists"></i>
        <span class="fileinput-filename" style="color: #99999c;" >ไฟล์ชนิด .jpg,.jpeg,.png และจำกัดขนาดไม่เกิน 5MB</span>
      </div>
      <span class="input-group-addon btn btn-default btn-file">
        <span class="fileinput-new" >เลือกไฟล์</span>
<<<<<<< HEAD
        <span class="fileinput-exists" >แก้ไข</span>
        <input type="file" accept="" name="wisd_wisd_photo[]"  onchange="imgchange(this);" />
      </span>
      <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
    </div> -->
  </div>

  <div class="col-xs-12 col-sm-2" style="width: 12%;padding-right: 5px;">
      <a class="btn btn-info " href="" style="font-size: 15px !important; width: 100%;" title="ดาวน์โหลด" download><i class="fa fa-download"></i> ดาวน์โหลด</a>&nbsp;
  </div>
  <div class="col-xs-12 col-sm-2" style="width: 12%;padding-left: 5px;">
     <button class="btn btn-danger fileinput-exists " type="button"   onclick="del_file(this,'img');" style="font-size: 15px !important; width: 100%;" title="ลบไฟล์"><i class="fa fa-trash"></i> ลบไฟล์</button>
  </div>

</div>
</div>

<!-- *************************************body*js***************************************************** -->
<script>


   // var copy_form        = $('#view_formupload').children().clone();
   // var copy_file_upload = $('#view_file').children().clone();
   var csrf_hash        ='<?php echo @$csrf['hash'];?>';
   var content_file     = $('#content_file');
   var content_img      = $('#content_img');
   // $('#content_file').before(copy_file_upload);
   // $('#content_img').before(copy_form);

    function copy_file_upload(){
    return $('#view_file').children().clone();
   }

   $('.btn-cancel').click(function(){
       location.reload();
   });

   function copy_form(){
    return $('#view_formupload').children().clone();
   }


   content_file.before(copy_file_upload());
   content_img.before(copy_form());


=======
        <span class="fileinput-exists">แก้ไข</span>
        <input type="file" accept="" name="wisd_wisd_photo[]"  onchange="imgchange(this);" />    
      </span>
      <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 col-sm-offset-3">
    <button class="btn btn-default form-control" type="button" style="font-size: 15px !important;">ดาวน์โหลด</button>      
  </div>
  <div class="col-xs-12 col-sm-2">
    <button class="btn btn-default form-control" type="button" onclick="del_file(this);" style="font-size: 15px !important;">ลบไฟล์</button>      
  </div>
  <div class="col-xs-12 col-sm-2"><img src="" class="img-responsive" style="width: 50%;"></div>    
</div>
</div>

<!-- ******************************body*js***************************************************** -->
<script>

   var copy_form        = $('#view_formupload').children().clone();
   var copy_file_upload = $('#view_file').children().clone();

   $('#content_file').before(copy_file_upload);
   $('#content_img').before(copy_form);
   
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
   function add_img(node){
      if($('.add_img').length>5){
        alert('จำนวนรูปภาพ ครบตามที่กำหนด 5 รูปภาพ');
      }else{
<<<<<<< HEAD
       $(node).parent().parent().before(copy_form());
     }
   }

   function add_file(node){
     // var copy_file_upload = $('#view_file').children().clone();
    // console.log($(node).parent().parent());
     // $(node).css('display','none');
     $(node).parent().parent().before(copy_file_upload());
   }

   function triger_file(node,id,mode){
     $(node).parent().prev().click();
     if(id!=''){
       del_ajax(id,mode);
     }
   }

   function del_ajax(id,mode){

      $.ajax({
        url: base_url+'intelprop/del_wisd',
        type: 'POST',
        dataType: 'json',
        data: {
          'id'  : id,
          'mode': mode,
          'csrf_dop': csrf_hash
        },
      success: function (value) { //Result True
      },
    });

   }

   function del_file(node,mode,branch_id){
     var dev_flim = $(node).parent().parent();
     var dev_text = $(node).parent().prev().prev().children().children();

      if(mode=="file"){
          var num_file = ($('.add_file').length)-1;
          if(num_file<=1){
             $(dev_text[0]).val("");
          }else{
             $(dev_flim).remove();
          }

          if(branch_id!=''){
            del_ajax(branch_id,mode);
          }

      }else if(mode=="img"){
          var num_img = ($('.add_img').length)-1;
            if(num_img<=1){
             $(node).parent().next().remove();
             $(dev_text[0]).val("");
          }else{
             $(dev_flim).remove();
          }

           if(branch_id!=''){
            del_ajax(branch_id,mode);
          }
      }

   }

   function del_imges(node,mode,id){
     var path_img     = $(node).parent().next();
     var set_namefile = $(node).parent().prev().prev().children().children();
     $(set_namefile[0]).val("");
     $(path_img).remove();
     if(mode!=''){
         del_ajax(id,mode);
     }
=======
      var copy_form        = $('#view_formupload').children().clone();
      $(node).parent().parent().before(copy_form);
     }      
   }

   function add_file(node){  
     var copy_file_upload = $('#view_file').children().clone();
    // console.log($(node).parent().parent());
     $(node).css('display','none');
     $(node).parent().parent().before(copy_file_upload);
   }

   function del_file(node){
      $(node).parent().parent().remove();
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
   }

   $(function(){
     $('#myModal').modal({
      show:false,
      backdrop:false
    });
   });

<<<<<<< HEAD
   function edit_modal(knwl_id){

     $.ajax({
      url: base_url+'intelprop/edit_wisd',
      type: 'POST',
      dataType: 'json',
      data: {
        'knwl_id': knwl_id,
        'csrf_dop': csrf_hash
      },
      success: function (value) { //Result True
          console.log(value);

          $('#branch_id').val(value[0]['branch_id']);
          $('#wisd_branch_wisd_code > option').each(function(){
              if($(this).val()==value[0]['wisd_code']){
                $(this).prop('selected',true);
              }
          });

          $('#wisd_branch_wisd_sp_title').val(value[0]['wisd_sp_title']);
          $('#wisd_branch_wisd_sp_url').val(value[0]['wisd_sp_url']);


          if(1<=value.count_arr){
             content_file.prev().remove();
          }

          for(var i=1;i<=value.count_arr;i++){
             content_file.before(copy_file_upload());
             var txt_label = content_file.prev().children().next().children().children();
             var link_down = content_file.prev().children().next().next().children();
             var btn_del   = content_file.prev().children().next().next().next().children();

             $(txt_label[0]).val(value[i]['wisd_sp_label']+".pdf");
             $(txt_label[2]).children().attr('onclick',"triger_file(this,"+value[i]['branch_id']+",'file')");

             $(link_down[0]).prop('href','<?php echo base_url('assets/modules/intelprop/uploads/'); ?>'+'/'+value[i]['wisd_sp_file']);
             $(btn_del[0]).attr('onclick',"del_file(this,'file',"+value[i]['branch_id']+")");
            // console.log(content[0]);
            // console.log(link_down[0]);
            // console.log(btn_del[0]);
          }

           var last_arr = (value.count_arr+1);
          if(value[last_arr].length!=0){

              for(var j=0;j<value[last_arr].length;j++){
                   if(value[last_arr][j].result!=0 ){
                        $('#txt_photo_head').val(value[last_arr][j].wisdom_photo_label);
                        $('#btn_photo_head').attr('onclick',"triger_file(this,"+value[last_arr][j].wisdom_photo_id+",'img')");
                        $('#link_photo_head').prop('href','<?php echo base_url('assets/modules/intelprop/images/'); ?>'+'/'+value[last_arr][j].wisdom_photo_file);
                        $('#del_photo_head').attr('onclick',"del_imges(this,'img',"+value[last_arr][j].wisdom_photo_id+")");
                        var add_img = '<div class="col-xs-12 col-sm-2 col-sm-offset-3"><img src="<?php echo base_url('assets/modules/intelprop/images');?>/'+value[last_arr][j].wisdom_photo_file+'" class="img-responsive" style="width:200px; height:150px;">';
                        $('#del_photo_head').parent().after(add_img);

                  }else{

                      content_img.before(copy_form());
                      var txt_label_img = content_img.prev().children().next().children().children();
                      var link_down_img = content_img.prev().children().next().next().children();
                      var btn_del_img   = content_img.prev().children().next().next().next().children();

                       $(txt_label_img[0]).val(value[last_arr][j].wisdom_photo_label);
                       $(txt_label_img[2]).children().attr('onclick',"triger_file(this,"+value[last_arr][j].wisdom_photo_id+",'img')");
                       $(link_down_img[0]).prop('href','<?php echo base_url('assets/modules/intelprop/images/'); ?>'+'/'+value[last_arr][j].wisdom_photo_file);
                       $(btn_del_img[0]).attr('onclick',"del_file(this,'img',"+value[last_arr][j].wisdom_photo_id+")");
                       var add_img = '<div class="col-xs-12 col-sm-2 col-sm-offset-3"><img src="<?php echo base_url('assets/modules/intelprop/images');?>/'+value[last_arr][j].wisdom_photo_file+'" class="img-responsive" style="width:200px; height:150px;">';
                       $(btn_del_img[0]).parent().after(add_img);
                  }
              }

                if(value[last_arr].length==1){
                  if(value[last_arr][0].result==0){
                    $('.add_img')[0].remove();
                  }
                }
          }
      },

    });
      $('#myModal').modal('show');
   }

=======
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
</script>

<!-- upload profile -->
<script type="text/javascript">

  function brwImg (node,myID){
    $(node).prev().click();
  //console.log($(node).prev());
  }

  function imgchange(node,myID){
      //var countFiles = $(this)[0].files.length;
<<<<<<< HEAD

      var path_img       = $(node).parent().parent().next().next();
      var imgPath        = $(node)[0].value;
      var extn           = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      var size_img       = $(node)[0].files[0].size;
      var set_namefile   = $(node).prev();
      var Name_file      = $(node)[0].files[0].name;
=======
      var path_img = $(node).parent().parent().parent().next().next().next().children();
      var imgPath  = $(node)[0].value;
      var extn     = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
      //Get count of selected files
      //var image_holder = $("#image-holder");
      //image_holder.empty();
      // $(node).prev().remove();
      if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
<<<<<<< HEAD
        if(size_img>5242880){
            alert("ขนาดไฟล์เกิน 5MB");
        }else{
              if($(set_namefile).val()!=""){
                $(path_img).next().remove();
              }

               if (typeof(FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                //for (var i = 0; i < countFiles; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                //console.log(e.target.result);

                var add_img = '<div class="col-xs-12 col-sm-2 col-sm-offset-3"><img src="'+e.target.result+'" class="img-responsive" style="width:200px; height:150px;">';
                // $(node).before(add_img);
                $(path_img).after(add_img);
                $(set_namefile).val(Name_file)
                }
                //  image_holder.show();
                reader.readAsDataURL($(node)[0].files[0]);
            }else {
                alert("This browser does not support FileReader.");
            }
        }

      } else {
            alert("กรุณาเลือกไฟล์เป็นชนิด รูปภาพ");
      }
  }//close loop function
</script>

 <!-- filechange -->
<script type="text/javascript">
    function filechange(node){
       var filepath       = $(node)[0].value;
       var extnfile       = filepath.substring(filepath.lastIndexOf('.') + 1).toLowerCase();
       var Name_file      = $(node)[0].files[0].name;
       var size_file      = $(node)[0].files[0].size;
       var set_namefile   = $(node).prev();
       var link_download  = $(node).parent().parent().next().children();
       // console.log($(node));
       // console.log(link_download[0]);

       if(extnfile!='pdf'){
         alert("รูปแบบไฟล์ไม่ถูกต้อง");
       }else{
          if(size_file>26214400){
            alert("ขนาดไฟล์เกิน 25MB");
          }else{
            // กำหนดการทำงาน
            $(set_namefile).val(Name_file);
          }
       }
    }
</script>
<!-- End filechange -->
=======
      if (typeof(FileReader) != "undefined") {
      //loop for each file selected for uploaded.
      //for (var i = 0; i < countFiles; i++) {
      var reader = new FileReader();
      reader.onload = function(e) {
      //console.log(e.target.result);

      // var add_img = '<img src="'+e.target.result+'" class="image" >';
      // $(node).before(add_img);
      $(path_img).prop("src",e.target.result);
      }
      //  image_holder.show();
      reader.readAsDataURL($(node)[0].files[0]);
      }
      else {
      alert("This browser does not support FileReader.");
      }
      } else {
      alert("กรุณาเลือกไฟล์เป็นชนิด รูปภาพ");
      }
  }//close loop function
</script>
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
