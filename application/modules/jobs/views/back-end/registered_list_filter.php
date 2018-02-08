<!-- Search Modal -->
<div class="modal fade" id="mySearch" role="dialog">
  <div class="modal-dialog">
     <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title" style="color: #333; font-size: 15px;">ค้นหา</h4>
       </div>
      <div class="modal-body">
        <label for="col1_filter">วันที่ขึ้นทะเบียน:</label>
        <input type="date" class="form-control date_filter">
        <input data-column="1" type="text" class="form-control column_filter" id="col1_filter">

        <label for="col2_filter">เลขประจำตัวประชาชน:</label>
        <input data-column="2" type="text" class="form-control column_filter" id="col2_filter">

        <label for="col3_filter">ชื่อตัว - ชื่อสุกล:</label>
        <input data-column="3" type="text" class="form-control column_filter" id="col3_filter">

        <label for="col5_filter">ประเภทงานที่ต้องการ:</label>
        <input data-column="5" type="text" class="form-control column_filter" id="col5_filter">

        <label for="col6_filter">สาขาความเชี่ยวชาญ:</label>
        <input data-column="6" type="text" class="form-control column_filter" id="col6_filter">

        <label for="col7_filter">สถานะ:</label>
        <input data-column="7" type="text" class="form-control column_filter" id="col7_filter">


       <!-- /* fitter */ -->
         <script type="text/javascript">
            $('.date_filter').css('display','none');
            var date_set = '<?php echo (date("Y")+543)."-".date("m-d"); ?>';

                 $('.date_filter').next().focus(function(){
                    $(this).css('display','none');
                    $(this).prev().css('display','block');
                    $(this).prev().val(date_set);
                 });

                $('.date_filter').change(function(){
                      var val_date    = $(this).val();
                      if(val_date!=''){
                      var date_filter = val_date.split("-");
                      //var year_th = parseInt(date_filter[0])+543;
                      var date_th     = date_filter[2]+"/"+date_filter[1]+"/"+date_filter[0];
                      $(this).next().val(date_th);
                      }else{
                        $(this).next().val('');
                        $(this).next().css('display','block');
                        $(this).css('display','none');
                        $(this).val(date_set);
                      }
                });
         </script>
         <!-- END fitter -->

      </div>
       <div class="modal-footer">
        <button id="filter" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-search" aria-hidden="true"></i> ตกลง</button>
       </div>
    </div>

  </div>
</div>
<!-- End Search Modal -->
