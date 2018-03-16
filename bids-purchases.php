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
    <title>User's Bids & Purchases</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="assets/js/pace.min.js"></script>

    <style> 
        .dropbtn {
            background-color: orange;
            color: white;
            padding: 10px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 6px 8px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #ddd}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
            background-color: red;
        } 
    </style> 


</head>
<body>
<div id="wrapper">

<?php

//CONNECT TO THE DATABASE
include 'DbConnection.php';

//FETCH THE LOGGED IN USER
$logged_in_user = 3;

//FETCHING THE VARIABLES POSTED WHEN SELLER IS RATED ON THIS PAGE
if (  isset($_GET['rating']) && isset($_GET['sellerUserID']) && isset($_GET['saleID'])  ) {
 //   $rating = $_GET['rating'];
 //   $sellerUserID = $_GET['sellerUserID'];
  //  $saleID = $_GET['saleID'];
 
    //INSERTING THE RATING FOR THE SELLER
    $query_insertRating = "INSERT INTO Ratings (raterUserID, receiverUserID, rating) VALUES ($logged_in_user, $_GET[sellerUserID], $_GET[rating] )";
    mysqli_query($db, $query_insertRating)
        or die('Error making select users query' . mysql_error());

    //SETTING THE BOOLEAN 'SELLER RATED' TO TRUE
    $query_sellerRated = "UPDATE Purchase SET sellerRated = TRUE WHERE saleID = $_GET[saleID]";
    mysqli_query($db, $query_sellerRated)
        or die('Error making select users query' . mysql_error());

}


//FETCHING THE BUYER ID OF THE LOGGED IN USER
$query_buyer = "SELECT buyerID FROM BuyerDetails WHERE userID = $logged_in_user LIMIT 1";
$result_buyer = mysqli_query($db, $query_buyer)
    or die('Error making select users query' . mysql_error());

$row1 = mysqli_fetch_array($result_buyer);
//echo $row1['buyerID'];

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

?>

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
        <div class="container">
            <div class="row">
                <div class="col-md-3 page-sidebar">
                    <aside>
                        <div class="inner-box">
                            <div class="user-panel-sidebar">
                                <div class="collapse-box">
                                    <h5 class="collapse-title no-border"> My Account <a class="pull-right"
                                                                                           aria-expanded="true"  data-toggle="collapse"
                                                                                           href="#MyClassified"><i
                                            class="fa fa-angle-down"></i></a></h5>

                                    <div id="MyClassified" class="panel-collapse collapse show">
                                        <ul class="acc-list">
                                            <li><a href="personalpage.html"><i class="icon-home"></i> Personal Home </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <!-- /.collapse-box  -->
                                <div class="collapse-box">
                                    <h5 class="collapse-title"> My Items <a class="pull-right" aria-expanded="true"  data-toggle="collapse"
                                                                          href="#MyAds"><i class="fa fa-angle-down"></i></a>
                                    </h5>

                                    <div id="MyAds" class="panel-collapse collapse show">
                                        <ul class="acc-list">
                                            <li><a href="my-listings.php"><i class="icon-docs"></i> My Listings <span
                                                    class="badge">42</span> </a></li>
                                            <li><a href="watchlist.php"><i class="icon-heart"></i>
                                                Watchlist <span class="badge badge-secondary">42</span> </a></li>
                                            <li><a href="bids-purchases.php"><i class="icon-hourglass"></i>
                                                Bids / Purchases <span class="badge badge-secondary">42</span> </a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- /.collapse-box  -->
                                <div class="collapse-box">
                                    <h5 class="collapse-title"> Terminate Account <a class="pull-right"
                                                                                     aria-expanded="true"  data-toggle="collapse"
                                                                                     href="#TerminateAccount"><i
                                            class="fa fa-angle-down"></i></a></h5>

                                    <div id="TerminateAccount" class="panel-collapse collapse show">
                                        <ul class="acc-list">
                                            <li><a href="account-close.html"><i class="icon-cancel-circled "></i> Close
                                                account </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.collapse-box  -->
                            </div>
                        </div>
                        <!-- /.inner-box  -->

                    </aside>
                </div>
                <!--/.page-sidebar-->

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-folder-close"></i> Bids / Purchases </h2>

                        <div class="table-responsive">
                            <div class="table-action">

                                
                                </div>
                            </div>


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
                                                <p><strong> Congratulations. </strong></p>
                                                <p><strong><a href='#'>Pay Now</a></strong></p>

                                            </div>
                                        </td>
                                        <td style="width:16%" class="action-td">
                                            <div>
                                                <p><strong><a href="personal-account.php?sellerID=<?php echo $row4['userID'] ?>"><?php echo $row4['firstName'] ?></a></strong>

                                                <?php if (!$row3['sellerRated']) { ?>  
                                                    
                                                    <div class="dropdown">
                                                        <button class="dropbtn">Rate Seller</button>
                                                            <div class="dropdown-content">
                                                                <a href="bids-purchases.php?rating=5&sellerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row3['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</a>
                                                                <a href="bids-purchases.php?rating=4&sellerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row3['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;</a>
                                                                <a href="bids-purchases.php?rating=3&sellerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row3['saleID']; ?>">&#9733;&#9733;&#9733;</a>
                                                                <a href="bids-purchases.php?rating=2&sellerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row3['saleID']; ?>">&#9733;&#9733;</a>
                                                                <a href="bids-purchases.php?rating=1&sellerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row3['saleID']; ?>">&#9733;</a>
                                                            </div>
                                                    </div>
                                                    
                                                <?php } else { ?>
                                                        <p><strong> Thanks for rating! </strong></p>
                                                <?php } ?>
                                                

                                                
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
                                            <p><strong>Your Current Bid </strong>: £<?php echo $row5['bidValue']  ?> </p>
                                            <p><strong>Current Highest Bid </strong>: £<?php echo $row2['mBid']  ?> </p>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div>
                                                <?php if ($row6) { ?>

                                                    <p><strong> £<?php echo $row6['salePrice']   ?> </strong></p>
                                                    <?php if ($row6['buyerID'] == $row1['buyerID']) {   ?>
                                                        <p><strong> Congratulations, You Won! </strong></p>
                                                        <p><strong><a href='#'>Pay Now</a></strong></p>
                                                    <?php } else {?>
                                                        <p><strong> Sorry, you did not win </strong></p>
                                                    <?php } ?>

                                                <?php } else { ?>
                                                    <p><strong> Ongoing Auction </strong></p>
                                                <?php } ?>


                                            </div>
                                        </td>
                                        <td style="width:16%" class="action-td">
                                            <div>
                                                <p><strong><a href="#"><?php echo $row7['firstName']  ?></a></strong>
                                                </p>
                                                
                                                <?php if ($row6 && $row6['buyerID'] == $row1['buyerID'] ) {
                                                    if (!$row6['sellerRated']) { ?>
                                                        
                                                        
                                                        <div class="dropdown">
                                                            <button class="dropbtn">Rate Seller</button>
                                                                <div class="dropdown-content">
                                                                    <a href="bids-purchases.php?rating=5&sellerUserID=<?php echo $row7['userID']; ?>&saleID=<?php echo $row6['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</a>
                                                                    <a href="bids-purchases.php?rating=4&sellerUserID=<?php echo $row7['userID']; ?>&saleID=<?php echo $row6['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;</a>
                                                                    <a href="bids-purchases.php?rating=3&sellerUserID=<?php echo $row7['userID']; ?>&saleID=<?php echo $row6['saleID']; ?>">&#9733;&#9733;&#9733;</a>
                                                                    <a href="bids-purchases.php?rating=2&sellerUserID=<?php echo $row7['userID']; ?>&saleID=<?php echo $row6['saleID']; ?>">&#9733;&#9733;</a>
                                                                    <a href="bids-purchases.php?rating=1&sellerUserID=<?php echo $row7['userID']; ?>&saleID=<?php echo $row6['saleID']; ?>">&#9733;</a>
                                                                </div>
                                                        </div>
                                                        
                                                    <?php }
                                                    else { ?>
                                                        <p><strong> Thanks for rating! </strong></p>
                                                    <?php }
                                                } ?>
                                            </div>
                                        </td>
                                    </tr>

                                <?php ;
                                 } ?>

                              
                                </tbody>
                            </table>
                        </div>
                        <!--/.row-box End-->

                    </div>
                </div>
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
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


<!-- include custom script for listings table [select all checkbox]  -->
<script>

    function checkAll(bx) {
        var chkinput = document.getElementsByTagName('input');
        for (var i = 0; i < chkinput.length; i++) {
            if (chkinput[i].type == 'checkbox') {
                chkinput[i].checked = bx.checked;
            }
        }
    }

</script>

</body>

<?php
mysqli_close($db);
?>

</html>
