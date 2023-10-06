var FILE_PHOTO = null;


var SUBTOTAL = 0
var TAX = 0
var NET_PAY = 0
var ID_HISTORIC = 0;
$(document).ready(function () {



    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            
            form.addEventListener('submit', function (event) {

                

                Calcular()   
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }else{
                    event.preventDefault();
                    Save()
                }
                
            }, false);
        });
    }, false);



    ID_HISTORIC =$("#id_historic").val();
     
    table_Details_fails()
    ListSuccessUpload()
})

var $TABLA_UPLOAD_DETAILS = null
function RecargarTabla() {
    if ($TABLA_UPLOAD_DETAILS != null)
        $TABLA_UPLOAD_DETAILS.draw();
    return false;
}


function Imprimir(id){
   
    $.ajax({
        type: "POST",
        url: "./controller/upload_payrollController.php",
        data: {
            tipo:'IMPIRMIR',
            id:id
        },
        success: function(data) {
           
        }
        
    });
}

var $TABLA_UPLOAD_SUCCESS=null
function ListSuccessUpload(){
    $TABLA_UPLOAD_SUCCESS = $('#details_employee_success').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "scrollX": true,
            "bPaginate": false,
        
        "ajax": {
            "url": './controller/fast_checkController.php',
            "type": "POST",
            "data": function (d) {
                d.id = ID_HISTORIC;
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTSUCCESS",
                });
            }
        },
        "columns": [
            { "data": "nombre" },
            { "data": "val_total" },
            { "data": "description" },
            { "data": "tax" },
            { "data": "id_check" },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a target='_blank' href='./controller/impresion__fast_check.php?id="+data+"' >Print</a>";
                } 
            },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "7%",
            "render": function (data, type, full, meta) {
                return "<input type='checkbox' class='form-check-input'  name='"+data+"' id='"+data+"' onclick='Select("+data+")' >";
                } 
            },
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}


var  $TABLA_UPLOAD_FAIL= null;
function table_Details_fails(){
    
    $TABLA_UPLOAD_FAIL = $('#details_fails').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "order": [[ 1, "desc" ]],
        "ajax": {
            "url": './controller/fast_checkController.php',
            "type": "POST",
            "data": function (d) {
                d.id = ID_HISTORIC;
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "TABLE_DETAILS_FAIL",
                });
            }
        },
        "columns": [
            { "data": "id" },
            
            { "data": "descripcion" },
            
            
    
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
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
     
        window.open("./controller/impresion__fast_check.php?id="+num, '_blank');
    }
}



  
  $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    
    checkboxes.prop('checked', $(this).is(':checked'));
    var selected = [];

    $('input[type=checkbox]').each(function () {
        console.info($(this).attr('name'))
        if($(this).attr('name') != undefined){
            Select(parseInt($(this).attr('name')))
        }
      
    });

    console.info(IMPUT)
  });