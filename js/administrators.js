$('#filtro').keyup(function(e){
    if(e.keyCode == 13)
    {
        RecargarTabla()
    }
});


var $TABLA_ADMIN = null
$(function () {
    ListAdmin()
});


function RecargarTabla() {
    if ($TABLA_ADMIN != null)
        $TABLA_ADMIN.draw();
    return false;
}

function ListAdmin(){
    $TABLA_ADMIN = $('#admin').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/administradorController.php',
            "type": "POST",
            "data": function (d) {
                d.parametro = $("#filtro").val();
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTADMIN",
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "fullname" },
            { "data": "identification" },
            { "data": "email" },
            { "data": "state" },
            {
                "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "10%",
                "render": function (data, type, full, meta) {
                    return "<div class='btn-group'><a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' class='p-0 btn'>"+
                        "Acciones <i class='fa fa-angle-down ml-2 opacity-8'></i>"+
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'><a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate' onclick='GetId("+data+")'>inactivate</a>"+
                        "<a href='edit_administrator.php?id="+data+"' type='button' tabindex='0' class='dropdown-item'>Edit</a><div tabindex='-1' ></div>"
                        +"<div tabindex='-1' ></div>"
                        +"</div></div>";
                }
            }
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}

var ID = 0
function GetId(id){
    ID = id
}


function InactivateAdmin(){
    $.ajax({
        type: "POST",
        url: "./controller/administradorController.php",
        data: {
            tipo:'INACTIVATEADMIN',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully inactivated administrator');
                location.href = 'administrators.php';
            } else {
                alert(json.mensaje);
            }
        }, error: function (jqXHR, exception) {
            console.info(jqXHR)
            console.info(exception)
            return false;
        }   
    });
}