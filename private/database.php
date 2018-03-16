<?php

  require_once('db_credentials.php');

  function db_connect() {
    
  #$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  #confirm_db_connect();
  #return $connection;

  $host = 'mockebay.mysql.database.azure.com';
  $username = 'webuser@mockebay';
  $password = 'Pa55word!';
  $db_name = 'mockebay';
  
  //Establishes the connection
  $connection = mysqli_init();
  mysqli_real_connect($connection, $host, $username, $password, $db_name, 3306);

  //if (mysqli_connect_errno($conn)) {
  //die('Failed to connect to MySQL: '.mysqli_connect_error());

  confirm_db_connect();
  return $connection;

/*
  $connection = mysqli_init(); 
  mysqli_ssl_set($connection, NULL, NULL, NULL, NULL, NULL); 
  mysqli_real_connect($connection, DB_SERVER, DB_USER, DB_PASS, DB_NAME, 3306);
  confirm_db_connect();
  return $connection;

*/



    
/*
    $connectstr_dbname = 'MockEbay';
    $connectstr_dbhost = '';
    $connectstr_dbusername = '';
    $connectstr_dbpassword = '';
	 
    foreach ($_SERVER as $key => $value) {
      if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
      }
      
      $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
      $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
      $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
    }
    
    $connection = mysqli_connect($connectstr_dbhost, $connectstr_dbusername, $connectstr_dbpassword,$connectstr_dbname);
    
    if (!$connection) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }
    
    echo "<p>Success: A proper connection to MySQL was made!</p>";
    echo "<p>The database is $connectstr_dbname</p>";
    echo "<p>connectstr_dbhost = $connectstr_dbhost</p>";
    echo "<p>Host information: " . mysqli_get_host_info($link) . "</p>";
    echo "<p>connectstr_dbusername: $connectstr_dbusername</p>";

    //confirm_db_connect();
    return $connection;
*/
    
  }

  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

  function confirm_db_connect() {
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
  }

  function confirm_result_set($result_set) {
    if (!$result_set) {
    exit("Database query failed.");
    }
  }

  #db_connect();








  

?>