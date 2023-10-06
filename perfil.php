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
    <title>Edit employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
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
                                <div>My profile
                                    
                                </div>
                            </div>

                            <div class="page-title-actions">
                                
                                
                        </div>
                        
                        </div>
                    </div>

                    <div class="main-card mb-4 card">
                    <div class="card-body">
                                <h5 class="card-title">My profile</h5>

                                <input type="hidden" id="id_emplyee" name="id_emplyee" value="<?php echo $_GET['id'] ?>" >
                                <div class="form-row">
                                <div class="col-md-6 mb-3">
                                <center><img id="logo_empresa" src="img/avatar_2x.png" alt="" class="rounded-circle col-sm-4" width="100px" /></center>
                                </div>
                                
                                </div>


                                <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Id(*)</label>
                                            <input type="text" class="form-control" disabled maxlength="25"  name="id_employee_edit" id="id_employee_edit" placeholder="Id"  required>
                                            <div class="invalid-feedback">
                                            Id is required
                                            </div>
                                        </div>
                                        </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">First name(*)</label>
                                            <input type="text" class="form-control" disabled maxlength="25"  name="first_name" id="first_name" placeholder="First name"  required>
                                            <div class="invalid-feedback">
                                            First name is required
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Middle name</label>
                                            <input type="text" class="form-control" disabled maxlength="25" name="second_name" id="second_name" placeholder="Middle name"  >
                                            <div class="invalid-feedback">
                                            Middle name is required
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Last name(*)</label>
                                            <input type="text" class="form-control"disabled id="surname" name="surname" maxlength="25"  placeholder="Last name"  required>
                                            <div class="invalid-feedback">
                                            Last name is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Last name</label>
                                            <input type="text" class="form-control" disabled id="second_surname" name="second_surname" maxlength="25" placeholder="Last name">
                                            <div class="invalid-feedback">
                                            Last name is required
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">ID Number(*)</label>
                                            <input type="text" class="form-control" disabled id="identification" name="identification" maxlength="20" placeholder="ID Number" required>
                                            <div class="invalid-feedback">
                                            ID Number is required
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Address(*)</label>
                                            <input type="text" class="form-control" disabled id="address_emp" name="address" maxlength="25"  placeholder="Adress" required>
                                            <div class="invalid-feedback">
                                            Address is required
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">State(*)</label>
                                            <select  name="state" id="state" disabled class="form-control" required onchange="FindCities(this)">
                                                        <option value="">Select state</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            State is required
                                            </div>
                                        
                                    </div>

                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">City(*)</label>
                                            <select  name="city" disabled id="city" class="form-control" required>
                                                        <option value="">Select city</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            City is required
                                            </div>
                                        
                                    </div>

                                    </div>



                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Zip Code(*)</label>
                                            <input type="text" class="form-control" disabled name="postcode" id="postcode" maxlength="10" placeholder="Zip Code" required>
                                            <div class="invalid-feedback">
                                            Zip Code is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Phone Number(*)</label>
                                            <input type="text" class="form-control"  disabled name="phone" id="phone_edit" maxlength="12" placeholder="Postcode" required>
                                            <div class="invalid-feedback">
                                            Phone Number is required
                                            </div>
                                        </div>

                                    </div>


                                    
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Emergency contact(*)</label>
                                            <input type="text" class="form-control" disabled name="emergency" id="emergency" maxlength="12" placeholder="Emergency contact" required>
                                            <div class="invalid-feedback">
                                            Emergency contact is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Hired date(*)</label>
                                            <input type="text" class="form-control" disabled name="birth" id="birth" placeholder="Hired date" required>
                                            <div class="invalid-feedback">
                                            Hired date is required
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Gender(*)</label>
                                            <select  name="gender" id="gender" disabled class="form-control" required>
                                                        <option value="">Select Gender</option>
                                                        
                                                    </select>
                                            <div class="invalid-feedback">
                                            Gender is required
                                            </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Nationality(*)</label>
                                            <select  name="nationality" id="nationality" disabled class="form-control" required>
                                                        <option value="">Select Nationality</option>
                                                        
                                                    </select>
                                            <div class="invalid-feedback">
                                            Nationality is required
                                            </div>
                                    </div>
                                    </div>

                                    <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                    <label for="validationCustom03">Date of birth(*)</label>
                                            <input type="text" class="form-control" name="nacimiento" id="nacimiento" placeholder="Date of birth" required>
                                            <div class="invalid-feedback">
                                            Date of birth is required
                                            </div>
                                            </div>
                                    </div>

                                    <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">E-mail</label>
                                            <input type="email" class="form-control" disabled id="email" name="email" maxlength="50" placeholder="E-mail">
                                            <div class="invalid-feedback">
                                            E-mail format is not correct
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Host company(*)</label>
                                            <select  id="host_company"disabled name="host_company" class="form-control" Onchange="HostCompany(this)" required>
                                                        <option value="">Select Host company</option>
                                                        
                                                    </select>
                                            <div class="invalid-feedback">
                                            Host company is required
                                            </div>
                                        
                                    </div>
                                        
                                    </div>


                                    <div class="form-row">
                                    

                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Work Place(*)</label>
                                            <select  name="work_place" disabled id="work_place" class="form-control" Onchange="Find_Staff(this)" required>
                                                        <option value="">Select Work place</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            Work place is required
                                            </div>
                                        
                                    </div>

                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom04">Staff company(*)</label>
                                            <select  name="staff_company" disabled id="staff_company" class="form-control" required>
                                                        <option value="">Select Staff company</option>
                                                    </select>
                                            <div class="invalid-feedback">
                                            Staff company is required
                                            </div>
                                        
                                    </div>


                                    </div>


                                    <div class="form-row">


                                   
                                    <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Position(*)</label>
                                            <input type="text" class="form-control" disabled name="position" id="position" maxlength="50" placeholder="Position" required>
                                            <div class="invalid-feedback">
                                            Position is required
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Regular rate(*)</label>
                                            <input type="text" class="form-control" disabled name="hourvalue" id="hourvalue" maxlength="10" placeholder="Regular rate" required>
                                            <div class="invalid-feedback">
                                            Regular rate is required                                            
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-row">
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Over time rate(*)</label>
                                            <input type="text" class="form-control" disabled name="overtime" id="overtime" maxlength="10" placeholder="Over time rate" required>
                                            <div class="invalid-feedback">
                                            Over time rate is required                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">Shift(*)</label>
                                            <input type="text" class="form-control"disabled name="shift" id="shift" maxlength="20" placeholder="Shift" required>
                                            <div class="invalid-feedback">
                                            Shift is required
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
<script src="js/edit_empleado.js"></script>
</html>