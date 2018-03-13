<?php

include_once('../private/initialise.php');

    require_login();

    $logged_in_user = $_SESSION['id'];

    global $db;


    $listing = [];

	$listing['categoryHierarchy1'] = $_POST['categoryGroup'];
    $listing['productName'] = $_POST['itemTitle'];
    $listing['productDescription'] = $_POST['itemDesc'];
    $listing['userID'] = $_SESSION['id'];  
    $listing['startDate'] = $_POST['startDate']; 
    $listing['endDate'] = $_POST['endDate'];   
    $listing['postageCost'] = $_POST['postagePrice'];    
    $listing['returnsAccepted'] = $_POST['radio2']; 
    $listing['startPrice'] = $_POST['startPrice'] ?? NULL; 
    $listing['reservePrice'] = $_POST['reservePrice'] ?? NULL; 
    $listing['buyItNowPrice'] = $_POST['binPrice'] ?? NULL;     
    $listing['itemCondititon'] = $_POST['conditionGroup']; 
    $listing['imageURL'] = $_POST['imageURL'];	

    $listing['saleType'] = $_POST['saleType']; 

    $sellerID = $_SESSION['sellerID'];

if ($listing['saleType'] === "Auction") {


    $success = insert_auction($listing);

    if ($success) {
        echo "<script> alert('Your listing has been added.');</script>";
    } else {
        echo "<script> alert('Something went wrong.');</script>";
    }
	
} 


if ($listing['saleType'] === "BuyItNow"){

    $success = insert_buyitnow($listing);

    if ($success) {
        echo "<script> alert('Your buy it now listing has been added.');</script>";
    } else {
        echo "<script> alert('Something went wrong.');</script>";
    }


}

		
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <title>Sale Listing Page</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

   
    <!-- Just for debugging purposes. -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- include pace script for automatic web page progress bar  -->
    <script>
        paceOptions = {
            elements: true
        };
    </script>
    <script src="assets/js/pace.min.js"></script>



    
</head>
<body>
<div id="wrapper">

    <!-- header -->
        <?php include('customerHeader.php'); ?>
    <!-- /.header -->

    <div class="main-container">
        <div class="container">
            <div class="row">

            <!-- page-sidebar -->
                <?php include('userSidePanel.php'); ?>
            <!--/.page-sidebar-->


                <div class="col-md-9 page-content">
                    <div class="inner-box category-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="alert alert-success pgray  alert-lg" role="alert">
                                    <h2 class="no-margin no-padding">&#10004; Congratulations! Your item has been listed. </h2>

                                    <p> View your listings page to follow the sale. Bid alerts will also be sent by email. Go to your account to opt out
                                        of email alerts. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.page-content -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
    </div>
    <!-- /.main-container -->
    
</div>
<!-- /.wrapper -->




<!-- Le javascript
================================================== -->

<!-- Placed at the end of the document so the pages load faster -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/vendors.min.js"></script>

<!-- include custom script for site  -->
<script src="assets/js/script.js"></script>


<!-- include jquery file upload plugin  -->
<script src="assets/js/fileinput.min.js" type="text/javascript"></script>
<script>
    // initialize with defaults
    $("#input-upload-img1").fileinput();
    $("#input-upload-img2").fileinput();
    $("#input-upload-img3").fileinput();
    $("#input-upload-img4").fileinput();
    $("#input-upload-img5").fileinput();


</script>

</body>
</html>