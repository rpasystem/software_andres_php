$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});

(function () {

    $('#hourvalue').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

      $('#overtime').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

      

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




    
        
        
    
setTimeout(function(){ ListeningState() }, 500);
setTimeout(function(){ ListeningGender()}, 600);
setTimeout(function(){ ListeningNationality()}, 700);
setTimeout(function(){ ListeningHostCompany()}, 800);
setTimeout(function(){ Detalle()}, 1100);
})();



$(document).ready(function () {
    //called when key is pressed in textbox
    $("#id_employee_edit").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
});

$(document).ready(function () {
    $("#first_name").keypress(function (e) {
        var key = e.keyCode;
        $return = (key == 8 || key == 32 || (key < 48 && key > 57) || (key > 64 && key < 91) || (key > 96 && key < 123));
        if (!$return) {
            return false;
        }
    });
});

$(document).ready(function () {
    $("#second_name").keypress(function (e) {
        var key = e.keyCode;
        $return = (key == 8 || key == 32 || (key < 48 && key > 57) || (key > 64 && key < 91) || (key > 96 && key < 123));
        if (!$return) {
            return false;
        }
    });



});

$(document).ready(function () {
    $("#surname").keypress(function (e) {
        var key = e.keyCode;
        $return = (key == 8 || key == 32 || (key < 48 && key > 57) || (key > 64 && key < 91) || (key > 96 && key < 123));
        if (!$return) {
            return false;
        }
    });
});

$(document).ready(function () {
    $("#second_surname").keypress(function (e) {
        var key = e.keyCode;
        $return = (key == 8 || key == 32 || (key < 48 && key > 57) || (key > 64 && key < 91) || (key > 96 && key < 123));
        if (!$return) {
            return false;
        }
    });
});




$(document).ready(function () {
    $("#position").keypress(function (e) {
        var key = e.keyCode;
        $return = (key == 8 || key == 32 || (key < 48 && key > 57) || (key > 64 && key < 91) || (key > 96 && key < 123));
        if (!$return) {
            return false;
        }
    });
});


$(document).ready(function () {
    //called when key is pressed in textbox
    $("#postcode").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
});


$( function() {
    $( "#fecha_retiro" ).datepicker(
        { dateFormat: 'mm-dd-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );


  $( function() {
    $( "#nacimiento" ).datepicker(
        { dateFormat: 'mm-dd-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );

$( function() {
    $( "#admission" ).datepicker(
        { dateFormat: 'mm-dd-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );

$( function() {
    $( "#birth" ).datepicker(
        { dateFormat: 'mm-dd-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );

 /*
$(document).ready(function () {
    //called when key is pressed in textbox
    $("#phone").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
});
*/
/*
$(document).ready(function () {
    $("#identification").keypress(function(e){
        var keyCode = e.which;
     
      
        // Not allow special 
        if ( !( (keyCode >= 48 && keyCode <= 57) 
          ||(keyCode >= 65 && keyCode <= 90) 
          || (keyCode >= 97 && keyCode <= 122) ) 
          && keyCode != 8 && keyCode != 32) {
          e.preventDefault();
        }
      });
});
*/
var FILE_PHOTO = null;
function Detalle(){
    $.ajax({
        type: "POST",
        url: "./controller/empleadoController.php",
        data: {
            id:$("#id_emplyee").val(),
            tipo:'DETALLE'
        },
        success: function(data) {
            var json = JSON.parse(data);
            //$("#photo").val(json.datos[0].url_photo)
            $("#id_employee_edit").val(json.datos[0].id_employee)
            $("#password").val(json.datos[0].password_sin_encrypt)
            $("#first_name").val(json.datos[0].first_name);
            $("#second_name").val(json.datos[0].second_name);
            $("#surname").val(json.datos[0].surname);
            $("#second_surname").val(json.datos[0].second_surname);
            $("#identification").val(json.datos[0].identification);
            $("#address_emp").val(json.datos[0].address);
            $("#nacimiento").val(json.datos[0].nacimiento);
            
            $("#state").val(json.datos[0].id_state);
            setTimeout(function(){FindCities_edit(json.datos[0].id_state)
                setTimeout(function(){ $("#city").val(json.datos[0].id_city)},600);
            },300);
            FILE_PHOTO = {
                'Path': json.datos[0].url_photo,
                'Name': '',
                'Change': 0
            }
            
            

            CambiarImagen(json.datos[0].url_photo);
            $("#postcode").val(json.datos[0].postcode);
            $("#phone_edit").val(json.datos[0].phone);
            $("#emergency").val(json.datos[0].emergency);
            $("#birth").val(json.datos[0].birth);
            $("#fecha_retiro").val(json.datos[0].fecha_retiro);

            setTimeout(function(){ $("#gender").val(json.datos[0].id_gender)},700);
            setTimeout(function(){ $("#nationality").val(json.datos[0].id_nationality)},800);
            $("#email").val(json.datos[0].email);
            $("#admission").val(json.datos[0].admission);

            setTimeout(function(){ $("#host_company").val(json.datos[0].id_host_company)},900);
            
            setTimeout(function(){ HostCompany_edit(json.datos[0].id_host_company)
                setTimeout(function(){ $("#work_place").val(json.datos[0].id_work_place)},1400);
            },1200);
           
            setTimeout(function(){ Find_Staff_edit(json.datos[0].id_work_place)
                setTimeout(function(){ $("#staff_company").val(json.datos[0].id_staff_company)},1800);
            },1600);
            
            
            $("#position").val(json.datos[0].position);
            
            $("#hourvalue").val(json.datos[0].hourvalue);
            $("#overtime").val(json.datos[0].overtime);
            $("#shift").val(json.datos[0].shift);
            $("#observation").val(json.datos[0].observation);
        }, error: function (jqXHR, exception) {
            console.info(jqXHR)
            console.info(exception)
            return false;
        }
        
    });
}

function Validate(){
    var datastring = $("#create_employee").serialize()+'&foto='+ FILE_PHOTO.Path+'&nombre_imagen='+FILE_PHOTO.Name+'&tipo=EDITEMPLEADO';
    
    $.ajax({
        type: "POST",
        url: "./controller/empleadoController.php",
        data: 
            datastring
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully edit employee');
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

var FILE_PHOTO = null;
function UploadFile(e) {
    var formato = (e.files[0].type);
    if (formato != "image/jpeg" && formato != "image/png") {
        alert("Se debe visualizar imagen con formato JPG,PNG");
        e.value = "";
        return false;
    }
    var tam = (e.files[0].size);
    if (2150000 < tam) {
        alert("El archivo supera el tamaño permitido(2 MB)");
        e.value = "";
        return false;
    }
    RequestHttp._UploadFile(e, "controller/empleadoController.php", function(data) {
        
        if (data != null) {
            FILE_PHOTO = {
                'Path': data.Path,
                'Name': data.Name,
                'Change': 1
            };

            CambiarImagen(data.Path);
        }
    });
}

function CambiarImagen(Path){
    $('#logo_empresa').attr('src',Path);
}


function ListeningGender(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'GENDER'
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
            $("#gender").append(html);

            }
        }
        
    });
}

function ListeningState(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'STATE'
        }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);

            if(json.cant > 0){

                var html =  ""
            var tamano = json.datos.length;
            for (var i = 0; i < tamano; i++) {
                html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].state+"</option>";            
            }
            $("#state").append(html);

            }
        }
        
    });

}

function Find_Staff_edit(id){
    if(id != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'STAFF_COMPANY',
                id :id
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);
                if(json.cant > 0){
                    $('#staff_company').val('');
                    var html =  "<option value=''>Select Staff company</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
                }
                $("#staff_company").html(html);
    
                }else{
                    var html =  "<option value=''>Select Staff company</option>"
                    $("#staff_company").html(html);
                }
            }
            
        });
    }
}


function Find_Staff(e){
    if(e.value != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'STAFF_COMPANY',
                id :e.value
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);
                if(json.cant > 0){
                    $('#staff_company').val('');
                    var html =  "<option value=''>Select Staff company</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
                }
                $("#staff_company").html(html);
    
                }else{
                    var html =  "<option value=''>Select Staff company</option>"
                    $("#staff_company").html(html);
                }
            }
            
        });
    }
}


function HostCompany_edit(id){
    if(id != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'WORKPLACE',
                id :id
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);

                var html =  "<option value=''>Select Staff company</option>"
                $("#staff_company").html(html);

                if(json.cant > 0){
                    $('#work_place').val('');
                    var html =  "<option value=''>Select Work place</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
                }
                $("#work_place").html(html);
    
                }else{
                    var html =  "<option value=''>Select Work place</option>"
                    $("#work_place").html(html);
                }
            }
            
        });
    }
}


function HostCompany(e){
    if(e.value != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'WORKPLACE',
                id :e.value
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);

                var html =  "<option value=''>Select Staff company</option>"
                $("#staff_company").html(html);

                if(json.cant > 0){
                    $('#work_place').val('');
                    var html =  "<option value=''>Select Work place</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].name+"</option>";            
                }
                $("#work_place").html(html);
    
                }else{
                    var html =  "<option value=''>Select Work place</option>"
                    $("#work_place").html(html);
                }
            }
            
        });
    }
}

function FindCities_edit(id){
    if(id != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'CITIES',
                id_state :id
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);
                if(json.cant > 0){
                    $('#city').val('');
                    var html =  "<option value=''>Select city</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].city+"</option>";            
                }
                $("#city").html(html);
    
                }
            }
            
        });
    }
}


function FindCities(e){
    if(e.value != ""){
        $.ajax({
            type: "POST",
            url: "./controller/listasController.php",
            data: {
                tipo:'CITIES',
                id_state :e.value
            }
            ,
            success: function(data) {
                var json = JSON.parse(data);
                if(json.cant > 0){
                    $('#city').val('');
                    var html =  "<option value=''>Select city</option>"
                var tamano = json.datos.length;
                for (var i = 0; i < tamano; i++) {
                    html+= "<option value='"+json.datos[i].id+"' >"+json.datos[i].city+"</option>";            
                }
                $("#city").html(html);
    
                }
            }
            
        });
    }
}

function ListeningNationality(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'NATIONALITY'
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
            $("#nationality").append(html);

            }
        }
        
    });
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
