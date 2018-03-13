<?php

include_once('../private/initialise.php');

    require_login();

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
    <title>User's Watchlist Page</title>
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

<?php

$logged_in_user = $_SESSION['id'];

//FETCHING THE BUYER ID OF THE LOGGED IN USER
$query_buyer = "SELECT buyerID FROM BuyerDetails WHERE userID = $logged_in_user LIMIT 1";
$result_buyer = mysqli_query($db, $query_buyer)
    or die('Error making select users query' . mysqli_error($db));

$row1 = mysqli_fetch_array($result_buyer);

//FETCHING DETAILS FOR THE BUYER'S 'BUY IT NOW' WATCHLIST ITEMS
$query_buyItNow  = "SELECT imageURL, productName, startDate, endDate, buyItNowPrice, BuyItNow.saleID 
FROM Product
    JOIN itemForSale
        ON Product.productID = itemForSale.productID
    JOIN SaleDescription
        ON SaleDescription.saleID = itemForSale.saleID
    JOIN BuyItNow
        ON BuyItNow.saleID = SaleDescription.saleID
    JOIN WatchList
    	ON WatchList.buyItNowID = BuyItNow.buyItNowID
WHERE buyerID = $row1[buyerID]";

$result_buyItNow = mysqli_query($db, $query_buyItNow)
    or die('Error making select users query' . mysqli_error($db));


//FETCHING DETAILS FOR THE BUYER'S 'AUCTION' WATCHLIST ITEMS
$query_Auction  = "SELECT imageURL, productName, startDate, endDate, Auction.saleID
FROM Product
    JOIN itemForSale
        ON Product.productID = itemForSale.productID
    JOIN SaleDescription
        ON SaleDescription.saleID = itemForSale.saleID
    JOIN Auction
        ON Auction.saleID = SaleDescription.saleID
    JOIN WatchList
    	ON WatchList.auctionID = Auction.auctionID
WHERE buyerID = $row1[buyerID]";

$result_Auction = mysqli_query($db, $query_Auction)
    or die('Error making select users query' . mysqli_error($db));


?>


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
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-heart-1"></i> Watchlist </h2>

                        <div class="table-responsive">
                            <div class="table-action">

                                
                            <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Photo</th>
                                    <th data-sort-ignore="true"> Listing Details</th>
                                    <th data-type="numeric"> Price</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                while($row3 = mysqli_fetch_array($result_Auction)) {  ?>
                                    
                                    <tr><td style="width:14\%" class="add-img-td"><a href="ad-details.php?saleID=<?php echo $row3['saleID'] ?>"  ><img
                                        class="thumbnail  img-responsive"
                                        src="images/<?php echo htmlspecialchars($row3['imageURL']); ?>"
                                        alt="img"></a></td>
                                        <td style="width:58%" class="ads-details-td">
                                            <div>
                                                <p><strong> <a href="item-page.php?saleID=<?php echo $row3['saleID'] ?>"> <?php echo $row3['productName'] ?>
                                                    </a> </strong></p>
                                                <p><strong> Start Date </strong>: <?php echo $row3['startDate'] ?>
                                                </p><p><strong> End Date </strong>: <?php echo $row3['endDate'] ?>
                                                </p>   
                                            </div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div><strong> Auction</strong></div>
                                        </td>
                                    </tr> 
                                <?php ; 
                                }   ?> 
                                         
                                         
                                <?php
                                while($row2 = mysqli_fetch_array($result_buyItNow)) { ?>
                                    
                                    <tr><td style="width:14\%" class="add-img-td"><img
                                        class="thumbnail  img-responsive"
                                        src="images/<?php echo htmlspecialchars($row2['imageURL']); ?>"
                                        alt="img"></td>
                                        <td style="width:58%" class="ads-details-td">
                                            <div>
                                                <p><strong>  <?php echo $row2['productName'] ?>
                                                   </strong></p>
                                                <p><strong> Start Date </strong>: <?php echo $row2['startDate'] ?>
                                                </p><p><strong> End Date </strong>: <?php echo $row2['endDate'] ?>
                                                </p>   
                                            </div>
                                        </td>
                                        <td style="width:16%" class="price-td">
                                            <div><strong> £<?php echo $row2['buyItNowPrice'] ?> </strong></div>
                                        </td>
                                     </tr> 
                                <?php ;
                                }   ?>
                                
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
