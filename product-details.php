<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Check for errors in code build up
session_start();

require('dbase/db_conn.php');


// Retrieve product ID from the URL
$productLink = $_GET['id'];

// Getting user session
$email = $_SESSION['email'];
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$productBuyer = $firstName . ' ' . $lastName;

if ($productLink > 0) {
    // Retrieve product details along with associated images
    $sqlProduct = "SELECT 
        products.id,
		products.product_name, 
        products.price, 
        products.quantity, 
        products.description,
		products.date_uploaded, 
        products.first_name as products_first_name,
		products.email as products_email
        FROM products
        WHERE products.product_link = '$productLink'";

    $resultProduct = $conn->query($sqlProduct);

	if ($resultProduct->num_rows == 1) {
		$rowProduct = $resultProduct->fetch_assoc();
	
		// Calculate number of days ago
		$uploadDate = strtotime($rowProduct['date_uploaded']);
		$currentDate = time();
		$daysAgo = floor(($currentDate - $uploadDate) / (60 * 60 * 24));
	
		// Display product details
		$productId = $rowProduct['id'];
		$productName = $rowProduct['product_name'];
		$price = $rowProduct['price'];
		$quantity = $rowProduct['quantity'];
	
		// Product description
		$description = $rowProduct['description'];
		$words = str_word_count($description, 1);
	
		// Shortening product description
		if (count($words) > 10) {
			$shortDescription = implode(' ', array_slice($words, 0, 10)) . '...';
		} else {
			$shortDescription = $description;
		}
	
		// Vendor details
		$vendor = $rowProduct['products_first_name'];
		$vendorEmail = $rowProduct['products_email'];
	
		// Fetch associated images
		$sqlImages = "SELECT image_url FROM images WHERE product_id = " . $rowProduct['id'];
		$resultImages = $conn->query($sqlImages);

		if ($resultImages->num_rows > 0) {
			$imageUrls = [];

			while ($rowImage = $resultImages->fetch_assoc()) {
				$imageUrls[] = "MarionPeer/" . $rowImage['image_url'];
			}

			// Main image is the first element
			$mainImage = $imageUrls[0];

			// Thumbnails are the rest of the elements
			$thumbnails = array_slice($imageUrls, 1);
		} else {
			$imageUrls = array(); // Empty array if no images found
			$mainImage = ''; // Set a default value for mainImage if no images found
			$thumbnails = []; // Set a default empty array for thumbnails
		}
	} else {
		echo "Product not found.";
	}	
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | <?php echo $productName; ?></title>
	<meta name="keywords" content="HTML5 Template">
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
			<li><a href="#"><?php echo $productName; ?></a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<!-- mobile product slider  -->
		<div class="tt-mobile-product-layout visible-xs">
			<div class="tt-mobile-product-slider arrow-location-center" id="zoom-mobile__slider">
				<?php foreach ($thumbnails as $thumbnail): ?>				
				<div><img data-lazy="<?php echo $thumbnail; ?>" alt=""></div>
				<?php endforeach; ?>
			</div>
			<div id="zoom-mobile__layout">
				<a class="zoom-mobile__close btn" href="#">Back</a>
				<div id="tt-fotorama" data-nav="thumbs" data-auto="false" data-allowfullscreen="false" dataa-fit="cover" ></div>
			</div>
		</div>
		<!-- /mobile product slider  -->
		<div class="container container-fluid-mobile">
			<div class="row">
				<div class="col-12 col-lg-9">
					<div class="row custom-single-page">
						<div class="col-6 hidden-xs">
							<div class="tt-product-vertical-layout">
								<div class="tt-product-single-img">
									<div>
										<button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
										<img class="zoom-product" src='<?php echo $mainImage; ?>' data-zoom-image="<?php echo $mainImage; ?>" alt="">
									</div>
								</div>
								<div class="tt-product-single-carousel-vertical">
									<ul id="smallGallery" class="tt-slick-button-vertical  slick-animated-show-js">
										<li><a class="zoomGalleryActive" href="#" data-image="<?php echo $mainImage; ?>" data-zoom-image="<?php echo $mainImage ?>"><img src="<?php echo $mainImage; ?>" alt=""></a></li>
										<?php foreach ($thumbnails as $thumbnail): ?>
										<li>
										<a href="#" data-image="<?= $thumbnail ?>" data-zoom-image="<?= $thumbnail ?>">
											<img src="<?= $thumbnail ?>" alt="">
										</a>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="tt-product-single-info">
								<div class="tt-add-info">
									<ul>
										<li><span>Availability:</span> <?php echo $quantity; ?> in Stock</li>
									</ul>
								</div>
								<h1 class="tt-title"><?php echo $productName; ?></h1>
								<div class="tt-price">
									<span class="new-price"><span>&#163; </span><?php echo $price; ?></span>
								</div>
								<div class="tt-wrapper">
									<?php echo $shortDescription ?>									
								</div>
								<div class="tt-wrapper">
								<div class="tt-row-custom-01 tt-responsive-lg">
									<div class="col-item">
										<div class="tt-input-counter style-01">
											<span class="minus-btn"></span>
											<input type="text" value="1" id="quantityInput">
											<span class="plus-btn"></span>
										</div>
									</div>
									<div class="col-item">
										<a href="#" id="purchaseButton" class="btn btn-lg"><i class="icon-f-39"></i>PURCHASE</a>
									</div>
								</div>
								<div class="tt-wrapper">
									<div class="c-title-small" style="color: #2778fd; letter-spacing: 0.25em;">Purchase Total: <span id="totalPrice">£<?php echo $price; ?></span></div>
								</div>
								<script>
									document.addEventListener('DOMContentLoaded', function() {
										// Get references to elements
										var quantityInput = document.getElementById('quantityInput');
										var totalPriceElement = document.getElementById('totalPrice');
										var price = <?php echo $price; ?>; // Get the initial price from PHP
										var quantityLimit = <?php echo $quantity; ?>; // Get the maximum quantity limit from PHP

										var quantity = 1; // Initialize quantity

										// Function to update the total price
										function updateTotalPrice() {
											var totalPrice = quantity * price;
											totalPriceElement.textContent = '£' + totalPrice.toFixed(2);
										}

										// Add event listener to quantity input
										quantityInput.addEventListener('input', function() {
											var newQuantity = parseInt(quantityInput.value);

											if (isNaN(newQuantity) || newQuantity < 1) {
												quantity = 1;
											} else if (newQuantity > quantityLimit) {
												quantity = quantityLimit;
											} else {
												quantity = newQuantity;
											}

											quantityInput.value = quantity;
											updateTotalPrice();
										});

										// Add event listeners to minus and plus buttons
										document.querySelector('.minus-btn').addEventListener('click', function() {
											if (quantity > 1) {
												quantity--;
											} else {
												quantity = 1;
											}

											quantityInput.value = quantity;
											updateTotalPrice();
										});

										document.querySelector('.plus-btn').addEventListener('click', function() {
											if (quantity < quantityLimit) {
												quantity++;
											} else {
												quantity = quantityLimit;
											}

											quantityInput.value = quantity;
											updateTotalPrice();
										});

										// Add event listener to the purchase button
										var purchaseButton = document.getElementById('purchaseButton');
										purchaseButton.addEventListener('click', function(event) {
											event.preventDefault(); // Prevent the default form submission behavior

											// Assuming productLink is already defined
											var quantity = parseInt(document.getElementById('quantityInput').value);
											var totalPrice = quantity * price;

											// Redirect to handle_process.php file with productId, quantity, and totalPrice
											window.location.href = 'dbase/handle_process.php?product_id=<?php echo $productLink; ?>&quantity=' + quantity + '&total_price=' + totalPrice;
											});

										// Update total price on page load
										updateTotalPrice();
									});
								</script>
								</div>
								<div class="tt-wrapper">
									<div class="tt-add-info">
										<ul>
											<li><span>Vendor:</span> <?php echo $vendor; ?></li>
											<li><span>Posted:</span> <?php echo $daysAgo ?> day(s) ago.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container-indent">
						<div class="container">
							<div class="tt-collapse-block">
								<div class="tt-item">
									<div class="tt-collapse-title">DESCRIPTION</div>
									<div class="tt-collapse-content">
										<?php echo $description; ?>
									</div>
								</div>
								<div class="tt-item">
									<div class="tt-collapse-title">ADDITIONAL INFORMATION</div>
									<div class="tt-collapse-content">
										<table class="tt-table-03">
											<tbody>
												<tr>
													<td>Color:</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												</tr>
												<tr>
													<td>Size:</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												</tr>
												<tr>
													<td>Material:</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3">
					<div class="tt-product-single-aside">
						<div class="tt-services-aside">
							<h2 class="tt-title-small" style="margin-bottom: 20px; color: #2778fd;">
								MAKE AN ENQUIRY
							</h2>
							<div id="enquiryForm">						
								<div class="form-default">
									<form method="post" action="dbase/messenger.php">
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
										<!-- Add hidden fields to pass the values -->
										<input type="hidden" name="productId" value="<?php echo $productId; ?>">
										<input type="hidden" name="productLink" value="<?php echo $productLink; ?>">
										<input type="hidden" name="productName" value="<?php echo $productName; ?>">
										<input type="hidden" name="vendorEmail" value="<?php echo $vendorEmail; ?>">
										<input type="hidden" name="firstName" value="<?php echo $productBuyer; ?>">
										<!-- Rest form fields go here -->
										<div class="form-group">
											<label for="vendor" class="c-title-small">Vendor:</label>
											<input type="text" class="form-control" id="vendor" name="vendor" value="<?php echo $vendor; ?>" readonly>
										</div>
										<div class="form-group">
											<label for="userEmail" class="c-title-small">Your details:</label>
											<input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $email; ?>" readonly>
										</div>
										<div class="form-group">
											<label for="enquiry" class="c-title-small">Your Enquiry:</label>
											<textarea type="text" class="form-control" id="enquiry" name="enquiry" required></textarea>
										</div>
										<div class="form-group">
											<button class="btn btn-top btn-border" type="submit" name="sendmessage">Send Message</button>
										</div>
									</form>
								</div>
							</div>
							<div id=makeEnquiryBtn>
								<p class="tt-title">Please login to continue</p>
								<div style="margin-top: 20px;">
									<button id="enquiryBtn" class="btn btn-primary" style="color: #fff; text-transform: uppercase;">Make Enquiry</button>
								</div>
							</div>
							<script>
								document.addEventListener('DOMContentLoaded', function() {
									<?php
										if(isset($_SESSION['user_id'])) {
											echo "document.getElementById('enquiryForm').style.display = 'block';";
											echo "document.getElementById('makeEnquiryBtn').style.display = 'none';";
										} else {
											echo "document.getElementById('enquiryForm').style.display = 'none';";
											echo "document.getElementById('makeEnquiryBtn').style.display = 'block';";
										}
									?>
								});

								document.getElementById('enquiryBtn').addEventListener('click', function(event) {
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
<!-- modal (quickViewModal) -->
<div class="modal  fade"  id="ModalquickView" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
			</div>
			<div class="modal-body">
				<div class="tt-modal-quickview desctope">
					<div class="row">
						<div class="col-12 col-md-5 col-lg-6">
							<div class="tt-mobile-product-slider arrow-location-center">
								<div><img src="#" data-lazy="images/product/product-01.jpg" alt=""></div>
								<div><img src="#" data-lazy="images/product/product-01-02.jpg" alt=""></div>
								<div><img src="#" data-lazy="images/product/product-01-03.jpg" alt=""></div>
								<div><img src="#" data-lazy="images/product/product-01-04.jpg" alt=""></div>
								<!--
								//video insertion template
								<div>
									<div class="tt-video-block">
										<a href="#" class="link-video"></a>
										<video class="movie" src="video/video.mp4" poster="video/video_img.jpg"></video>
									</div>
								</div> -->
							</div>
						</div>
						<div class="col-12 col-md-7 col-lg-6">
							<div class="tt-product-single-info">
								<div class="tt-add-info">
									<ul>
										<li><span>Availability:</span> 40 in Stock</li>
									</ul>
								</div>
								<h2 class="tt-title">Cotton Blend Fleece Hoodie</h2>
								<div class="tt-price">
									<span class="new-price">$29</span>
									<span class="old-price"></span>
								</div>
								<div class="tt-wrapper">
									Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
								</div>
								<div class="tt-swatches-container">
									<div class="tt-wrapper">
										<div class="tt-title-options">SIZE</div>
										<form class="form-default">
											<div class="form-group">
												<select class="form-control">
													<option>21</option>
													<option>25</option>
													<option>36</option>
												</select>
											</div>
										</form>
									</div>
									<div class="tt-wrapper">
										<div class="tt-title-options">COLOR</div>
										<form class="form-default">
											<div class="form-group">
												<select class="form-control">
													<option>Red</option>
													<option>Green</option>
													<option>Brown</option>
												</select>
											</div>
										</form>
									</div>
									<div class="tt-wrapper">
										<div class="tt-title-options">TEXTURE:</div>
										<ul class="tt-options-swatch options-large">
											<li><a class="options-color" href="#">
												<span class="swatch-img">
													<img src="images/loader.svg" data-src="images/custom/texture-img-01.jpg" alt="">
												</span>
												<span class="swatch-label color-black"></span>
											</a></li>
											<li class="active"><a class="options-color" href="#">
												<span class="swatch-img">
													<img src="images/loader.svg" data-src="images/custom/texture-img-02.jpg" alt="">
												</span>
												<span class="swatch-label color-black"></span>
											</a></li>
											<li><a class="options-color" href="#">
												<span class="swatch-img">
													<img src="images/loader.svg" data-src="images/custom/texture-img-03.jpg" alt="">
												</span>
												<span class="swatch-label color-black"></span>
											</a></li>
											<li><a class="options-color" href="#">
												<span class="swatch-img">
													<img src="images/loader.svg" data-src="images/custom/texture-img-04.jpg" alt="">
												</span>
												<span class="swatch-label color-black"></span>
											</a></li>
											<li><a class="options-color" href="#">
												<span class="swatch-img">
													<img src="images/loader.svg" data-src="images/custom/texture-img-05.jpg" alt="">
												</span>
												<span class="swatch-label color-black"></span>
											</a></li>
										</ul>
									</div>
								</div>
								<div class="tt-wrapper">
									<div class="tt-row-custom-01">
										<div class="col-item">
											<div class="tt-input-counter style-01">
												<span class="minus-btn"></span>
												<input type="text" value="1" size="5">
												<span class="plus-btn"></span>
											</div>
										</div>
										<div class="col-item">
											<a href="#" id="purchaseButton" class="btn btn-lg"><i class="icon-f-39"></i>PURCHASE</a>
										</div>
									</div>
								</div>
							</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<script defer src="separate-include/single-product/single-product.js"></script>
</body>
</html>