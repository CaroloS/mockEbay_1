<?php include_once('../private/initialise.php'); 

    $country = find_all_countries();


    if(is_post_request()) {

        $user = [];
        $user['firstName'] = $_POST['firstName'] ?? null;
        $user['lastName'] = $_POST['lastName'] ?? null;
        $user['emailAddress'] = $_POST['emailAddress'] ?? null;
        $user['addressLine1'] = $_POST['addressLine1'] ?? null;
        $user['addressLine2'] = $_POST['addressLine2'] ?? null;
        $user['addressLine3'] = $_POST['addressLine3'] ?? null;
        $user['cityName'] = $_POST['cityName'] ?? null;
        $user['countryName'] = $_POST['countryName'] ?? null;
        $user['phoneNumber'] = $_POST['phoneNumber'] ?? null;
        $user['username'] = $_POST['username'] ?? null;
        $user['password'] = $_POST['password'] ?? null;
        $user['password2'] = $_POST['password2'] ?? null;

        $result = insert_user($user);

            if ($result === true) {
                $location = 'login.php';
                header("Location: " . $location);
                exit();
            } else {
                $errors = $result;
            }

    } else {
        //display blank form
        #echo "<script>window.location.href='login.php';</script>";
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

 <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
                 role="navigation">
                <div class="container">

                 <div class="navbar-identity">


            <img src="images/edatabay.png" alt="companyLogo">


            </div>



                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        
                    </ul>
                    <ul class="nav navbar-nav ml-auto navbar-right">
                        <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"></a>
                        </li>
                    </ul>
                </div>
                    <!--/.nav-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
        <!-- /.header -->

    <div class="main-container">
        <div class="container">

            <?php echo display_errors($errors); ?>

            <div class="row">
                <div class="col-md-8 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2"><i class="icon-user-add"></i> Create an account </h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <form action="<?php echo "user.php"; ?>" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group row required">

                                            <div class="col-md-6">
                                               
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group  row required">
                                            <label class="col-md-4 control-label">First Name <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input name="firstName" placeholder="First Name" class="form-control input-md" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label class="col-md-4 control-label">Last Name <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input name="lastName" placeholder="Last Name" class="form-control input-md" type="text">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group  row required">
                                            <label for="inputEmail3" class="col-md-4 control-label">Email <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control" placeholder="Email" name="emailAddress">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputstreet" class="col-md-4 control-label">Address Line 1 <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Street Number" name="addressLine1">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputstreet2" class="col-md-4 control-label">Address Line 2 <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Street Name" name="addressLine2">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputstreet2" class="col-md-4 control-label">Zip Code <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Street Name" name="addressLine3">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputCity" class="col-md-4 control-label">City <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="City" name="cityName">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputCountry" class="col-md-4 control-label">Country <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <select name="countryName" class="form-control">
                                                    <?php
                                                        while($countries_set = mysqli_fetch_assoc($country)) {
                                                            echo "<option value=\"{$countries_set['countryName']}\"";
                                                            if($countries_set['countryName'] == $countries_set['countryName']) {
                                                              echo " selected";
                                                            }
                                                                echo ">{$countries_set['countryName']}</option>";
                                                        }   
                                                    ?>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group  row required">
                                            <label class="col-md-4 control-label">Phone Number <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input name="phoneNumber" placeholder="Phone Number" class="form-control input-md" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputUsername" class="col-md-4 control-label">Username <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Username" name="username">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputPassword" class="col-md-4 control-label">Password <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="password" class="form-control" placeholder="Password" name="password">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputPassword" class="col-md-4 control-label">Confirm Password <sup>*</sup></label>
                                            <div class="col-md-6">
                                                <input type="password" class="form-control" placeholder="Confirm Password" name="password2">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4 control-label"></label>
                                            <div class="col-md-8">
                                                <div style="clear:both"></div>
                                                <input class="btn btn-primary" type="submit" value="Register"/>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->

                <div class="col-md-4 reg-sidebar">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>

                            <h3><strong>List your items for free</strong></h3>

                            <p> On edatabay you can list as many items as you'd like for free! You only get charged a small fee if your item sells.</p>
                        </div>
                        <div class="promo-text-box"><i class=" icon-pencil-circled fa fa-4x icon-color-2"></i>

                            <h3><strong>Manage your items</strong></h3>

                            <p> You can manage your listed items and keep track of all of the bids on your ads.</p>
                        </div>
                        <div class="promo-text-box"><i class="  icon-heart-2 fa fa-4x icon-color-3"></i>

                            <h3><strong>Create a watchlist for items you like</strong></h3>

                            <p> You can create a watchlist for your favourite items so you can keep track of bidding activity.  </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
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
