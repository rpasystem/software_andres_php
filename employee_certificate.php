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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">
    
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("head.php") 
        ?>
        <div class="app-main">
            <?php include("navbar.php") ?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-file icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>1099
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-card mb-4 card">
                    <div class="card-body">
                               

                    <form class="needs-validation" novalidate name="generate_formato" id="generate_formato" method="post"> 
                    <div class="form-row">
                                       
  
                                    <div class="col-md-4 mb-3">
                                            <label for="validationCustom04">Employee(*)</label>
                                            <select  name="id_employee" id="id_employee" class="form-control" required>
                                                        <option value="">Select employee</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            Staff employee
                                            </div>
                                        
                                    </div>

                                    </div>

                                    <button class="btn btn-primary" type="submit">Generate</button>
                    </form>


                                </div>
                        </div>
                    
                    
                        </div>
                        
                    </div>

                </div>
                <?php include("footer.php") ?>
            </div>

        </div>
    </div>

    
</body>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/employee_certificate.js"></script>
</html>