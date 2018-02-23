	<!--<div class="row">
	   <div class="col-xs-12 col-sm-12 text-right">

          <?php
            $tmp = $this->admin_model->getOnce_Application(12);
            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(12,$user_id); //Check User Permission
          ?>
          <a <?php if(!isset($tmp1['perm_status'])) {?>
            readonly
          <?php }else{?> href="<?php echo site_url('webconfig/infrm1');?>" <?php }?> style="color: #000; padding-left: 20px; padding-right: 20px;" title="<?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>" class="btn btn-default">
              <i class="fa fa-plus" aria-hidden="true"></i>
          </a>

          <?php
            $tmp = $this->admin_model->getOnce_Application(16);
            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(16,$user_id); //Check User Permission
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
	</div>-->

	<div class="table-responsive">
    <table id="dtable" class="table table-striped table-bordered table-hover dataTables-example" >
		<thead style="color: #333; font-wight: bold; font-size: 15px; font-weight: bold;">
			<tr>
				<th class="text-center" style="width: 70px;">#</th>
				<th class="text-center">ชื่อข่าวประชาสัมพันธ์</th>
				<th class="text-center" style="width: 200px;">บันทึกเมื่อ</th>
				<th style="width: 100px;">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($news_list AS $k => $row) { ?>
			<tr>
				<td class="lnk"><?php echo $i; ?></td>
				<td class="lnk"><?php echo $row['news_name']; ?></td>
				<td class="lnk"><?php echo formatDateThai1($row['insert_datetime']); ?></td>
				<td>
					<a href="<?php echo site_url("webconfig/infrm1/Edit/".$row['news_id'])?>" class="btn btn-default"><i class="fa fa-pencil-square" aria-hidden="true" style="color: #000"></i></a>
					<a href="#" data-id=<?php echo $row['news_id'];?> data-toggle="modal" data-target="#dltModel" title="ลบ" type="button" class="btn btn-default">
					  <i class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #000"></i>
					</a>
				</td>
			</tr>
			<?php $i++; } ?>
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
        <h4 class="modal-title" style="color: #333; font-size: 15px;">หน้าต่างแจ้งเตือนเพื่อยืนยัน</h4>
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
