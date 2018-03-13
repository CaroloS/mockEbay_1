<?php

include_once('../private/initialise.php');

    require_login();

    date_default_timezone_set("Europe/London");

    $message = '';

    $auctionEnded = false;

    $userID= $_SESSION['id'];

    $loggedInProfile = $_SESSION['description'];

    $logged_in_user= $_SESSION['id'];

    if (isset($_GET['saleID'])) {
        $saleID = $_GET['saleID'];
    } else{ 
        if ($_SESSION('description') === 'Customer') {
            $location = 'categoryCustomer.php';
            header("Location: " . $location);
            exit();
        } else {
            $location = 'categoryAdmin.php';
            header("Location: " . $location);
            exit();
        }
    }

    $item = get_item_by_sale_id($saleID);

    $buyerID = $_SESSION['buyerID'];

    $highest_bid = highest_bid($saleID);

    /////CHECKING IF AUCTION HAS ENDED//////
    $auction_endDate = date('Y-m-d h:i:sa', strtotime($item['endDate']));
    $now = date('Y-m-d h:i:sa');
    if ($auction_endDate < $now) {
        $auctionEnded = true;
    }

    $purchase = is_purchase_complete($saleID);

    $seller = get_seller_details($saleID);

    $sellerID_logged_user = $_SESSION['sellerID'];

    $recommendations = get_recommendations($sellerID_logged_user);

    $auctionID = get_auction_id($saleID);

    $bid_mail = send_bid_mail($saleID);

    $all_bids = get_all_bids($saleID);

    $item_sold = item_sold($saleID);

    $bids = check_bids($auctionID['auctionID']);

    $headers =  'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'From: Your name <daianabassi1@gmail.com>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    


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


if ($auctionEnded) {
    
    //IF THERE ISN'T AN ENTRY IN THE PURCHASE TABLE - ENTER ONE IF THERE IS A BID
    //AND SEND ALL THE EMAILS TO SELLER/BIDDERS/WATCHERS TO NOTIFY OF AUCTION END/OUTCOME
    if (!$purchase) {
        if ($bids) {   //if there are bids on the item
            
            create_purchase($saleID, $highest_bid['buyerID'], $highest_bid['bidValue'], FALSE, FALSE);
            
            //send emails out to highest bidder, seller, all other bidders and watchlisters 
            // while($buyers_emails = buyers_emails($saleID)) {   
            //     if ($buyers_emails['sellerID'] == $item['sellerID'] ) {   
            //             $msg = "Congratulations, your ".$item['productName']." has sold! Buyer: ".$highest_bid['firstName']." ".$highest_bid['lastName']." Winning Bid: £". $highest_bid['bidValue'];  //email to the seller
            //     }
            //     else if ($buyers_emails['userID'] == $highest_bid['userID'] ) {
            //             $msg = "Congratulations, you won the auction for: ". $item['productName'] ."! Your Winning Bid: £". $highest_bid['bidValue']." Go to your account to pay.";  //email to the highest bidder
            //     }
            //     else {
            //             $msg = "The auction for ". $item['productName'] ." has now ended. Winning Bid was: ". $highest_bid['bidValue'] ." We are selling similar items on edatabay, search now!";  //email to everyone else watching/bidding
            //     }
            //         // use wordwrap() if lines are longer than 70 characters
            //         $msg = wordwrap($msg,70);
            //         // send email
            //         mail($buyers_emails['emailAddress'],"Auction Ended",$msg, $headers);
            // }

            // email_sent($saleID);
        }
        // else {   

        //     $email_checked = check_email_sent($saleID);

        //     //If final emails sent ISN'T true: 
        //     if (!$email_checked['finalEmailsSent']) {

        //         while($buyers_emails = buyers_emails($saleID)) {  
        //             if ($buyers_emails['sellerID'] == $item['sellerID']) {   
        //                 $msg = "We're sorry your ".$item['productName']." didn't sell this time. Relist it again now. ";  //email to the seller
        //             }
        //             else {
        //                 $msg = "The auction for ". $item['productName'] ." has now ended without any bids. We are selling similar items on edatabay, search now!";  //email to everyone else watching/bidding
        //             }
        //             // use wordwrap() if lines are longer than 70 characters
        //             $msg = wordwrap($msg,70);
        //             // send email
        //             mail($buyers_emails['emailAddress'],"Auction Ended",$msg, $headers);
        //         }

        //         email_sent($saleID);
        //     }
            
        // }
    }   
}


if (isset($_POST['bid'])) {

        $bidValue = $_POST['bid'];


            if ($bidValue >  $item['startPrice']) {
                    if ($bidValue > $highest_bid['bidValue']){

                        place_bid($auctionID['auctionID'], $buyerID, $bidValue);

                        while($bid_mail_list = mysqli_fetch_assoc($bid_mail)){

                            $bidmessage= $bid_mail_list['firstName'] ." " . $bid_mail_list['lastName']. ", \nA bid of ". $bidValue ." pounds has been made on the product: ". $item['productName'];
                            $subject= "Bid on ". $item['productName'];
                            $email= $bid_mail_list["emailAddress"];
                            $headers =  'MIME-Version: 1.0' . "\r\n"; 
                            $headers .= 'From: Your name <info@address.com>' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
                            mail($email,$subject,$bidmessage, $headers); 
                        }
                    } else {

                    }


                    if (($bidValue <  $highest_bid['bidValue'])) {
                            echo "<script> alert('Bid must be higher than current highest bid.');</script>";
                    } 


            }  else {
                echo "<script> alert('Bid must be higher than starting price.');</script>";
            }
} 



if (isset($_POST['watchlist'])) {

    $watchlist = $_POST['watchlist'];

    if($watchlist === "added_to_watchlist"){

        $auctionID = get_auction_id($saleID);

        $buyItNowID = get_buy_id($saleID);

                add_watchlist($saleID,$buyerID, $buyItNowID['buyItNowID'], $auctionID['auctionID']);

    }
}


if(isset($_POST['backtolist'])) {

    update_views($saleID);

    unset($saleID);
    if ($_SESSION['description'] === 'Customer') {
        $location = 'categoryCustomer.php';
        header("Location: " . $location);
        exit();
    } elseif ($_SESSION['description'] === 'Employee') {
        $location = 'categoryAdmin.php';
        header("Location: " . $location);
         exit();
    }   

}

//Buy It Now Purchase
    if(isset($_POST['buyitnow'])) {

        create_purchase($saleID, $buyerID, $item['buyItNowPrice'], 0, 0);

        

    }
?>

<!-- IF LOGGED IN USER IS CUSTOMER THIS HEADER - ELSE INCLUDE ADMIN HEADER    -->


        <!-- /.header -->

    <?php 
        if ($_SESSION['description'] === 'Customer') {
            include('customerHeader.php');
        } else {
            include('adminHeader.php');
        }
    ?>
        <!-- /.header -->



<div class="main-container">

<?php if ($auctionEnded) { ?>
    <div >
        <h1 style=" margin-left: 500px;" >This auction has ended! </h2>
    </div> 
<?php } elseif ($item_sold) {?>
    <div >
        <h1 style=" margin-left: 500px;" >This item has been sold! </h2>
    </div> 
<?php } ?>







    <div   class="container">
        <div  class="row">

            <form action="item-page.php?saleID=<?php echo $saleID; ?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-10" style="margin-left: 16px"><input class="btn btn-block btn-primary" style="border-radius: 0px; background-color: #CCCCCC; border-color: #CCCCCC;" type="submit" name="backtolist" value="Back to Results"></div>
                </div>
            </form>
        </div>
    </div>
   
   
    <div  <?php if($auctionEnded || $item_sold) { ?> style=" opacity: 0.3;"  <?php } ?>    class="container">

        <div class="row">
            <div class="col-md-9 page-content col-thin-right">
                <div class="inner inner-box ads-details-wrapper">
                    <h1 class="auto-heading" ><span class="auto-title left"> <?php echo $item['productName'] ?></span> </h1>
                                
                    <div style="clear:both;"></div>


                    <div class="row ">
                        <div class="col-sm-12 automobile-left-col">

                            <div style="margin-left: 200px; " class="ads-image">
                                    <img style="height: 300px; width: auto;" src="images/<?php echo $item['imageURL']; ?>"
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
                                <p id="auction-info" ><?php echo $item['productDescritpion'] ?></p>

                                <aside   class="panel panel-body panel-details">

                                    <ul>

                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>
                                                <?php 
                                                    if($item['auction'] == 1) {
                                                        echo "Starting Price";
                                                    } else {
                                                        echo "Buy It Now Price";
                                                    }
                                                ?>
                                            </strong><span id="auction-php"> £
                                                <?php 
                                                    if($item['auction'] == 1) {
                                                        echo $item['startPrice'];
                                                    } else {
                                                        echo $item['buyItNowPrice'];
                                                    }
                                                ?> 
                                            </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>End Date:</strong><span id="auction-php"> <?php echo $item['endDate'] ?> </span> </p>
                                        </li>

                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>Time Remaining:</strong><span id="demo"> </span> </p>
                                            
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Category:</strong> <span id="auction-php">  <?php echo $item['categoryHierarchy1'] ?> </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class=" no-margin "><strong>Condition:</strong> <span id="auction-php">  <?php echo $item['itemCondition'] ?> </span></p>
                                        </li>
                                        
                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Views:</strong> <span id="auction-php">  <?php echo $item['viewing'] ?> </span> </p>
                                        </li>

                                        <li>
                                            <p id="auction-info" class="no-margin"><strong>Seller:</strong> <span id="auction-php"><?php echo $seller['firstName']." ".$seller['lastName']?>  </span> </p>
                                        </li>
                                      
                                    </ul>
                                </aside>

                                


                            </div>
                        </div>
                        
                </div>
                <!--/.ads-details-wrapper-->

<!--AND IF LOGGED IN USER DOESN'T EQUAL THE SELLER  -->

<?php if ($loggedInProfile == "Customer" && $seller['sellerID'] !== $sellerID_logged_user)  { ?>               

        <form form action="<?php echo "item-page.php?saleID=" . $saleID; ?>" method="post">
           <input style="visibility: hidden;" type="radio" name="watchlist" value="added_to_watchlist" checked>
          <div class="col-md-3" style="margin-bottom: 20px;">
          <input class="btn btn-block btn-primary" type="submit" value="Add to Watch List" >
          </div>
        </form>
<?php } ?>
</div>
</div>
<!--/.page-content-->


<!--AND IF LOGGED IN USER DOESN'T EQUAL THE SELLER  -->
<?php if ($loggedInProfile == "Customer" && $item['auction'] == 1 && $seller['sellerID'] !== $sellerID_logged_user)  { ?>
            <div class="col-md-3  page-sidebar-right">
                <aside>
                    <div class="card sidebar-card">
                        <div class="card-header">Bid</div>
                        <div class="card-content">
                            <div class="card-body text-left">
                                <label class="col-form-label" for="formGroupExampleInput">
                                <form action="item-page.php?saleID=<?php echo $saleID; ?>" method="post">
                                Place Bid:</label>

                                <input type="text" class="form-control" name="bid" placeholder="Bid Value">

                                <br>

                                <div class="form-group row">
<!--                                     <label class="col-sm-3 col-form-label"></label> -->

                                    <div class="col-sm-12"><input class="btn btn-block btn-primary" type="submit" value="Submit Bid" ></div>
                                   </div>


                                </form>

                            </div>
                        </div>
                    </div>

                    <?php }?>

<?php if ($loggedInProfile == "Customer" && $item['auction'] == 1)  { ?>
            <div class="card sidebar-card">
                <div class="card-header"> Watch Auction</div>
                   <div class="card-content">
                     <div class="card-body text-left">

                            <strong>Highest Bid: <br> £<?php echo $highest_bid['bidValue'] ?>  - </strong> 



                            <a href="<?php echo "personalpage.php?userID=" . $highest_bid['userID']; ?>" >
                                <strong><?php echo $highest_bid['firstName']; echo $highest_bid['lastName']; ?></strong>
                            </a>

                        <br>
                        <br>
                            Previous Bids:
                            <?php 
                                while($previous_bids = mysqli_fetch_array($all_bids)) {   ?> 
                                <br>
                                    £<?php  echo $previous_bids['bidValue']; ?> - 

                                    <a href="personalpage.php?userID=<?php echo $previous_bids['userID']; ?>" >
                                        <strong><?php echo $previous_bids['firstName']; echo $previous_bids['lastName']; ?></strong>
                                    </a>
                            <?php } ?>
                    </div>
                </div>
            </div>

    <?php } ?>

<?php if ($loggedInProfile == "Customer" && $item['buyItNow'] == 1 && $seller['sellerID'] !== $sellerID_logged_user)  { ?>
            <div class="col-md-3  page-sidebar-right">
                <aside>
                    <div class="card sidebar-card">
                        <div class="card-header">Buy It Now</div>
                        <div class="card-content">
                            <div class="card-body text-left">
                                <form action="item-page.php?saleID=<?php echo $saleID; ?>" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-6"><input class="btn btn-block btn-primary" type="submit" name="buyitnow" value="Buy It Now"></div>
                                   </div>
                                </form>

                            </div>
                        </div>
                    </div>

<?php } ?>
                    






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
var countDownDate = new Date("<?php echo $item['endDate'] ?>").getTime();
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

<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="col-xl-12 content-box" style=" width: 58%; margin-left: 165px;">
                 <div class="row row-featured">



<?php if ($loggedInProfile == "Customer" && $seller['sellerID'] !== $sellerID_logged_user)  { ?>

                     <div class="col-xl-12  box-title ">
                        <div class="inner"><h2>Others who saved this item also liked... </h2>
                        </div>
                    </div>               

                    <?php while($reccomendation_set = mysqli_fetch_assoc($recommendations)){ 
                    ?>
                         <div class="col-xl-4  box-title " style="border-right: 10px; border-left: 10px; text-align:center;">
                             <h2><a href="item-page.php?saleID=<?php echo $reccomendation_set['saleID'] ?>"><?php echo $reccomendation_set['productName']; ?></a></h2>
                                <img src="images/<?php echo $reccomendation_set['imageURL']; ?>">
                        </div>
                    <?php } ?>
<?php } ?>  

                </div>
            </div>
        </div>
	</div>
</footer>
<!-- /.footer -->


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




<script src="assets/js/footable.js?v=2-0-1" type="text/javascript"></script>
<script src="assets/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#addManageTable').footable().bind('footable_filtering', function (e) {
            var selected = $('.filter-status').find(':selected').text();
            if (selected && selected.length > 0) {
                e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                e.clear = !e.filter;
            }
        });
        $('.clear-filter').click(function (e) {
            e.preventDefault();
            $('.filter-status').val('');
            $('table.demo').trigger('footable_clear_filter');
        });
    });
</script>



</body>

<?php
mysqli_close($db);
?>

</html>