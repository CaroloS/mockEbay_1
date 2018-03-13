        <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
            <div class="container">
                <div class="navbar-identity">
                    <a href="categoryCustomer.php" class="navbar-brand logo logo-title"><img src="images/edatabay.png" alt="edatabay"></a>
            </div>


        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav ml-auto navbar-right">
                <li class="nav-item"><a href="categoryCustomer.php" class="nav-link"><i class="icon-th-thumb"></i> Browse Items</a>
                </li>
                <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="icon-user fa"></i>
                <span><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];?></span>
                <i class=" icon-down-open-big fa"></i></a>
                    <ul class="dropdown-menu user-menu dropdown-menu-right">
                    <li class="dropdown-item"><a href="personalpage.php"><i class="icon-user fa"></i> My account</a>
                </li>
                <li class="dropdown-item"><a href="myListings.php"><i class="icon-user fa"></i> My Listings</a>
                </li>
                <li class="dropdown-item"><a href="watchlist.php"><i class="icon-user fa"></i> Watchlist</a>
                </li>
                <li class="dropdown-item"><a href="bidsPurchases.php"><i class="icon-user fa"></i> Bids/Purchases</a>
                </li>
<!--                 <li class="dropdown-item"><a href="#"><i class="icon-key"></i> Change Password </a>
                </li> -->
                <li class="dropdown-item"><a href="logout.php"><i class=" icon-logout "></i> Log out </a>
                </li>
            </ul>
        </li>
        <li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-danger nav-link" href="listItems.php">LIST AN ITEM</a>
        </li>

    </ul>
</div>
<!--/.nav-collapse -->
</div>
<!-- /.container-fluid -->
</nav>
</div>