<?php 
    include_once('private/initialise.php');

    if(is_post_request()) {

      $login = [];
      $login['username'] = $_POST['username'];
      $login['password'] = $_POST['password'];

      $result = user_login($login);

      if($result === true) {
        user_session($login);
            if ($_SESSION['description'] === 'Customer') {
                $location = 'categoryCustomer.php';
                header("Location: " . $location);
                exit();
            } elseif ($_SESSION['description'] === 'Employee') {
                $location = 'categoryAdmin.php';
                header("Location: " . $location);
                exit();
            }
      } else {
      	$errors = $result;
      }
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
    <title>Ebaydata - Login</title>
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
            <div class="row">
                <div class="col-sm-5 login-box">
                    <div class="card card-default">
                        <div class="panel-intro text-center">
                            <h2 class="logo-title">
                                <!-- Original Logo will be placed here  -->
                                <span class="logo-icon"><i
                                        class="icon icon-search-1 ln-shadow-logo shape-0"></i> </span> EDATA<span>BAY </span>
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo "index.php"; ?>" method="post">
                                <div class="form-group">
                                    <label for="sender-email" class="control-label">Username: <sup>*</sup></label>

                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input id="username" type="text"
                                               class="form-control email" required="" name="username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user-pass" class="control-label">Password: <sup>*</sup></label>

                                    <div class="input-icon"><i class="icon-lock fa"></i>
                                        <input type="password" class="form-control" id="password" required="" name="password">
                                    </div>
                                </div>
                                <div>
                                    <input class="btn btn-primary  btn-block" type="submit" value="Login"/>
                                </div>
                            </form>
                        </div>
<!--                         <div class="card-footer">
                            <div class="checkbox pull-left">
                            </div>
                            <p class="text-center"><a href="forgot-password.html"> Lost your password?</a>
                            </p>

                            <div style=" clear:both"></div>
                        </div> -->
                    </div>
                    <div class="login-box-btm text-center">
                        <p> Don't have an account? <br>
                            <a href="<?php echo "user.php"; ?>"><strong>Sign Up!</strong> </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.main-container -->

<!--     <footer class="main-footer">
    <!-- /.footer -->
</div>
<!-- /.wrapper -->

<!-- Modal Change City -->

<!-- /.modal -->

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
