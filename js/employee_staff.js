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




    
    ListeningStaffCompany()

})();

function  Validate(){
   
var initial =$("#initial_date").val()
var end = $("#final_date").val()
var staff =$("#staff_company").val()
    window.open("./controller/employee_staff_Controller.php?tipo=generar&staff="+staff, '_blank');
}

function ListeningStaffCompany(){
    $.ajax({
        type: "POST",
        url: "./controller/listasController.php",
        data: {
            tipo:'ALLSTAFFCOMPANY_NOID'
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
            $("#staff_company").append(html);

            }else{
                var html =  "<option value=''>Select staff company</option>"
                $("#staff_company").html(html);
            }
        }
        
    });

}

