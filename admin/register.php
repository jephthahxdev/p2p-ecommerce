<?php
session_start();

// Checking if the user is already logged in
if(isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Admin</title>
	<link rel="shortcut icon" href="#">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../css/style.css">
	
</head>
<body>
	<header id="tt-header">
		<!-- tt-mobile menu -->
		<nav class="panel-menu mobile-main-menu">
			<ul>
				<li>
					<a href="../index.php">HOME</a>
				</li>
			</ul>
			<div class="mm-navbtn-names">
				<div class="mm-closebtn">Close</div>
				<div class="mm-backbtn">Back</div>
			</div>
		</nav>
			<nav class="panel-menu mobile-caterorie-menu">
			<div class="mm-navbtn-names">
				<div class="mm-closebtn">Close</div>
				<div class="mm-backbtn">Back</div>
			</div>
		</nav>
		<!-- tt-mobile-header -->
		<div class="tt-mobile-header">
			<div class="container-fluid tt-top-line">
				<div class="tt-header-row">
					<div class="tt-mobile-parent-menu">
						<div class="tt-menu-toggle stylization-02" id="js-menu-toggle">
							<i class="icon-03"></i>
						</div>
					</div>
					<!-- account -->
					<div class="tt-mobile-parent-account tt-parent-box"></div>
					<!-- /account -->
				</div>
			</div>
			<div class="container-fluid tt-top-line">
				<div class="row">
					<div class="tt-logo-container">
						<!-- mobile logo -->
						<a class="tt-logo tt-logo-alignment" href="../index.php"><img src="../images/custom/logo.png" alt=""></a>
						<!-- /mobile logo -->
					</div>
				</div>
			</div>
		</div>
		<!-- tt-desktop-header -->
		<div class="tt-desktop-header headerunderline">
			<div class="container">
				<div class="tt-header-holder">
					<div class="tt-col-obj tt-obj-logo">
						<!-- logo -->
						<a class="tt-logo tt-logo-alignment" href="../index.php"><img src="../images/custom/logo.png" alt=""></a>
						<!-- /logo -->
					</div>
					<div class="tt-col-obj tt-obj-menu">
						<!-- tt-menu -->
						<div class="tt-desctop-parent-menu tt-parent-box">
							<div class="tt-desctop-menu">
								<ul>
									<li>
										<a href="../index.php">HOME</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- /tt-menu -->
					</div>
					<div class="tt-col-obj tt-obj-options obj-move-right">
						<!-- tt-search -->
						<!-- tt-account -->
						<div class="tt-desctop-parent-account tt-parent-box">
							<div class="tt-account tt-dropdown-obj">
								<button class="tt-dropdown-toggle"  data-tooltip="My Account" data-tposition="bottom"><i class="icon-f-94"></i></button>
								<div class="tt-dropdown-menu">
									<div class="tt-mobile-add">
										<button class="tt-close">Close</button>
									</div>
									<div class="tt-dropdown-inner">
										<ul>
											<li><a href="login.php"><i class="icon-f-76"></i>Sign In</a></li>
											<li><a href="register.php"><i class="icon-f-94"></i>Register</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- /tt-account -->
						</div>
				</div>
			</div>
		</div>
		<!-- /tt-desktop-header -->
		<!-- stuck nav -->
		<div class="tt-stuck-nav" id="js-tt-stuck-nav">
			<div class="container">
				<div class="tt-header-row ">
					<div class="tt-stuck-desctop-menu-categories"></div>
					<div class="tt-stuck-parent-menu"></div>
					<div class="tt-stuck-parent-account tt-parent-box"></div>
					<div class="tt-stuck-parent-multi tt-parent-box"></div>
				</div>
			</div>
		</div>
	</header>
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li>Register</li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container">
			<h1 class="tt-title-subpages noborder">ADMIN REGISTER</h1>
			<div class="tt-login-form">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="tt-item">
                            <img src="../images/admin.png" width="100%"/>
							<p>
								Login as an administrator to have acces to the overview of activities within MarionPeer system.
							</p>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="tt-item">
							<h2 class="tt-title">REGISTER</h2>
							If you do not have an account with us, please register.				
							<div class="form-default form-top">
								<form method="post" action="../dbase/admin_signup.php" id="loginForm">
									<?php
										session_start(); // Start the session
										if(isset($_SESSION['registration_error'])) {
											echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['registration_error'].'</div>';
											unset($_SESSION['registration_error']); // Clear the session variable after displaying the error
										}

										if(isset($_SESSION['registration_success'])) {
											echo '<div class="alert alert-success" id="responseMessage">'.$_SESSION['registration_success'].'</div>';
											unset($_SESSION['registration_success']); // Clear the session variable after displaying the success message
										}
									?>
									<script>
										document.addEventListener('DOMContentLoaded', function() {
											var responseMessage = document.getElementById('responseMessage');

											if (responseMessage) {
											setTimeout(function() {
												responseMessage.style.transition = "opacity 0.5s";
												responseMessage.style.opacity = "0";
											}, 3000);

											setTimeout(function() {
												responseMessage.style.display = "none";
											}, 3500);
											}
										});
									</script>
									<div class="form-group">
										<label for="loginInputName">FIRST NAME</label>
										<div class="tt-required">* Required Fields</div>
										<input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required>
									</div>
									<div class="form-group">
										<label for="loginInputName">LAST NAME</label>
										<div class="tt-required">* Required Fields</div>
										<input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required>
									</div>
									<div class="form-group">
										<label for="loginInputName">E-MAIL *</label>
										<div class="tt-required">* Required Fields</div>
										<input type="email" name="email" class="form-control" placeholder="Enter E-mail" required>
									</div>
									<div class="form-group">
										<label for="loginInputName">PHONE *</label>
										<div class="tt-required">* Required Fields</div>
										<input type="tel" name="phone_number" class="form-control" placeholder="Enter phone number" required>
									</div>
									<div class="form-group">
										<label for="loginInputEmail">PASSWORD *</label>
										<div class="tt-required">* Required Fields</div>
										<input type="password" name="password" class="form-control" placeholder="Enter Password" required>
									</div>
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" name="register" type="submit">REGISTER</button>
											</div>
										</div>										
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<footer id="tt-footer">
	<div class="tt-footer-custom">
		<div class="container">
			<div class="tt-row">
				<div class="tt-col-left">
					<div class="tt-col-item tt-logo-col">
						<!-- logo -->
						<a class="tt-logo tt-logo-alignment" href="index.php">
							<img  src="images/loader.svg"  data-src="images/custom/logo.png" alt="">
						</a>
						<!-- /logo -->
					</div>
					<div class="tt-col-item">
						<!-- copyright -->
						<div class="tt-box-copyright">
							&copy; MarionPeer 2023. All Rights Reserved
						</div>
						<!-- /copyright -->
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="external/jquery/jquery.min.js"><\/script>')</script>
<script defer src="js/bundle.js"></script>

<a href="#" class="tt-back-to-top" id="js-back-to-top">BACK TO TOP</a>
</body>
</html>