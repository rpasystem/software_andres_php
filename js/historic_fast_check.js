var $TABLA_HISTORICO = null
$(function () {
    ListHistoric()
   
});

function exportar_Excel(){
    window.open("./controller/generateexportfast_chechController.php", '_blank');
}

function RecargarTabla() {
    if ($TABLA_HISTORICO != null)
        $TABLA_HISTORICO.draw();
    return false;
}

function ListHistoric(){
    $TABLA_HISTORICO = $('#historic_fast_check').DataTable({
        "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "order": [[ 0, "desc" ]],
        "ajax": {
            "url": './controller/fast_checkController.php',
            "type": "POST",
            "data": function (d) {
                return $.extend({}, d, {
                    "tipo": "LIST_HISTORIC",
                });
            }
        },
        "columns": [
            { "data": "id_check" },
            {"data":"nombre"},
            { "data": "val_total" },
            { "data": "fecha_creacion" },
            { "data": "admin" },
            { "data": "tax" },
            { "data": "description" },

           
        ],
        "drawCallback": function (settings) {
            //Utils._BuilderModal();
        }
    })
}
