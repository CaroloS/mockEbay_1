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
    <title>Sale Listing Page</title>
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
               <li class="nav-item"><a href="customerCategory.php" class="nav-link"><i class="icon-th-thumb"></i> Browse Items</a>
               </li>
               <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                  <span>User</span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
                  <ul class="dropdown-menu user-menu dropdown-menu-right">
                     <li class="active dropdown-item"><a href="personalpage.html"><i class="icon-home"></i> Personal Home
                     </a>
                 </li>
                 <li class="dropdown-item"><a href="my-listings.html"><i class="icon-th-thumb"></i> My Listings </a>
                 </li>
                 <li class="dropdown-item"><a href="watchlist.html"><i class="icon-heart"></i> Watchlist </a>
                 </li>
                 <li class="dropdown-item"><a href="bids-purchases.html"><i class="icon-hourglass"></i> Bids / Purchases
                 </a>
             </li>

             <li class="dropdown-item"><a href="login.html"><i class=" icon-logout "></i> Log out </a>
             </li>
         </ul>
     </li>
     <li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-danger nav-link" href="list-items.html">List An Item</a>
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
            <div class="col-md-9 page-content">
                <div class="inner-box category-content">
                    <h2 class="title-2 uppercase"><strong> <i class="icon-docs"></i> List an item to sell
                    </strong></h2>
                    <div class="row">
                        <div class="col-sm-12">


                            <form class="form-horizontal" action="insert.php" method="post">

                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-8">
                                         <select name="categoryGroup" id="category-group" class="form-control">
                                            <option value="0" selected="selected"> Select a category...</option>
                                            <option value="Appliances"> Appliances</option>
                                            <option value="Clothes"> Clothes</option>
                                            <option value="Games">Games</option>
                                            <option value="Home & Garden"> Home And Garden</option>
                                            <option value="Electronics"> Electronics</option>
                                            <option value="Sports"> Sports</option>
                                            <option value="Auto & Parts"> Auto And Parts</option>
                                            <option value="Office Equipment"> Office Equipment</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Sale Type</label>
                                    <div class="col-sm-8">
                                         <select name="saleType" id="category-group" class="form-control">
                                            <option value="0" selected="selected"> Select a sale type</option>
                                            <option value="Auction">Auction</option>
                                            <option value="BuyItNow">Buy it now</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Sale Type</label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="radio1" id="inlineRadio1" value="Auction"> Auction
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="radio1" id="inlineRadio2" value="BuyItNow"> Buy it now
                                            </label>
                                        </div>


                                    </div>
                                </div> -->



                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Item title</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="Adtitle" name="itemTitle" placeholder="Item title">
                                        <small id="" class="form-text text-muted">
                                           
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Item Description</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="Adtitle" name="itemDesc" placeholder="Item Description">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Condition</label>
                                    <div class="col-sm-8">
                                        <select name="conditionGroup" id="category-group" class="form-control">
                                            <option value="0" selected="selected"> Select a condition...</option>
                                            <option value="Brand new with tags">Brand new with tags</option>
                                            <option value="Like New">Like New</option>
                                            <option value="Good">Good</option>
                                            <option value="Some signs of wear">Some signs of wear</option>


                                        </select>
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Start Price <small id="" class="form-text text-muted">
                                        (Auction Only)
                                    </small></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="text" class="form-control" aria-label="Price" name="startPrice">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Reserve Price <small id="" class="form-text text-muted">
                                        (Auction Only)
                                    </small></label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="text" class="form-control" aria-label="Price" name="reservePrice">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Buy It Now Price <small id="" class="form-text text-muted">
                                        (Buy It Now Only)
                                    </small></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="text" class="form-control" aria-label="Price" name="binPrice">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Postage</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">£</span>
                                            <input type="text" class="form-control" aria-label="Price" name="postagePrice">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Returns Accepted?</label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="radio2" id="inlineRadio1" value="Yes"> Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="radio2" id="inlineRadio2" value="No"> No
                                            </label>
                                        </div>


                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Start Date <small id="" class="form-text text-muted">
                                        Format: yyyy-mm-dd
                                    </small></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"></span>
                                            <input type="datetime-local" id="datetime" class="form-control" aria-label="Price" name="startDate">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">End Date <small id="" class="form-text text-muted">
                                        Format: yyyy-mm-dd
                                    </small></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"></span>
                                            <input type="datetime-local" id="datetime" class="form-control" aria-label="Price" name="endDate">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="textarea">Image URL</label>


                                    <div class="col-lg-8">
                                        <div class="mb10">
                                            <input type="text" class="form-control" aria-label="Price" name="imageURL">
                                        </div>

                                    </div>
                                </div>




                                <!-- Button  -->
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>

                                    <div class="col-sm-8"><input class="btn btn-block btn-primary" type="submit" value="List Item" ></div>
                                   </div>


                               </form>

                           </div>
                       </div>
                   </div>
               </div>
               <!-- /.page-content -->




           </div>
           <!-- /.row -->
       </div>
       <!-- /.container -->
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


    <!-- include jquery file upload plugin  -->
    <script src="assets/js/fileinput.min.js" type="text/javascript"></script>
    <script>
    // initialize with defaults
    $("#input-upload-img1").fileinput();
    $("#input-upload-img2").fileinput();
    $("#input-upload-img3").fileinput();
    $("#input-upload-img4").fileinput();
    $("#input-upload-img5").fileinput();
</script>
</body>
</html>
