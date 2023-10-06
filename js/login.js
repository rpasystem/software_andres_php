
$(document).ready(function () {
    $("#email").keypress(function(e){
        var keyCode = e.which;
        if ( !( (keyCode >= 48 && keyCode <= 57) 
          ||(keyCode >= 65 && keyCode <= 90) 
          || (keyCode >= 97 && keyCode <= 122) ) 
          && keyCode != 8 && keyCode != 32) {
          e.preventDefault();
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
            }else{
                event.preventDefault();
                
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);
})


function Validar(){
    event.preventDefault();
    var forms = document.getElementsByClassName('needs-validation');
    var datastring = $("#login").serialize();
    


    if($("#email").val() == "" ){
        
        form.classList.add('was-validated');
        event.preventDefault();
        return false;
    }

    if($("#state").val() == "" ){
        
        form.classList.add('was-validated');
        event.preventDefault();
        return false;
    }

    if($("#pass").val() == "" ){
        
        form.classList.add('was-validated');
        event.preventDefault();
        return false;
    }



        datastring = datastring+"&tipo=Login"
    $.ajax({
        type: "POST",
        url: "./controller/loginController.php",
        data: 
            datastring
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                location.href = 'home.php';
            } else {
                alert(json.mensaje);
            }
        }, error: function (jqXHR, exception) {
            console.info(jqXHR)
            console.info(exception)
            return false;
        }
        
    });

    return false;
}