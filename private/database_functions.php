<?php

	require_once('initialise.php');

	function find_all_countries() {
		global $db;

		$sql = "SELECT * FROM country";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function unique_username($username) {
		global $db;

		$sql = "SELECT username FROM access WHERE username = '" . $username . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$result_count = mysqli_num_rows($result);

		if($result_count) {
			return false;
		} else {
			return true;
		}


	}

	function insert_user($user) {
		global $db;

		$errors = validate_user($user);
		if(!empty($errors)) {
  			return $errors;
  		}

  		$hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

		$sql = "CALL insert_user('" . $user['firstName'] . "', '" . $user['lastName'] . "', '". $user['emailAddress'] . "', '". $user['addressLine1'] . "', '". $user['addressLine2'] . "', '". $user['addressLine3'] . "', '". $user['cityName'] . "', '". $user['countryName'] .  "', '" . $user['phoneNumber'] . "', '". $user['username'] . "', '" . $hashed_password ."' , @`id_Out`)";

		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}


	function update_user($user) {
		global $db;

		$errors = validate_edit_user($user);

		if(!empty($errors)) {
  			return $errors;
  		}
		
		$sql = "CALL update_user('" . $user['firstName'] . "', '" . $user['lastName'] . "', '". $user['emailAddress'] . "', '". $user['addressLine1'] . "', '". $user['addressLine2'] . "', '". $user['addressLine3'] . "', '". $user['cityName'] . "', '". $user['countryName'] .  "', '" . $user['phoneNumber'] . "', '". $user['username'] . "' , @`id_Out`)";

		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function get_user_id($username) {
		global $db;

		$sql = "SELECT userID FROM Users U INNER JOIN Access A ON U.accessID = A.accessID WHERE username = '" . $username . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$id = mysqli_fetch_row($result);
		return $id;
	}

	function get_user_by_id($id) {
		global $db;

		$sql = "SELECT * FROM userdetails WHERE userID= '";
		$sql .= $id . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$user = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $user;

	}

	function find_user($username) {
		global $db;

		$sql = "SELECT username, password FROM userdetails WHERE username= '";
		$sql .= $username . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$user = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $user;
	}

	function user_login($login) {
		global $db;


		$user = find_user($login['username']);

		if($user) {
			if (password_verify($login['password'], $user['password'])) {
				//password matches
				return true;
			} else {
				// username exist, but password not
				echo "<script>alert('Wrong password and/or username. Try again.'); window.location.href='../public/login.php';</script>";
				echo mysqli_error($db);
				db_disconnect($db);
				exit;
			}
		} else {
			//neither password nor username correct
				echo "<script>alert('Wrong password and/or username. Try again.'); window.location.href='../public/login.php';</script>";
				echo mysqli_error($db);
				db_disconnect($db);
				exit;
		}


	}

	function get_item_by_sale_id($saleID) {
		global $db;

		$sql = "SELECT * FROM item_details WHERE saleID = '";
		$sql .= $saleID . "' ";

		#echo $sql;

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$item = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $item;

	}

	// $result = get_item_by_sale_id('1003');
	// echo $result['productName'];
	// echo "<br>";
	// echo $result['itemCondition'];
	// echo "<br>";


	function highest_bid($saleID) {
		global $db;

	$sql = "SELECT * FROM allbiddata WHERE saleID = '";
	$sql .= $saleID . "' ";
	$sql .= "ORDER BY bidValue DESC LIMIT 1";

	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$highest_bid = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $highest_bid;

	}


	// $result2 = highest_bid('1003');

	// echo $result2['bidValue'];
	// echo "<br>";


	function get_all_bids($saleID) {
		global $db;

		$sql = "SELECT * FROM allbiddata WHERE saleID = '";
		$sql .= $saleID . "' ";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;		
	}


	function buyers_emails($saleID) {
		global $db;

		$sql = "SELECT * FROM nodupesemails WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$buyer_email = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $buyer_email;

	}



	// $result = buyers_emails('1092');

	// echo $result['userID'];
	// echo "<br>";
	// mail('daianabassi1@gmail.com',"Auction Ended",'XXXXX', 'hello');


	function purchase_detail($saleID) {
		global $db;

		$sql = "SELECT * FROM purchase WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$purchase = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $purchase; 

	}


	// $result = purchase_detail('1001');

	// echo $result['buyerID'];
	// echo "<br>";


	function is_purchase_complete($saleID) {
		global $db;

		$sql = "SELECT * FROM purchase WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$count = mysqli_num_rows($result);

		if ($count) {
			return true;
		} else {
			return false;
		}

	}

	// $result = is_purchase_complete('1001');
	// echo $result;
	// echo "<br>";



	function create_purchase($saleID, $buyerID, $salePrice, $sellerRated, $buyerRated) {
		global $db;

		$sql = "INSERT INTO Purchase ( saleID, buyerID, salePrice, sellerRated, buyerRated ) VALUES ('";
		$sql .= $saleID . "', '" . $buyerID . "', '" .  $salePrice . "', '" . $sellerRated . "', '" . $buyerRated . "')";

		#echo $sql;
		
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		echo  "<script>alert('Your purchase has been succesful.');</script>";

	}

	#create_purchase('1006','3004', '6', FALSE, FALSE);



	function email_sent($saleID) {
		global $db;

		$sql = "UPDATE Auction SET finalEmailsSent = TRUE WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
	}

	// email_sent('1006');
	// echo "<br>";


	function check_email_sent($saleID) {
		global $db;

		$sql = "SELECT finalEmailsSent FROM Auction WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$email_checked = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $email_checked; 

	}

	// $result = check_email_sent('1006');

	// echo $result['finalEmailsSent'];
	// echo "<br>";

	function get_seller_details($saleID) {
		global $db;

		$sql = "SELECT u.username, u.firstName, u.lastName, u.userID, u.sellerID ";
		$sql .= "FROM userdetails u INNER JOIN sellerdetails s ";
		$sql .= "ON u.userID = s.userID INNER JOIN sale a ";
		$sql .= "ON a.sellerID = s.sellerID WHERE a.saleID =  '";
		$sql .= $saleID . "'"; 

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$seller = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $seller; 


	}

	function get_recommendations($sellerID) {
		global $db;

		$sql = "SELECT DISTINCT i.imageURL, i.productName, i.saleID FROM item_details i";
		$sql .= " WHERE i.sellerID <> '" . $sellerID . "' ";
		$sql .= " AND i.saleID NOT IN (SELECT saleID FROM purchase) LIMIT 3";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;

	}
	
	// $recommendation = get_recommendations('2001');

	// echo "<br>". $recommendation['productName'];


	function get_auction_id($saleID) {
		global $db;

		$sql = "SELECT auctionID FROM auction WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$auctionID = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $auctionID; 
	}

	function get_buy_id($saleID) {
		global $db;

		$sql = "SELECT buyItNowID FROM buyitnow WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$auctionID = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $auctionID; 
	}




	function place_bid($auctionID, $buyerID, $bidValue) {
		global $db;

		$sql = "INSERT INTO bids (auctionID, buyerID, bidValue) VALUES ('";
		$sql .= $auctionID . "', '" . $buyerID . "', '" . $bidValue . "')";

		#echo $sql;

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		if($result) {
			echo "<script>alert('Your bid has been added.'); location.reload(false);</script>";
		} else {
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}

	#place_bid('7015', '50', '3001');

	function send_bid_mail($saleID){
		global $db;

		$sql = "SELECT * FROM nodupesemails WHERE saleID='";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;

	}

	function add_watchlist($saleID, $buyerID, $buyItNowID, $auctionID) {
		global $db;

		$sql_0 = "SELECT buyerID FROM watchedsales WHERE buyerID = '";
		$sql_0 .= $buyerID . "' AND saleID = '";
		$sql_0 .= $saleID . "'";

		#echo $sql_0;

		$result_0 = mysqli_query($db, $sql_0);
		confirm_result_set($result_0);

		$count = mysqli_num_rows($result_0);

		#echo "<br> this is count " . $count;

		if ($count < 1) {

			$sql = "INSERT INTO watchlist (buyerID, buyItNowID, auctionID) VALUES ('";
			$sql .= $buyerID . "', '" . $buyItNowID . "', '" . $auctionID . "')";

			$result = mysqli_query($db, $sql);
			confirm_result_set($result);

			if($result) {
			echo "<script>alert('This item has been added to your watchlist.');</script>";
			} 

		} else {
			echo "<script>alert('You are already watching this item.');</script>";
		}


	}

	function item_sold($saleID) {
		global $db;

		$sql = "SELECT saleID FROM purchase WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$count = mysqli_num_rows($result);

		if ($count == 1) {
			return true;
		} else {
			return false;
		}
	}


	function update_views($saleID) {
		global $db;

		$sql = "UPDATE saledescription SET viewing = viewing + 1 WHERE saleID = '";
		$sql .= $saleID . "'";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
	}


	function insert_employee($user) {
		global $db;

		$errors = validate_user($user);
		if(!empty($errors)) {
  			return $errors;
  		}

  		$hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

		$sql = "CALL insert_employee('" . $user['firstName'] . "', '" . $user['lastName'] . "', '". $user['emailAddress'] . "', '". $user['addressLine1'] . "', '". $user['addressLine2'] . "', '". $user['addressLine3'] . "', '". $user['cityName'] . "', '". $user['countryName'] .  "', '" . $user['phoneNumber'] . "', '". $user['username'] . "', '" . $hashed_password ."' , @`id_Out`)";

		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function delete_sale($saleID) {
		global $db;

		$sql = "CALL  `delete_sale` ('";
		$sql .= $saleID . "', @`id_Out`)";

		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}

	}

	  	function check_bids($auctionID) {
	  		global $db;

	  		$sql = "SELECT COUNT(bidID) FROM bids WHERE auctionID = '";
	  		$sql .= $auctionID . "'";

	  		#echo $sql;

	  		$result = mysqli_query($db, $sql);
			confirm_result_set($result);

			// $bid = mysqli_fetch_assoc($result);
			// mysqli_free_result($result);
			// return $bid; 

			$count = mysqli_num_rows($result);

			if ($count == 1) {
				return true;
			} else {
				return false;
			}
  		
  	}

  	#check_bids('7015');

	function insert_auction($listing) {
		global $db;

		$sql = "CALL insert_auction('" . $listing['categoryHierarchy1'] . "', '" . $listing['productName'] . "', '". $listing['productDescription'] . "', '". $listing['userID'] . "', '". $listing['startDate'] . "', '". $listing['endDate'] . "', '". $listing['postageCost'] . "', '". $listing['returnsAccepted'] .  "', '". $listing['startPrice'] .  "', '". $listing['reservePrice'] .  "', '" . $listing['itemCondititon'] . "', '". $listing['imageURL'] . "' , @`id_Out`)";

		#echo $sql;

		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	// $listing = [];

	// $listing['categoryHierarchy1'] = 'Clothes';
 //    $listing['productName'] = 'Navy Coat';
 //    $listing['productDescription'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 //    $listing['userID'] = '1';  
 //    $listing['startDate'] = '2018-03-13 01:15:28'; 
 //    $listing['endDate'] = '2018-03-14 01:15:28';   
 //    $listing['postageCost'] = '3';    
 //    $listing['returnsAccepted'] = '1'; 
 //    $listing['startPrice'] = '5'; 
 //    $listing['reservePrice'] = '10'; 
 //    $listing['buyItNowPrice'] = NULL;     
 //    $listing['itemCondititon'] = 'Like New'; 
 //    $listing['imageURL'] = 'navy-coat.png';	

 //    $listing['saleType'] = 'Auction';

 //    $success = insert_auction($listing);

 //    echo $success;




		function insert_buyitnow($listing) {
		global $db;

		$sql = "CALL insert_buyitnow('" . $listing['categoryHierarchy1'] . "', '" . $listing['productName'] . "', '". $listing['productDescription'] . "', '". $listing['userID'] . "', '". $listing['startDate'] . "', '". $listing['endDate'] . "', '". $listing['postageCost'] . "', '". $listing['returnsAccepted'] .  "', '". $listing['buyItNowPrice'] .  "', '" . $listing['itemCondititon'] . "', '". $listing['imageURL'] . "' , @`id_Out`)";

		#echo $sql;


		$sql2 = "SELECT @`id_Out`";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		$result2 = mysqli_query($db, $sql2);
		confirm_result_set($result2);

		$output = mysqli_fetch_assoc($result2);

		$var = $output['@`id_Out`'];

		if(isset($var)) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}


/*	$listing = [];

	$listing['categoryHierarchy1'] = 'Sports';
    $listing['productName'] = 'Yoga Mat';
    $listing['productDescription'] = 'sssss';
    $listing['userID'] = '1';  
    $listing['startDate'] = '2018-03-13 01:15:28'; 
    $listing['endDate'] = '2018-03-14 01:15:28';   
    $listing['postageCost'] = '3';    
    $listing['returnsAccepted'] = '1'; 
    $listing['startPrice'] = NULL; 
    $listing['reservePrice'] = NULL; 
    $listing['buyItNowPrice'] = '25';     
    $listing['itemCondititon'] = 'Like New'; 
    $listing['imageURL'] = 'navy-coat.png';	
    $listing['saleType'] = 'Auction';

    insert_buyitnow($listing);*/

    #echo $success;



?>