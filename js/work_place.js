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
        var datastring = $("#create_work_place").serialize()+'&tipo=CREATEWORK';
        $.ajax({
            type: "POST",
            url: "./controller/workPlaceController.php",
            data: 
                datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                if (json.status == 'success') {
                    alert('successfully created work place');
                    location.href = 'work_place.php';
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
        var datastring = $("#edit_work_place").serialize()+'&id='+ID+'&tipo=EDITWORK';
        $.ajax({
            type: "POST",
            url: "./controller/workPlaceController.php",
            data: 
                datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                if (json.status == 'success') {
                    alert('successfully edit work place');
                    location.href = 'work_place.php';
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

var ID = 0

$(document).ready(function () {
  
});

var $TABLA_WORK_PLACE = null
$(function () {
    ListWorkPlace()
    
});

$(document).on('show.bs.modal', '#Newwork', function (e) {
    ListeningHostCompany()
});


function RecargarTabla() {
    if ($TABLA_WORK_PLACE != null)
        $TABLA_WORK_PLACE.draw();
    return false;
}


function ListWorkPlace(){
    $TABLA_WORK_PLACE = $('#work_place').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/workPlaceController.php',
            "type": "POST",
            "data": function (d) {
                d.parametro = $("#filtro").val();
                
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTAWORK_PLACE",
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "work_place" },
            { "data": "host_company" },
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
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'><a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate_work_place' onclick='GetId("+data+")'>Inactivate</a>"+
                        "<button type='button' tabindex='0' class='dropdown-item'  data-toggle='modal' data-target='#Edit_work' onclick='Editar("+data+")'>Edit</button><div tabindex='-1' ></div>"
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

                var html =  "<option value=''>Select host company</option>"
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            $("#id_host_company_work").html(html);
            }
        }   
    });
}

function Editar(id){
    ID = id
    
    $.ajax({
        type: "POST",
        url: "./controller/workPlaceController.php",
        data:{
            tipo:'DETALLE',
            id:ID
        },
        success: function(data) {   
            var json = JSON.parse(data);
            if (json.status == 'success') {
                $("#name_work_edit").val(json.datos[0].name);
                  ListeningHostCompanyEdit()
                  setTimeout(function(){ $("#id_host_company_work_edit").val(json.datos[0].id_host_company); }, 500);
                 
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


 function ListeningHostCompanyEdit(){
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

                var html =  "<option value=''>Select host company</option>"
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            $("#id_host_company_work_edit").html(html);
            }
        }   
    });
}

function GetId(id){
    ID = id
}

function Create(){
    ID = 0
}


function InactivateWorkPlace(){
    $.ajax({
        type: "POST",
        url: "./controller/workPlaceController.php",
        data: {
            tipo:'INACTIVATEWORK',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully Work company delete ');
                location.href = 'work_place.php';
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