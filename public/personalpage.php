<?php

include_once('../private/initialise.php');

    require_login();

    if (isset($_GET['userID'])) {
        $id = $_GET['userID'];
        $user = get_user_by_id($id);
    } else {
        $id = $_SESSION['id'];
        $user = get_user_by_id($id);
    }



    if (isset($_GET['userID'])) {
        $id = $_GET['userID'];

        $query_ratings = "SELECT AVG(rating) FROM Ratings WHERE receiverUserID = $id";

        $result_ratings = mysqli_query($db, $query_ratings)
                or die('Error making select users query' . mysqli_error($db));
        $row2 = mysqli_fetch_array($result_ratings);

        $avg_rating = round ($row2['AVG(rating)']);

    } else {
        $id = $_SESSION['id'];

        $query_ratings = "SELECT AVG(rating) FROM Ratings WHERE receiverUserID = $id";

        $result_ratings = mysqli_query($db, $query_ratings)
                or die('Error making select users query' . mysqli_error($db));
        $row2 = mysqli_fetch_array($result_ratings);

        $avg_rating = round ($row2['AVG(rating)']);
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
    <title>BOOTCLASIFIED - Responsive Classified Theme</title>
   <!-- Bootstrap core CSS -->
   <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">


   <link href="assets/css/style.css" rel="stylesheet">

   <!-- styles needed for carousel slider -->
   <link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
   <link href="assets/plugins/owl-carousel/owl.theme.css" rel="stylesheet">

   <!-- bxSlider CSS file -->
   <link href="assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet"/>

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
    if ($_SESSION['description'] === 'Customer') {
        include('customerHeader.php');
    } else {
        include('adminHeader.php');
    }
 ?>

    <div class="main-container">
        <div class="container">
            <div class="row">

            <!--/.page-sidebar-->
    <?php 
        if ($_SESSION['description'] === 'Customer') {
            include('userSidePanel.php');
        } else {
            include('adminSidePanel.php');
        }
     ?>

                <!--/.page-sidebar-->

                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <div class="row">
                            <div class="col-md-5 col-xs-4 col-xxs-12">
                                <h3 class="no-padding text-center-480 useradmin"><img class="userImg" src="images/user.jpg" alt="user">
                                    <?php echo $user['firstName'] . " " . $user['lastName'];?>
                                </h3>
                            </div>
                            <div class="col-md-7 col-xs-8 col-xxs-12">
                                <div class="header-data text-center-xs">

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner-box">
                        <div id="accordion" class="panel-group">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB1" aria-expanded="true"  data-toggle="collapse" > Personal Details </a></h4>
                                </div>
                                <div class="panel-collapse collapse show" id="collapseB1">
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">First Name</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['firstName']; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Last Name</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['lastName']; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Email</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['emailAddress']; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Username</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['username']; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">City</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['cityName']; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Country</label>

                                                <div class="col-sm-9">
                                                    <span><?php echo $user['countryName'];; ?></span>
                                                </div>
                                            </div>

                                            <?php if ($_SESSION['description'] === 'Employee' && $id !== $_SESSION['id']) {?>

                                            <div  class="form-group">
                                                <label class="col-sm-3 control-label">Overall Rating</label>

                                                <div class="col-sm-9">
                                                    <span>
                                                        <p><strong><?php 
                                                        for ( $i = 0; $i < $avg_rating; $i ++) {
                                                            ?> &#9733 <?php
                                                        } ?></strong></p>
                                                    </span>

                                                </div>
                                            </div>

                                            <?php } ?>

                                            <?php if ($_SESSION['description'] === 'Customer') {?>

                                            <div  class="form-group">
                                                <label class="col-sm-3 control-label">Overall Rating</label>

                                                <div class="col-sm-9">
                                                    <span>
                                                        <p><strong><?php 
                                                        for ( $i = 0; $i < $avg_rating; $i ++) {
                                                            ?> &#9733 <?php
                                                        } ?></strong></p>
                                                    </span>

                                                </div>
                                            </div>

                                            <?php } ?>



                                        </div>  
                                        </form>
                                    </div>
                                </div>

<?php 
    
    if (!isset($_GET['userID'])) {

        $button_update = "<form action=\"edit.php?username=";
        $button_update .= "<?php echo {$_SESSION['username']}; ?>\" method=\"get\">";
        $button_update .= "<div class=\"form-group row\" style=\"padding-top: 10px;\">";
        $button_update .= "<label class=\"col-form-label\"></label>";
        $button_update .= "<div class=\"col-sm-3\">";
        $button_update .= "<input class=\"btn btn-block btn-primary\" type=\"submit\" value=\"Edit Account\" >";
        $button_update .= "</div></div></form>";

        echo $button_update;
    } 

?>


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
</html>
