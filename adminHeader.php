 <div class="header">
            <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
                 role="navigation">
                <div class="container">

                <div class="navbar-identity">

                    <a href="categoryAdmin.php" class="navbar-brand logo logo-title">
                    <img src="images/edatabay.png" alt="Available on the App Store">
                    </a>

                </div>

                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav ml-auto navbar-right">
<!--                             <li class="nav-item"><a href="categoryAdmin.php" class="nav-link"><i class="icon-th-thumb"></i> Browse Items</a>
                            </li> -->
                            <li class="dropdown no-arrow nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="icon-user fa"></i>
                                <span><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];?></span>
                                <i class=" icon-down-open-big fa"></i></a>
                                <ul class="dropdown-menu user-menu dropdown-menu-right">
                                    <li class="active dropdown-item"><a href="personalpage.php"><i class="icon-user fa"></i> My Account
                                    </a>
                                    </li>
                                    <li class="dropdown-item"><a href="<?php echo "employee.php"?>"><i class="icon-user fa"></i> Add Employee </a>
                                    </li>
                                    <li class="dropdown-item"><a href="admin-all-users.php"><i class="icon-user fa"></i> All Users </a>
                                    </li>
                                    <li class="dropdown-item"><a href="admin-all-listings.php"><i class="icon-user fa"></i> All Listings </a>
                                    </li>
                                    <li class="dropdown-item"><a href="logout.php"><i class=" icon-logout "></i> Log out </a>
                                    </li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
        <!-- /.header -->
  