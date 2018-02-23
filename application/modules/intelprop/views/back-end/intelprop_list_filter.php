

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
                <input data-column="1" type="text" class="form-control numberonly column_filter" id="col1_filter" placeholder="เลขประจำตัวประชาชน (13 หลัก)" maxlength="13">
            </div>
             <div class="col-xs-12 col-sm-6">
              <div class="form-check">
               <h3>
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input "  id="disablepid" >
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
          <div class="col-xs-12 col-sm-3" >
            <h3><label for="col3_filter">เพศ:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-3" >

                 <select  class="form-control" id="gender">
                   <?php
                        $gender = $this->common_model->custom_query('SELECT * FROM std_gender');
                        foreach ($gender as $key_gen => $value_gen) {
                        $name_gen = explode(" ",$value_gen['gender_name']);
                   ?>
                        <option value="<?php echo $value_gen['gender_code']; ?>"><?php echo $name_gen[0]; ?></option>
                  <?php } ?>
                </select>
          </div>
          <div class="col-xs-12 col-sm-1" style="width: 6%;">
                 <h3><label>อายุ:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-1">
            <input type="text" id="age_str" name="" class="form-control">
             <!-- <input type="text" id="range" value="" name="range" /> -->
          </div>
           <div class="col-xs-12 col-sm-1" style="width: 6%;">
                 <h3><label>ถึง</label></h3>
          </div>
           <div class="col-xs-12 col-sm-1">
              <input type="text" id="age_end" name="" class="form-control">
             <!-- <input type="text" id="range" value="" name="range" /> -->
          </div>
          <div class="col-xs-12 col-sm-1" >
                 <h3><label>ปี</label></h3>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col5_filter">สถานะดำเนินการ:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-3">
            <select class="form-control" id="statusoper">
               <option value="All">ทั้งหมด</option>
               <option value="date_of_reg">วันที่ขึ้นทะเบียน</option>
               <!-- <option value="date_of_visit">ตรวจเยี่ยม</option> -->
               <!-- <option value="date_of_pay">ช่วยเหลือ</option> -->
               <option value="notvalue">ไม่ระบุสถานะ</option>
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

            <input type="hidden" data-column="3" class="column_filter" id="col3_filter">
            <input type="hidden" data-column="6" class="column_filter" id="col6_filter">
            <input type="hidden" data-column="9" class="column_filter" id="col9_filter">
            <input type="hidden" data-column="10" class="column_filter" id="col10_filter">
            <input type="hidden" data-column="11" class="column_filter" id="col11_filter">
            <input type="hidden" data-column="12" class="column_filter" id="col12_filter">
            <input type="hidden" data-column="13" class="column_filter" id="col13_filter">

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

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3"><h3><label>ที่อยู่:</label></h3></div>
          <div class="col-xs-12 col-sm-3 dropdown">
                <select title="จังหวัด" placeholder="เลือกจังหวัด" class="elder_addr_pre" style="width: 100%" id="Province" name="pers_addr[addr_province]" onchange="optionGen(this,'Amphur');">
                    <option value="">เลือกจังหวัด</option>
                    <?php $temp = $this->personal_model->getAll_Province();
                    foreach ($temp as $key => $row) { ?>
                    <option value="<?php echo $row['area_code']; ?>"><?php echo $row['area_name_th']; ?></option>
                    <?php  } ?>
                </select>
          </div>
          <div class="col-xs-12 col-sm-3">
               <select title="อำเภอ" placeholder="เลือกอำเภอ" class="elder_addr_pre" style="width: 100%" id="Amphur" name="pers_addr[addr_district]" onchange="optionGen(this,'Tambon');" disabled>
                <option value="">เลือกอำเภอ</option>
              </select>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-12"><h3><label>สาขาภูมิปัญญา:</label></h3></div>
        </div>

        <div class="form-group row">
          <?php

               $std_wisd = $this->common_model->custom_query("SELECT * FROM std_wisdom ");
               foreach ($std_wisd as $key => $value) {
          ?>
          <div class="col-xs-12 col-sm-3"><input type="checkbox" class="wisdom" value="<?php echo $value['wis_code']; ?>">&nbsp;&nbsp;<font style="font-size: 15px;"><?php echo $value['wis_name']; ?></font></div>
          <?php } ?>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col6_filter">หน่วยงาน (ผู้บันทึกข้อมูล):</label></h3>
          </div>
          <div class="col-xs-12 col-sm-6">
            <?php $usrm = $this->common_model->custom_query("SELECT * FROM usrm_org"); ?>
            <select class="form-control" id="usrm_org">
              <?php foreach($usrm as $key=>$value) {?>
               <option><?php echo $value['org_title']; ?></option>
               <?php } ?>
            </select>
          </div>
        </div>

        <div class="row">
           <div class="col-xs-12 col-sm-8">&nbsp;</div>
           <div class="col-xs-12 col-sm-4 right" style="padding-right: 3px;">
               <button id="filtersearch" class="btn btn-primary btn-save" type="button"  title="ค้นหา" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
               <button id="btnclear" class="btn btn-primary  btn-cancel" type="button" title="ค้นหา" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-refresh" aria-hidden="true"></i> ล้างค่า</button>
           </div>
        </div>

     </div><!-- End class="container-fluid"-->
  </div><!-- Endclass="well" -->
</div><!-- End class="collapse"-->
<!-- End search -->

<script>
  // var gender = 'false';

    $(function () {

    $('select.elder_addr_pre').select2();

    //เช็คกรณีไม่ระบุเลขบัตรประจำตัวประชาชน
    $('#disablepid').on('change',function(){
        if($(this).prop('checked')){
          $('#col1_filter').prop('disabled','disabled');
        }else{
          $('#col1_filter').prop('disabled','');
        }
    });

    //กดล้างค่า
    $('#btnclear').click(function(){

       $('.column_filter').each(function(){
           $(this).val('');
       });

       $('#gender').each(function(){
          if($(this).val()==0){
            $(this).prop('selected','selected');
          }
       });

       $('#statusoper').each(function(){
          if($(this).val()=='All'){
            $(this).prop('selected','selected');
          }
       });

       $('input[name=start]').val('');
       $('input[name=end]').val('');

       location.reload();

    });

    //เลือกเพศ
    $('#gender').change(function(){
         // gender = $(this).val();
         // console.log(gender);
          $('#col9_filter').val($(this).val());
    });

    // ช่วงอายุ
    $('#age_str,#age_end').change(function(){
        var value_age = $('#age_str').val()+";"+$('#age_end').val();
        // console.log(value_age);
        $('#col3_filter').val(value_age);
    });

    //เลือกถึงวันที่ สถานะดำเนินการ
    $('#datepicker').change(function(){
        var statusoper  = $('#statusoper').val();
        var composedate = $('input[name=start]').val()+'_'+$('input[name=end]').val();
         if(statusoper == 'date_of_reg'){
           $('#col6_filter').val(composedate);
         }
    });

    // ที่อยู่จังหวัด
    $('#Province').change(function(){
        $('#col11_filter').val($(this).val());
    });

    //ที่อยู่อำเภอ
     $('#Amphur').change(function(){
        $('#col10_filter').val($(this).val());
    });

    //สาขาภูมิปัญญา
    $('.wisdom').change(function(){
       var value_wisdom="";
        $('.wisdom').each(function(){
           if($(this).prop('checked')){
             value_wisdom = value_wisdom+","+$(this).val();
           }
        });
        // console.log(value_wisdom);
        $('#col12_filter').val(value_wisdom);
    });

     $('#usrm_org').change(function(){
        $('#col13_filter').val($(this).val());
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
