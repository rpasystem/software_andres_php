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

function Save(){


    var datastring = $("#success_upload_employee_edit").serialize()+'&tipo=CALCULATE_PAYROLL';
    if(ID_HISTORIC != 0){
        $.ajax({
            type: "POST",
            url: "./controller/upload_payrollController.php",
            data: datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                    if(json.status=='success'){
                        alert("Payroll successfully edit")                 
                        $("#btn_cancelar").trigger( "click" );
                        
                    }
            }
        });
    }


}





function RecargarTabla() {
    if ($TABLA_UPLOAD_DETAILS != null)
        $TABLA_UPLOAD_DETAILS.draw();
    return false;
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
            "url": './controller/upload_payrollController.php',
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
            { "data": "host_name" },
            { "data": "fullname" },
            { "data": "hour_reg" },
            { "data": "hour_pto" },
            { "data": "hour_ot" },
            { "data": "missing_hours" },
            { "data": "bonus" },
            { "data": "deductions" },
            { "data": "subtotal" },
            { "data": "net_pay" },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a href='#' aria-expanded='false' data-toggle='modal' data-target='#Detailsuccess_onlyread' Onclick='table_Success("+full.id+")'>show details</a>";
                } 
            },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a target='_blank' href='./controller/impresion_cheque.php?id="+data+"' >Print</a>";
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


var SUBTOTAL = 0
var TAX = 0
var NET_PAY = 0


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

function table_Success(id){
    
    if(id != 0){
        $.ajax({
            type: "POST",
            url: "./controller/upload_payrollController.php",
            data: {
                tipo:'DETAILS_SUCCESS',
                id:id
            },
            success: function(data) {
                
                var json = JSON.parse(data);
                     $("#id_success_employee_onlyread").val(id);
                    $("#hour_reg_onlyread").val(json.datos[0].hour_reg);
                    $("#total_ger_val_onlyread").val(json.datos[0].total_ger_val);
                    $("#hourvalue_onlyread").val(json.datos[0].hourvalue);
                    $("#hour_pto_onlyread").val(json.datos[0].hour_pto);
                    $("#total_pto_val_onlyread").val(json.datos[0].total_pto_val);
                    $("#hour_ot_onlyread").val(json.datos[0].hour_ot);
                    $("#total_ot_val_onlyread").val(json.datos[0].total_ot_val);
                    $("#subtotal_onlyread").val(json.datos[0].subtotal);
                    $("#bonus_onlyread").val(json.datos[0].bonus);
                    $("#deductions_onlyread").val(json.datos[0].deductions);
                    $("#over_time_onlyread").val(json.datos[0].overtime)
                    $("#missing_over_time_onlyread").val(json.datos[0].missing_over_time)

                    if(json.datos[0].description_bonus != ""){
                        $("#description_bonus_id_onlyread option:contains('"+json.datos[0].description_bonus+"')").attr('selected', 'selected')

                        $("#description_bonus_onlyread").val(json.datos[0].description_bonus)
                    }
                    
                    if(json.datos[0].description_deduction != ""){
                        $("#description_deduction_id_onlyread option:contains('"+json.datos[0].description_deduction+"')").attr('selected', 'selected')
                        $("#description_deduction_onlyread").val(json.datos[0].description_deduction)
                    }



                    $("#missing_hours_onlyread").val(json.datos[0].missing_hours);
                    SUBTOTAL = json.datos[0].subtotal
                    $("#val_tax_onlyread").val(json.datos[0].val_tax);
                    TAX=json.datos[0].val_tax
                    $("#tax_onlyread").val(json.datos[0].tax);
                    $("#net_pay_onlyread").val(json.datos[0].net_pay);
                    NET_PAY = json.datos[0].net_pay
                    
                    
            }
            
        });
    }
}



function ListDetail(){
    $TABLA_UPLOAD_DETAILS = $('#details').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.id = ID_HISTORIC;
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTDETAILS",
                });
            }
        },
        "columns": [
            { "data": "dates" },
            { "data": "host_company" },
            { "data": "fails",
                "orderable": false,
                "searchable": false,
                "width": "10%",
                "render": function (data, type, full, meta) {
                    return "<a href='#' aria-expanded='false' data-toggle='modal' data-target='#DetailFails' Onclick='table_Details("+full.id+")'>"+data+"</a>";
                }
            },
            { "data": "success" },
            /*
            {
                "data": "success",
                "orderable": false,
                "searchable": false,
                "width": "10%",
                "render": function (data, type, full, meta) {
					
                    return "<div class='btn-group'><a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' class='p-0 btn'>"+
                        "Acciones <i class='fa fa-angle-down ml-2 opacity-8'></i>"+
                        "</a><div tabindex='-1' role='menu' aria-hidden='true' class='dropdown-menu dropdown-menu-right'><a href='#' class='dropdown-item'  data-toggle='modal' data-target='#inactivate_employee' onclick='GetId("+data+")'>inactivate</a>"+
                        "<a href='edit_employee.php?id="+data+"' type='button' tabindex='0' class='dropdown-item'>Edit</a><div tabindex='-1' ></div>"
                        +"<div tabindex='-1' ></div>"
                        +"</div></div>";

                }
            }*/
            
    
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
            "url": './controller/upload_payrollController.php',
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



function DescriptionDeductions(e){

    if(e.value == '0'){
        $('#deductions_onlyread').prop('required', false);
    }else{
        $('#deductions_onlyread').prop('required', true);
    }

    if(e.value == '4'){
        $('#description_deduction_onlyread').val('');
        $('#description_deduction_onlyread').prop('readonly', false);
        $('#description_deduction_onlyread').prop('required', true);

    }else{
        $('#description_deduction_onlyread').val($( "#description_deduction_id option:selected" ).text());
        $('#description_deduction_onlyread').prop('readonly', true);

    }
}

function DescriptionBonus(e){


    if(e.value == '0'){
        $('#bonus_onlyread').prop('required', false);
    }else{
        $('#bonus_onlyread').prop('required', true);
    }


    if(e.value == '4'){
        $('#description_bonus_onlyread').val('');
        $('#description_bonus_onlyread').prop('readonly', false);
        $('#description_bonus_onlyread').prop('required', true);
    }else{
        $('#description_bonus_onlyread').val($( "#description_bonus_id option:selected" ).text());
        $('#description_bonus_onlyread').prop('readonly', true);

    }
}


function Calcular(){

    var missing_hour = $("#missing_hours_onlyread").val();
    var hourvalue = $("#hourvalue_onlyread").val()
    var bonus = $("#bonus_onlyread").val()
    var deductions = $("#deductions_onlyread").val()
    var tax = $("#tax_onlyread").val()
    var total_ger_val = $("#total_ger_val_onlyread").val()
    var total_pto_val = $("#total_pto_val_onlyread").val()
    var total_ot_val = $("#total_ot_val_onlyread").val()
    var val_missing_hour = ((missing_hour *1)*(hourvalue*1 ))
    var subtotal =((total_ger_val*1) +(total_pto_val*1)+(total_ot_val*1)+(val_missing_hour*1)+(bonus*1))-(deductions*1)
    $("#subtotal_onlyread").val(subtotal);
    var val_tax = ((subtotal *tax)/100);
    $("#val_tax_onlyread").val(val_tax);
    var net_pay = (subtotal*1) -(val_tax*1);
    $("#net_pay_onlyread").val(net_pay);
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
     
        window.open("./controller/impresion_cheque.php?id="+num, '_blank');
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