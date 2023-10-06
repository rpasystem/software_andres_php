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




    
    ListeningEmployee()

})();

function  Validate(){
   
var id =$("#id_employee").val()
    window.open("./controller/impresion_membrete_admin.php?id="+id, '_blank');
}

function ListeningEmployee(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'ALLEMPLOYEE'
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
            $("#id_employee").append(html);

            }else{
                var html =  "<option value=''>Select employee</option>"
                $("#id_employee").html(html);
            }
        }
        
    });
}