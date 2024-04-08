<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Check for errors in code build up
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
$vendor = $_SESSION['vendor'];

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
		$userId = $row['user_id'];
		$productName = $row['product_name'];
	} else {
		echo "Product not Found";
	}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Payment</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="css/style.css">
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
			<li>Order Payment</li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container">
			<h1 class="tt-title-subpages noborder">ORDER PAYMENT: #<?php echo $productLink ?></h1>
			<div class="row">
				<div class="col-sm-12 col-xl-6">
					<div class="img-transaction">
						<div class="container-custom">
							<div class="row">
								<div class="c-title-large" style="text-transform: uppercase;">
									<h1 style="font-weight: bolder; font-size: 72px;">Complete</h1>
									<h1 style="font-weight: bolder; font-size: 72px;">your Order,</h1>
									<h1 style="font-weight: bolder; font-size: 72px; color: #2879fe;"><?php echo $first_name; ?>.</h1>
								</div>
								<p class="c-title-small">You are about to pay <span style="color: #2879fe;">£<?php echo $totalPrice; ?></span> for your item: <a href="product-details.php?id=<?php echo $productLink; ?>" style="color: #2879fe;"><?php echo $productName; ?></a></p>
							</div>
						</div>
						<div class="container-custom">
							<div>
								<img src="images/atm_double.png" alt="transactions-img" width="100%"/>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-xl-6">
					<div class="tt-shopcart-wrapper">
						<div class="tt-shopcart-box">							
							<form class="form-default" method="post" action="dbase/payment_handler.php">
								<?php
									if(isset($_SESSION['payment_error'])) {
										echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['payment_error'].'</div>';
										unset($_SESSION['payment_error']); // Clear the session variable after displaying the error
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
								<input type="hidden" name="product_name" value="<?php echo $productName; ?>">
								<input type="hidden" name="vendor" value="<?php echo $vendor; ?>">
								<div class="form-group">
									<label for="card_holder">CARD HOLDER <sup>*</sup></label>
									<input class="form-control" type="text" id="card-holder" name="cardHolder" required><br>
								</div>
								<div class="form-group">
									<label for="card_number">CARD NUMBER <sup>*</sup></label>
									<input class="form-control" type="text" id="cardNumber" name="cardNumber" required><br>
								</div>
								<div class="form-group">
									<label for="expiration_date">EXPIRATION DATE <sup>*</sup></label>
									<input class="form-control" type="text" id="expiry" placeholder="MM/YY" required><br>
								</div>
								<div class="form-group">
									<label for="cvc">CVC <sup>*</sup></label>
									<input class="form-control" type="password" id="cvc" placeholder="CV2" required><br>
								</div>
								<div class="form-group">
									<button class="btn btn-top btn-border" type="submit" name="pay">PAY</button>
								</div>								
							</form>
							<script>
								document.addEventListener('DOMContentLoaded', function() {
								// Card Number Formatting
								document.getElementById('cardNumber').addEventListener('input', function() {
									let value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
									value = value.slice(0, 16); // Limit the card number to 16 digits
									let formattedValue = value.replace(/(.{4})/g, '$1 '); // Add a space after every four digits
									this.value = formattedValue.trim();
								});

								// CVC Formatting
								document.getElementById('cvc').addEventListener('input', function() {
									let value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
									value = value.slice(0, 3); // Limit the cv2 to 3 digits
									this.value = value.trim();
								});

								// Expiry Date Formatting
							document.getElementById('expiry').addEventListener('input', function() {
								let value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
								if (value.length > 4) {
									value = value.slice(0, 4); // Limit to four digits
								}
								if (value.length > 2) {
									value = value.slice(0, 2) + '/' + value.slice(2); // Add a slash after the second digit
								}
								this.value = value.trim();
							});
							});
							</script>
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
							<li><a href="page404.html"><span class="icon-Stripe"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span>
			                </span></a></li>
							<li><a href="page404.html"> <span class="icon-paypal-2">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span>
			                </span></a></li>
							<li><a href="page404.html"><span class="icon-visa">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
			                </span></a></li>
							<li><a href="page404.html"><span class="icon-mastercard">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span>
			                </span></a></li>
							<li><a href="page404.html"><span class="icon-discover">
			                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span>
			                </span></a></li>
							<li><a href="page404.html"><span class="icon-american-express">
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
<!-- modal (AddToCartProduct) -->
<div class="modal  fade"  id="modalAddToCartProduct" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
			</div>
			<div class="modal-body">
				<div class="tt-modal-addtocart mobile">
					<div class="tt-modal-messages">
						<i class="icon-f-68"></i> Added to cart successfully!
					</div>
					<a href="#" class="btn-link btn-close-popup">CONTINUE SHOPPING</a>
			        <a href="shopping_cart_02.html" class="btn-link">VIEW CART</a>
			        <a href="page404.html" class="btn-link">PROCEED TO CHECKOUT</a>
				</div>
				<div class="tt-modal-addtocart desctope">
					<div class="row">
						<div class="col-12 col-lg-6">
							<div class="tt-modal-messages">
								<i class="icon-f-68"></i> Added to cart successfully!
							</div>
							<div class="tt-modal-product">
								<div class="tt-img">
									<img src="images/loader.svg" data-src="images/product/product-01.jpg" alt="">
								</div>
								<h2 class="tt-title"><a href="product.html">Flared Shift Dress</a></h2>
								<div class="tt-qty">
									QTY: <span>1</span>
								</div>
							</div>
							<div class="tt-product-total">
								<div class="tt-total">
									TOTAL: <span class="tt-price">$324</span>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<a href="#" class="tt-cart-total">
								There are 1 items in your cart
								<div class="tt-total">
									TOTAL: <span class="tt-price">$324</span>
								</div>
							</a>
							<a href="#" class="btn btn-border btn-close-popup">CONTINUE SHOPPING</a>
							<a href="shopping_cart_02.html" class="btn btn-border">VIEW CART</a>
							<a href="#" class="btn">PROCEED TO CHECKOUT</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="external/jquery/jquery.min.js"><\/script>')</script>
<script defer src="js/bundle.js"></script>


<a href="#" class="tt-back-to-top" id="js-back-to-top">BACK TO TOP</a>
<script>
jQuery(function($){
	var $window = $(window),
		$ttPageContent = $('#tt-pageContent'),
		ttwindowWidth = window.innerWidth || $window.width(),
		blocks = {
			ttShopCart: $ttPageContent.find('.tt-shopcart-table, .tt-shopcart-table-02')
		};
	if (blocks.ttShopCart.length) {
		ttShopCart(ttwindowWidth);
	};
	var ttCachedWidth = $window.width();
	$window.on('resize', function () {
		var newWidth = $window.width();
		if(newWidth !== ttCachedWidth){
			ttCachedWidth = newWidth;
			var ttwindowWidth = window.innerWidth || $window.width();

			// shopping_cart.html
			if (blocks.ttShopCart.length) {
					ttShopCart(ttwindowWidth);
			};
		}
	});
	function ttShopCart(ttwindowWidth){
		ttwindowWidth <= 789 ?  insertDesctopeObj() : insertMobileObj();

		function insertDesctopeObj(){
				blocks.ttShopCart.find('tr').each(function(){
					var objDesctope = $(this).find('.detach-quantity-desctope .tt-input-counter').detach().get(0);
					$(this).find('.detach-quantity-mobile').append(objDesctope);
				});
		};
		function insertMobileObj(){
				blocks.ttShopCart.find('tr').each(function(){
					var objMobile = $(this).find('.detach-quantity-mobile .tt-input-counter').detach().get(0);
					$(this).find('.detach-quantity-desctope').append(objMobile);
				});
		};
	};
});
</script>
</body>
</html>