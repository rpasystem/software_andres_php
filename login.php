<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="./img/favicon/logo.jpeg"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
	<link rel="stylesheet" type="text/css" href="css/site.css">
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-20"  novalidate name="login" id="login" method="post" onsubmit="Validar()">
				
				   <center>	<img src="img/Officium.png" ></center>
				

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter identification">
						<input class="input100" type="text" id="email" maxlength="16" name="username" required placeholder="Identification(*)"  maxlength="16" >
						<span class="focus-input100"></span>
					</div>


					<div class="wrap-input100 validate-input m-b-16" data-validate="Please select option">
					<select name="state" id="state" class="input100" required>
                                                        <option value="">Select Option</option>
                                                        <option value="1">Employee</option>
                                                        <option value="2">Admin</option>
                                                    </select>
						<span class="focus-input100"></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" id="pass" maxlength="20" name="pass" required placeholder="Password(*)">
						<span class="focus-input100"></span>
					</div>



					

					<div class="text-right p-t-13 p-b-23">
					
					</div>
				

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>

					

					<div class="text-right p-t-13 p-b-23">
					<center>	<img src="img/staffing.png" ></center>

						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="container-loading" class="container-loading">
        <div>
            <img src="img/loading.gif" alt="" />
            <p>Loading...<br />Wait a moment please.</p>
        </div>
	</div>

<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/moment.min.js"></script>
	<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>
	<script src="js/core.min.js"></script>
    <script type="text/javascript" src="js/site.js"></script>
    <script src="js/revolution.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/login.js"></script>


</body>
</html>