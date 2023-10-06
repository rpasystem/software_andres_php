<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
$title = "Home";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="./img/favicon/logo.jpeg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Upload template Fast Check</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
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
                                    <i class="pe-7s-upload icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Fast check

                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <h5 class="card-title">Create fast check </h5>
                            <div class="col-md-12">
                            <form class="needs-validation" novalidate name="create_fast_check" id="create_fast_check" method="post"> 
                            <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Name(*)</label>
                                            <input type="text" class="form-control" maxlength="25"  name="name" id="name" placeholder="Name"  required>
                                            <div class="invalid-feedback">
                                            Name is required
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Value(*)</label>
                                            <input type="text" class="form-control" maxlength="25"  name="valor" id="valor" placeholder="Value"  required>
                                            <div class="invalid-feedback">
                                            Value is required
                                            </div>
                                        </div>
                                        </div>



                                        <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Reason(*)</label>
                                            <input type="text" class="form-control" maxlength="25"  name="razon" id="razon" placeholder="Reason"  required>
                                            <div class="invalid-feedback">
                                            Reason is required
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Tax(*)</label>
                                            <input type="text" class="form-control" maxlength="5"  name="tax" id="tax" placeholder="Tax"  required>
                                            <div class="invalid-feedback">
                                            Tax is required
                                            </div>
                                        </div>
                                        </div>


                                        <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Number(*)</label>
                                            <input type="text" class="form-control" maxlength="25"  name="numero" id="numero" placeholder="Number"  required>
                                            <div class="invalid-feedback">
                                            Number is required
                                            </div>
                                        </div>


                                        </div>

                                        <button class="btn btn-primary" type="submit">Generate fast check</button>

                            </form>
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
<script src="js/upload_fast_check.js"></script>

</html>