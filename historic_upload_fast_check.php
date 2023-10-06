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
    <title>Historic upload fast check </title>
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
                                <div>Historic upload fast check
                                    
                                </div>
                            </div>

                            
                        
                        </div>
                    </div>

                    <div class="main-card mb-12 card">
                        <br>
                        <div class="col-md-3">
                        <button  class="btn btn-primary" onclick="exportar_Excel()">Export to Excel </button> 
                        </div>
                        
                    <div class="card-body"><h5 class="card-title">List historic upload fast check </h5>


                                        <div class="table-responsive ">
                                            
                                        
                            
                                            <table class="mb-0 table table-striped" id="historic_fast_check">
                                                <thead>
                                                <tr>
                                                    <th>Number check</th>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th>Date</th>
                                                    <th>Admin</th>
                                                    <th>Tax</th>
                                                    <th>Reason</th>
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
<script src="js/historic_fast_check.js"></script>
</html>