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
    <title>User's Sale Listing Page</title>
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
    <!-- CSS for the rating dropdown menu -->
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


//FETCHING THE VARIABLES POSTED WHEN BUYER IS RATED ON THIS PAGE
if (isset($_GET['rating']) && isset($_GET['buyerUserID']) && isset($_GET['saleID'])  ) {

      //INSERTING THE RATING FOR THE BUYER
       $query_insertRating = "INSERT INTO Ratings (raterUserID, receiverUserID, rating) VALUES ($logged_in_user, $_GET[buyerUserID], $_GET[rating] )";
       mysqli_query($db, $query_insertRating)
           or die('Error making select users query' . mysqli_error($db));
   
       //SETTING THE BOOLEAN 'BUYER RATED' TO TRUE
       $query_buyerRated = "UPDATE Purchase SET buyerRated = TRUE WHERE saleID = $_GET[saleID]";
       mysqli_query($db, $query_buyerRated)
           or die('Error making select users query' . mysqli_error($db));
   
}

//FETCHING THE SELLER ID OF THE LOGGED IN USER
$query_seller = "SELECT sellerID FROM SellerDetails WHERE userID = $logged_in_user LIMIT 1";
$result_seller = mysqli_query($db, $query_seller)
    or die('Error making select users query' . mysqli_error($db));

$row1 = mysqli_fetch_array($result_seller);

//FETCHING DETAILS OF ALL ITEMS SELLER IS SELLING / HAS SOLD 
$query_allSelling  = "SELECT imageURL, productName, startDate, endDate, viewing, auction, buyItNow, saleDescription.saleID
FROM Product
    JOIN itemForSale
        ON Product.productID = itemForSale.productID
    JOIN SaleDescription
        ON SaleDescription.saleID = itemForSale.saleID
    JOIN Sale 
        On Sale.saleID = SaleDescription.saleID
WHERE sellerID = $row1[sellerID]";

$result_allSelling = mysqli_query($db, $query_allSelling)
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
                        <h2 class="title-2"><i class="icon-docs"></i> My Listings </h2>

                        <div class="table-responsive">
                            <div class="table-action">
                               

                               
                            <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Photo</th>
                                    <th data-sort-ignore="true"> Lising Details</th>
                                    <th data-type="numeric"> Sold For</th>
                                    <th data-type="numeric"> Buyer</th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php 
                                while($row2 = mysqli_fetch_array($result_allSelling)) {   
                                    
                                    //FETCHING THE SALE DETAILS FOR ITEMS THAT HAVE SOLD AND ARE THEREFORE IN THE PURCHASE TABLE
                                    $query_sold = "SELECT buyerID, salePrice, buyerRated, sellerRated FROM Purchase WHERE saleID = $row2[saleID] LIMIT 1";
                                    $result_sold = mysqli_query($db, $query_sold)
                                        or die('Error making select users query' . mysqli_error($db));
                                    $row3 = mysqli_fetch_array($result_sold);

                                    //FETCHING THE DETAILS FOR THE BUYER IF THE ITEM HAS SOLD
                                    if ($row3) {
                                        $query_buyer = "SELECT Users.userID, firstName FROM Users JOIN BuyerDetails ON BuyerDetails.userID = Users.userID WHERE buyerID = $row3[buyerID] LIMIT 1";
                                        $result_buyer = mysqli_query($db, $query_buyer)
                                            or die('Error making select users query' . mysqli_error($db));
                                        $row4 = mysqli_fetch_array($result_buyer);
                                    }
                                    ?>

                                    <tr>
                                            <!-- <?php #if ($row2['auction']) { ?> -->
                                                        <td style="width:14%" class="add-img-td"><a href="item-page.php?saleID=<?php echo $row2['saleID'] ?>"><img
                                                        class="thumbnail  img-responsive"
                                                        src="images/<?php echo htmlspecialchars($row2['imageURL']); ?>"
                                                        alt="img"></a></td>
                                                <td style="width:40%" class="ads-details-td">


                                            <div>
                                              <!--   <?php #if ($row2['auction']) { ?> -->
                                                    <p><strong> <a href="item-page.php?saleID=<?php echo $row2['saleID'] ?>" > <?php echo $row2['productName'] ?> 
                                                    </a> </strong></p>

                                                

                                                <p><strong> Start Date </strong>: <?php echo $row2['startDate'] ?> </p>
                                                <p><strong> End Date </strong>: <?php echo $row2['endDate'] ?></p>

                                                <p><strong>Views </strong>: <?php echo $row2['viewing'] ?>  
                                                    <strong> Type </strong>: 

                                                        <?php if ($row2['auction']) { ?>
                                                            Auction
                                                        <?php } else {  ?> 
                                                             Buy It Now
                                                        <?php } ?>

                                                </p>
                                            </div>
                                        </td>
                                        
                                        <td style="width:16%" class="price-td">
                                            <div>
                                                <p><strong>

                                                    <?php if ($row3) 
                                                            echo '<span>£</span>'. $row3['salePrice'];
                                                        else 
                                                            echo '<p><strong> Ongoing Sale </strong></p>';
                                                    ?>

                                                </strong>
                                                </p>
                                            </div>
                                        </td>

                                        <td style="width:16%" class="price-td">
                                            <div><p><strong>
                                                
                                                <?php if ($row3) {  ?>
                                                    <a href="personalpage.php?userID=<?php echo $row4['userID']; ?>"> <?php echo $row4['firstName'] ?>  </a></strong></p>

                                                   <?php if (!$row3['buyerRated']) { ?>  
                                                   
                                                    <div class="dropdown">
                                                        <button class="dropbtn">Rate Buyer</button>
                                                            <div class="dropdown-content">
                                                                <a href="myListings.php?rating=5&buyerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row2['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</a>
                                                                <a href="myListings.php?rating=4&buyerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row2['saleID']; ?>">&#9733;&#9733;&#9733;&#9733;</a>
                                                                <a href="myListings.php?rating=3&buyerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row2['saleID']; ?>">&#9733;&#9733;&#9733;</a>
                                                                <a href="myListings.php?rating=2&buyerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row2['saleID']; ?>">&#9733;&#9733;</a>
                                                                <a href="myListings.php?rating=1&buyerUserID=<?php echo $row4['userID']; ?>&saleID=<?php echo $row2['saleID']; ?>">&#9733;</a>
                                                            </div>
                                                    </div>
                                                        
                                                   <?php } else { ?>
                                                        <p><strong> Thanks for rating! </strong></p>
                                                   <?php } ?>


                                                <?php } else { ?>
                                                    <p><strong> Ongoing Sale </strong></p>
                                                <?php } ?>

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



<!-- include footable   -->

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
<!-- include custom script for ads table [select all checkbox]  -->
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