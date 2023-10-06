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
    <title>Upload Paydroll</title>
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
                                    <i class="pe-7s-timer icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <input type="hidden" id="id_historic" value="<?php echo $_GET['id'] ?>">
                                <div>Detail historic upload Payroll
                                    
                                </div>
                            </div>

                        
                        </div>
                    </div>

                    <div class="col-lg-12">
                    <div class="main-card mb-12 card">
                    <div class="card-body">


            

            

                <div class="form-row">
                <h3> Detalis fails</h3>
                <div class="table-responsive">
                <table class="mb-0 table table-striped" id="details_fails" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Detail</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                </div>


                </div>



                <div class="col-md-12">
                <div class="form-row">
                <h3>Detalis success</h3>



                <div class="col-md-12" >
                    <div class="form-row">
                <div class="col-md-3 mb-3" style="float: left;" >
                                            <br>
                                            <button type="button" style="font-size: 12px;" class="btn-block btn-transition btn btn-outline-primary" Onclick="Imprimir_Seleccionados()">Print selected</button>
                                    </div>

                                        </div>
                                </div>
                <div class="table-responsive">
                <form>
                                            <table  class="display mb-0 table table-striped" style="width:100%" cellpadding="1000" style="width:100%" id="details_employee_success">
                                                <thead>
                                                <tr>
                                                    
                                                    <th>Staff company</th>
                                                    <th>Employee</th>
                                                    <th>Reg.Hour</th>
                                                    <th>PTO</th>
                                                    <th>Over time</th>
                                                    <th>Missing hour</th>
                                                    <th>Bonus</th>
                                                    <th>Deductions</th>
                                                    <th>Subtotal</th>
                                                    <th>NetPay</th>
                                                    <th>Details</th>
                                                    <th>Print</th>
                                                    <th><input type="checkbox" id="select_all" /></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            </form>
                                        </div>
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
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script src="js/details_historic_upload_payroll.js"></script>
</html>