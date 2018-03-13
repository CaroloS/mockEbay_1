<?php
$message='';
$db= new mysqli('localhost','phoebestaab','602211qaz','MockEbay');

if($db->connect_error){
    $message=$db->connect_error;
}
else{ 

    // session_start();

    
    $userID=2;
    $buyerID=3002;
    $saleID=1002;


    if (isset($_GET['saleID'])) {
      $saleID= $_GET['saleID'];
} 

    // $sql='SELECT * FROM watchedSalesData';
    // $result= $db->query($sql);


    $sql="SELECT imageURL, productName FROM watchedsalesdata WHERE saleID <> '$saleID' AND buyerID IN 
    (SELECT buyerID FROM watchedsalesdata WHERE saleID='$saleID'AND buyerID <> '$buyerID') ";
    $result= $db->query($sql);

    if($db->error){
        $message= $db->error;
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
</body>

<footer class="main-footer">
  <div class="footer-content">
    <div class="container">
      <div class="col-xl-12 content-box" style=" width: 58%; margin-left: 165px;">
                 <div class="row row-featured">
                     <div class="col-xl-12  box-title ">
                        <div class="inner"><h2>Others who saved this item also liked... </h2>
                        </div>
                    </div>

                    <?php while($row = $result-> fetch_assoc()){ 
                    ?>
                         <div class="col-xl-4  box-title " style="border-right: 10px; border-left: 10px; text-align:center;">
                             <h2><a href="#"><?php echo $row['productName']; ?></a></h2>
                                <img src="images/<?php echo $row['imageURL']; ?>">
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
  </div>
</footer>

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



    <!-- bxSlider Javascript file -->
    <script src="assets/plugins/bxslider/jquery.bxslider.min.js"></script>
    <script>
        $('.bxslider').bxSlider({
            pagerCustom: '#bx-pager'
        });

    </script>

</body>
</html>
