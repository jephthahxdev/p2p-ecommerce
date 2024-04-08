<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Check for errors in code build up
session_start();

require('dbase/db_conn.php');

// Check if the order initiation flag is set
if (!isset($_SESSION['product_id'])) {
    header('Location: index.php');
    exit();
}

//Getting user session
$isLoggedIn = isset($_SESSION['user_id']);
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

// Getting purchase details session before payment initiation
$productLink = $_SESSION['product_id'];
$quantity = $_SESSION['quantity'];
$totalPrice = $_SESSION['total_price'];

$sql = "SELECT 
		products.id,
		products.user_id,
		products.product_name,
		products.price,
		products.first_name,
		products.last_name,
		products.email
		FROM products
		WHERE product_link = '$productLink'";

$result = $conn->query($sql);

	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$productId = $row['id'];
		$productName = $row['product_name'];
		$price = $row['price'];
		$vendor = $row['first_name'];

		// Store $vendor in a session variable
		$_SESSION['vendor'] = $vendor;

		// Retrieve main image URL from the images table
		$sqlImage = "SELECT 
		images.image_url,
		images.product_id
		FROM images 
		WHERE product_id = " . $row['id'] . " LIMIT 1";
		$resultImage = $conn->query($sqlImage);

		if ($resultImage->num_rows == 1) {
		$rowImage = $resultImage->fetch_assoc();
		$mainImage = "MarionPeer/" . $rowImage['image_url'];
		} else {
		echo "Image not found";
		}
	} else {
		echo "No Product Found";
	}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Order Summary</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="css/style.css">
	<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	<script src="js/custom-min.js"></script>
</head>
<body>
<header id="tt-header">
	<!-- tt-mobile menu -->
	<nav class="panel-menu mobile-main-menu">
		<ul>
			<li>
				<a href="index.php">HOME</a>
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
					<a class="tt-logo tt-logo-alignment" href="index.php"><img src="images/custom/logo.png" alt=""></a>
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
					<a class="tt-logo tt-logo-alignment" href="index.php"><img src="images/custom/logo.png" alt=""></a>
					<!-- /logo -->
				</div>
				<div class="tt-col-obj tt-obj-menu">
					<!-- tt-menu -->
					<div class="tt-desctop-parent-menu tt-parent-box">
						<div class="tt-desctop-menu">
							<ul>
								<li>
									<a href="index.php">HOME</a>
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
									    <li><a href="dashboard.php"><i class="icon-f-94"></i>Account</a></li>
									    <li><a href="login.php"><i class="icon-f-76"></i>Sign In</a></li>
									    <li><a href="register.php"><i class="icon-f-94"></i>Register</a></li>
									    <li><a href="logout.php"><i class="icon-f-77"></i>Sign Out</a></li>										
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
				<div class="tt-stuck-mobile-menu-categories"></div>
				<div class="tt-stuck-parent-search tt-parent-box"></div>
				<div class="tt-stuck-parent-cart tt-parent-box"></div>
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
			<li><a href="#"><?php echo isset($productName) ? $productName : ''; ?></a></li>
			<li>Order Summary</li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-shopping-layout">
				<h1 class="tt-title-subpages noborder" style="font-size: 28px;" id="orderSummary">ORDER SUMMARY</h1>
				<div class="tt-wrapper">
				<?php if (!$isLoggedIn): ?>
					<a href="#" id="notLoggedIn" class="btn" target="_blank">NOT LOGGED IN? LOGIN</a><br>
				<?php endif; ?>
				<script>
					document.getElementById('notLoggedIn').addEventListener('click', function(event) {
						event.preventDefault();

						// Open login page in a new popup window
						var loginWindow = window.open('login.php', '_blank', 'width=600,height=400');

						// Set an interval to check if the popup window has been closed
						var checkClosed = setInterval(function() {
							if (loginWindow.closed) {
								clearInterval(checkClosed);

								// Assuming `loginSuccessful` is set to true when login is successful
								var loginSuccessful = true;

								if (loginSuccessful) {
									// Reload the product details page
									window.location.reload();
								}
							}
						}, 500); // Check every 500 milliseconds (adjust as needed)
					});
				</script>
					<?php
						if ($result->num_rows == 1) {
							// Display the link to return to the product page
							echo '<a href="product-details.php?id=' . $productLink . '" class="tt-link-back">';
							echo '<i class="icon-h-46"></i> RETURN TO PRODUCT PAGE';
							echo '</a>';
						} else {
							// If product is not found, display return to home page message
							echo '<a href="index.php" class="tt-link-back">';
							echo '<i class="icon-h-46"></i> RETURN TO HOME PAGE';
							echo '</a>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="container-indent">
		<div class="container">
			<div class="tt-shopcart-table-02">
				<table>
					<tbody>
						<tr>
							<td>
								<div class="tt-product-img">
									<img src="<?php echo $mainImage ?>" data-src="<?php echo $mainImage; ?>" alt="">
								</div>
							</td>
							<td>
								<h2 class="tt-title">
									<a href="#"><?php echo $productName; ?></a>
								</h2>
								<ul class="tt-list-description">
									<li>Vendor: <?php echo $vendor ?></li>
									<li class="tt-title-small" style="color: #2778fd; font-weight:500; letter-spacing:0.2em;">MARIONPEER</li>
								</ul>
								<ul class="tt-list-parameters">
									<li>
										<div class="tt-price">
											<span>£</span><?php echo $price; ?>
										</div>
									</li>
									<li>
										<div class="detach-quantity-mobile"></div>
									</li>
									<li>
										<div class="tt-price subtotal">
											<span>£</span><?php echo $price; ?>
										</div>
									</li>
								</ul>
							</td>
							<td>
								<div class="tt-price">
									<span>£</span><?php echo $price; ?>
								</div>
							</td>
							<td>
								<div class="detach-quantity-desctope">
									<div class="tt-input-counter style-01">
										<?php echo $quantity; ?>
									</div>
								</div>
							</td>
							<td>
								<div class="tt-price subtotal">
									<span>£</span><?php echo $totalPrice; ?>
								</div>
							</td>
							<td></td>							
						</tr>
					</tbody>
				</table>
				<div class="tt-shopcart-col">
					<div class="row">
						<div class="col-md-6 col-lg-8">
							<div class="tt-shopcart-box">
								<h4 class="tt-title">
									YOUR BILLING DETAILS
								</h4>
								<p>Enter your destination to have your product delivered</p>
								<form class="form-default" method="post" action="dbase/order-billing.php" id="formBilling">
									<?php
											if(isset($_SESSION['message_error'])) {
												echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['message_error'].'</div>';
												unset($_SESSION['message_error']); // Clear the session variable after displaying the error
											}

											if(isset($_SESSION['message_success'])) {
												echo '<div class="alert alert-success" id="responseMessage">'.$_SESSION['message_success'].'</div>';
												unset($_SESSION['message_success']); // Clear the session variable after displaying the success message
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
									<input type="hidden" name="first_name" value="<?php echo $first_name; ?>">
									<input type="hidden" name="last_name" value="<?php echo $last_name; ?>">
									<div class="form-group">
										<label for="address_country">COUNTRY <sup>*</sup></label>
										<select id="address_country" class="form-control" name="select_country" required>
											<option value="Austria">Austria</option>
											<option value="Belgium">Belgium</option>
											<option value="Cyprus">Cyprus</option>
											<option value="Croatia">Croatia</option>
											<option value="Czech-republic">Czech Republic</option>
											<option value="Denmark">Denmark</option>
											<option value="Finland">Finland</option>
											<option value="France">France</option>
											<option value="Germany">Germany</option>
											<option value="Greece">Greece</option>
											<option value="Hungary">Hungary</option>
											<option value="Ireland">Ireland</option>
											<option value="France">France</option>
											<option value="Italy">Italy</option>
											<option value="Luxemborg">Luxembourg</option>
											<option value="Netherlands">Netherlands</option>
											<option value="Poland">Poland</option>
											<option value="Portugal">Portugal</option>
											<option value="Slovakia">Slovakia</option>
											<option value="Slovenia">Slovenia</option>
											<option value="Spain">Spain</option>
											<option value="United-kingdom">United Kingdom</option>
										</select>
									</div>
									<div class="form-group">
										<label for="address_province">STATE/PROVINCE <sup>*</sup></label>
										<input type="text" class="form-control" id="shopState" name="state" required>										
									</div>
									<div class="form-group">
										<label for="shopAddress" class="control-label">ADDRESS *</label>
										<input type="text" class="form-control" id="shopAddress" name="address" required>
									</div>
									<div class="form-group">
										<label for="shopTown" class="control-label">TOWN / CITY *</label>
										<input type="text" class="form-control" id="shopTown" name="town_city" required>
									</div>							
									<div class="form-group">
										<label for="shopPostCode" class="control-label">POSTCODE / ZIP *</label>
										<input type="text" class="form-control" id="shopPostCode" name="postcode" required>
									</div>
									<div class="form-group">
										<label for="shopPhone" class="control-label">PHONE</label>
										<input type="text" class="form-control" id="shopPhone" name="phone" required>
									</div>									
								</form>
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="tt-shopcart-box tt-boredr-large">
								<table class="tt-shopcart-table01">
									<tbody>
										<tr>
											<th>SUBTOTAL</th>
											<td><span>£</span><?php echo $totalPrice; ?></td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th>GRAND TOTAL</th>
											<td><span>£</span><?php echo $totalPrice; ?></td>
										</tr>
									</tfoot>
								</table>
								<a href="#" id="checkoutBtn" class="btn btn-lg" style="padding-top: 20px;">PROCEED TO CHECKOUT</a>
								<a href="#orderSummary" id="altLogin" class="btn btn-lg" style="padding-top: 20px;">LOGIN TO PROCEED</a>
								<script>
									document.getElementById('checkoutBtn').addEventListener('click', function(event) {
									var form = document.getElementById('formBilling');

									// Check if all required fields are filled
									if (!form.checkValidity()) {
									event.preventDefault(); // Prevent form submission
									alert('Please fill in all required fields');
									} else {
									form.submit(); // Submit the form
									}
								});
								document.addEventListener('DOMContentLoaded', function() {
									<?php
										if(isset($_SESSION['user_id'])) {
											echo "document.getElementById('checkoutBtn').style.display = 'block';";
											echo "document.getElementById('altLogin').style.display = 'none';";
										} else {
											echo "document.getElementById('checkoutBtn').style.display = 'none';";
											echo "document.getElementById('altLogin').style.display = 'block';";
										}
									?>
								});
								</script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<script defer src="separate-include/single-product/single-product.js"></script>
</body>
</html>