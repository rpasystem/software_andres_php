(function () {


    $(document).ready(function () {
        //called when key is pressed in textbox
        $("#invoice_number").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                //$("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
    });

    
    $(document).ready(function () {


        $('#porcent_ganancia').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
              event.preventDefault();
            }
          });


        
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




    
    ListeningStaffCompany()

})();

function  Validate(){
   
var initial =$("#initial_date").val()
var end = $("#final_date").val()
var staff =$("#staff_company").val()
var invoice =$("#invoice_number").val()
var porcent_ganancia =$("#porcent_ganancia").val()
    window.open("./controller/generateexcel1055Controller.php?tipo=generar&invoice="+invoice+"&initial="+initial+"&end="+end+"&staff="+staff+"&porcent_ganancia="+porcent_ganancia, '_blank');
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


$( function() {
    $( "#initial_date" ).datepicker(
        { dateFormat: 'm/d/yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );

$( function() {
    $( "#final_date" ).datepicker(
        { dateFormat: 'm/d/yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0" }
        );
  } );