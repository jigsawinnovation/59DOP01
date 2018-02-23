var table;
$(document).ready(function(){
	$("#menu_topright").html(
	'<a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="'+base_url+'webconfig/infrm4"><i class="fa fa-plus" aria-hidden="true"></i> </a>'+
	'<a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 2px 20px 2px 20px;" href="'+base_url+'webconfig/main"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>'
	);
	
	table = $('#dtable').DataTable({
		"searching": false,
		"bLengthChange": false,
		"pageLength": 25,
		"responsive": true,
		"language": {
			"sProcessing":   "กำลังดำเนินการ...",
			"sLengthMenu":   "แสดง _MENU_ แถว",
			"sZeroRecords":  "ไม่พบข้อมูล",
			"sInfo":         "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
			"sInfoEmpty":    "แสดง 0 ถึง 0 จาก 0 แถว",
			"sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
			"sInfoPostFix":  "",
			"sSearch":       "ค้นหา: ",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "หน้าแรก",
				"sPrevious": "ก่อนหน้า",
				"sNext":     "ถัดไป",
				"sLast":     "หน้าสุดท้าย"
			}
		}
       /*
       // Show Export Tools
       dom: '<"html5buttons"B>lTfgitp',
       buttons: [
           { extend: 'copy'},
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
	
	
	$('#dltModel').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var id = button.data("id");
		$('#dltModel').data('id', id);
	})

	//$('.confirm-delete').on('click', function(e) {e.preventDefault();var id = $(this).data('id');$('#myModal').data('id', id).modal('show');});

	$('#btnYes').click(function() {
		window.location.replace(base_url+'webconfig/infrm4'+'/Delete/'+$('#dltModel').data('id'));
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
})