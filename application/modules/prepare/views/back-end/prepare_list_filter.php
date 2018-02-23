 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.css")?>" type="text/css"  />
 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.css")?>" type="text/css"  />
 <link rel="stylesheet" href="<?php echo base_url("assets/plugins/Static_Full_Version/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css")?>" type="text/css"  />

<!-- search-->
  <div class="collapse" id="collapseExample">
  <div class="well" style="background-color: rgb(255, 255, 255);">
     <div class="container-fluid">
        <form id="dkm_info" action="" method="get">
        <div class="form-group row">
          <div class="col-xs-12 col-sm-12"><h3><label>ค้นหา</label></h3></div>
        </div>

        <div class="form-group row">
          <div class="col-xs-12 col-sm-3">
            <h3><label for="col2_filter">ชื่อองค์ความรู้:</label></h3>
          </div>
          <div class="col-xs-12 col-sm-6">
            <input data-column="2" name="dkm_title" type="text" class="form-control column_filter" value="<?php echo $_GET['dkm_title'];?>" placeholder="ชื่อองค์ความรู้">
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
               <button id="filtersearch" class="btn btn-primary btn-save" type="button"  title="ค้นหา" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
               <button id="btnclear" class="btn btn-primary  btn-cancel" type="button" title="ล้างค่า" style=" background-color: #2f4050;border: 1px;"><i class="fa fa-refresh" aria-hidden="true"></i> ล้างค่า</button>
           </div>
        </div>
      </form>
     </div><!-- End class="container-fluid"-->
  </div><!-- Endclass="well" -->
</div><!-- End class="collapse"-->
<!-- End search -->

<script>
  // var gender = 'false';

    $(function () {

    //เช็คกรณีไม่ระบุเลขบัตรประจำตัวประชาชน
    $('#disablepid').on('change',function(){
        if($(this).prop('checked')){
          $('#col1_filter').prop('disabled','disabled');
        }else{
          $('#col1_filter').prop('disabled','');
        }
    });

    $("#filtersearch").on('click', function () {
      $('#dkm_info').submit();
    });

    //กดล้างค่า
    $('#btnclear').click(function(){
        window.location='';
    });

    //เลือกเพศ
    $('#gender').change(function(){
         // gender = $(this).val();
         // console.log(gender);
          $(this).prev().val($(this).val());
    });

    //เลือกถึงวันที่
    $('#datepicker').change(function(){
        var statusoper  = $('#statusoper').val();
        var composedate = $('input[name=start]').val()+'_'+$('input[name=end]').val();
         if(statusoper == 'date_of_reg'){
           $('#col5_filter').val(composedate);
         }else if(statusoper == 'date_of_visit'){
           $('#col6_filter').val(composedate);
         }else if(statusoper == 'date_of_pay'){
           $('#col7_filter').val(composedate);
         }
    });


    });
</script>
