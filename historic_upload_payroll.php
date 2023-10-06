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
    <title>Historic upload payroll</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="./css/main.css" rel="stylesheet">
    <link href="./css/site.css" rel="stylesheet">
    
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("head.php") ?>
        <div class="app-main">
            <?php include("navbar.php") ?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Historic upload payroll
                                    
                                </div>
                            </div>

                            
                        
                        </div>
                    </div>

                    <div class="main-card mb-12 card">
                    <div class="card-body"><h5 class="card-title">List historic upload payroll </h5>



                    <div class="col-md-12" >
                    <div class="form-row">
                                       
                                    <div class="col-md-3 mb-3">
                                            <label for="validationCustom04">Day of the week</label>
                                            <input type="text" autocomplete="off" class="form-control" name="day_of_the_week" id="day_of_the_week" placeholder="Day of the week">
                                    </div>

                                    <div class="col-md-3 mb-3" style="float: left;" >
                                            <br>
                                            <button type="button" style="font-size: 12px;" class="btn-block btn-transition btn btn-outline-primary" Onclick="RecargarTabla()">Filter</button>
                                    </div>
                                        </div>
                                </div>





                                        <div class="table-responsive ">
                                            
                                        
                            
                                            <table class="mb-0 table table-striped" id="historic_payroll">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Staff Company</th>
                                                    <th>Dates</th>
                                                    <th>Date upload</th>
                                                    <th>success</th>
                                                    <th>Failed</th>
                                                    <th>Details</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script src="js/historic_payroll.js"></script>
</html>