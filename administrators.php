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
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
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
                                <div>Administrators
                                    
                                </div>
                            </div>

                            <div class="page-title-actions">
                                
                                <?php 
                                if($_SESSION['user_login_status']['rol']== 1){ ?>
                                <a href="crear_admin.php" type="button" class="mb-2 mr-2 btn-transition btn btn-outline-primary">
                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                        <i class="fa fa-plus-circle fa-w-20"></i>
                                    </span>
                                    Create
                                </a>  

                                <?php 
                                }   
                                ?>
                        </div>
                        
                        </div>
                    </div>

                    <div class="main-card mb-4 card">
                    <div class="card-body"><h5 class="card-title">List Administrators</h5>

                    <div class="col-md-12" align="right">
                            
                            <div class="col-md-3">
                                    
                                        <div class="position-relative form-group"><label for="exampleEmail" class="">  </label><input name="filtro" id="filtro" placeholder="Filter" type="text" class="form-control"></div>
                                    
                                </div>
                                </div>

                                        <div class="table-responsive ">
                                            
                                        
                            
                                            <table class="mb-0 table table-striped" id="admin">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Full Name</th>
                                                    <th>Id number</th>
                                                    <th>E-mail</th>
                                                    <th>State</th>
                                                    <th>More</th>
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
<script src="js/administrators.js"></script>
</html>