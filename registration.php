<?php
session_start();
require 'config/config.php';
require 'config/common.php';

if ($_POST) {

	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=password_hash($_POST['password'],PASSWORD_DEFAULT);
	$address=$_POST['address'];
	$phone=$_POST['phone'];

	if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])
	|| empty($_POST['password']) || strlen($_POST['password']) < 4 ){

		if (empty($_POST['name'])) {
			$nameError = 'Name is required';
		}
		if (empty($_POST['email'])) {
			$emailError = 'Email is required';
		}
		if (empty($_POST['password'])) {
			$passwordError = 'Password is required';
		}
		if ((!empty($_POST['password'])) && (strlen($_POST['password']) < 4)) {
			$passwordError = 'Password should be at least 4 characters';
		}
		if (empty($_POST['address'])) {
			$addressError = 'Address is required';
		}
		if (empty($_POST['phone'])) {
			$phoneError = 'Phone is required';
		}
	}else{

		$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->execute(array(':email'=>$email));
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if($user){
			echo "<script>alert('Email already exists');</script>";
		}else{
			$stmt = $pdo->prepare("INSERT INTO users(name,email,password,address,phone) VALUES (:name,:email,:password,:address,:phone)");
			$result = $stmt->execute(array(':name'=>$name,':email'=>$email,':password'=>$password,':address'=>
				$address,':phone'=>$phone));
			if ($result) {
				echo "<script>alert('Registration Success.You can now login');window.location.href='login.php';
				</script>";
			}
		}
	}
}
?>


<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Fashion Shopping</title>

	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<a class="navbar-brand logo_h" href="index.php"><h4>Fashion Shop</h4></a>
					
				</div>
			</nav>
		</div>
		
	</header>
	<!-- End Header Area -->

	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome Fashion Shopping</h1>
				</div>
			</div>
		</div>
	</section>

	<!--================Login Box Area =================-->
	<section class="login_box_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login_form_inner">
						<h3 style="color:orange">Register To Shop Our Website</h3>

						<form action="registration.php" method="post" id="contactForm" class="row login_form" novalidate="novalidate">
							<input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">

							<div class="col-md-12 form-group">
								<input type="name" class="form-control"  name="name" placeholder="Name" 
								style="<?php echo empty($nameError) ? '' : 'border:1px solid red'; ?>" 
								onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" name="email" placeholder="Email" 
								style="<?php echo empty($emailError) ? '' : 'border:1px solid red'; ?>" 
								onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" name="password" placeholder="Password" style="<?php echo empty($passwordError) ? '' : 'border:1px solid red'; ?>" 
								onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
								<p style="color:red; margin-top:5px"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" name="address" placeholder="Address" 
								style="<?php echo empty($addressError) ? '' : 'border:1px solid red'; ?>" 
								onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" name="phone" placeholder="Phone" 
								style="<?php echo empty($phoneError) ? '' : 'border:1px solid red'; ?>" 
								onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'">
							</div>
							
							
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
								<a href="login.php" class="primary-btn" style="color: white">Login</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<br>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap" style="padding:0px 0px 50px 0px !important">
		<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
			<p class="footer-text m-0">
				Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved. </a>
			</p>
		</div>
	</footer>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>