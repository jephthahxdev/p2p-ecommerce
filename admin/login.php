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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>	
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
											<li><a href="login.php"><i class="icon-f-94"></i>Sign In</a></li>
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
	</header>
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="../index.php">Home</a></li>
			<li>Admin</li>
			<li><a href="login.php">Login</a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container">
			<h1 class="tt-title-subpages noborder">ADMIN CONTROL</h1>
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
							<h2 class="tt-title">LOGIN</h2>
							If you have an account with us, please log in.
							<div class="form-default form-top">
								<form method="post" action="../dbase/admin_signin.php" id="loginForm">
									<?php session_start();
										if(isset($_SESSION['login_error'])) {
											echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['login_error'].'</div>';
											unset($_SESSION['login_error']); // Clear the session variable after displaying the error
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
										<label for="loginInputName">E-MAIL *</label>
										<div class="tt-required">* Required Fields</div>
										<input type="email" name="email" class="form-control" id="loginInputEmail" placeholder="Enter Username or E-mail" required>
									</div>
									<div class="form-group">
										<label for="loginInputEmail">PASSWORD *</label>
										<input type="password" name="password" class="form-control" id="loginInputPassword" placeholder="Enter Password" required>
									</div>
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" name="login" type="submit">LOGIN</button>
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
				<div class="tt-col-right">
					<div class="tt-col-item">
						<!-- payment-list -->
						<ul class="tt-payment-list">
							<li><a href="#"><span class="icon-Stripe"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span>
			                </span></a></li>
							<li><a href="#"> <span class="icon-paypal-2">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span>
			                </span></a></li>
							<li><a href="#"><span class="icon-visa">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
			                </span></a></li>
							<li><a href="#"><span class="icon-mastercard">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span>
			                </span></a></li>
							<li><a href="#"><span class="icon-discover">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span>
			                </span></a></li>
							<li><a href="#"><span class="icon-american-express">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span>
			                </span></a></li>
						</ul>
						<!-- /payment-list -->
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