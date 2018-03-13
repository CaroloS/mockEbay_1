<?php

include_once('../private/initialise.php');

    require_login();

?>


<?php 

if (  isset($_GET['userID'])  ) {

    $query_thisBuyer = "SELECT Users.userID, firstName, buyerID FROM Users JOIN  BuyerDetails ON BuyerDetails.userID = Users.userID WHERE Users.userID = $_GET[userID] LIMIT 1";
    $result_thisBuyer = mysqli_query($db, $query_thisBuyer)
        or die('Error making select users query' . mysql_error());
    $row1 = mysqli_fetch_array($result_thisBuyer);

    //FETCHING ITEMS THAT USER HAS BID ON - AND THE CURRENT HIGHEST BID FOR THOSE ITEMS
    $query_bids = "SELECT DISTINCT imageURL, productName, startDate, endDate, SaleDescription.saleID, sellerID, Auction.auctionID,
    (select MAX(bidValue) from Bids GROUP BY Bids.auctionID HAVING Bids.buyerID = $row1[buyerID] AND auctionID = Auction.auctionID) AS mBid 
    FROM Product 
        JOIN itemForSale 
            ON Product.productID = itemForSale.productID 
        JOIN SaleDescription 
            ON SaleDescription.saleID = itemForSale.saleID 
        JOIN Sale 
            ON Sale.saleID = itemForSale.saleID 
        JOIN Auction 
            ON Auction.saleID = itemForSale.saleID 
        JOIN Bids 
            ON Bids.auctionID = Auction.AuctionID 
    WHERE buyerID = $row1[buyerID]";

    $result_bids = mysqli_query($db, $query_bids)
        or die('Error making select users query' . mysql_error());


    //FETCHING 'BUY IT NOW' ITEMS THAT USER HAS PURCHASED
    $query_buyItNow = "SELECT imageURL, productName, startDate, endDate, SaleDescription.saleID, sellerID, salePrice, sellerRated
    FROM Product 
        JOIN itemForSale 
            ON Product.productID = itemForSale.productID 
        JOIN SaleDescription 
            ON SaleDescription.saleID = itemForSale.saleID 
        JOIN Sale 
            ON Sale.saleID = itemForSale.saleID 
        JOIN Purchase
            ON Purchase.saleID = itemForSale.saleID
    WHERE buyerID = $row1[buyerID]
    AND SaleDescription.buyItNow = TRUE";

    $result_buyItNow = mysqli_query($db, $query_buyItNow)
        or die('Error making select users query' . mysql_error());

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
    <title>Admin View User Purhcases</title>
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
        <?php include('adminHeader.php'); ?>
    <!-- /.header -->

    <div class="main-container">
        <div class="container">
           <div class="row clearfix">

                <!-- page-sidebar -->
                    <?php include('adminSidePanel.php'); ?>
                <!--/.page-sidebar-->

            <div class="col-md-9 page-content" style="float: right;">

                <div class="inner-box">

                    <h1 class="text-center title-1"> <?php echo $row1['firstName'] ?>'s Bids & Purchases </h1>

                    <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Photo</th>
                                    <th data-sort-ignore="true"> Item Details</th>
                                    <th data-type="numeric"> Bids </th>
                                    <th data-type="numeric"> Winning Bid</th>
                                    <th> Seller</th>
                                </tr>
                                </thead>
                                <tbody>


                        <!-- PHP loop to iterate through the user's 'buy it now' items and dispaly them in the table     -->
                                 <?php 
                                while($row3 = mysqli_fetch_array($result_buyItNow)) { 
                                
                                    //FETCHING THE NAME AND USER ID OF THE SELLER FOR THIS ITEM
                                    if ($row3) {
                                        $query_seller = "SELECT Users.userID, firstName FROM Users JOIN SellerDetails ON SellerDetails.userID = Users.userID WHERE sellerID = $row3[sellerID] LIMIT 1";
                                        $result_seller = mysqli_query($db, $query_seller)
                                                    or die('Error making select users query' . mysql_error());
                                        $row4 = mysqli_fetch_array($result_seller);
                                        
                                    }

                                    ?>

                                    <tr>
                                        <td style="width:14%" class="add-img-td"><img
                                                class="thumbnail  img-responsive"
                                                src="images/<?php echo htmlspecialchars($row3['imageURL']); ?>"
                                                alt="img"></td>
                                        <td style="width:40%" class="ads-details-td">
                                            <div>
                                                <p><strong> <?php echo $row3['productName'] ?>
                                             </strong></p>

                                                <p><strong> Start Date </strong>: <?php echo $row3['startDate'] ?> </p>
                                                <p><strong> End Date </strong>: <?php echo $row3['endDate'] ?></p>
                                                <p><strong> Type </strong>: Buy It Now </p>

                                            </div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div><strong> £<?php echo $row3['salePrice'] ?> </strong></div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div>
                                                <p><strong> £<?php echo $row3['salePrice'] ?> </strong></p>

                                            </div>
                                        </td>
                                        <td style="width:16%" class="action-td">
                                            <div>
                                                <p><strong><a href="personalpage.php?userID=<?php echo $row4['userID']; ?>"><?php echo $row4['firstName'] ?></a></strong>
                                            </div>
                                        </td>
                                    </tr>

                                <?php ;
                                 } ?>

                     <!-- PHP loop to iterate through the user's 'auction' items and dispaly them in the table     -->
                                 <?php 
                                while($row2 = mysqli_fetch_array($result_bids)) { 

                                    //FETCHING THE LOGGED IN USER'S MOST RECENT BID VALUE ON THIS ITEM
                                    $query_myCurrentBid = "SELECT auctionID, bidValue, buyerID FROM Bids HAVING buyerID = $row1[buyerID] AND auctionID = $row2[auctionID] ORDER BY bidValue DESC LIMIT 1";
                                    $result_myCurrentBid = mysqli_query($db, $query_myCurrentBid)
                                         or die('Error making select users query' . mysql_error());
                                    $row5 = mysqli_fetch_array($result_myCurrentBid);

                                    //FETCHING THE WINNING BID FOR THE ITEM, IF AUCTION HAS ENDED
                                    $query_winningBid = "SELECT saleID, salePrice, buyerID, sellerRated FROM Purchase WHERE saleID = $row2[saleID]";
                                    $result_winningBid = mysqli_query($db, $query_winningBid)
                                         or die('Error making select users query' . mysql_error());
                                    $row6 = mysqli_fetch_array($result_winningBid);

                                    //FETCHING THE NAME AND USER ID OF THE SELLER FOR THIS ITEM
                                    $query_seller = "SELECT Users.userID, firstName FROM Users JOIN SellerDetails ON SellerDetails.userID = Users.userID WHERE sellerID = $row2[sellerID] LIMIT 1";
                                    $result_seller = mysqli_query($db, $query_seller)
                                         or die('Error making select users query' . mysql_error());
                                    $row7 = mysqli_fetch_array($result_seller);

                                    ?>

                                    <tr>
                                        <td style="width:14%" class="add-img-td"><a href="item-page.php?saleID=<?php echo $row2['saleID'] ?>"><img
                                                class="thumbnail  img-responsive"
                                                src="images/<?php echo htmlspecialchars($row2['imageURL']); ?>"
                                                alt="img"></a></td>
                                        <td style="width:40%" class="ads-details-td">
                                            <div>
                                                <p><strong> <a href="item-page.php?saleID=<?php echo $row2['saleID'] ?>" ><?php echo $row2['productName'] ?>
                                                </a> </strong></p>

                                                <p><strong> Start Date </strong>: <?php echo $row2['startDate'] ?> </p>
                                                <p><strong> End Date </strong>: <?php echo $row2['endDate'] ?></p>
                                                <p><strong> Type </strong>: Auction </p>

                                            </div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <p><strong><?php echo $row1['firstName']?>'s' Current Bid </strong>: £<?php echo $row5['bidValue']  ?> </p>
                                            <p><strong>Current Highest Bid </strong>: £<?php echo $row2['mBid']  ?> </p>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div>
                                                <?php if ($row6) { ?>
                                                    <p><strong> £<?php echo $row6['salePrice']   ?> </strong></p>
                                                <?php } else { ?>
                                                    <p><strong> Ongoing Auction </strong></p>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td style="width:16%" class="action-td">
                                            <div>
                                                <p><strong><a href="personalpage.php?userID=<?php echo $row7['userID'] ?>"><?php echo $row7['firstName']  ?></a></strong>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>

                                <?php ;
                                 } ?>

                              
                                </tbody>
                            </table>
                    </div>
                </div>

            </div>
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

</body>

<?php
mysqli_close($db);
?>

</html>