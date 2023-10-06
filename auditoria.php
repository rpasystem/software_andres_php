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
                                <div> Logs Audit
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-card mb-4 card">
                    <div class="card-body">
                               

                    <form class="needs-validation" novalidate name="generate_formato" id="generate_formato" method="post"> 
                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom03">Initial date(*)</label>
                                            <input type="text" class="form-control" autocomplete="off" name="initial_date" id="initial_date" placeholder="Hired date" required>
                                            <div class="invalid-feedback">
                                            Initial date is required
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom03">Final date(*)</label>
                                            <input type="text" class="form-control" autocomplete="off" name="final_date" id="final_date" placeholder="Hired date" required>
                                            <div class="invalid-feedback">
                                            Final date is required
                                            </div>
                                        </div>

<input type="hidden" id="id_admin" val="<?php echo $_SESSION['user_login_status']['id'] ?>">

                                        
                                    <div class="col-md-4 mb-3">
                                            <label for="validationCustom04">User administrator(*)</label>
                                            <select  name="staff_company" id="admin" class="form-control" required>
                                                        <option value="">Select user administrator</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            User administrator is required
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
<script src="js/auditoria.js"></script>
</html>