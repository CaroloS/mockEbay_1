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
    <title>Item Page</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        #auction-info {
            font-size: 17px;
            margin-bottom: 12px;
        }
        #auction-php {
            margin-left: 10px;
            margin-bottom: 12px;
        }
    </style>

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



<?php
date_default_timezone_set("Europe/London");  //need to set the timezone to London 
$message = '';
      $db = new MySQLi('localhost', 'caroline', 'ebay123', 'MockEbay');
      if ($db->connect_error) {
          $message = $db->connect_error;
      } else {
          $message = 'Connection is OK';
      }
echo $message;
  //connect to the database
$auctionEnded = false;     //boolean to set to true when auction end date has passed
//NEED TO GRAB THE SALE ID WHEN IT IS POSTED THROUGH
/*if(isset($_GET['saleID'])){
    $saleID=$_GET['saleID'];
} */
$userID=3;

if (isset($_GET['saleID'])) {
$saleID= $_GET['saleID'];
} else{ $saleID=1005;}

// else{
// $saleID = 1009;
// }
//GETTING THE INFO/USERID OF THE SELLER OF THIS ITEM
$query_sellerDetails = "SELECT Users.userID, firstName, lastName, SellerDetails.sellerID, saleID
                        FROM Users 
                        JOIN SellerDetails 
                            ON Users.userID = SellerDetails.userID
                        JOIN Sale
                            ON SellerDetails.sellerID = Sale.sellerID
                        WHERE saleID = '$saleID';";
$result_sellerDetails = mysqli_query($db, $query_sellerDetails);
$row8 = mysqli_fetch_array($result_sellerDetails);
//NB - NEED TO GET THE SESSION VARIABLES OF LOGGED IN USER

$loggedInProfile = "Customer";
$logged_in_user=3;

// We need to actually get this data 


//FETCHING THE BUYER ID OF THE LOGGED IN USER
$query_buyer = "SELECT buyerID FROM BuyerDetails WHERE userID = $logged_in_user LIMIT 1";
$result_buyer = mysqli_query($db, $query_buyer)
    or die('Error making select users query' . mysql_error());
$row5 = mysqli_fetch_array($result_buyer);
$buyerID= $row5['buyerID'];

//UPDATING THE VIEWING TABLE - INCREMENT THE VIEWING FOR THIS ITEM BY 1
$query_viewings = "UPDATE saleDescription SET viewing=viewing + 1 WHERE saleID=$saleID";
$result_viewings = mysqli_query($db, $query_viewings);

//GETTING ALL THE DETAILS FOR THE ITEM ON THIS PAGE FOR DISPLAY
$query_itemDetails = "SELECT * FROM maintable WHERE saleID=$saleID";
$result_itemDetails = mysqli_query($db, $query_itemDetails);
$row1 = mysqli_fetch_array($result_itemDetails);

//GETTING THE NUMBER OF PAGE VIEWS FOR THIS ITEM
$query_getviewing = "SELECT viewing FROM saleDescription WHERE saleID=$saleID";
$result_getviewing = mysqli_query($db, $query_getviewing);
$row2 = mysqli_fetch_array($result_getviewing);

//GETTING ALL THE BIDS ON THIS ITEM 
$query_allBids = "SELECT * FROM allbids WHERE saleID=$saleID";
$result_allBids = mysqli_query($db, $query_allBids);
$row3 = mysqli_fetch_array($result_allBids);

//GETTING THE USER DETAILS FOR THE PEOPLE WHO HAVE BID ON THIS SALE
$query_bidName = "SELECT * FROM allbiddata WHERE saleID=$saleID ORDER BY bidValue DESC";
$result_bidName = mysqli_query($db, $query_bidName);
$row4 = mysqli_fetch_array($result_bidName);
if ($row4) {
    $highestBidderUserID = $row4['userID'];
}

//GETTING THE EMAIL INFO FOR ALL PEOPLE WATCHING/BUYING SALE
$query_noDupeEmails = "SELECT * FROM nodupesemails WHERE saleID=$saleID";
$result_noDupeEmails = mysqli_query($db, $query_noDupeEmails);

/////CHECKING IF AUCTION HAS ENDED//////
$auction_endDate = date('Y-m-d h:i:sa', strtotime($row1['endDate']));
$now = date('Y-m-d h:i:sa');
if ($auction_endDate < $now) {
    $auctionEnded = true;
}
if ($auctionEnded) {
    //CHECKING IF THERE IS ALREADY AN ENTRY IN THE PURCHASE TABLE FOR THIS SALE
    $query_purchase = "SELECT * FROM Purchase WHERE saleID=$saleID";
    $result_purchase = mysqli_query($db, $query_purchase);
    $row6 = mysqli_fetch_array($result_purchase);
    
    //IF THERE ISN'T AN ENTRY IN THE PURCHASE TABLE - ENTER ONE IF THERE IS A BID
    //AND SEND ALL THE EMAILS TO SELLER/BIDDERS/WATCHERS TO NOTIFY OF AUCTION END/OUTCOME
    if (!$row6) {
        if ($row3) {   //if there are bids on the item
            
            $query_insertPurchase = "INSERT INTO Purchase ( saleID, buyerID, salePrice, sellerRated, buyerRated ) VALUES ( $saleID, $row4[buyerID], $row4[bidValue], FALSE, FALSE );";
            $result_insertPurchase = mysqli_query($db, $query_insertPurchase);
            
            //send emails out to highest bidder, seller, all other bidders and watchlisters 
            while($row7 = mysqli_fetch_array($result_noDupeEmails)) {   
                if ($row7['userID'] == $row8['userID'] ) {   
                    $msg = "Congratulations, your ".$row1['productName']." has sold! Buyer: ".$row4['firstName']." ".$row4['lastName']." Winning Bid: £".$row4['bidValue'];  //email to the seller
                }
                else if ($row7['userID'] == $highestBidderUserID ) {
                    $msg = "Congratulations, you won the auction for: ".$row1['productName']."! Your Winning Bid: £".$row4['bidValue']." Go to your account to pay.";  //email to the highest bidder
                }
                else {
                    $msg = "The auction for ".$row1['productName']." has now ended. Winning Bid was: ".$row4['bidValue']." We are selling similar items on edatabay, search now!";  //email to everyone else watching/bidding
                }
                // use wordwrap() if lines are longer than 70 characters
                $msg = wordwrap($msg,70);
                // send email
                mail($row7['emailAddress'],"Auction Ended",$msg);
            }
            $query_emailsSent = "UPDATE Auction SET finalEmailsSent = TRUE WHERE saleID = $saleID;";
            $result_emailsSent = mysqli_query($db, $query_emailsSent);
        }
        else {   //if there are no bids on the item
            $query_checkEmailsSent = "SELECT finalEmailsSent FROM Auction WHERE saleID = $saleID;";
            $result_checkEmailsSent = mysqli_query($db, $query_checkEmailsSent);
            $row9 = mysqli_fetch_array($result_checkEmailsSent);
            //If final emails sent ISN'T true: 
            if (!$row9['finalEmailsSent']) {
                while($row7 = mysqli_fetch_array($result_noDupeEmails)) {  
                    if ($row7['userID'] == $row8['userID'] ) {   
                        $msg = "We're sorry your ".$row1['productName']." didn't sell this time. Relist it again now. ";  //email to the seller
                    }
                    else {
                        $msg = "The auction for ".$row1['productName']." has now ended without any bids. We are selling similar items on edatabay, search now!";  //email to everyone else watching/bidding
                    }
                    // use wordwrap() if lines are longer than 70 characters
                    $msg = wordwrap($msg,70);
                    // send email
                    mail($row7['emailAddress'],"Auction Ended",$msg);
                }
            $query_emailsSent = "UPDATE Auction SET finalEmailsSent = TRUE WHERE saleID = $saleID;";
            $result_emailsSent = mysqli_query($db, $query_emailsSent);
            }
            
        }
    }   
}



$sql="SELECT imageURL, productName, saleID FROM watchedsalesdata WHERE saleID <> '$saleID' AND buyerID IN 
    (SELECT buyerID FROM watchedsalesdata WHERE saleID='$saleID'AND buyerID <> '$buyerID') ";
$result= $db->query($sql);



$sqlbuyer="SELECT buyerID from BuyerDetails WHERE userID='$userID'";
$result_buyer= $db->query($sqlbuyer);
while($row_buyer = $result_buyer-> fetch_assoc()){
        $buyerID=$row_buyer["buyerID"];
    }


$sqlauc="SELECT auctionID from Auction WHERE saleID='$saleID'";
$result_auc= $db->query($sqlauc);
while($row_auc = $result_auc-> fetch_assoc()){
        $auctionID=$row_auc["auctionID"];
}

$sqlbid="SELECT * from maintable WHERE saleID='$saleID'";
$result_bid= $db->query($sqlbid);
while($row_bid = $result_bid-> fetch_assoc()){
        $highBid=$row_bid["maxbid"];
        $saleName=$row_bid["productName"];
    }


if (isset($_POST['bid']))
{
$bid = $_POST['bid'];

    if ($bid> $highBid){

        $sql_add_bid= "INSERT INTO Bids (auctionID, buyerID, bidValue) VALUES ('$auctionID', '$buyerID', '$bid')";
        if ($db->query($sql_add_bid) === TRUE) {
        echo "<script>
        alert('Your bid has been added.');
        </script>";



        $sql_bid_mail= "SELECT * FROM nodupesemails WHERE saleID='$saleID'";
        $result_bid_mail= $db->query($sql_bid_mail);
        while($row_bid_mail = $result_bid_mail-> fetch_assoc()){

        $bidmessage= $row_bid_mail["firstName"] ." " .$row_bid_mail["lastName"]. ", \nA bid of ". $bid." pounds has been made on the product: ". $saleName;
         $subject= "Bid on ". $saleName;
         $email= $row_bid_mail["emailAddress"];
        mail($email,$subject,$bidmessage);
            
        
        }


        }
        
        else{
            echo "<script>
        alert('didnt work.');
        </script>";

        }

    }   
        else{
        echo "<script>
        alert('Bid must be higher than current highest bid.');
        </script>";
    }

}


//GETTING THE USER DETAILS FOR THE PEOPLE WHO HAVE BID ON THIS SALE
$query_bidName = "SELECT * FROM allbiddata WHERE saleID=$saleID ORDER BY bidValue DESC";
$result_bidName = mysqli_query($db, $query_bidName);
$row4 = mysqli_fetch_array($result_bidName);
if ($row4) {
    $highestBidderUserID = $row4['userID'];
}



if (isset($_POST['Watchlist']))
{
$wl=$_POST['Watchlist'];

if($wl==="WL"){

    $sqlWL = "SELECT * FROM watchedsalesdata WHERE saleID=$saleID";
    $result_WL = mysqli_query($db, $sqlWL);
    $rowWL = mysqli_fetch_array($result_WL);


        if ($rowWL['auctionID'] != NULL){
        

        $aucID=$rowWL['auctionID'];
       

        $sql_WL_auc= "INSERT INTO Watchlist ( buyerID, buyItNowID, auctionID) VALUES ('$buyerID', NULL, '$aucID')";
        if ($db->query($sql_WL_auc) === TRUE) {
        echo "<script>
         alert('Item has been added to your watch list.');
         </script>";
            }
        }


        elseif ($rowWL['buyItNowID'] != NULL){
            

        $binID=$rowWL['buyItNowID'];
        

        $sql_WL_bin= "INSERT INTO Watchlist ( buyerID, buyItNowID, auctionID) VALUES ('$buyerID', '$binID', NULL)";
        if ($db->query($sql_WL_bin) === TRUE) {
         echo "<script>
        alert('Item has been added to your watch list.');
        </script>"; 
            }   
        }
}
}

?>

<!-- IF LOGGED IN USER IS CUSTOMER THIS HEADER - ELSE INCLUDE ADMIN HEADER    -->

        <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
                 role="navigation">
                <div class="container">

                <div class="navbar-identity">

                    <a href="categoryCustomer.php" class="navbar-brand logo logo-title">
                    <img src="images/edatabay.png" alt="Available on the App Store">
                    </a>

                </div>

                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav ml-auto navbar-right">
                            <li class="nav-item"><a href="categoryCustomer.php" class="nav-link"><i class="icon-th-thumb"></i> Browse Items</a>
                            </li>
                            <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                                <span>User</span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
                                <ul class="dropdown-menu user-menu dropdown-menu-right">
                                    <li class="active dropdown-item"><a href="personalpage.html"><i class="icon-home"></i> Personal Home
                                    </a>
                                    </li>
                                    <li class="dropdown-item"><a href="my-listings.php"><i class="icon-th-thumb"></i> My Listings </a>
                                    </li>
                                    <li class="dropdown-item"><a href="watchlist.php"><i class="icon-heart"></i> Watchlist </a>
                                    </li>
                                    <li class="dropdown-item"><a href="bids-purchases.php"><i class="icon-hourglass"></i> Bids / Purchases
                                    </a>
                                    </li>

                                    <li class="dropdown-item"><a href="index.php"><i class=" icon-logout "></i> Log out </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-danger nav-link" href="list-items.php">List An Item</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
        <!-- /.header -->
        <!-- /.header -->



<div class="main-container">

<?php if ($auctionEnded) { ?>
    <div >
        <h1 style=" margin-left: 500px;" >This Auction has ended! </h2>
    </div> 
<?php } ?>

    <div   class="container">
        <div  class="row">

            <div  class="col-md-12">
                <div class="pull-left backtolist"><a href="mock-ebay/sub-category-sub-location.html"> <i
                        class="fa fa-angle-double-left"></i> Back to Results</a></div>
            </div>
        </div>
    </div>
   
   
    <div  <?php if($auctionEnded) { ?> style=" opacity: 0.3;"  <?php } ?>    class="container">

        <div class="row">
            <div class="col-md-9 page-content col-thin-right">
                <div class="inner inner-box ads-details-wrapper">
                    <h1 class="auto-heading" ><span class="auto-title left"> <?php echo $row1['productName'] ?></span> </h1>
                                
                    <div style="clear:both;"></div>








                    <div class="row ">
                        <div class="col-sm-12 automobile-left-col">

                            <div style="margin-left: 200px; " class="ads-image">
                                    <img style="height: 300px; width: auto;" src="images/<?php echo $row1['imageURL']; ?>"
                                    style="width: 300px;"/>
                            </div>
                            <!--item-image-->
                        </div>
                        <!-- /-left-col-->
                    </div>
                    <!--/.row-->


                    <div class="Ads-Details">
                        <h2 class="list-title"><strong>Details</strong></h2>

                        <div class="row">
                            
                            <div class="col-md-12">
                                <p id="auction-info" >  <?php echo $row1['productDescritpion'] ?></p>

                                <aside   class="panel panel-body panel-details">

                                    <ul>

                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>Starting Price:</strong> <span id="auction-php"> £<?php echo $row1['startPrice'] ?> </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>End Date:</strong><span id="auction-php"> <?php echo $row1['endDate'] ?> </span> </p>
                                        </li>

                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>Time Remaining:</strong>  <span id="demo"> </span> </p>
                                            
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Category:</strong> <span id="auction-php">  <?php echo $row1['categoryHierarchy1'] ?> </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>Condition:</strong> <span id="auction-php">  <?php echo $row1['itemCondition'] ?> </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Views:</strong> <span id="auction-php">  <?php echo $row2['viewing'] ?> </span> </p>
                                        </li>

                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Seller:</strong> <span id="auction-php"><?php echo $row1['firstName']." ".$row1['lastName']?>  </span> </p>
                                        </li>
                                      
                                    </ul>
                                </aside>

                                


                            </div>
                        </div>
                        
                </div>
                <!--/.ads-details-wrapper-->

<form form action="item-page.php?saleID=<?php echo $saleID; ?>" method="post">
   <input style="visibility: hidden;" type="radio" name="Watchlist" value="WL" checked>
  <div class="col-md-3" style="margin-bottom: 20px;">
  <input class="btn btn-block btn-primary" type="submit" value="Add to Watch List" >
  </div>
</form>


            </div>
            </div>
            <!--/.page-content-->


<!--AND IF LOGGED IN USER DOESN'T EQUAL THE SELLER  -->
            <?php if ($loggedInProfile == "Customer")  { ?>

            <div class="col-md-3  page-sidebar-right">
                <aside>
                    <div class="card sidebar-card">
                        <div class="card-header">Bid</div>
                        <div class="card-content">
                            <div class="card-body text-left">
                                <label class="col-form-label" for="formGroupExampleInput">
                                <form action="item-page.php?saleID=<?php echo $saleID; ?>" method="post">
                                Place bid:</label>

                                <input type="text" class="form-control" name="bid" placeholder="Bid Value">
                                <br />
                                
                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>

                                    <div class="col-sm-8"><input class="btn btn-block btn-primary" type="submit" value="Submit Bid" ></div>
                                   </div>


                                </form>

                            </div>
                        </div>
                    </div>

            <?php } ?>
                    





            <div class="card sidebar-card">
                <div class="card-header"> Watch Auction</div>
                   <div class="card-content">
                     <div class="card-body text-left">

                            <strong>Highest Bid: <br> £<?php echo $row4['bidValue'] ?>  - </strong> 



                            <a href="#.php?saleID=<?php echo $row2['saleID'] ?>" >
                                <strong><?php echo $row4['firstName']; echo $row4['lastName']; ?></strong>
                            </a>

                        <br>
                        <br>
                            Previous Bids:
                            <?php 
                                while($row4 = mysqli_fetch_array($result_bidName)) {   ?> 
                                <br>
                                    £<?php  echo $row4['bidValue']; ?> - 

                                    <a href="#.php?saleID=<?php echo $row2['saleID'] ?>" >
                                        <strong><?php echo $row4['firstName']; echo $row4['lastName']; ?></strong>
                                    </a>
                            <?php } ?>
                    </div>
                </div>
            </div>
                    <!--/.categories-list-->
            </aside>
        </div>
            <!--/.page-side-bar-->
    </div>
</div>
<!-- /.main-container -->




<!-- script for countdown timer -->
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $row1['endDate'] ?>").getTime();
// Update the count down every 1 second
var x = setInterval(function() {
    // Get todays date and time
    var now = new Date().getTime();
   
        // Find the distance between now an the count down date
        var distance = countDownDate - now;
            
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
            
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
            
            <?php if (!$auctionEnded) { ?>
                window.location.reload()
            <?php } ?> 
        }
    
    
}, 1000);
</script>
<!-- /.countdown timer -->





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




</body>

<?php
mysqli_close($db);
?>

</html>