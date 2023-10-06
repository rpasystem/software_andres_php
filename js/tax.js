(function () {

    $('#tax_edit').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });


      
    $('#profitpercentage').keypress(function(event) {
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


    ListarParametros()
})();

function ListarParametros(){

    $.ajax({
        type: "POST",
        url: "./controller/toolsController.php",
        data: 
            {
                tipo:"LIST"
            }
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            
            
            if(json.cantidad > 0){

                

                for(var i=0;i<json.cantidad;i++){
                  
                    $("#"+json.datos[i].llave+"_edit").val(json.datos[i].value)
                }
            }
        }, error: function (jqXHR, exception) {
            console.info(jqXHR)
            console.info(exception)
            return false;
        }
        
    });

}


function Validate(){
    var datastring = $("#form_tools").serialize()+'&tipo=UPDATE_TOOLS';
    
    $.ajax({
        type: "POST",
        url: "./controller/toolsController.php",
        data: 
            datastring
        ,
        success: function(data) {
            
            var json = JSON.parse(data);
            if (json.status == 'success') {
                alert('successfully edit tools');
                location.href = 'tools.php';
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