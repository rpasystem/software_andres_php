var $TABLA_HISTORICO = null
$(function () {
    ListHistoric()
   
});



function RecargarTabla() {
    if ($TABLA_HISTORICO != null)
        $TABLA_HISTORICO.draw();
    return false;
}

function ListHistoric(){
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
                    "tipo": "LIST_HISTORIC_EMPLOYEE",
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
