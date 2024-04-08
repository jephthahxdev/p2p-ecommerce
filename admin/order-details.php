<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../dbase/db_conn.php');

$billingId = $_GET['order_id'];
$productLink = $_GET['product_link'];

$sqlBilling = "SELECT
    billing.id,
    billing.user_id,
    billing.email,
    billing.first_name,
    billing.last_name,
    billing.country,
    billing.state_province,
    billing.address,
    billing.city,
    billing.postcode,
    billing.phone,
    billing.product_url,
    billing.vendor, orders.vendor,
    billing.created_at
	FROM billing
    JOIN orders ON orders.order_id = billing.id
    WHERE billing.product_url = '$productLink' AND 
    billing.id = '$billingId'";

	$result = $conn->query($sqlBilling);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			// Display the billing details in HTML format
			$userId = $row['user_id'];
			$buyer = $row['first_name'] . ' ' . $row['last_name'];
			$phone = $row['phone'];
			$country = $row['country'];
			$state = $row['state_province'];
			$address = $row['address'];
			$city = $row['city'];
			$post_code = $row['postcode'];
			$date = $row['created_at'];
		}

        $sqlProductName = "SELECT product_name FROM products WHERE product_link = '$productLink'";
        $productNameResult = $conn->query($sqlProductName);

        if ($productNameResult && $productNameResult->num_rows > 0) {
            $productNameRow = $productNameResult->fetch_assoc();
            $productName = $productNameRow['product_name'];
        } else {
            $productName = "Product Name Not Found";
        }
	} else {
		echo "No billing details found.";
	}

// Close the database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Order Details</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/custom-min.js"></script>
</head>
<body>
<header class="headertype3 headertype3-bottom" id="tt-header">
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
	<div class="tt-desktop-header">
		<div class="container">
			<div class="tt-header-holder">
				<div class="tt-obj-logo">
					<!-- logo -->
					<a class="tt-logo tt-logo-alignment" href="../index.php"><img src="../images/custom/logo.png" alt=""></a>
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
												<img src="../images/icon-svg/dashboard.svg"/>

											<span>Dashboard</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="users.php">
											<img src="../images/icon-svg/users-svgrepo-com.svg"/>

											<span>Users</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="products.php">
											<img src="../images/icon-svg/product.svg"/>

											<span>Products</span>
										</a>
									</li>
									<li class="tt-submenu">
										<a href="orders.php">
											<img src="../images/icon-svg/orders.svg"/>

											<span>Orders</span>
										</a>
									</li>																		
									<li class="tt-submenu">
										<a href="logout.php">
											<img src="../images/icon-svg/logout.svg"/>
												
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
						<h2 class="tt-title" style="text-transform: uppercase;">
							<?php echo 'BILLING DETAILS: ' . '<span style="text-decoration: underline; color:#2879fe;">' . '#' . $billingId . ';' . '</span>' . ' ' . $productName; ?>
						</h2>
					</div>				
					<div class="container-custom">
						<div class="tt-btn-img-list">
							<div class="row">
								<div class="col-12">
									<div href="#" class="reply-box">										
										<div class="fun-content">
											<form class="form-default">
												<div class="form-group">
													<label for="address_country">BUYER NAME</label>
													<input type="text" class="form-control" value="<?php echo $buyer; ?>" readonly>
												</div>
												<div class="form-group">
													<label for="shopPhone" class="control-label">PHONE NUMBER</label>
													<input type="text" class="form-control" value="<?php echo $phone; ?>" readonly>
												</div>
												<div class="form-group">
													<label for="address_province">STATE/PROVINCE</label>
													<input type="text" class="form-control" value="<?php echo $state; ?>" readonly>										
												</div>
												<div class="form-group">
													<label for="shopAddress" class="control-label">ADDRESS</label>
													<input type="text" class="form-control" value="<?php echo $address; ?>" readonly>
												</div>
												<div class="form-group">
													<label for="shopTown" class="control-label">TOWN / CITY</label>
													<input type="text" class="form-control" value="<?php echo $city; ?>" readonly>
												</div>							
												<div class="form-group">
													<label for="shopPostCode" class="control-label">POSTCODE / ZIP *</label>
													<input type="text" class="form-control" value="<?php echo $post_code; ?>" readonly>
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