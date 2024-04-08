<?php
session_start();

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$currentPage = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Product Upload</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/custom-min.js"></script>
</head>
<body>
<header class="headertype3 headertype3-bottom" id="tt-header">
	<!-- tt-mobile menu -->
	<nav class="panel-menu mobile-main-menu">
			<ul>
				<li>
					<a href="index.html">HOME</a>
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
						<a class="tt-logo tt-logo-alignment" href="index.html"><img src="images/custom/logo.png" alt=""></a>
						<!-- /mobile logo -->
					</div>
				</div>
			</div>
		</div>
	<!-- tt-desktop-header -->
	<div class="tt-desktop-header">
		<div class="container">
			<div class="tt-header-holder">
				<div class="tt-obj-logo">
					<!-- logo -->
					<a class="tt-logo tt-logo-alignment" href="index.html"><img src="images/custom/logo.png" alt=""></a>
					<!-- /logo -->
				</div>
				<div class="tt-obj-options obj-move-right">
					<!--========= visible only desktop ========= -->
					<div class="tt-desctop-parent-account tt-parent-box">
						<div class="tt-account tt-dropdown-obj">
							<button class="tt-dropdown-toggle"  data-tooltip="My Account" data-tposition="bottom"><i class="icon-f-94"></i></button>
							<div class="tt-dropdown-menu">
								<div class="tt-mobile-add">
									<button class="tt-close">Close</button>
								</div>
								<div class="tt-dropdown-inner">
									<ul>
										<li><a href="dashboard.php"><i class="icon-f-94"></i>Account</a></li>
										<li><a href="logout.php"><i class="icon-f-77"></i>Sign Out</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					</div>
			</div>
		</div>
		
	</div>
	<!-- stuck nav -->
	<div class="tt-stuck-nav" id="js-tt-stuck-nav">
			<div class="container">
				<div class="tt-header-row ">
					<div class="tt-stuck-desctop-menu-categories"></div>
					<div class="tt-stuck-parent-menu"></div>
					<div class="tt-stuck-parent-account tt-parent-box"></div>
				</div>
			</div>
		</div>
	
</header>
<div id="tt-pageContent">
	<div class="tt-offset-20 container-indent">
		<div class="container">
			<div class="row">
				<div class="col-md-3 tt-hidden-mobile">
					<div class="tt-menu-categories tt-categories-size-large tt-categories-btn-full-width categories-btn-noclick opened">
						<button class="tt-dropdown-toggle">
							MENU
						</button>
						<div class="tt-dropdown-menu" style="display: block;">
							<nav>
								<ul>
									<li class="tt-submenu">
										<a href="dashboard.php">
												<img src="images/icon-svg/dashboard.svg"/>

											<span>Dashboard</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="product-upload.php">
											<img src="images/icon-svg/product.svg"/>

											<span>Products & Uploads</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="messages.php">
											<img src="images/icon-svg/messages.svg"/>

											<span>Messages</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="orders.php">
											<img src="images/icon-svg/orders.svg"/>

											<span>Orders</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="purchases.php">
											<img src="images/icon-svg/purchase.svg"/>

											<span>Purchases</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="support.php">
											<img src="images/icon-svg/support.svg"/>
												
											<span>Support</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="logout.php">
											<img src="images/icon-svg/logout.svg"/>
												
											<span>Logout</span>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-10 col-lg-9">
					<div class="container-custom">
						<h2 class="tt-title">
							UPLOAD A PRODUCT
						</h2>
					</div>
					<div class="container-custom">
						<div class="tt-btn-img-list">
								<div class="row">
									<div class="col-12">
										<div class="form-default">
											<form method="post" action="dbase/uploader.php" id="uploadForm" enctype="multipart/form-data">
												<?php
													session_start(); // Start the session
													if(isset($_SESSION['upload_error'])) {
														echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['upload_error'].'</div>';
														unset($_SESSION['upload_error']); // Clear the session variable after displaying the error
													}
			
													if(isset($_SESSION['upload_success'])) {
														echo '<div class="alert alert-success" id="responseMessage">'.$_SESSION['upload_success'].'</div>';
														unset($_SESSION['upload_success']); // Clear the session variable after displaying the success message
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
													<label for="productName" class="c-title-small">Product Name:</label>
													<input type="text" class="form-control" id="productName" name="productName" required>
												</div>

												<div class="form-group">
													<label for="price" class="c-title-small">Price (<span>&#163;</span>):</label>
													<input type="number" class="form-control" id="price" name="price" min="0" required>
												</div>

												<div class="form-group">
													<label for="quantity" class="c-title-small">Quantity:</label>
													<input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
												</div>

												<div class="form-group">
													<label for="images" class="custom-upload">
														<span class="upload-caption">Click to upload images</span>
														<input type="file" id="images" name="images[]" accept="image/*" multiple required>
													</label>
													<div class="image-preview">
														<script>
															document.getElementById('images').addEventListener('change', function(event) {
																const previewDiv = document.querySelector('.image-preview');
																previewDiv.innerHTML = '';

																const files = event.target.files;
																for (const file of files) {
																	const reader = new FileReader();

																	reader.onload = function() {
																		const img = new Image();
																		img.src = reader.result;
																		previewDiv.appendChild(img);
																	}

																	reader.readAsDataURL(file);
																}
															});
														</script>
													</div>
												</div>	

												<div class="form-group">
													<label for="description" class="c-title-small">Product Description:</label><br>
													<textarea id="description" class="form-control" name="description" rows="4" cols="50" required></textarea>

												<div class="form-group">
													<button class="btn btn-top btn-border" type="submit" name="upload">Submit</button>
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
		</div>
	<div class="container-custom">
		<div class="container">
			<div class="tt-btn-img-list">
				<div class="row">
					<div class="container-custom">
						<h2 class="tt-title">RECENTLY UPLOADED PRODUCTS</h2>
					</div>
						<table class="container-custom tt-table-shop-01">
							<thead>
								<tr>
									<th class="c-title-small">Product Name</th>
									<th class="c-title-small">Product Image</th>
									<th class="c-title-small">Price (<span>&#163;</span>)</th>
									<th class="c-title-small">Quantity</th>
									<th class="c-title-small">Status</th>
								</tr>
							</thead>
							<tbody id="transactionTable" class="c-title-small">
								
							</tbody>
						</table>
					<div class="container-custom">
						<div class="row">
							<button onclick="prevPage()" class="btn btn-top btn-border">Previous</button>
							<button onclick="nextPage()" class="btn btn-top btn-border">Next</button>
						</div>
					</div>
					<script>
						function loadProducts(page) {
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									document.getElementById("transactionTable").innerHTML = this.responseText;

									// Update the URL in the address bar
									history.pushState(null, null, '?page=' + page);
								}
							};
							xhttp.open("GET", "dbase/get_products.php?page=" + page, true);
							xhttp.send();
						}

						function prevPage() {
							console.log("Prev button clicked");
							window.history.back();
						}

						function nextPage() {
							loadProducts(<?php echo $currentPage; ?> + 1);
						}

						// Load the initial page
						loadProducts(<?php echo $currentPage; ?>);

						// Event listener for popstate (when user navigates back/forward)
						window.onpopstate = function(event) {
							var currentPage = <?php echo $currentPage; ?>;
							loadProducts(currentPage);
						};
					</script>
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
						<a class="tt-logo tt-logo-alignment" href="index.html">
							<img src="images/loader.svg" data-src="images/custom/logo.png" alt="">
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