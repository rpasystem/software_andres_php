
var $TABLA_HISTORICO = null
$("#div_result").hide();
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

function RecargarTabla() {
    $("#div_result").show();
    if ($TABLA_HISTORICO != null)
        $TABLA_HISTORICO.draw();
    return false;
    
}


function ListHistoric(){
    if($("#id_employee").val()=="0" || $("#id_employee").val()==""){
        return false;
    }
    if ($TABLA_HISTORICO != null)
        $TABLA_HISTORICO.destroy();
    
    $("#div_result").show();
    $TABLA_HISTORICO = $('#historic_payroll').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            
            "order": [[ 0, "desc" ]],
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                return $.extend({}, d, {
                    "tipo": "List_historic_employee_admin",
                    "id_employee":$("#id_employee").val()
                });
            }
        },
        "columns": [
            { "data": "id" },
            {"data":"staff"},
            { "data": "rango"},
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a target='_blank' href='./controller/impresion_cuadros.php?id="+data+"' >Print</a>";
                } 
            },
            { "data": "id",
                "orderable": false,
                "searchable": false,
                "width": "5%",
                "render": function (data, type, full, meta) {
                    return "<input type='checkbox' class='form-check-input checkbox' name='"+data+"' id='"+data+"' onclick='Select("+data+")' >";
                }
            },
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
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





var IMPUT = []
function Select(id){
    var tam = IMPUT.length;
    var esta = true;
    for(var i =0;i<tam;i++){
        if(id==IMPUT[i]){
            IMPUT.splice(i, 1);
            esta=false;
            break;
        }
    }

    if(esta==true){
        IMPUT.push(id)
    }
  

}

function Imprimir_Seleccionados(){

    var tam = IMPUT.length;
 
    if(tam==0){
        alert("please select an item!");
        return false;
    }else{
        var num=""
        for(var i=0;i<tam;i++){

            if(i==0){
                num =IMPUT[i]
            }else{
                num =num +"-"+IMPUT[i]
            }
             
        }
     
        window.open("./controller/impresion_cuadros.php?id="+num, '_blank');
    }
}





  $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    
    checkboxes.prop('checked', $(this).is(':checked'));

    $('input[type=checkbox]').each(function () {
        console.info($(this).attr('name'))
        if($(this).attr('name') != undefined){
            Select(parseInt($(this).attr('name')))
        }
      
    });

    console.info(IMPUT)
  });
