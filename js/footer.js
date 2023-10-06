$('.menu').on('click', function() {
       
        
    
    $.ajax({
        type: "POST",
        url: "./Controller/ConfiguracionController.php",
        data: {tipo:"CAMBIAR_COLOR_MENU",
            color:$(this).attr('name')
        },
        success: function(data){
            
            /*
            var json = JSON.parse(data);
            alert(json.mensaje);
            if(json.status=='success'){
                location.reload();
            }
            */
      }
    });

});


    $('.cabezera').on('click', function() {
        $.ajax({
            type: "POST",
            url: "./Controller/ConfiguracionController.php",
            data: {tipo:"CAMBIAR_COLOR_CABECERA",
                color:$(this).attr('name')
            },
            success: function(data){
                
                /*
                var json = JSON.parse(data);
                alert(json.mensaje);
                if(json.status=='success'){
                    location.reload();
                }
                */
          }
        });

   });

    
   function CheckPassword(inputtxt) 
   { 
   var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*\.]{7,15}$/;
   if(inputtxt.match(paswd)) 
   { 
   return true;
   }
   else
   { 
   return false;
   }
   }
   


function CambiarPass(){
    

    if($("#pass").val()==""){
        $("#pass").addClass('bordes_obligatorios');
        alert("Debe ingresar todos los campos en rojo.")
        return false;
        }else{
            $("#pass").removeClass('bordes_obligatorios');
        }

       var check =  CheckPassword($("#pass").val())
        if(check == false){
            $("#pass").addClass('bordes_obligatorios');
            alert("La contraseña debe contener entre 7 y 15 caracteres, debe obtener mínimo un número,mínimo un una letra minúscula,mínimo una letra mayuscula y mínimo un caracter especial ")
            return false;
        }


    
    var confirmar_contrasena = $("#confirme").val()
    if(confirmar_contrasena==""){
        $("#confirme").addClass('bordes_obligatorios');
        alert("Debe ingresar todos los campos en rojo.")
        return false;
        }else{
            $("#confirme").removeClass('bordes_obligatorios');
        }

    if($("#pass").val() != $("#confirme").val()){
        $("#pass").addClass('bordes_obligatorios');
        $("#confirme").addClass('bordes_obligatorios');
        alert("La contraseña y la confirmación deben ser iguales");
        return false
    }

    $.ajax({
        type: "POST",
        url: "./Controller/ConfiguracionController.php",
        data: {tipo:"CAMBIAR_PASS",
            pass:$("#pass").val()
        },
        success: function(data){
            var json = JSON.parse(data);
            alert(json.mensaje);
            if(json.status=='success'){
                location.reload();
            }
      }
    });

}