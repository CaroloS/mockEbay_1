

<?php

include_once('private/initialise.php');

require_login();

if (isset($_POST['deletesale'])) {

    #echo "<script>alert('deletesale');</script>";

    $deletesaleID = $_GET['deletesaleID'];

    if (!item_sold($deletesaleID)) {

        $deleted_sale = delete_sale($deletesaleID);

        if ($deleted_sale) {
            echo "<script>alert('Sale has been removed.');</script> ";
            unset($deletesaleID);
            echo "<script>window.location.replace('admin-all-listings.php');</script> ";
        }

    } else {
        echo "<script>alert('Sale has already been concluded and cannot be removed.');</script>";
        unset($deletesaleID);
        echo "<script>window.location.replace('admin-all-listings.php');</script> ";
    }
}

//FETCHING DETAILS OF ALL ITEMS SELLER IS SELLING / HAS SOLD 
$query_allItems  = "SELECT imageURL, productName, startDate, endDate, auction, buyItNow, saleDescription.saleID, sellerID
FROM Product
    JOIN itemForSale
        ON Product.productID = itemForSale.productID
    JOIN SaleDescription
        ON SaleDescription.saleID = itemForSale.saleID
    JOIN Sale 
        On Sale.saleID = SaleDescription.saleID";

$result_allItems = mysqli_query($db, $query_allItems)
    or die('Error making select users query' . mysql_error());

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
    <title>Admin All Listingss</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

   
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
            <div class="row">

            <!--/.page-sidebar-->
 <?php 
        include('adminSidePanel.php');
 ?>
                <!--/.page-sidebar-->




                <!--/.page-sidebar-->

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-folder-close"></i> All Listings </h2>

                        <div class="table-responsive">
                            <div class="table-action">

                               
                            <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Photo</th>
                                    <th data-sort-ignore="true"> Item Details</th>
                                    <th data-type="numeric"> Winning Bid</th>
                                    <th> Seller</th>
                                    <th data-type="numeric"> Options</th>
                                </tr>
                                </thead>
                                <tbody>



                                <?php 
                                while($row1 = mysqli_fetch_array($result_allItems)) { 
                                    // s  = "SELECT imageURL, productName, startDate, endDate, auction, buyItNow, saleDescription.saleID

                                    $query_seller = "SELECT Users.userID, firstName FROM Users JOIN SellerDetails ON SellerDetails.userID = Users.userID WHERE sellerID = $row1[sellerID] LIMIT 1";
                                    $result_seller = mysqli_query($db, $query_seller)
                                         or die('Error making select users query' . mysql_error());
                                    $row2 = mysqli_fetch_array($result_seller);

                                    $query_winningBid = "SELECT saleID, salePrice, buyerID, sellerRated FROM Purchase WHERE saleID = $row1[saleID]";
                                    $result_winningBid = mysqli_query($db, $query_winningBid)
                                         or die('Error making select users query' . mysql_error());
                                    $row3 = mysqli_fetch_array($result_winningBid);

                                    if ($row3) {
                                        $query_buyer = "SELECT Users.userID, firstName FROM Users JOIN BuyerDetails ON BuyerDetails.userID = Users.userID WHERE buyerID = $row3[buyerID] LIMIT 1";
                                        $result_buyer = mysqli_query($db, $query_buyer)
                                            or die('Error making select users query' . mysql_error());
                                        $row4 = mysqli_fetch_array($result_buyer);
                                    }

                                    ?>

                                <tr>
                                    <?php if ($row1['auction']) { ?>
                                            <td style="width:14%" class="add-img-td"><a href="item-page.php?saleID=<?php echo $row1['saleID'] ?>"><img
                                                class="thumbnail  img-responsive"
                                                src="images/<?php echo htmlspecialchars($row1['imageURL']); ?>"
                                                alt="img"></a></td>
                                        <td style="width:40%" class="ads-details-td">            
                                    <?php } else { ?>
                                            <td style="width:14%" class="add-img-td"><img
                                                class="thumbnail  img-responsive"
                                                src="images/<?php echo htmlspecialchars($row1['imageURL']); ?>"
                                                alt="img"></td>
                                        <td style="width:40%" class="ads-details-td">   

                                    <?php } ?>
                                        <div>

                                             <?php if ($row1['auction']) { ?>
                                                <p><strong> <a href="item-page.php?saleID=<?php echo $row1['saleID'] ?>" > <?php echo $row1['productName'] ?>
                                                 </a> </strong></p>
                                            <?php } else { ?>
                                                <p><strong>  <?php echo $row1['productName'] ?>
                                                </strong></p>
                                            <?php } ?>

                                            
                                            <p><strong> Start Date </strong>:
                                               <?php echo $row1['startDate'] ?> </p>
                                            <p><strong> End Date </strong>:
                                               <?php echo $row1['endDate'] ?></p>
                                            <p><strong> Type </strong>:
                                                <?php if ($row1['auction']) { ?>
                                                    Auction </p>
                                                <?php } else { ?>
                                                    Buy It Now </p>
                                                <?php } ?>

                                            
                                        </div>
                                    </td>
                                    <td style="width:16%" class="price-td">
                                        <div>

                                            <?php if ($row3) { ?>
                                                    <p><strong> £<?php echo $row3['salePrice']   ?> </strong></p>
                                                    <p><strong> Buyer: </strong></p>
                                                    <p><strong><a href="personalpage.php?userID=<?php echo $row4['userID'];?>"> <?php echo $row4['firstName'] ?> </a></strong></p>
                                            <?php } else { ?>
                                                <p><strong> Ongoing Sale </strong></p>
                                            <?php } ?>

                                        </div>
                                    </td>

                                    <td style="width:16%" class="action-td">
                                        <div>
                                            <p><strong><a href="personalpage.php?userID=<?php echo $row2['userID']; ?>"><?php echo $row2['firstName'] ?></a></strong>
                                            </p>
                                        </div>
                                    </td>

                                    <td style="width:10%">
                                            <div   class="container">
                                                <div  class="row">

                                                    <form action="<?php echo "admin-all-listings.php?deletesaleID=" .  $row1['saleID']; ?>" method="post">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"></label>
                                                                <div class="col-sm-10"><input class="btn btn-danger btn-sm" type="submit" 
                                                                    name="deletesale" value="Remove"></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>




<!--                                             <p><a class="btn btn-danger btn-sm"
                                                  href="admin-all-listings.php?deletesaleID=<?php #echo $row1['saleID']; ?>"> <i class=" fa fa-trash"></i> Remove
                                            </a></p>
 -->
                                    </td>
                                </tr>

                                <?php } ?>

                               
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

</body>

<?php
mysqli_close($db);
?>

</html>
