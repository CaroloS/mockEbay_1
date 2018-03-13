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
    <title>Admin All Users</title>
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

if ( isset($_GET['deleteUserID']) ) {

    echo $_GET['deleteUserID'];
    /*
    $query_deleteUser = "DELETE * FROM Users WHERE userID = $_GET[deleteUserID]";

    $result_deleteUser = mysqli_query($db, $query_deletUser)
        or die('Error making select users query' . mysql_error());
        */
}

//FETCH ALL THE USERS FROM THE DATABASE AND SOME OF THEIR DETAILS TO DISPLAY
$query_allUsers = "SELECT * FROM userdetails";

$result = mysqli_query($db, $query_allUsers);
        confirm_result_set($result);
        #$user = mysqli_fetch_assoc($result);

?>


    <!-- header -->
        <?php include('adminHeader.php'); ?>
    <!-- /.header -->
  

    <div class="main-container">
        <div class="container">
            <div class="row">
                
            <!-- page-sidebar -->
                <?php include('adminSidePanel.php'); ?>
            <!--/.page-sidebar-->


                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2"><i class="icon-user fa"></i> All Users </h2>

                        <div class="table-responsive">
                            <div class="table-action">

                               
                            <table id="addManageTable"
                                   class="table table-striped table-bordered add-manage-table table demo"
                                   data-filter="#filter" data-filter-text-only="true">
                                <thead>
                                <tr>
                                    <th> Username</th>
                                    <th data-sort-ignore="true"> Name</th>
                                    <th data-type="numeric"> Email</th>
                                    <th data-type="numeric"> Overall Rating</th>
                                    <th data-type="numeric"> Options</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php 
                                while($user = mysqli_fetch_assoc($result)) { 

                                    //GETTINGS ALL THE RATINGS FOR EVERY USER FROM THE RATINGS TABLE
                                    $query_ratings = "SELECT AVG(rating) FROM Ratings WHERE receiverUserID = $user[userID]";

                                    $result_ratings = mysqli_query($db, $query_ratings)
                                        or die('Error making select users query' . mysqli_error($db));
                                    $row2 = mysqli_fetch_array($result_ratings);

                                    $avg_rating = round ($row2['AVG(rating)']);

                                    ?> 
                                    <tr>
                                        <td style="width:17%" ><a>
                                            <p><strong> <a href="personalpage.php?userID=<?php echo $user['userID'] ?>"><?php echo $user['username'] ?></a> </strong></p>
                                        </td>

                                         <td style="width:25%">
                                            <div>
                                                <p><strong> <?php echo $user['firstName'] ?> <span> </span> <?php echo $user['lastName'] ?> </strong></p>
                                            </div>
                                        </td>

                                        <td style="width:30%">
                                            <div>
                                                <p><strong> <?php echo $user['emailAddress'] ?> </strong></p>
                                            </div>
                                        </td>

                                        <td style="width:16%" class="action-td">
                                            <div>
                                                <p><strong><?php 
                                                    for ( $i = 0; $i < $avg_rating; $i ++) {
                                                        ?> &#9733 <?php
                                                    } 
                                                ?></strong></p>
                                            </div>
                                        </td>

                                        <td style="width:10%" class="action-td">
                                            <div>
                                                <?php if ($user['description'] == 'Customer') { ?>
                                                    <p><a class="btn btn-info btn-sm" href="admin-view-userSales.php?userID=<?php echo $user['userID'] ?>"> <i class="fa fa-mail-forward"></i> View Sales
                                                    </a></p>
                                                    <p><a class="btn btn-primary btn-sm" href="admin-view-userPurchases.php?userID=<?php echo $user['userID'] ?>"> <i class="fa fa-edit"></i> View Purchases </a>
                                                    </p>
                                                <?php } ?>
                                            </div>
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
