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
     
   
    ListSuccessUpload()
})




var $TABLA_UPLOAD_DETAILS = null

function Save(){


    var datastring = $("#success_upload_employee_print").serialize()+'&tipo=CALCULATE_PAYROLL';
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
                        RecargarTabla()
                    }
            }
        });
    }


}





function RecargarTabla() {
    if ($TABLA_UPLOAD_SUCCESS != null)
        $TABLA_UPLOAD_SUCCESS.draw();
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
                    "tipo": "LISTSUCCESS_PRINT",
                });
            }
        },
        "columns": [
          
            { "data": "fullname" },
            { "data": "hour_reg" },
            { "data": "hour_pto" },
            { "data": "hour_ot" },
            { "data": "missing_hours" },
            { "data": "bonus" },
            { "data": "deductions" },
            { "data": "subtotal" },
            { "data": "net_pay",
             "render":function(data,type,full,meta){
                 return  (parseFloat(data).toFixed(2));
             } },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a href='#' aria-expanded='false' data-toggle='modal' data-target='#Detailsuccess_print' Onclick='table_Success("+full.id+")'>show details</a>";
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
                return "<input type='checkbox' class='form-check-input checkbox' name='"+data+"' id='"+data+"' onclick='Select("+data+")' >";
                } 
            }
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
                     $("#id_success_employee_print").val(id);
                    $("#hour_reg_print").val(json.datos[0].hour_reg);
                    $("#total_ger_val_print").val(json.datos[0].total_ger_val);
                    $("#hourvalue_print").val(json.datos[0].hourvalue);
                    $("#hour_pto_print").val(json.datos[0].hour_pto);
                    $("#total_pto_val_print").val(json.datos[0].total_pto_val);
                    $("#hour_ot_print").val(json.datos[0].hour_ot);
                    $("#total_ot_val_print").val(json.datos[0].total_ot_val);
                    $("#subtotal_print").val(json.datos[0].subtotal);
                    $("#bonus_print").val(json.datos[0].bonus);
                    $("#deductions_print").val(json.datos[0].deductions);
                    $("#over_time_print").val(json.datos[0].overtime)
                    $("#missing_over_time").val(json.datos[0].missing_over_time)

                    if(json.datos[0].description_bonus != ""){
                        $("#description_bonus_id_print option:contains('"+json.datos[0].description_bonus+"')").attr('selected', 'selected')

                        $("#description_bonus_print").val(json.datos[0].description_bonus)
                    }else{

                        $("#description_bonus_id_print").val("")
                        $("#description_bonus_print").val("")
                    }
                    
                    if(json.datos[0].description_deduction != ""){
                        $("#description_deduction_id_print option:contains('"+json.datos[0].description_deduction+"')").attr('selected', 'selected')
                        $("#description_deduction_print").val(json.datos[0].description_deduction)
                    }else{
                        $("#description_deduction_id_print").val("")
                        $("#description_deduction_print").val("")
                    }



                    $("#missing_hours_print").val(json.datos[0].missing_hours);
                    SUBTOTAL = json.datos[0].subtotal
                    $("#val_tax_print").val(parseFloat(json.datos[0].val_tax).toFixed(2));
                    TAX=json.datos[0].val_tax
                    $("#tax_print").val(json.datos[0].tax);
                    $("#net_pay_print").val(parseFloat(json.datos[0].net_pay).toFixed(2));
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






function DescriptionDeductions(e){

    if(e.value == '0'){
        //$('#deductions_print').prop('required', false);
    }else{
        //$('#deductions_print').prop('required', true);
        if(e.value == '4'){
            $('#description_deduction_print').val('');
           $('#description_deduction_print').prop('readonly', false);
          //  $('#description_deduction_print').prop('required', true);
    
        }else{
          
            $('#description_deduction_print').val($( "#description_deduction_id_print option:selected" ).text());
            $('#description_deduction_print').prop('readonly', true);
    
        }
    }

   
}

function DescriptionBonus(e){


    if(e.value == '0'){
        //$('#bonus_print').prop('required', false);
    }else{
        //$('#bonus_print').prop('required', true);
    }


    if(e.value == '4'){
        $('#description_bonus_print').val('');
        $('#description_bonus_print').prop('readonly', false);
        //$('#description_bonus_print').prop('required', true);
    }else{
        $('#description_bonus_print').val($( "#description_bonus_id_print option:selected" ).text());
        $('#description_bonus_print').prop('readonly', true);

    }
}


function Calcular(){



    var missing_hour = $("#missing_hours_print").val();
    var hourvalue = $("#hourvalue_print").val()
    var bonus = $("#bonus_print").val()
    var deductions = $("#deductions_print").val()
    var tax = $("#tax_print").val()


    $("#total_ger_val_print").val((hourvalue*$("#hour_reg_print").val()).toFixed(2))

    $("#total_pto_val_print").val((hourvalue*$("#hour_pto_print").val()).toFixed(2))

    $("#total_ot_val_print").val(($("#hour_ot_print").val()*$("#over_time_print").val()).toFixed(2))


    var total_ger_val = $("#total_ger_val_print").val()
    var total_pto_val = $("#total_pto_val_print").val()
    var total_ot_val = $("#total_ot_val_print").val()
    var val_missing_hour = ((missing_hour *1)*(hourvalue*1 ))


    var val_missin_over_time = (($("#missing_over_time").val()*1) *  ($("#over_time_print").val()*1))

 
    var subtotal =((total_ger_val*1) +(total_pto_val*1)+(total_ot_val*1)+(val_missing_hour*1)+(val_missin_over_time)+(bonus*1))-(deductions*1)
    $("#subtotal_print").val(subtotal.toFixed(2));
    var val_tax =  parseFloat((subtotal *tax)/100);
    $("#val_tax_print").val(val_tax.toFixed(2));
    var net_pay = parseFloat(subtotal*1) -(val_tax*1);
    $("#net_pay_print").val(net_pay.toFixed(2));

    
    
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
  

    console.info(IMPUT)
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