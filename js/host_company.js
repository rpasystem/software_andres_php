$('#filtro').keyup(function(e){
    if(e.keyCode == 13)
    {
        RecargarTabla()
    }
});




(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }else{
                    event.preventDefault();
                
                    Validate()
                }
                
            }, false);
        });
    }, false);


})();

function Validate(){
    if(ID== 0){
        var datastring = $("#create_hostCompany").serialize()+'&tipo=CREATECOMPANY';
        $.ajax({
            type: "POST",
            url: "./controller/hostCompanyController.php",
            data: 
                datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                if (json.status == 'success') {
                    alert('successfully created host company');
                    location.href = 'host_company.php';
                } else {
                    alert(json.mensaje);
                }
            }, error: function (jqXHR, exception) {
                console.info(jqXHR)
                console.info(exception)
                return false;
            }
            
        });
    }else{
        var datastring = $("#edit_hostCompany").serialize()+'&id='+ID+'&tipo=EDITCOMPANY';
        $.ajax({
            type: "POST",
            url: "./controller/hostCompanyController.php",
            data: 
                datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                if (json.status == 'success') {
                    alert('successfully edit host company');
                    location.href = 'host_company.php';
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
}





var $TABLA_HOST_COMPANY = null
$(function () {
    ListHostCompany()
});


function RecargarTabla() {
    if ($TABLA_HOST_COMPANY != null)
        $TABLA_HOST_COMPANY.draw();
    return false;
}

function ListHostCompany(){
    $TABLA_HOST_COMPANY = $('#host_company').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/hostCompanyController.php',
            "type": "POST",
            "data": function (d) {
                d.parametro = $("#filtro").val();
                
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTAHOSTCOMPANY",
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "date",
                "width": "20%"},
                {
                    "data": "id",
                    "orderable": false,
                    "searchable": false,
                    "width": "10%",
                    "render": function (data, type, full, meta) {
                        return "<div class='btn-group'><a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' class='p-0 btn'>"+
                        "Actions <i class='fa fa-angle-down ml-2 opacity-8'></i>"+
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'><a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate_host_company' onclick='GetId("+data+")'>Inactivate</a>"+
                        "<button type='button' tabindex='0' class='dropdown-item'  data-toggle='modal' data-target='#Edit_host' onclick='Editar("+data+")'>Edit</button><div tabindex='-1' ></div>"
                        +"<div tabindex='-1' ></div>"
                        +"</div></div>";;
                    }
                }
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}

function Editar(id){
    ID = id
    
    $.ajax({
        type: "POST",
        url: "./controller/hostCompanyController.php",
        data:{
            tipo:'DETALLE',
            id:ID
        },
        success: function(data) {   
            var json = JSON.parse(data);
            if (json.status == 'success') {
                $("#edit_name").val(json.datos[0].name);
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


var ID = 0
function GetId(id){
    ID = id
}

function Create(){
    ID = 0
}

function InactivateHost(){
    $.ajax({
        type: "POST",
        url: "./controller/hostCompanyController.php",
        data: {
            tipo:'INACTIVATEHOST',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully Host Company delete ');
                location.href = 'host_company.php';
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