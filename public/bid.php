<?php

	if (isset($_POST['bid'])) {

		$bidValue = $_POST['bid'];

		    if ($bidValue > $highest_bid['bidValue']){

		    	place_bid($auctionID, $bidValue, $buyerID);

		        while($bid_mail_list = mysqli_fetch_assoc($bid_mail)){

			        $bidmessage= $bid_mail_list['firstName'] ." " . $bid_mail_list['lastName']. ", \nA bid of ". $bidValue ." pounds has been made on the product: ". $item['productName'];
			        $subject= "Bid on ". $item['productName'];
			        $email= $bid_mail_list["emailAddress"];
			        mail($email,$subject,$bidmessage); 
		        }
		    } 

	} else {
		echo "<script> alert('Bid must be higher than current highest bid.');</script>";
	}


if (isset($_POST['Watchlist'])) {

	$watchlist = $_POST['Watchlist'];

	if($watchlist === "added_to_watchlist"){

    	$auctionID = get_auction_id($saleID);

    	$buyItNowID = get_buy_id($saleID);

    		if($auctionID['auctionID'] != NULL && $buyItNowID['buyItNowID'] != NULL) {

    			add_watchlist($buyerID, $buyItNowID, $auctionID);

    		}
    }
}



        if ($rowWL['auctionID'] != NULL){
        

        $aucID=$rowWL['auctionID'];
       

        $sql_WL_auc= "INSERT INTO Watchlist ( buyerID, buyItNowID, auctionID) VALUES ('$buyerID', NULL, '$aucID')";
        if ($db->query($sql_WL_auc) === TRUE) {
        echo "<script>
         alert('Item has been added to your watch list.');
         </script>";
            }
        }


        elseif ($rowWL['buyItNowID'] != NULL){
            

        $binID=$rowWL['buyItNowID'];
        

        $sql_WL_bin= "INSERT INTO Watchlist ( buyerID, buyItNowID, auctionID) VALUES ('$buyerID', '$binID', NULL)";
        if ($db->query($sql_WL_bin) === TRUE) {
         echo "<script>
        alert('Item has been added to your watch list.');
        </script>"; 
            }   
        }
}













?>