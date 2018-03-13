<?php 
include_once('../private/initialise.php');

	require_login();	

	// $id = get_user_id($_SESSION['username']); 

	// $_SESSION['id'] = $id['0'];

	echo $_SESSION['id'];

	echo "<br> sessions user details " . $_SESSION['username'] . "<br>" . $_SESSION['contactID']
			. "<br>" . $_SESSION['description'] . "<br>" . $_SESSION['emailAddress']
			 . "<br>" . $_SESSION['buyerID']  . "<br>" . $_SESSION['sellerID'];

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Home Page</title>
    <meta charset="utf-8">
	
	<!-- include css file here-->
   <link rel="stylesheet" href="css/style.css"/>
   
	<!-- include JavaScript file here-->
  
  </head>	
  <body>
	<div class="container">
		<div class="main">

			<h1>Welcome to the Auction Site</h1>

			<h3><a href="<?php echo "edit.php?username=". $_SESSION['username']; ?>">View or Edit Account</a></h3>

			<h3><a href="<?php echo "personalpage.php?username=". $_SESSION['username']; ?>">Static User Page</a></h3>

			<div>
                <a href="<?php echo "logout.php"; ?>"><input class="btn btn-primary  btn-block" type="submit" value="Logout"/>
            </div>

		</div>
  </body>
</html>