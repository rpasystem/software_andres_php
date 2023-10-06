var $TABLA_PAYROLL = null
$(function () {



    ListPayRoll()
 
});



function ListPayRoll(){
    $.ajax({
        type: "POST",
        url: "./controller/print_payrollController.php",
        data: {
            tipo:'LIST_PRINT'
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){
             
                var html =  ""
          
        
            for (var i = 0; i < json.cant; i++) {
                html+= "<tr><td>"+json[i].id+"</td><td>"+json[i].host_company+"</td><td>"+json[i].date+"</td><td>"+json[i].date_add+"</td><td><a href='detail_print_payroll.php?id="+json[i].id+"'>View Details</a></td></tr>";            
            }
            $("#print_payroll").append(html);

            }
        }
        
    });
}


/*

function RecargarTabla() {
    if ($TABLA_PAYROLL != null)
        $TABLA_PAYROLL.draw();
    return false;
}

function ListPayRoll(){
    $TABLA_PAYROLL = $('#historic_payroll').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "order": [[ 0, "desc" ]],
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.date = $("#dates").val();
                return $.extend({}, d, {
                    "tipo": "LIST_PRINT",
                });
            }
        },
        "columns": [
            { "data": "id" },
            {"data":"host_company"},
            { "data": "dates" },
            { "data": "date_add" },
            { "data": "success" },
            { "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "15%",
                "render": function (data, type, full, meta) {
                    return "<a href='detail_Print.php?id="+data+"'>View Details</a>";
                }
            },
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}

*/