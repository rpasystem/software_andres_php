var FILE_PHOTO = null;


var SUBTOTAL = 0
var TAX = 0
var NET_PAY = 0
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


    $("#button_result").hide();
    $("#div_details").hide();
    $("#div_details_employee").hide();
    $("#div_buttons").hide();


    $('#bonus').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {   
          event.preventDefault();
        }
      });

      $('#missing_over_time_upload').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {   
          event.preventDefault();
        }
      });


    $('#missing_hours').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {   
          event.preventDefault();
        }
      });


      $('#deductions').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });
      
      

})


function Save(){


    var datastring = $("#success_upload_employee").serialize()+'&tipo=CALCULATE_PAYROLL';
    if(ID_PAYROLL != 0){
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
                        RecargarTabla_success()               
                    }
            }
        });
    }


}






function UploadFile(e) {

    $("#button_result").hide();
    $("#div_details").hide();
    $("#div_details_employee").hide();
    $("#div_buttons").hide();

    FILE_PHOTO = {}

    var regex = /^([a-zA-Z0-9\s_\\.\)(-:])+(.xlsx|.xls)$/;  
    if (regex.test(e.value.toLowerCase())) {  
        var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
        if (e.value.toLowerCase().indexOf(".xlsx") > 0 || e.value.toLowerCase().indexOf(".xls")) {  
            xlsxflag = true;  
         
            RequestHttp._UploadFile(e, "controller/upload_payrollController.php", function(data) {
        
                
                if (data != null) {
                    FILE_PHOTO = {
                        'Path': data.Path,
                        'Name': data.Name,    
                    }
                    
                }
            });
            
        }  
    }  
    else {  
        $("#file_excel").val('');
        alert("Please upload a valid Excel file!");  
    } 
}

var ID_PAYROLL=0;

function DescriptionDeductions(e){

    if(e.value == '0'){
     //   $('#deductions').prop('required', false);
    }else{
     //   $('#deductions').prop('required', true);
    }

    if(e.value == '4'){
        $('#description_deduction').val('');
        $('#description_deduction').prop('readonly', false);
       // $('#description_deduction').prop('required', true);

    }else{
        $('#description_deduction').val($( "#description_deduction_id option:selected" ).text());
        $('#description_deduction').prop('readonly', true);

    }
}

function DescriptionBonus(e){


    if(e.value == '0'){
        //$('#bonus').prop('required', false);
    }else{
        //$('#bonus').prop('required', true);
    }


    if(e.value == '4'){
        $('#description_bonus').val('');
        $('#description_bonus').prop('readonly', false);
        //$('#description_bonus').prop('required', true);
    }else{
        $('#description_bonus').val($( "#description_bonus_id option:selected" ).text());
        $('#description_bonus').prop('readonly', true);

    }
}


function Calcular(){

    var missing_hour = $("#missing_hours").val();
    var hourvalue = $("#hour_value").val()
    var bonus = $("#bonus").val()
    var deductions = $("#deductions").val()
    var tax = $("#tax").val()
    
    $("#total_ger_val").val((hourvalue*$("#hour_reg").val()).toFixed(2))

    $("#total_pto_val").val((hourvalue*$("#hour_pto").val()).toFixed(2))

    $("#total_ot_val").val(($("#hour_ot").val()*$("#over_time").val()).toFixed(2))

    var total_ger_val = $("#total_ger_val").val()
    var total_pto_val = $("#total_pto_val").val()
    var total_ot_val = $("#total_ot_val").val()

    


    var val_missin_over_time = (($("#missing_over_time_upload").val()*1) *  ($("#over_time").val()*1))

    var val_missing_hour = ((missing_hour * 1)*(hourvalue * 1 ))
    var subtotal =((val_missin_over_time*1) + (total_ger_val*1) +(total_pto_val*1)+(total_ot_val*1)+(val_missing_hour*1)+(bonus*1))-(deductions*1)
    $("#subtotal").val(subtotal.toFixed(2));
    var val_tax = parseFloat((subtotal *tax)/100);
    $("#val_tax").val(val_tax.toFixed(2));
    var net_pay = parseFloat((subtotal*1) -(val_tax*1));
    $("#net_pay").val(net_pay.toFixed(2));
}


function UploadData(){
    if(FILE_PHOTO != null){
        $.ajax({
            type: "POST",
            url: "./controller/upload_payrollController.php",
            data: {
                tipo:'UPLOAD_EXCEL',
                path:FILE_PHOTO.Path,
                name:FILE_PHOTO.Name,
            }
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                alert(json.mensaje);
                    FILE_PHOTO=null
                if (json.status == 'success') {
                    FILE_PHOTO = null;
                    $("#file_excel").val('');
                    ID_PAYROLL =json.data 
                    $("#button_result").show();
                    
                    
                } else {
                    alert(json.mensaje);
                }
            }
            
        });
    }else{
        FILE_PHOTO = null;
        $("#file_excel").val('');
        alert("Please upload a Excel file!")
    }
    
}


var $TABLA_UPLOAD_DETAILS = null
function showResult(){
    FILE_PHOTO = null;
    $("#file_excel").val('');
    $("#div_details").show();
     SUBTOTAL = 0
    TAX = 0
    NET_PAY = 0
    $("#div_details_employee").show();
    $("#div_buttons").show();
    ListDetail()
    setTimeout(() => {
        ListSuccessUpload();
    }, 500);
}


function Reject(){
    if(ID_PAYROLL != 0){
        $.ajax({
            type: "POST",
            url: "./controller/upload_payrollController.php",
            data: {
                tipo:'DELETE_PAYROLL',
                id:ID_PAYROLL
            },
            success: function(data) {
                
                var json = JSON.parse(data);
                    if(json.status=='success'){
                        alert("Payroll successfully delete")
                        location.href = 'upload_payroll.php';                    
                    }
            }
        });
    }
}


function Accept(){

    if(ID_PAYROLL != 0){
        $.ajax({
            type: "POST",
            url: "./controller/upload_payrollController.php",
            data: {
                tipo:'ACEPT_PAYROLL',
                id:ID_PAYROLL
            },
            success: function(data) {
                
                var json = JSON.parse(data);
                    if(json.status=='success'){
                        alert("Payroll successfully loaded")
                        location.href = 'upload_payroll.php';                    
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

function RecargarTabla_success(){
    if ($TABLA_UPLOAD_SUCCESS != null)
        $TABLA_UPLOAD_SUCCESS.draw();
    return false;
}

var $TABLA_UPLOAD_SUCCESS=null
function ListSuccessUpload(){
  
  /*  if($TABLA_UPLOAD_SUCCESS != null){
        $TABLA_UPLOAD_SUCCESS.destroy();
        
    }
    */
    $TABLA_UPLOAD_SUCCESS = $('#details_employee_success').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "bPaginate": false,
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.id = ID_PAYROLL;
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "LISTSUCCESS",
                });
            }
        },
        "columns": [
            { "data": "fullname" },
            { "data": "hour_reg" },
            { "data": "hour_ot" },
            { "data": "total_hours" },
            { "data": "subtotal" },
            { "data": "id",
            "orderable": false,
            "searchable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                return "<a href='#' aria-expanded='false' data-toggle='modal' data-target='#Detailsuccess' Onclick='table_Success("+full.id+")'>show details</a>";
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
                     $("#id_success_employee").val(id);
                    $("#hour_reg").val(json.datos[0].hour_reg);
                    $("#total_ger_val").val(json.datos[0].total_ger_val);
                    $("#hour_value").val(json.datos[0].hourvalue);
                    $("#hour_pto").val(json.datos[0].hour_pto);
                    $("#total_pto_val").val(json.datos[0].total_pto_val);
                    $("#hour_ot").val(json.datos[0].hour_ot);
                    $("#total_ot_val").val(json.datos[0].total_ot_val);
                    $("#subtotal").val(json.datos[0].subtotal);
                    $("#bonus").val(json.datos[0].bonus);
                    $("#deductions").val(json.datos[0].deductions);
                    $("#over_time").val(json.datos[0].overtime)

                    if(json.datos[0].description_bonus != ""){
                        $("#description_bonus_id option:contains('"+json.datos[0].description_bonus+"')").attr('selected', 'selected')

                        $("#description_bonus").val(json.datos[0].description_bonus)
                    }else{
                        $("#description_bonus_id").val("")
                        $("#description_bonus").val("")
                    }
                    
                    if(json.datos[0].description_deduction != ""){
                        $("#description_deduction_id option:contains('"+json.datos[0].description_deduction+"')").attr('selected', 'selected')
                        $("#description_deduction").val(json.datos[0].description_deduction)
                    }else{
                        $("#description_deduction").val("")
                        $("#description_deduction_id").val("")
                    }


                    $("#missing_over_time_upload").val(json.datos[0].missing_over_time)    
                    $("#missing_hours").val(json.datos[0].missing_hours);
                    SUBTOTAL = json.datos[0].subtotal
                    var valtax = parseFloat(json.datos[0].val_tax)
                    $("#val_tax").val(valtax.toFixed(2));
                    TAX=json.datos[0].val_tax
                    $("#tax").val(json.datos[0].tax);
                    var netpay =  parseFloat(json.datos[0].net_pay)
                    $("#net_pay").val(netpay.toFixed(2));
                    NET_PAY = json.datos[0].net_pay
                    
                    
            }
            
        });
    }
}



function ListDetail(){

    if($TABLA_UPLOAD_DETAILS != null){
        $TABLA_UPLOAD_DETAILS.destroy();
        
    }
    
    $TABLA_UPLOAD_DETAILS = $('#details').DataTable({
      
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.id = ID_PAYROLL;
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
function table_Details(id){

    if($TABLA_UPLOAD_FAIL != null){
        $TABLA_UPLOAD_FAIL.destroy();
        
    }
    
    $TABLA_UPLOAD_FAIL = $('#details_fail').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "order": [[ 1, "desc" ]],
        "ajax": {
            "url": './controller/upload_payrollController.php',
            "type": "POST",
            "data": function (d) {
                d.id = id;
                //d.estado = $("#estado_aspirantes").val();
                return $.extend({}, d, {
                    "tipo": "TABLE_DETAILS_FAIL",
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "descripcion" },
            
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
