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
    <title>Edit admin</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./css/main.css" rel="stylesheet">
    <link href="./css/site.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
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
                                    <i class="pe-7s-add-user icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Edit administrator
                                    
                                </div>
                            </div>

                            <div class="page-title-actions">
                                
                                
                        </div>
                        
                        </div>
                    </div>

                    <div class="main-card mb-4 card">
                    <div class="card-body">
                                <h5 class="card-title">Form edit administrator</h5>
                                <form class="needs-validation" novalidate name="edit_employee" id="edit_employee" method="post"> 
                                <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id_admin" name="id_admin">
                                <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">First name(*)</label>
                                            <input type="text" class="form-control" maxlength="25"  name="first_name" id="first_name" placeholder="First name"  required>
                                            <div class="invalid-feedback">
                                            First name is required
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Second name</label>
                                            <input type="text" class="form-control" maxlength="25" name="second_name" id="second_name" placeholder="Second name"  >
                                            <div class="invalid-feedback">
                                            Second name is required
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Surname(*)</label>
                                            <input type="text" class="form-control" id="surname" name="surname" maxlength="25"  placeholder="Surname"  required>
                                            <div class="invalid-feedback">
                                            Surname is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Second surname</label>
                                            <input type="text" class="form-control" id="second_surname" name="second_surname" maxlength="25" placeholder="Second surname">
                                            <div class="invalid-feedback">
                                            Second surname is required
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Identification(*)</label>
                                            <input type="text" class="form-control" id="identification" name="identification" maxlength="20" placeholder="Identification" required>
                                            <div class="invalid-feedback">
                                            Identification is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">E-mail(*)</label>
                                            <input type="email" class="form-control" id="email" name="email" maxlength="50" placeholder="E-mail" required>
                                            <div class="invalid-feedback">
                                            E-mail format is not correct
                                            </div>
                                        </div>
                                        
                                    </div>
 
                                    
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Reset Password</label>
                                            <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control" name="password" id="password" maxlength="15" pattern="^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d]{7,15}$" placeholder="Reset password" required>
                                            <div class="invalid-feedback">
                                            Password is not correct
                                            </div>

                                            <div class="input-group-addon">
                                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                            </div>

                                        </div>
                                    </div>


                                    <button class="btn btn-primary" type="submit">Create employee</button>
                                </form>
                            </div> 
                    </div>

                </div>
                <?php include("footer.php") ?>
            </div>

        </div>
    </div>

    
</body>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/edit_admin.js"></script>
</html>