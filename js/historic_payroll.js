var $TABLA_HISTORICO = null
$(function () {
    ListHistoric()
   
});



$( function() {
    $("#day_of_the_week").datepicker(
        { dateFormat: 'm/d/yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );
function ListDates(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'DATES'
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

                var html =  ""
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].name+"' >"+json.datos[i].name+"</option>";            
            }
            $("#dates").append(html);

            }
        }
        
    });
}

function RecargarTabla() {
    if ($TABLA_HISTORICO != null)
        $TABLA_HISTORICO.draw();
    return false;
}

function ListHistoric(){
    $TABLA_HISTORICO = $('#historic_payroll').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            
            "order": [[ 0, "desc" ]],
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.date = $("#day_of_the_week").val();
                return $.extend({}, d, {
                    "tipo": "LIST_HISTORIC",
                });
            }
        },
        "columns": [
            { "data": "id" },
            {"data":"host_company"},
            { "data": "dates" },
            { "data": "date_add" },
            { "data": "success" },
            { "data": "fails" },
            { "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "15%",
                "render": function (data, type, full, meta) {
                    return "<a href='detail_historic.php?id="+data+"'>View Details</a>";
                }
            },
            { "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "15%",
                "render": function (data, type, full, meta) {
                    return "<a href='#' onclick='Delete("+data+")' >Delete</a>";
                }
            },
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}


function Delete(id){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'delete',
            id
        }
        ,
        success: function(data) {
            RecargarTabla()
        }
        
    });   
}