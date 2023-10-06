
(function () {

    $('#valor').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

      $('#tax').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

      
      $('#numero').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
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
  

    })();


    function Validate(){
        var datastring = $("#create_fast_check").serialize()+'&tipo=CREAR_FAST_CHECK';
        
        $.ajax({
            type: "POST",
            url: "./controller/fast_checkController.php",
            data: 
                datastring
            ,
            success: function(data) {
                
                var json = JSON.parse(data);
                if (json.status == 'success') {
                    id = json.id;
                    window.open("./controller/impresion__fast_check.php?id="+id, '_blank');
                    location.reload();
                } else {
                    alert("Ha ocurrido un error, por favor intente de nuevo.");
                }
            }, error: function (jqXHR, exception) {
                console.info(jqXHR)
                console.info(exception)
                return false;
            }
            
        });
    }