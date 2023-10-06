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
    var datastring = $("#create_staffCompany").serialize()+'&tipo=CREATESTAFF';
    
    $.ajax({
        type: "POST",
        url: "./controller/staffCompanyController.php",
        data: 
            datastring
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully created staff company');
                location.href = 'staff_company.php';
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
    var datastring = $("#editar_staffCompany").serialize()+'&id='+ID+'&tipo=EDITSTAFF';
    $.ajax({
        type: "POST",
        url: "./controller/staffCompanyController.php",
        data: datastring,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully edit staff company');
                location.href = 'staff_company.php';
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




var $TABLA_STAFF_COMPANY = null
$(function () {
    ListStaffCompany()
    ListeningHostCompany()
});


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
            $("#id_host_company").append(html);

            }else{
                var html =  "<option value=''>Select host company</option>"
                $("#id_host_company").html(html);
            }
        }
        
    });

}



function ListeningWorkPlace(e){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'WORKPLACE',
            id:e.value
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

            var html =  "<option value=''>Select work place</option>"
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            
            $("#id_work_place").html(html);
            }else{
                var html =  "<option value=''>Select work place</option>"
                $("#id_work_place").html(html);
            }
        }
        
    });

}


function RecargarTabla() {
    if ($TABLA_STAFF_COMPANY != null)
        $TABLA_STAFF_COMPANY.draw();
    return false;
}

function ListStaffCompany(){
    $TABLA_STAFF_COMPANY = $('#staff_company').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/staffCompanyController.php',
            "type": "POST",
            "data": function (d) {
                d.parametro = $("#filtro").val();
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTASTAFFCOMPANY",
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "work_place" },
            { "data": "host_compnay" },
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
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'><a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate_staff_company' onclick='GetId("+data+")'>Inactivate</a>"+
                        "<button type='button' tabindex='0' class='dropdown-item'  data-toggle='modal' data-target='#Edit_staff' onclick='Editar("+data+")'>Edit</button><div tabindex='-1' ></div>"
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


function ListeningWorkPlace_edit_change(e){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'WORKPLACE',
            id:e.value
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

            var html =  "<option value=''>Select work place</option>"
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            
            $("#id_work_place_edit").html(html);
            }else{
                var html =  "<option value=''>Select work place</option>"
                $("#id_work_place_edit").html(html);
            }
        }
        
    });
}

function ListeningWorkPlace_edit(id){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'WORKPLACE',
            id:id
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

            var html =  "<option value=''>Select work place</option>"
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            
            $("#id_work_place_edit").html(html);
            }else{
                var html =  "<option value=''>Select work place</option>"
                $("#id_work_place_edit").html(html);
            }
        }
        
    });
}

function Editar(id){
    ID = id
    
    $.ajax({
        type: "POST",
        url: "./controller/staffCompanyController.php",
        data:{
            tipo:'DETALLE',
            id:ID
        },
        success: function(data) {   
            var json = JSON.parse(data);
            if (json.status == 'success') {
                $("#name_edit").val(json.datos[0].name);
                $("#address_staff").val(json.datos[0].address);
                $("#phone_staff").val(json.datos[0].phone);
                $("#payer_staff").val(json.datos[0].payer);
                  ListeningHostCompanyEdit()
                  setTimeout(function(){ $("#id_host_company_edit").val(json.datos[0].id_host_company); }, 500);
                  
                  setTimeout(function(){ ListeningWorkPlace_edit(json.datos[0].id_host_company)}, 700);
                  
                  setTimeout(function(){ $("#id_work_place_edit").val(json.datos[0].id_work_place); }, 900);


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

                var html =  ""
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
            }
            $("#id_host_company_edit").append(html);

            }else{
                var html =  "<option value=''>Select host company</option>"
                $("#id_host_company_edit").html(html);
            }
        }
        
    });
}

function InactivateStaff(){
    $.ajax({
        type: "POST",
        url: "./controller/staffCompanyController.php",
        data: {
            tipo:'INACTIVATESTAFF',
            id:ID
        },
        success: function(data) {    
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully Staff Company delete ');
                location.href = 'staff_company.php';
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