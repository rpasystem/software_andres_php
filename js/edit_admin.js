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
/*
$(document).ready(function () {
    $("#identification").keypress(function(e){
        var keyCode = e.which;
    
        if ( !( (keyCode >= 48 && keyCode <= 57) 
          ||(keyCode >= 65 && keyCode <= 90) 
          || (keyCode >= 97 && keyCode <= 122) ) 
          && keyCode != 8 && keyCode != 32) {
          e.preventDefault();
        }
      });
});
*/
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
    var datastring = $("#edit_employee").serialize()+'&tipo=EDITADMIN';
    $.ajax({
        type: "POST",
        url: "./controller/administradorController.php",
        data: 
            datastring
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully created administrator');
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


$(function () {
    VerDetalle()
});


function VerDetalle(){
    ID = $("#id_admin").val()
    
    $.ajax({
        type: "POST",
        url: "./controller/administradorController.php",
        data:{
            tipo:'DETALLE',
            id:ID
        },
        success: function(data) {   
            var json = JSON.parse(data);
            if (json.status == 'success') {
                $("#first_name").val(json.datos[0].firstname);
                $("#second_name").val(json.datos[0].second_name);
                $("#surname").val(json.datos[0].surename);
                $("#second_surname").val(json.datos[0].second_surname);
                $("#identification").val(json.datos[0].identification);
                $("#email").val(json.datos[0].email);
                $("#password").val(json.datos[0].password_sin_encrypt);
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