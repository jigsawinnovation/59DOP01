var table;
$(document).ready(function(){
	table = $('#dtable').DataTable({
      "searching": false,
      "bSort" : false,
      "bLengthChange": false,
      "pageLength": 50,
      "responsive": true,
      "language": {
        "sProcessing":   "กำลังดำเนินการ...",
        "sLengthMenu":   "แสดง _MENU_ แถว",
        "sZeroRecords":  "ไม่พบข้อมูล",
        // "sInfo":         "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว / รายการทั้งหมด จำนวน _TOTAL_ รายการ (แบ่งออกเป็น _PAGES_ หน้า หน้าละ 50 รายการ)",
        "sInfo":         "รายการทั้งหมด จำนวน _TOTAL_ รายการ (แบ่งออกเป็น _PAGES_ หน้า หน้าละ 50 รายการ)",
        // "sInfoEmpty":    "แสดง 0 ถึง 0 จาก 0 แถว",
        "sInfoEmpty":    "รายการทั้งหมด จำนวน 0 รายการ (แบ่งออกเป็น _PAGES_ หน้า หน้าละ 50 รายการ)",
        "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
        "sInfoPostFix":  "",
        "sSearch":       "ค้นหา: ",
        "sUrl":          "",
        "oPaginate": {
          "sFirst":    '<i class="fa fa-step-backward" style="font-size: 12px;" aria-hidden="true"></i>',
          "sPrevious": '<i class="fa fa-backward" style="font-size: 12px;" aria-hidden="true"></i>',
          "sNext":     '<i class="fa fa-forward" style="font-size: 12px;" aria-hidden="true"></i>',
          "sLast":     '<i class="fa fa-step-forward" style="font-size: 12px;" aria-hidden="true"></i>'
        }
      }
       /*
       // Show Export Tools
       dom: '<"html5buttons"B>lTfgitp',
       buttons: [
           {extend: 'copy'},
           {extend: 'csv'},
           {extend: 'excel', title: 'ExampleFile'},
           {extend: 'pdf', title: 'ExampleFile'},
           {extend: 'print',

            customize: function (win){
                   $(win.document.body).addClass('white-bg');
                   $(win.document.body).css('font-size', '10px');

                   $(win.document.body).find('table')
                           .addClass('compact')
                           .css('font-size', 'inherit');
           }
           }
       ]
       */
    });
	
	$(".clickImage").on("click", function(){
		var src = $(this).attr("src");
		$('#image').modal('show');
		$("#previewImage").attr("src", src);
	});
	
	$('#dltModel').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var id = button.data("id");
		$('#dltModel').data('id', id);
	})

	//$('.confirm-delete').on('click', function(e) {e.preventDefault();var id = $(this).data('id');$('#myModal').data('id', id).modal('show');});

	$('#btnYes').click(function() {
		window.location.replace(base_url+'webconfig/infrm3'+'/Delete/'+$('#dltModel').data('id'));
		console.log($('#dltModel').data('id'));
	});


	$('#dtable').on('click', 'td.lnk', function () {
		  
	  // Get Data from record table
	  var tmp = table.row($(this).parent()).data();
	  console.log(tmp[1]);

	  //console.log(name);
	  //console.log( companyTable.row(this).data()[1]);
	  //$("#company-full-name").val(companyTable.row(this).data()[1]);
	  //$("#company-short-name").val(companyTable.row(this).data()[2]);
	  //console.log(pid);
	  $('#'+tmp[1]).modal("show");
	});
});