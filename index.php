<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require('dbase/db_conn.php');

// Getting active products to display as now selling
$sql = "SELECT products.id, products.first_name, products.product_name, products.product_link, products.price, products.status, products.date_uploaded, CONCAT('MarionPeer/', images.image_url) AS image_url
        FROM products
        INNER JOIN images ON products.id = images.product_id
        WHERE products.status = 'active'
        GROUP BY products.id
		ORDER BY products.date_uploaded DESC";

$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    $products = array();

    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = array();
}

//Getting inactive products to display as best buys
$sqlInactive = "SELECT products.id, products.first_name, products.product_name, products.product_link, products.price, products.status, products.date_uploaded, CONCAT('MarionPeer/', images.image_url) AS image_url
        FROM products
        INNER JOIN images ON products.id = images.product_id
        WHERE products.status = 'sold'
        GROUP BY products.id
		ORDER BY products.date_uploaded DESC";

$result = $conn->query($sqlInactive);

if ($result !== false && $result->num_rows > 0) {
    $purchasedProducts = array();

    while($row = $result->fetch_assoc()) {
        $purchasedProducts[] = $row;
    }
} else {
    $purchasedProducts = array();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Home</title>
	<link rel="shortcut icon" href="#">
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
				<div class="tt-stuck-mobile-menu-categories"></div>
				<div class="tt-stuck-parent-search tt-parent-box"></div>
				<div class="tt-stuck-parent-cart tt-parent-box"></div>
				<div class="tt-stuck-parent-account tt-parent-box"></div>
				<div class="tt-stuck-parent-multi tt-parent-box"></div>
			</div>
		</div>
	</div>
</header>
<div id="tt-pageContent">
	<div class="container-indent0">
		<div class="container">
			<div class="row flex-sm-row-reverse tt-layout-promo-box">
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-sm-6">
							<a href="#on-sale" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/CustomerService_Brand.jpg" alt="">
								<div class="tt-description">
									<div class="tt-description-wrapper">
										<div class="tt-background"></div>
										<div class="tt-title-small">BUY</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-sm-6">
							<a href="#best-buys" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/colorful-student-desk-f46jhz47hwtqo7rk.jpg" alt="">
								<div class="tt-description">
									<div class="tt-description-wrapper">
										<div class="tt-background"></div>
										<div class="tt-title-small">SELL</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-sm-12">
							<a href="#" class="tt-promo-box tt-one-child">
								<img src="images/loader.svg" data-src="images/promo/160719_col_texasam_011.jpg" alt="">
								<div class="tt-description">
									<div class="tt-description-wrapper">
										<div class="tt-background"></div>
										<div class="tt-title-small">ONLY AT</div>
										<div class="tt-title-large">ROBERT GORDON UNIVERSITY</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<a href="#" class="tt-promo-box">
						<img src="images/loader.svg" data-src="images/promo/02ff1f70-e5bb-11e9-bfdb-cd062f61cb1e-scaled.jpg" alt="">
						<div class="tt-description">
							<div class="tt-description-wrapper">
								<div class="tt-background"></div>
								<div class="tt-title-small">WELCOME TO</div>
								<div class="tt-title-large">MARIONPEER</div>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container-indent1" id="on-sale">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-block-title text-left">
				<h2 class="tt-title">ON SALE</h2>
			</div>
			<div class="tt-tab-wrapper tt-ajax-tabs">
				<ul class="nav nav-tabs tt-tabs-default" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="">NEW ARRIVALS</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tt-tab01-01">
						<div class="tt-carousel-products row arrow-location-tab tt-alignment-img tt-layout-product-item slick-animated-show-js">
							<?php foreach ($products as $product): ?>
								<div class="col-2 col-md-4 col-lg-3">								
									<div class="tt-product thumbprod-center">
										<div class="tt-image-box">
											<a href="product-details.php?id=<?php echo $product['product_link']; ?>">
												<span class="tt-img"><img src="<?php echo $product['image_url']; ?>" alt="Product Image"></span>
												<span class="tt-img-roll-over"><img src="<?php echo $product['image_url']; ?>" data-lazy="<?php echo $product['image_url']; ?>"></span>
											</a>
										</div>
										<div class="tt-description">
											<div class="tt-row">
												<ul class="tt-add-info">
													<li><a style="text-transform: uppercase;">VENDOR: <?php echo $product['first_name']; ?></a></li>
												</ul>
											</div>
											<h2 class="tt-title" style="text-transform: uppercase;"><a><?php echo $product['product_name']; ?></a></h2>
											<div class="tt-price">
												<span>&#163;</span><?php echo $product['price']; ?>
											</div>
											<div class="tt-product-inside-hover">
												<div class="tt-row-btn">
													<a class="tt-btn-addtocart thumbprod-button-bg" href="product-details.php?id=<?php echo $product['product_link']; ?>">VIEW</a>
												</div>											
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>							
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<div class="container-indent1" id="best-buys">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-block-title text-left">
				<h2 class="tt-title">BEST BUYS</h2>
			</div>
			<div class="tt-tab-wrapper tt-ajax-tabs">
				<ul class="nav nav-tabs tt-tabs-default" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tt-tab01-01">SOLD OUT ITEMS</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tt-tab01-01">
						<div class="tt-carousel-products row arrow-location-tab tt-alignment-img tt-layout-product-item slick-animated-show-js">
							<?php foreach ($purchasedProducts as $purchasedProduct): ?>
								<div class="col-2 col-md-4 col-lg-3">
									<div class="tt-product thumbprod-center">
										<div class="tt-image-box">
											<a href="product-details.php?id=<?php echo $purchasedProduct['product_link']; ?>">
												<span class="tt-img"><img src="<?php echo $purchasedProduct['image_url']; ?>" alt="Product Image"></span>
												<span class="tt-img-roll-over"><img src="<?php echo $purchasedProduct['image_url']; ?>" data-lazy="<?php echo $purchasedProduct['image_url']; ?>"></span>
											</a>
										</div>
										<div class="tt-description">
											<div class="tt-row">
												<ul class="tt-add-info">
													<li><a style="text-transform: uppercase;">VENDOR: <?php echo $purchasedProduct['first_name']; ?></a></li>
												</ul>
											</div>
											<h2 class="tt-title" style="text-transform: uppercase;"><a><?php echo $purchasedProduct['product_name']; ?></a></h2>
											<div class="tt-price">
												<span>&#163;</span><?php echo $product['price']; ?>
											</div>
											<div class="tt-product-inside-hover">
												<div class="tt-row-btn">
													<a class="tt-btn-addtocart thumbprod-button-bg" href="product-details.php?id=<?php echo $purchasedProduct['product_link']; ?>">VIEW</a>
												</div>											
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-custom"></div>
<footer class="nomargin" id="tt-footer">
	<div class="tt-footer-col tt-color-scheme-01">
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