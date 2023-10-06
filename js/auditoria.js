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




    
    ListeningAdmin()

})();

function  Validate(){
   
var initial =$("#initial_date").val()
var end = $("#final_date").val()
var admin =$("#admin").val()
var id_admin=$("#id_admin").val()
    window.open("./controller/auditoriaController.php?tipo=generar&initial="+initial+"&end="+end+"&admin="+admin+"&id_admin="+id_admin, '_blank');
}

function ListeningAdmin(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'LIST_ADMIN'
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
            $("#admin").append(html);

            }else{
                var html =  "<option value=''>Select user administrator</option>"
                $("#admin").html(html);
            }
        }
        
    });

}


$( function() {
    $( "#initial_date" ).datepicker(
        { dateFormat: 'm-d-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );

$( function() {
    $( "#final_date" ).datepicker(
        { dateFormat: 'm-d-yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );