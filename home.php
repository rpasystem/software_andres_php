<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$title="Home";
	
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="./img/favicon/logo.jpeg"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>home</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    
    <link href="css/main.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">
    <style>
    .fondo_admin_mobile{
        background: url('img/Home-administradores_mobile.png');
        background-size:150% 100%;
        background-repeat: no-repeat;
    

    }
    .fondo_admin{
        background: url('img/Home-administradores.png');
        background-size:100% 100%;
        background-repeat: no-repeat;
    

    }.fondo_emp{
        background: url('img/home-empleados.png')  ;
        background-size:100% 100%;
        background-repeat: no-repeat;
     
    }.fondo_emp_mobile{
        background: url('img/home-empleados_mobile.png')  ;
        background-size:100% 100%;
        background-repeat: no-repeat;
    }
    .image_profile{
        top: 20%;
        left: 20%;
        transform: translate(2200%, 590%);
    }.image_certificado{
        top: 20%;
        left: 20%;
        transform: translate(1900%, 830%);
    }.image_historico{
        top: 20%;left: 20%;
        transform: translate(1600%, 1080%);

    }.text_profile{
        color: #00000;
        position: absolute;
        transform: translate(740%, 600%);
    }.text_certificado{
        color: #00000;
        position: absolute;
        transform: translate(630%, 910%);
    }.text_historic{
        position: absolute;
        transform: translate(420%, 1210%);
    }



    .text_profile_mobile{
        color: #00000;
        position: absolute;
        transform: translate(150%, 640%);
    }
    .image_profile_mobile{
       
        transform: translate(240%, 470%);
        
    }
    






    .text_certificado_mobile{
        color: #00000;
        position: absolute;
        transform: translate(120%, 965%);
    }
    .image_certificado_mobile{
      
        transform: translate(85%, 654%);
        
    }
    



    .text_historic_mobile{
        position: absolute;
        transform: translate(78%, 1240%);
    }
    .image_historico_mobile{
        
        transform: translate(-65%, 810%);
        
    }


    </style>
</head>

<body>
    <div id="container" class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("head.php") 
        ?>
        <div  id="cabecera" class="app-main ">
            <?php include("navbar.php") ?>
            <div class="app-main__outer">


            <?php if($_SESSION['user_login_status']['rol'] == 1 || $_SESSION['user_login_status']['rol'] == 2){?>
                <div id="cuerpo" class="app-main__inner fondo_admin">
                                    <?php } else{?>
                                        <div id="cuerpo" class="app-main__inner fondo_emp">
                                        <a style="color:black;" href="perfil.php?id=<?php echo  $_SESSION['user_login_status']['id'] ?>"><img src="img/icono-perfil2.png" id="img_perfil" class="image_profile"><h3 id="text_profile" class="text_profile"> My profile</h3></a>
                                        <a style="color:black;" href="certificate.php"><img src="img/icono-certificados2.png" id="img_certificado" class="image_certificado"><h3 id="text_certificado" class="text_certificado">Certificates</h3></a>
                                        <a style="color:black" href="historic_pay_employee.php?id=<?php echo  $_SESSION['user_login_status']['id'] ?>"><img src="img/icono-de-historia2.png"  id="img_historico" class="image_historico"><h3 id="text_historic" class="text_historic"> Historic payroll</h3></a>
                                        <?php } ?>
                
                


                    
                    
                        </div>
                        
                    </div>

                </div>
                <?php include("footer.php") ?>
            </div>

        </div>
    </div>

    
</body>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php if($_SESSION['user_login_status']['rol'] == 1 || $_SESSION['user_login_status']['rol'] == 2){?>
<script>
jQuery(document).ready(function($) {
    $("#container").addClass('closed-sidebar')
  var alterClass = function() {
    var ww = document.body.clientWidth;
    
    if (ww < 1000) {
        
      $('#cabecera').addClass('fondo_admin_mobile');
      $('#cuerpo').removeClass('fondo_admin');
      $("#footer").hide()
    } else if (ww >= 1001) {
      $('#cabecera').removeClass('fondo_admin_mobile');
      $('#cuerpo').addClass('fondo_admin');
   
    };
  };
  $(window).resize(function(){
    alterClass();
  });
  //Fire it when the page first loads:
  alterClass();
});
</script>
<?php } else{?>
    <script>



jQuery(document).ready(function($) {
    $("#container").addClass('closed-sidebar')
  var alterClass = function() {
    var ww = document.body.clientWidth;
    
    if (ww < 1000) {
        
      $('#cabecera').addClass('fondo_emp_mobile');
      $('#cuerpo').removeClass('fondo_emp');


      $("#img_perfil").removeClass('image_profile');
      $("#img_perfil").addClass('image_profile_mobile');

      $("#text_profile").removeClass('text_profile');
      $("#text_profile").addClass('text_profile_mobile');
      
      

      $("#img_certificado").removeClass('image_certificado');
      $("#img_certificado").addClass('image_certificado_mobile');

      $("#text_certificado").removeClass('text_certificado');
      $("#text_certificado").addClass('text_certificado_mobile');
      
      


        
      $("#img_historico").removeClass('image_historico');
      $("#img_historico").addClass('image_historico_mobile');

      $("#text_historic").removeClass('text_historic');
      $("#text_historic").addClass('text_historic_mobile');
      
      $("#footer").hide()

    } else if (ww >= 1001) {
      $('#cabecera').removeClass('fondo_emp_mobile');
      $('#cuerpo').addClass('fondo_emp');


      $("#img_perfil").addClass('image_profile');
      $("#img_perfil").removeClass('image_profile_mobile');

      $("#text_profile").addClass('text_profile');
      $("#text_profile").removeClass('text_profile_mobile');
    };
  };
  $(window).resize(function(){
    alterClass();
  });
  //Fire it when the page first loads:
  alterClass();
});
</script>
    <?php } ?>
</html>