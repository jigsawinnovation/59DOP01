 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.css")?>" type="text/css"  />
 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.css")?>" type="text/css"  />
 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css")?>" type="text/css"  />

<!-- search-->
  <div class="collapse" id="collapseExample">
  <div class="well" style="background-color: rgb(255, 255, 255);">
     <div class="container-fluid">

        <div class="form-group row">
          <div class="col-xs-12 col-sm-12"><h3><label>ค้นหา</label></h3></div>
        </div>

        <div class="form-group row ">
            <div class="col-xs-12 col-sm-3">
                <h3><label for="col1_filter">เลขประจำตัวประชาชน (ผู้สูงอายุ):</label></h3>
            </div>
            <div class="col-xs-12 col-sm-3">
                <input data-column="1" type="text" class="form-control column_filter" id="col1_filter" placeholder="เลขประจำตัวประชาชน (13 หลัก)">
            </div>
             <div class="col-xs-12 col-sm-6">
              <div class="form-check">
               <h3>
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                  ไม่ระบุเลขบัตรประจำตัวประชาชน
                </label>
              </h3>
              </div>

            </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col2_filter">ชื่อตัว-ชื่อสกุล:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-6">
            <input data-column="2" type="text" class="form-control column_filter" id="col2_filter" placeholder="ชื่อตัว-ชื่อสกุล">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3" style="padding-top: 12px;" >
            <h3><label for="col4_filter">เพศ:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-3" style="padding-top: 12px;">
                 <select  class="form-control" id="gender">
                   <?php 
                        $gender = $this->common_model->custom_query('SELECT * FROM std_gender');
                        foreach ($gender as $key_gen => $value_gen) {
                        //$name_gen = explode(" ",$value_gen['gender_name']);                                           
                   ?>
                        <option value="<?php echo $value_gen['gender_code']; ?>" ><?php echo $value_gen['gender_name']; ?></option>
                  <?php } ?>
                </select>
          </div>
          <div class="col-xs-12 col-sm-1" style="padding-top: 12px;">
                 <h3><label>อายุ :</label></h3>
          </div>
          <div class="col-xs-12 col-sm-3">
             <input type="text" id="range" value="" name="range" />
          </div>
          <div class="col-xs-12 col-sm-1" style="padding-top: 12px;">
                 <h3><label>ปี</label></h3>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col5_filter">สถานะดำเนินการ:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-3">
            <select class="form-control">
               <option>ทั้งหมด</option>
               <option>แจ้งเรื่อง</option>
               <option>ตรวจเยี่ยม</option>
               <option>ช่วยเหลือ</option>
               <option>ไม่ระบุสถานะ</option>
            </select>
          </div>
          <div class="col-xs-12 col-sm-4">

            <div class="form-group" id="data_5" data-date-format="dd-mm-yyyy">
              <div class="input-daterange input-group " id="datepicker">
                <input type="text" class="input-sm form-control" name="start" value="" placeholder="เลือกตั้งแต่วันที่" style="height: 34px;" />
                <span class="input-group-addon">ถึง</span>
                <input type="text" class="input-sm form-control" name="end" value="" placeholder="เลือกถึงวันที่" style="height: 34px;"/>
              </div>
            </div>

            <script type="text/javascript">

             $('#data_5 .input-daterange').datepicker({
              keyboardNavigation: false,
              forceParse: false,
              autoclose: true,
              language: 'th',
              thaiyear: true,
              format: 'dd/mm/yyyy',
              todayBtn: true
            });

          </script>
        </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col6_filter">หน่วยงาน (ผู้บันทึกข้อมูล):</label></h3>
          </div>
          <div class="col-xs-12 col-sm-6">
            <?php $usrm = $this->common_model->custom_query("SELECT * FROM usrm_org"); ?>
            <select class="form-control">
              <?php foreach($usrm as $key=>$value) {?>
               <option><?php echo $value['org_title']; ?></option>
               <?php } ?>
            </select>
          </div>
        </div>

        <div class="row">
           <div class="col-xs-12 col-sm-8">&nbsp;</div>
           <div class="col-xs-12 col-sm-4 right" style="padding-right: 3px;">
               <button class="btn btn-primary btn-save" type="button" href="" title="ค้นหา" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
               <button class="btn btn-primary  btn-cancel" type="button" href="" title="ล้างค่า" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-refresh" aria-hidden="true"></i> ล้างค่า</button>
           </div>
        </div>

     </div><!-- End class="container-fluid"-->
  </div><!-- Endclass="well" -->
</div><!-- End class="collapse"-->
<!-- End search -->

<script>

    $(function () {

    $("#range").ionRangeSlider({
          type: "double",
          min: 1,
          max: 100,
          from: 60,
          to: 80,
          prefix: "",
          postfix: " ปี",
          decorate_both: false,
          values_separator: " to ",
          grid: true
        });

    });
</script>
