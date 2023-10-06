$(function() {
    ForDefault._DataTable();
    ///Inicializa animacón ajax loading
    Utils._InitAjaxLoading(); 
});




function salir() {
    var tipo = "Cerrar";
    $.ajax({
        type: "POST",
        url: "controller/loginController.php",
        data: {
            tipo: tipo
        },
        success: function(data) {
            var json = JSON.parse(data);
            localStorage.setItem("salir", json.confirmar);
            window.location = "login.php";
        }
    });


}

var Utils = {
    ///Loading
    
    _InitAjaxLoading: function() {
        
        var $loading = $('#container-loading').hide();
        $(document).ajaxStart(function() {
            $loading.stop().fadeIn(100);
        }).ajaxStop(function() {
            $loading.stop().fadeOut(100);
        });
    },

    _Exitoso: function() {
        $('.modal').modal('hide')
        $("#ExitosoModal").modal("show")
        setTimeout(function() {
            $('.modal').modal('hide')
            RecargarTabla()
        }, 1500);


    },

    _Error: function() {
        $("#ErrorModal").modal("show")
        $('.modal').modal('hide');
        RecargarTabla()
    }
}



var RequestHttp = {
    _ValidateResponse: function(response) {
        var result = null;

        if (response.status == 200) {
            result = JSON.parse(response.responseText);
        } else {
            if (response.status == 0)
                Utils._BuilderMessage("danger", "No pudo conectarse con el servidor.</br>Por favor, revise su conexión a internet o comuníquese con el administrador.");
            else
                Utils._BuilderMessage("danger", response.status + ": " + response.statusText);
        }
        return result;
    },
    _UploadFile: function(e, url, callback) {
        console.log("RequestHttp._UploadFile");

        var files = $(e).prop("files");

        var data = new FormData();
        $.each(files, function(key, value) {
            data.append("file", value);
            data.append("tipo", "UPLOAD");
        });

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            complete: function(jqXHR, textStatus) {
                var resultado = RequestHttp._ValidateResponse(jqXHR);

                if (resultado != null) {
                    if (resultado.state == true)
                        callback(resultado.data);
                    else
                    // Utils._BuilderMessage('danger', resultado.message);
                    if (resultado.message != null) {
                        alert(resultado.message);
                    }

                }
                callback(null);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var $loading = $('#container-loading').hide();
                // Utils._BuilderMessage("danger", textStatus);
                alert("Error por tamaño o formato no permitido");
                $loading.stop().fadeOut(100);
            }
        });
    }
}


var ForDefault = {
    _FormatDate: "DD/MM/YYYY", // 01/12/2017, plugin momentjs
    _FormatHour: "h : mm A", // 12:30 am, plugin momentjs
    _DatePicker: function () {
        if ("undefined" !== typeof $.datepicker) {
            console.log("_DatePicker");

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: '',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            };
            $.datepicker.setDefaults($.datepicker.regional["es"]);
        }
    },
    _DataTable: function () {
        if ("undefined" !== typeof $.fn.dataTable) {
            console.log("_DataTable");

            $.extend(true, $.fn.dataTable.defaults, {
                "bLengthChange": false,
                "bFilter": false,
                "processing": true,
                "serverSide": true,
                
            });

            $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
                console.info(settings);
                console.info(helpPage);
                console.info(message);
                if (settings.jqXHR !== null && typeof (settings.jqXHR.responseJSON) !== 'undefined') {
                    //var codeError = settings.jqXHR.status;
                    var messageError = settings.jqXHR.responseJSON.error;
                   // Utils._BuilderMessage('danger', messageError);
                    //alert(messageError);
                } else {
                    //alert('Ocurrió un error, por favor comuníquese con el administrador.');
                    //Utils._BuilderMessage('danger', 'Ocurrió un error, por favor comuníquese con el administrador.');
                }
            };
        }
    },
}
