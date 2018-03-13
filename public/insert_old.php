<?php

include_once('../private/initialise.php');

    require_login();

    $logged_in_user = $_SESSION['id'];

    global $db;



	$category= $_POST['categoryGroup']; 
	$type= $_POST['saleType']; 
	$product= $_POST['itemTitle']; 
	$desc= $_POST['itemDesc']; 
	$condition= $_POST['conditionGroup']; 
	$sprice= $_POST['startPrice']; 
	$rprice= $_POST['reservePrice']; 
	$bprice= $_POST['binPrice']; 
	$postage= $_POST['postagePrice']; 
	$return= $_POST['radio2']; 
	$sdate= $_POST['startDate']; 
	$edate= $_POST['endDate']; 
	$picture= $_POST['imageURL'];

    $sellerID = $_SESSION['sellerID'];


// $sqlseller = "SELECT sellerID FROM SellerDetails WHERE userID='" .  $logged_in_user . "'";
// $res= $db->query($sqlseller);
// while($line = $res->fetch_assoc()) {
//         $sellerID=$line["sellerID"];
//     }



$sql = "INSERT INTO Sale (sellerID) VALUES ($sellerID)";

if ($db->query($sql) === TRUE) {
    #echo "New record created successfully 1";
}

$sql2='SELECT max FROM maxsaleid';
$result= $db->query($sql2);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $saleID=$row["max"];
    }
    echo $saleID;
} else {
    #echo "sale ID failed";
}


if ($type === "Auction"){
	$auc=1;
	$bin=0;
	$sql3= "INSERT INTO Auction (saleID, startPrice, reservePrice) VALUES ('$saleID', '$sprice', '$rprice')";

    if ($db->query($sql3) === TRUE) {
    #echo "New record created successfully 2";
    }

    $sql4="SELECT categoryID FROM Category WHERE categoryHierarchy1='$category' ";
$result2= $db->query($sql4);

    if ($result2->num_rows > 0) {
        // output data of each row
        while($row2 = $result2->fetch_assoc()) { 
            $catID= $row2["categoryID"];
        }
        echo $catID;
    } else {
        #echo "cat ID failed";
    }


    $sql5= "INSERT INTO Product (categoryID, productName, productDescritpion) VALUES ('$catID', '$product', '$desc')";

    if ($db->query($sql5) === TRUE) {
        #echo "New record created successfully 3";
    }


    $sql6= "SELECT MAX(productID) AS max FROM Product ";
    $result3= $db->query($sql6);

    if ($result3->num_rows > 0) {
        // output data of each row
        while($row3 = $result3->fetch_assoc()) {
            $prodID= $row3["max"];
        }
        echo $prodID;
    } else {
        #echo "prod ID failed";
    }

    $sql7= "INSERT INTO itemForSale (saleID, productID, itemCondition, imageURL) VALUES ('$saleID', '$prodID', '$condition', '$picture')";

    if ($db->query($sql7) === TRUE) {
        #echo "New record created successfully 4";
    }

    $date = new DateTime($sdate);
    $startdate= $date->format('Y-m-d H:i:s');
    $startdate2= (string)$startdate;
    echo $startdate2;

    $date = new DateTime($edate);
    $enddate= $date->format('Y-m-d H:i:s');
    $enddate2= (string)$enddate;
    echo $enddate2;



    $sql8= "INSERT INTO SaleDescription (saleID, startDate, endDate, auction, buyItNow, postageCost,returnsAccepted) VALUES('$saleID','$startdate2','$enddate2','$auc','$bin','$postage', '$ret')";

    if ($db->query($sql8) === TRUE) {
        #echo "New record created successfully 5";
    }
    else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }



	
	
} 


if ($type === "BuyItNow"){
//else{
	$auc=0;
	$bin=1;
	$sql9= "INSERT INTO BuyItNow (saleID, buyItNowPrice) VALUES ('$saleID', '$bprice')";

    if ($db->query($sql9) === TRUE) {
    #echo "New record created successfully 2";
    }

    $sql10="SELECT categoryID FROM Category WHERE categoryHierarchy1='$category' ";
    $result10= $db->query($sql10);

    if ($result10->num_rows > 0) {
        // output data of each row
        while($row10 = $result10->fetch_assoc()) {
            $catID= $row10["categoryID"];
        }
        echo $catID;
    } else {
        echo "cat ID failed";
    }


    $sql11= "INSERT INTO Product (categoryID, productName, productDescritpion) VALUES ('$catID', '$product', '$desc')";

    if ($db->query($sql11) === TRUE) {
        #echo "New record created successfully 3";
    }


    $sql12= "SELECT MAX(productID) AS max FROM Product ";
    #$result3= $db->query($sql12);
    $result3 = mysqli_query($db, $sql12);

    $count = mysqli_num_rows($result3);

    if ($count > 0) {
        // output data of each row
        while($row12 = mysqli_fetch_assoc($result3)) {
            $prodID= $row12["max"];
        }
        echo $prodID;
    } else {
        #echo "prod ID failed";
    }

    $sql13= "INSERT INTO itemForSale (saleID, productID, itemCondition, imageURL) VALUES ('$saleID', '$prodID', '$condition', '$picture')";

    if ($db->query($sql13) === TRUE) {
        #echo "New record created successfully 4";
    }

    $date = new DateTime($sdate);
    $startdate= $date->format('Y-m-d H:i:s');
    $startdate2= (string)$startdate;
    echo $startdate2;

    $date = new DateTime($edate);
    $enddate= $date->format('Y-m-d H:i:s');
    $enddate2= (string)$enddate;
    echo $enddate2;



    $sql14= "INSERT INTO SaleDescription (saleID, startDate, endDate, auction, buyItNow, postageCost,returnsAccepted) VALUES('$saleID','$startdate2','$enddate2','$auc','$bin','$postage', '$ret')";

    if ($db->query($sql14) === TRUE) {
        #echo "New record created successfully 5";
    }
    else {
        echo "Error: " . $sql . "<br>" . $db->error;
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