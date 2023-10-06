


var $TABLA_EMPLOYEE = null
$(function () {
    ListEmployee()
    ListeningHostCompany()
});


function RecargarTabla() {
    if ($TABLA_EMPLOYEE != null)
        $TABLA_EMPLOYEE.draw();
    return false;
}

function ChangeHostCompany(e){

    if(e.value != ""){

        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'STAFFBYHOSTCOMPANY',
                id:e.value

            }
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
    
                if(json.cant > 0){
    
                    var html =  ""
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
                }
                $("#staff_company").append(html);
    
                }else{
                    var html =  "<option value=''>Select staff company</option>"
                    $("#staff_company").html(html);
                }
            }
            
        });
    
    }
}


function ListeningHostCompany(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'HOSTCOMPANY'
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

                var html =  ""
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            $("#host_company").append(html);

            }else{
                var html =  "<option value=''>Select host company</option>"
                $("#host_company").html(html);
            }
        }
        
    });

}

function ListEmployee(){
    $TABLA_EMPLOYEE = $('#employee').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/empleadoController.php',
            "type": "POST",
            "data": function (d) {
                d.parametro = $("#filtro").val();
                d.host_company = $("#host_company").val();
                d.staff_company = $("#staff_company").val();
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTEMPLOYEE",
                });
            }
        },
        "columns": [
            { "data": "id_employee" },
            { "data": "fullname" },
            { "data": "identification" },
            { "data": "address" },
            { "data": "phone" },
            { "data": "position" },
            { "data": "staff" },
            { "data": "state" },
            { "data": "nacimiento" },
            { "data": "observation" },
            { "data": "fecha_retiro" },
            { "data": "shift" },
            { "data": "overtime" },
            { "data": "hourvalue" },
            { "data": "admission" },
            { "data": "email" },
            { "data": "emergency" },
            {
                "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "10%",
                "render": function (data, type, full, meta) {
					
                    var button= "<div class='btn-group'><a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' class='p-0 btn'>"+
                        "Actions <i class='fa fa-angle-down ml-2 opacity-8'></i>"+
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'>";
                        if(full.state == "Active"){
                            button = button + "<a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate_employee' onclick='GetId("+data+")'>Inactivate</a>";
                        }else{
                            button = button + "<a href='#' class='dropdown-item'  data-toggle='modal' data-target='#activate_employee' onclick='GetId("+data+")'>Activate</a>";
                        }
                        
                        button = button +"<a href='edit_employee.php?id="+data+"' type='button' tabindex='0' class='dropdown-item'>Edit</a><div tabindex='-1' ></div>"
                        +"<div tabindex='-1' ></div>"
                        +"</div></div>";
                        return button;
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


function activateEmployee(){
    $.ajax({
        type: "POST",
        url: "./controller/empleadoController.php",
        data: {
            tipo:'ACTIVATEEMPLOYEE',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully employee activated ');
                location.href = 'employees.php';
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


function InactivateEmployee(){
    $.ajax({
        type: "POST",
        url: "./controller/empleadoController.php",
        data: {
            tipo:'INACTIVATEEMPLOYEE',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully employee inactivated ');
                location.href = 'employees.php';
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