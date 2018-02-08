<!--
<h3 style="color: #4e5f4d"><?php echo $title;?></h3>
<hr/>

   <div class="row">
	   <div class="col-xs-12 col-sm-12 text-right">

          <?php
            $tmp = $this->admin_model->getOnce_Application(58);
            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(58,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else{?> href="<?php echo site_url('school/school1');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="บันทึกแบบขึ้นทะเบียน<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>" class="btn btn-default">
              <i class="fa fa-plus" aria-hidden="true"></i>
          </a>

          <?php
            $tmp = $this->admin_model->getOnce_Application(6);
            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(6,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else{?> href="<?php echo site_url('report/excel');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>" class="btn btn-default">
              <i class="fa fa-file-excel-o" aria-hidden="true"></i>
          </a>

          &nbsp;
          <a style="color: #000; padding-left: 20px; padding-right: 20px;" title="ค้นหา" class="btn btn-default" data-toggle="modal" data-target="#mySearch">
              <i class="fa fa-filter" aria-hidden="true"></i>
		      </a>

	   </div>
   </div>
   -->

      <div id="tmp_menu" hidden='hidden'>
    <?php
      $tmp = $this->admin_model->getOnce_Application(59);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss(59,$user_id); //Check User Permission
    ?>
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-add" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;"
    <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else{?> href="<?php echo site_url('school/school1');?>"
    <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
    <i style='font-size:14px;' class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ
    </a>

    <a id="showChart" class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-overview" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 17px 2px 17px;" href="javascript:showChart();"><i style='font-size:14px;' class="fa fa-area-chart" aria-hidden="true"></i> ภาพรวม </a>


    <a title="ค้นหา" class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-search" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" type="button" id="filter" href="javascript:showFilter();" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <i style='font-size:14px;' class="fa fa-search" aria-hidden="true"></i> ค้นหา</a>

    <?php
      $tmp = $this->admin_model->getOnce_Application(62);
      $tmp1 = $this->admin_model->chkOnce_usrmPermiss(62,$user_id); //Check User Permission
    ?>
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-export" style=" margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;"
    <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else{?> href="<?php echo site_url('report/G0/xls');?>"
    <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>">
    <i style='font-size:14px;' class="fa fa-table" aria-hidden="true"></i> ส่งออกไฟล์</a>

    <!--
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-top: 11px; margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 5px 20px 3px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>
    -->
  </div>
  <script>
    setTimeout(function(){
      $("#menu_topright").html($("#tmp_menu").html());
    },300);

    function showChart(){
      $("#chart_display").slideToggle();
    }
  </script>

  <?php
    //summary
    $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/back-end/school_list_summary.php');
    //search
    $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/back-end/school_list_filter.php');
  ?>

  <div class="table-responsive">

    <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" style="margin-top: 0px !important; width:100% !important;" >
      <thead style="font-size: 15px;">
        <tr>
            <th style="width:2% !important;" class="text-center">#</th>
            <th class="text-center">ชื่อโรงเรียน</th>
            <th style="width:10% !important;" class="text-center">จังหวัด</th>
            <th style="width:10% !important;" class="text-center">ปีที่จัดตั้ง</th>
            <th style="width:10% !important;" class="text-center">จำนวน (รุ่น)</th>
            <th style="width:10% !important;" class="text-center">ผู้เข้าร่วม (คน)</th>
            <th style="width:1% !important;" class="text-center">&nbsp;</th>
        </tr>
			</thead>
      <tbody>
        <?php
        $number = 1;
            foreach ($schl_info as $key => $schl) {

        ?>
                <tr>
                    <td class="lnk text-center"><?php echo $number; ?></td>
                    <td class="lnk">
                       <?php
                         $sta_model = $this->common_model->custom_query("SELECT * FROM schl_model WHERE schl_id = {$schl['schl_id']}");

                        ?>
                           <i id="star<?php echo $schl['schl_id']; ?>_1" aria-hidden="true"  class="fa fa-star-o" style="font-size: 16px; color: #909090;"></i> <i id="star<?php echo $schl['schl_id']; ?>_2" aria-hidden="true"  class="fa fa-star-o" style="font-size: 16px; color: #909090;"></i> <i id="star<?php echo $schl['schl_id']; ?>_3" aria-hidden="true"  class="fa fa-star-o" style="font-size: 16px; color: #909090;"></i> <i id="star<?php echo $schl['schl_id']; ?>_4" aria-hidden="true"  class="fa fa-star-o" style="font-size: 16px; color: #909090;"></i>&nbsp;<?php echo $schl['schl_name']; ?>
                        <?php

                          if(count($sta_model)!=0){
                              if(count($sta_model)<=9){
                                echo "<script> $('#star".$schl['schl_id']."_1').removeClass('fa fa-star-o'); $('#star".$schl['schl_id']."_1').addClass('fa fa-star'); $('#star".$schl['schl_id']."_1').css('color','#FF9800'); </script>";
                              }else if(count($sta_model)<=12){
                                echo "<script> $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2').removeClass('fa fa-star-o'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2').addClass('fa fa-star'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2').css('color','#FF9800'); </script>";
                              }else if(count($sta_model)<=15){
                                echo "<script> $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3').removeClass('fa fa-star-o'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3').addClass('fa fa-star'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3').css('color','#FF9800'); </script>";
                              }else if(count($sta_model)<=20){
                                echo "<script> $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3,#star".$schl['schl_id']."_4').removeClass('fa fa-star-o'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3,#star".$schl['schl_id']."_4').addClass('fa fa-star'); $('#star".$schl['schl_id']."_1,#star".$schl['schl_id']."_2,#star".$schl['schl_id']."_3,#star".$schl['schl_id']."_4').css('color','#FF9800'); </script>";
                              }else{}
                          }
                        ?>
                    </td>
                    <td class="lnk">
                    <?php
                     if($schl['addr_province']!=''){
                       $province = $this->common_model->query("SELECT * FROM std_area WHERE area_code = {$schl['addr_province']}")->row_array();

                             echo $province['area_name_th'];
                     }else{
                      echo "-";
                     }

                    ?>

                    </td>
                  <td class="lnk text-center"><?php if($schl['year_of_established'] != ''){ echo $schl['year_of_established']+543; }else{ echo " - ";} ?></td>
                    <!-- จำนวนรุ่นตามโรงเรียน-->
                    <td class="lnk text-center">
                      <a href="<?php echo base_url('school/generation3/Edit/'.$schl['schl_id']);?>">
                          <?php
                             $gen_schl = $this->common_model->custom_query("SELECT * FROM schl_info_generation WHERE schl_id = {$schl['schl_id']}");
                             echo count($gen_schl);
                          ?>
                      </a>
                    </td>

                    <!-- จำนวนนักเรียน-->
                    <td class="lnk text-center">

                          <?php
                               $amout_schl = $this->common_model->custom_query("SELECT * FROM schl_info_student WHERE schl_id = {$schl['schl_id']}");

                          ?>
                          <a <?php if(isset($amout_schl[0]['gen_id'])){?> href="<?php echo base_url('school/participant/Add/'.$schl['schl_id'].'/'.$amout_schl[0]['gen_id']);?>" <?php }?>>
                          <?php
                               echo count($amout_schl);
                          ?>
                        </a>
                    </td>

                    <td align="right">

                      <div class="btn-group" style="cursor: pointer;">
                        <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>
                        <ul class="dropdown-menu" style="position: absolute;left: -210px;">
                         
                          <li>
                           <a style="font-size:16px;" data-toggle="modal" data-target="#prt<?php echo $schl['schl_id']; ?>" title="พิมพ์แบบฟอร์ม" >
                             <i class="fa fa-file-text" aria-hidden="true" style="color: #000"></i>  พิมพ์แบบฟอร์ม (.PDF)                 
                           </a>
                          </li>
                           <li>
                            <?php
                            $tmp = $this->admin_model->getOnce_Application(3);
                            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                            ?>
                            <a style="font-size:16px;" <?php if(!isset($tmp1['perm_status'])) {?>
                              readonly
                              <?php }else{?> href="<?php echo site_url('school/school1/Edit/'.$schl['schl_id']);?>" <?php }?> title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>" >
                              <i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ
                            </a>
                          </li>
                          <li>
                                   <?php
                              $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                              if(isset($tmp['perm_status'])) {
                                if($tmp['perm_status']=='Yes') {
                                  ?>
                                  <a style="font-size:16px;" data-id=<?php echo $schl['schl_id']; ?> onclick="opn(this)" title="ลบ"  >
                                    <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                                  </a>
                                  <?php
                                }
                              }
                              ?>
                          </li>
                        </ul>
                      </div>

                  
                             

                          <!-- Print Modal -->
            <div class="modal fade" id="prt<?php echo $schl['schl_id']; ?>" role="dialog">
              <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
              <div class="modal-header text-left">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
              </div>
              <div class="modal-body">
              <div class="row ">
              <!--
              <?php
                $tmp  = $this->admin_model->getOnce_Application(49);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(49, get_session('user_id')); //Check User Permission
                    ?>
                                                            <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"
                                                            <?php
                                if (!isset($tmp1['perm_status'])) {?>
                                                            class="disabled"
                                                            <?php
                              } else if ($usrpm['app_id'] == 49) {
                                      ?>
                                                            class="active"
                                                            <?php
                              }
                                  ?>
              >
              -->
              <div class="col-xs-12 col-sm-12 text-left">
              <a style="color: #333; font-size: 16px;" target="_blank"
              href="<?php echo site_url('report/G7/pdf?id='.$schl['schl_id']); ?>"><i class="fa fa-print"
              aria-hidden="true"></i> ส่งออกไฟล์ ประกาศนียบัตรการเป็นผู้นำบริหารโรงเรียน (G7) (PDF)
               <!--<?php if (isset($tmp1['perm_status'])) {echo $tmp1['app_name'];}?>-->
              </a>
              </div>
              </div>

              </div>

              </div>
              <br/>

              </div>
              </div>

              </div>
              </div>
              <!-- End Print Modal -->


                    </td>
                </tr>



          <?php
             $number++;
            } //close foreach
          ?>

      </tbody>
		</table>

  </div>

<!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

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
        <button id="btnYes" type="button" class="btn btn-danger">ตกลง</button>
        <button style="margin-bottom: 5px;" type="button" aria-hidden="true" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Model -->
