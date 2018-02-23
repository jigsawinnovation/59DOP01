var table;
$(document).ready(function() {

    table = $('#dtable').DataTable({
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      // Load data for the table's content from an Ajax source
      "ajax": {
           "url": dtable_url,
           "type": "POST",
           data:{ 'request':'get_users_invoices', 'csrf_dop': csrf_hash},
      },
      //Set column definition initialisation properties.
      "columnDefs": [
        { "name": "B.pid",  "targets": 1 },
        { "name": "CONCAT(B.pers_firstname_th,' ', B.pers_lastname_th)", "targets": 2 },
        { "name": "D.gender_name",  "targets": 3},
        { "name": "B.date_of_birth",    "targets": 4 },
        { "name": "A.date_of_req",    "targets": 5 },
        { "name": "A.date_of_pay",    "targets": 6 },
        //{ "name": "A.pay_amount",    "targets": 7,"visible": false },
        //{ "name": "start_age",    "targets": 8 },
        //{ "name": "end_age",    "targets": 9 },
        //{ "name": "A.insert_org_id", "targets": 10}
      ],
      "order": [[ 0, "desc" ]],

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
        // "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
        "sInfoFiltered": "",
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

    });


    function filterColumn (i) {
        $('#dtable').DataTable().column(i).search(
            $('#col'+i+'_filter').val()
        ).draw();
        console.log($('#col'+i+'_filter').val());
    }

    $("#filtersearch").on('click', function () {
      $('input.column_filter').each(function(  ) {
        if($(this).val() != ''){
          filterColumn($(this).data('column'));
        }
      });
      //console.log("filter");
      // table.draw();
    });

    $("#dtable_filter").hide();



});

$('#dltModel').on('show', function() {var id = $(this).data('id'),removeBtn = $(this).find('.danger');});

//$('.confirm-delete').on('click', function(e) {e.preventDefault();var id = $(this).data('id');$('#myModal').data('id', id).modal('show');});

$('#btnYes').click(function() {
    window.location.replace(base_url+'difficult/sufferer_form1'+'/Delete/'+$('#dltModel').data('id'));
});

var opn = function(node) {
    var id = $(node).data('id');
    $('#dltModel').data('id', id).modal('show');
}

/*$('#dtable').on('click', 'td button.lnk', function () {

  console.log($(this).data('info'));
        var data_info = $(this).data('info');
        $.each(data_info, function(key,val) {
            $("."+key).html(val );
            //console.log(key+': '+val);
        });

  $("#info").modal('show');
  //$('.m'+($(this).parent().parent().index()+1)).modal("show");
});*/
