
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                       

                        <div class="tab-content">
                            <div id="tab-1" <?php if($usrpm['app_id']==163){?>class="tab-pane active" <?php }else{?> class="tab-pane"<?php }?>>
                                <div class="panel-body">

                                
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

                                                    <button type="button" class="btn btn-default delfamily_members" onclick="btDel_family_members(this,'')" style="margin-right: 16px;"><i class="fa fa-minus" aria-hidden="true"></i></button>

                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <label for="" class="col-2 col-form-label">ผู้ประสานงาน</label>
                                                            <input title="ผู้ประสานงาน" placeholder="(คำนำหน้า) ชื่อ-นามสกุล" name="schl_contacts[sch_cnt_name][myID]" class="form-control" type="text"/>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-3 ">
                                                            <label for="example-text-input" class="col-2 col-form-label">ตำแหน่ง</label>
                                                            <input title="ตำแหน่ง" placeholder="ระบุตำแหน่ง" name="schl_contacts[sch_cnt_title][myID]" class="form-control" type="text"/>

                                                        </div>

                                                        <div class="col-xs-12 col-sm-3">
                                                            <label for="" class="col-2 col-form-label">เบอร์โทรศัพท์ (มือถือ)</label>
                                                            <input title="เบอร์โทรศัพท์ (มือถือ)" placeholder="ตัวอย่าง 08XXXXXXX" name="schl_contacts[tel_no_mobile][myID]" class="form-control" type="text"/>
                                                        </div>
                                                      </div>

                                                  </div>
                                              </div>
                                            </div>
                                          </div><!-- close family_members_template-->

                                    <div class="form-group row">

                                    <?php
                                    $schl_id = '';

                                    if($process_action=='Add'){$process_action = 'Added';}

                                    if($process_action=='Edit'){$process_action = 'Edited'; @$schl_id = '/'.$center_info['qlc_id'];}

                                    echo form_open_multipart('school/center_info/'.$process_action.$schl_id,array('id'=>'form1'));
                                    ?>

                                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" /> <!-- Set hidden csrf field -->

                                    <input type="submit" value="submit" name="bt_submit" hidden="hidden">


                                    <?php echo validation_errors('<div class="error" style="font-size: 18px; padding-left: 20px">', '</div>'); ?>

                                    <div class="panel-group">
                                          <div class="panel panel-default" style="border: 0">

                   <!--                            <div class="panel-heading">
                                                <h4>ข้อมูลโรงเรียนผู้สูงอายุ</h4>
                                              </div> -->

                                              <div class="panel-body" style="border:0; padding: 20px;">

                                                <div class="form-group row">
                                                  <div class="col-xs-12 col-sm-12 has-error">
                                                      <label for="" class="control-label col-md-3 col-sm-3 col-xs-12" style="color: red;">ชื่อหน่วยงาน :</label>
                                                      <div class="col-md-9 col-sm-9 col-xs-12 ">
                                                        <input type="text" class="form-control " name="center_info[qlc_name]" title="ชื่อโรงเรียน" value="<?php echo $center_info['qlc_name']; ?>" placeholder="ระบุชื่อหน่วยงาน" required>
                                                      </div>
                                                  </div>
                                       
                                                </div>


                                                  <div class="form-group row">

                                                      <div class="col-xs-12 col-sm-12  dropdown" style="color: red;">
                                                          <label for="example-text-input" class="col-sm-3 col-xs-12 col-form-label">ที่ตั้ง</label>
                                                          <label for="example-text-input" class="col-sm-3 col-xs-12 col-form-label">จังหวัด</label>
                                               
                                                          <div class="col-sm-6 col-xs-12">
                                                            <select  title="จังหวัด" placeholder="เลือกจังหวัด" class="form-control elder_addr_pre" id="Province" name="center_info[addr_province]" onchange="optionGen(this,'Amphur',<?php echo @$center_info['addr_district']; ?>);">
                                                                <option value="">เลือกจังหวัด</option>
                                                                <?php $temp = $this->personal_model->getAll_Province();
                                                                  foreach ($temp as $key => $row) { ?>
                                                                  <option value="<?php echo $row['area_code']; ?>"> <?php echo $row['area_name_th']; ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                            
                                                      </div>

                                                  </div>

                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-12 dropdown" style="color: red;">
                                                        <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label"></label>
                                                        <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label">อำเภอ</label>
                                                 
                                                          <div class=" col-sm-6 col-xs-12">
                                                          <select title="อำเภอ" placeholder="เลือกอำเภอ" class="form-control elder_addr_pre" id="Amphur" name="center_info[addr_district]" onchange="optionGen(this.value,'Tambon',<?php echo @$center_info['addr_sub_district']; ?>);" disabled>
                                                              <option value="">เลือกอำเภอ</option>
                                                              <?php //$temp = $this->personal_model->getAll_Amphur();
                                                                //foreach ($temp as $key => $row) { ?>
                                                                <!-- <option value="<?php //echo $row['area_code']; ?>"><?php //echo $row['area_name_th']; ?></option> -->
                                                              <?php  //} ?>
                                                          </select>
                                                        </div>
                                                
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-12 dropdown" style="color: red;">
                                                      <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label"></label>
                                                        <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label">ตำบล</label>
                                                        <div class="col-10">
                                                        <div class=" col-sm-6 col-xs-12">
                                                        <select title="ตำบล" placeholder="เลือกตำบล" class="form-control elder_addr_pre" id="Tambon" name="center_info[addr_sub_district]" disabled>
                                                            <option value="">เลือกตำบล</option>
                                                            <?php //$temp = $this->personal_model->getAll_Tambon();
                                                              //foreach ($temp as $key => $row) { ?>
                                                              <!-- <option value="<?php //echo $row['area_code']; ?>"><?php //echo $row['area_name_th']; ?></option> -->
                                                            <?php  //} ?>
                                                        </select>
                                                        </div>
                                                        </div>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-12 dropdown">
                                                    <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label"></label>
                                                    <label for="example-text-input" class="col-md-3 col-sm-3 col-xs-12 col-form-label">พิกัด</label>
                                                    <div class="col-xs-12 col-sm-6">
                                                     <?php
                                                            $addr_gps = @$center_info['addr_gps']; // Old Data $diff_info['addr_gps']

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
                                                              <input type="hidden" name="center_info[addr_gps]" value="<?php echo $addr_gps;?>" id="addr_gps">
                                                              <span id="addr_gpg_txt"><?php if($addr_gps!='0,0') { echo '('.$addr_gps.')';}?></span>

                                                     </div>
                                                  </div>
                                                  </div>


                                                  <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-12">
                                                      <div class="col-xs-6 col-sm-6" style="padding: 0px">
                                                          <label for="" class="col-sm-6 col-xs-12 col-form-label">เบอร์โทรศัพท์ </label>
                                                          <div class=" col-sm-6 col-xs-12">
                                                            <input title="เบอร์โทรศัพท์ " placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="center_info[tel_no]" value="<?php echo $center_info['tel_no'];?>"/>
                                                           </div>
                                                      </div>

                                                      <div class="col-xs-6 col-sm-6" style="padding: 0px">
                                                          <label for="" class=" col-sm-6 col-xs-12 col-form-label">เบอร์โทรสาร</label>
                                                          <div class=" col-sm-6 col-xs-12">
                                                          <input title="เบอร์โทรสาร (แฟกซ์)" placeholder="ตัวอย่าง 02XXXXXXX ต่อ XXX" class="form-control" type="text" name="center_info[fax_no]" value="<?php echo $center_info['fax_no'];?>"/>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                            
                                                      <div class="col-xs-12 col-sm-12" >
                                                        <label for="" class=" col-sm-3 col-xs-12 col-form-label">ที่อยู่อีเมล</label>
                                                        <div class=" col-sm-6 col-xs-12">
                                                        <input title="ที่อยู่อีเมล" placeholder="ตัวอย่าง me@mail.com" class="form-control" type="email" name="center_info[email_addr]" value="<?php echo $center_info['email_addr'];?>"/>
                                                        </div>
                                                    </div>
                                          
                                                  </div>

                                                  <div class="form-group row">
                                                 
                                                      <div class="col-xs-12 col-sm-12" >
                                                        <label for="" class=" col-sm-3 col-xs-12 col-form-label">หน่วยงานดูแล</label>
                                                        <div class=" col-sm-6 col-xs-12">
                                                        <input title="หน่วยงานดูแล" placeholder="ระบุชื่อหน่วยงาน" class="form-control" type="text" name="center_info[agency_org]" value="<?php echo $center_info['agency_org'];?>"/>
                                                      </div>
                                                    </div>
                                   
                                                </div>

                                                <br/>
                                                <div class="form-group row">
                                                  <label for="" class=" col-sm-3 col-xs-12 col-form-label">ผลการตรวจมาตรฐาน/ตัวชี้วัด</label>
                                                  <div class="col-xs-12 col-sm-9">

                                                    <?php 
                                                      $qlc_select = array();
                                                      if($process_action=='Edited'){
                                                         $qlc_select = $this->common_model->query("SELECT qlc_kpi_code FROM schl_qlc_kpi WHERE qlc_id = {$center_info['qlc_id']}")->result_array();
                                                      }
                                                          
                              
                                                    ?>
                                                    <?php foreach ($std_qlc as $key => $values) { ?>
                                         
                                                     <div class="table-responsive">
                                                        <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" style="margin-top: 0px !important; width:100% !important;" >
                                                          <thead style="font-size: 15px;">
                                                            <tr>
                                                                <th style="width:2% !important; text-align: left;" class=""><?php echo $values['title']['qlc_kpi_grp'];?></th>
                          
                                                            </tr>
                                                          </thead>
                                                          <tbody>

                                                            <?php foreach ($values['data'] as $key2 => $value) { ?>
                                                              <tr>
                                                                <td>
                                                                  <?php 

                                                                    $status = '';
                                                                     foreach($qlc_select as $key => $product)
                                                                     {
                                                                        if ( $product['qlc_kpi_code'] === $value['qlc_kpi_code'] )
                                                                           $status = 'checked=checked';
                                                                     }
                                                                    
                                                                  ?>
                                                                  <div class="i-checks">
                                                                    <input  <?php echo $status;?> type="checkbox"  name="qlc[<?php echo $value['qlc_kpi_code']?>]" value="<?php echo $value['qlc_kpi_score']?>">
                                                                    <div style="margin-left: 5px; display: inline;">
                                                                  <?php echo $value['qlc_kpi_title']; ?>
                                                                </div>
                                                              </div>
                                                              </td>
                                                              </tr>
                                                          <?php  } ?>
                                                            
                                                          </tbody>
                                                        </table>
                                                      </div>
                                                    <?php } ?>
                                                  </div>
                                                </div>

                                              </div>
                                          </div>
                                      </div>

                                    <?php
                                    echo form_close();
                                    ?>

                                    </div>

                                    <hr style="margin-top: 0px;">
                                    <div class="row">
                                     <div class="col-xs-12 col-sm-8">&nbsp;</div>
                                     <div class="col-xs-12 col-sm-2">
                                      <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-save" onclick="return opnCnfrom()"> <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                      <button style="height: 40px;width: 100% !important;" type="button" class="btn btn-primary btn-cancel" onclick="window.location.href='<?php echo site_url('school/center_list');?>'"> <i class="fa fa-caret-left" aria-hidden="true"></i> ย้อนกลับ</button>
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

                        </div><!-- close tab-content-->


                    </div>
                </div>
            </div>

            <script type="text/javascript">


                  <?php if($process_action == 'Edited'){ ?>
                  setTimeout(function(){$("#Province").val('<?php echo @$center_info['addr_province']; ?>').trigger('change');},200);
                  //setTimeout(function(){$("#Amphur").val('<?php echo @$addr_info['district_code']; ?>').trigger('change');},300);
                  // setTimeot(function(){$("#Tambon").val('<?php echo @$addr_info['sub_district_code']; ?>').trigger('change');},400);

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
                    $('#'+target).prop('disabled', false);
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

              function checkbox_model(node){
                 if($(node).prop('checked',)==true){
                     $(node).parent().next().children().attr('disabled',false);
                 }else{
                     $(node).parent().next().children().attr('disabled',true);
                 }
              }
            </script>

            <script type="text/javascript">
              $(document).ready(function () {
                $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
                  increaseArea: '20%'
                });

                chebox_star();
              });

              $("input[name='std_model[]']").on('ifChanged',function(){
                 if($(this).prop('checked')){
                     $(this).parent().parent().parent().next().children().prop('disabled',false).focus();
                 }else{
                     $(this).parent().parent().parent().next().children().val('');
                     $(this).parent().parent().parent().next().children().prop('disabled',true);
                 }

               chebox_star();

              });

              function chebox_star(){

                var num_star = parseInt($("input[name='std_model[]']:checked").length);

                if(num_star>0 && num_star<=9){

                 add_color($("#star1"));

                 che_star($("#star2"));
                 che_star($("#star3"));
                 che_star($("#star4"));
               }else{

                if(num_star>9 && num_star<=12){
                 add_color($("#star1"));
                 add_color($("#star2"));

                 che_star($("#star3"));
                 che_star($("#star4"));
               }else{
                if(num_star>12 && num_star<=15){
                 add_color($("#star1"));
                 add_color($("#star2"));
                 add_color($("#star3"));

                 che_star($("#star4"));
               }else{

                if(num_star>15 && num_star<=20){
                 add_color($("#star1"));
                 add_color($("#star2"));
                 add_color($("#star3"));
                 add_color($("#star4"));
               }else{
                 che_star($("#star1"));
                 che_star($("#star2"));
                 che_star($("#star3"));
                 che_star($("#star4"));
               }

             }
           }

         }
       }

              function che_star(star_id){

                 var status_star = star_id.hasClass("fa fa-star-o");
                 if(!status_star){
                    star_id.removeClass("fa fa-star");
                    star_id.css("color","#676a6c");
                    star_id.addClass("fa fa-star-o");

                 }
              }

              function add_color(star_id){
                   star_id.removeClass("fa fa-star-o");
                   star_id.addClass("fa fa-star");
                   star_id.css("color","#FF9800");
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
  <!-- END modal_marker -->

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
