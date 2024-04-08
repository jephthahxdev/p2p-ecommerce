<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require('dbase/db_conn.php');

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Update is_opened to 1 for the clicked productId
    $updateSql = "UPDATE messages SET is_opened = 1 WHERE productId = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('s', $productId);
    $stmt->execute();
    $stmt->close();
}

// Retrieve message ID from the URL
$messageID = $_GET['id']; // Assuming id is used to identify conversations

// Getting user session
$email = $_SESSION['email'];

if (!empty($messageID)) {
    // Retrieve messages for the specified ID
    $sqlMessage = "SELECT
	messages.userId,
	messages.productId,
	messages.productName,
	messages.userEmail,
	messages.vendor,
	messages.vendorEmail,
	messages.firstName,
	messages.lastName,
	messages.enquiry,
	messages.attachment_url,
	messages.is_opened,
	messages.timestamp
    FROM messages
    WHERE messages.productId = '$messageID'
    AND (messages.userId = {$_SESSION['user_id']} OR messages.vendorEmail = '{$_SESSION['email']}')
    ORDER BY timestamp ASC";

    $resultMessage = $conn->query($sqlMessage);

    if ($resultMessage === false) {
        die("Error executing query: " . $conn->error);
    }

    // Fetch the messages and store them in an array
    $messages = [];
    while ($message = $resultMessage->fetch_assoc()) {
        $messages[] = $message;
    }
    
    // Retrieve the first message in the conversation
    $sqlFirstMessage = "SELECT
	messages.userId,
	messages.productId,
	messages.productName,
	messages.userEmail,
	messages.vendor,
	messages.vendorEmail,
	messages.firstName,
	messages.lastName,
	messages.enquiry,
	messages.attachment_url,
	messages.is_opened,
	messages.timestamp 
    FROM messages
    WHERE messages.productId = '$messageID'
    AND (messages.userId = {$_SESSION['user_id']} OR messages.vendorEmail = '{$_SESSION['email']}')
    ORDER BY timestamp ASC
    LIMIT 1";

    $resultFirstMessage = $conn->query($sqlFirstMessage);
    $firstMessage = $resultFirstMessage->fetch_assoc();

	$productId = $firstMessage['productId'];
	$userEmail = $firstMessage['userEmail'];
	$firstName = $firstMessage['firstName'];
	$productName = $firstMessage['productName'];

} else {
    echo "Cannot load conversation. Err: Invalid Message ID";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MarionPeer | Messages</title>
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
							<?php
								// Display the Sender
								if ($firstMessage) {
									echo 'PRODUCT ENQUIRY: ' . $firstMessage['productName'];
								}
							?>							
						</h2>
					</div>				
					<div class="container-custom">
						<div class="tt-btn-img-list">
							<div class="row">
								<div class="col-12">
									<div href="#" class="fun-fact-box">											
										<div class="col-8">
											<div class="fun-content">
												<?php
													// Display the Sender
													if ($firstMessage) {
														echo '<div class="c-title-small">FROM: ' . $firstMessage['firstName'] . ' ' . $firstMessage['lastName'] . '<br>';
														echo '<div class="tt-title"> Sent: ' . $firstMessage['timestamp'] . '<br>';
														echo '</div>';
													}
												?>												
											</div>
										</div>
									</div>										
										<div class="col-4">											
											<?php
											// Display sender address
												if ($firstMessage) {
													echo '<div class="c-title-small" style="text-transform: none;"> EMAIL: ' . $firstMessage['userEmail'];
													echo '</div>';
												}
											?>													
										</div>										
									</div>
								</div>
							</div>
						</div>
					</div>	
					<div class="container-custom">
						<div href="#" class="reply-box">
							<div class="fun-content">											
								<div class="col-12">
									<?php
									//Display sender message
									if($firstMessage){
										echo '<div class="tt-title" style="margin-top: 20px;">';
										echo 'Message: ' . $firstMessage['enquiry'] . '<br>';
										echo '</div>' . '<br>';										
									}
									// Checking for conversations
									if (!empty($messages)) {
										$firstMessage = true; // Adding flag to identify the first message

										// Using the foreach loop to display subsequent messages
										foreach ($messages as $message) {
											if ($firstMessage) {
												$firstMessage = false;
												continue; // Skip the first iteration
											}
											echo '<div class="c-title-reply">';
											
											if ($message['userEmail'] == $_SESSION['email']) {
												// If the logged-in user is the sender
												echo 'You: ' . $_SESSION['email'] . '<br>';
												echo 'Date: ' . $message['timestamp'] . '<br>';
												echo 'Reply: ' . $message['enquiry'] . '<br>';
												
											} else {
												// If the logged-in user is the recipient
												echo 'Sender Address: ' . $message['userEmail'] . '<br>';
												echo 'Date: ' . $message['timestamp'] . '<br>';
												echo 'Message: ' . $message['enquiry'] . '<br>';
												echo 'Attachments: ' . $message['attachment_url'] . '<br>';
											}

												echo 'Attachments:' . '<br>';

												// Check if attachment URLs are available
												if (!empty($message['attachment_url'])) {
													// Fetch image URLs from the message in the conversation
													$ImageURLs = explode(',', $message['attachment_url']);

													// Display attached images if there are any
													foreach ($ImageURLs as $imageUrl){
														$imageUrl = 'MarionPeer/' . $imageUrl; 
														?>
														<img class="reply-img" src="<?php echo $imageUrl;?>" alt="Attached Image">
														<?php
													}
												} else {
													echo ' ' . ' No image attachments';
												}											
											echo '</div><br><br>';
										}																			
									} else {
										echo "No messages found.";
									}
									?>														
									<div class="container-custom">																																
										<button class="btn btn-top btn-border" id="replyButton">REPLY</button>																																	
										<div id="reply" style="display: none;">
											<div class="container-custom">
												<div class="form-default">
													<form method="post" action="dbase/responder.php" id="" enctype="multipart/form-data">
														<?php
															if(isset($_SESSION['reply_error'])) {
																echo '<div class="alert alert-danger" id="responseMessage">'.$_SESSION['reply_error'].'</div>';
																unset($_SESSION['reply_error']); // Clear the session variable after displaying the error
															}
					
															if(isset($_SESSION['reply_success'])) {
																echo '<div class="alert alert-success" id="responseMessage">'.$_SESSION['reply_success'].'</div>';
																unset($_SESSION['reply_success']); // Clear the session variable after displaying the success message
															}
														?>
														<script>
															document.addEventListener('DOMContentLoaded', function() {
																var replyButton = document.getElementById('replyButton');
																var replyForm = document.getElementById('reply');
																var responseMessage = document.getElementById('responseMessage');

																replyButton.addEventListener('click', function() {
																	replyForm.style.display = (replyForm.style.display === 'none') ? 'block' : 'none';
																	replyButton.style.display = 'none'; // Hide the button when form is shown
																});

																if (responseMessage) {
																	setTimeout(function() {
																		responseMessage.style.transition = "opacity 0.5s";
																		responseMessage.style.opacity = "0";
																	}, 3000);

																	setTimeout(function() {
																		responseMessage.style.display = "none";
																		replyForm.style.display = "none"; // Hide the form after response is displayed
																	}, 3500);
																}
															});
														</script>
														<input type="hidden" name="productId" value="<?php echo $productId; ?>">
														<input type="hidden" name="userEmail" value="<?php echo $userEmail; ?>">
														<input type="hidden" name="productName" value="<?php echo $productName; ?>">
														<input type="hidden" name="firstName" value="<?php echo $firstName; ?>">
														<input type="hidden" name="isOpened" value="1">
														<div class="form-group">
															<textarea id="description" class="form-control" name="body" rows="4" cols="50" required></textarea>
														</div>																	
														<div class="form-group">
															<label for="images" class="custom-upload">
																<span class="upload-caption">Click to upload images (if exists)</span>
																<input type="file" id="images" name="images[]" accept="image/*" multiple>
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

																			// Create a link for downloading the image
																			const link = document.createElement('a');
																			link.href = reader.result;
																			link.download = file.name; // Set the filename for downloading
																			link.appendChild(img);

																			previewDiv.appendChild(link);
																		}

																		reader.readAsDataURL(file);
																	}
																});
																</script>
															</div>
														</div>
														<div class="form-group">
															<button class="btn btn-top btn-border" type="submit" name="reply">Submit</button>
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