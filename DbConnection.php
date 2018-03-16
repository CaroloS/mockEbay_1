 <?php
 /*
      $message = '';
      $db = new MySQLi('localhost', 'caroline', 'ebay123', 'MockEbay');
      if ($db->connect_error) {
          $message = $db->connect_error;
      } else {
          $message = 'Connection is OK';
      }
echo $message;
*/

  $host = 'mockebay.mysql.database.azure.com';
  $username = 'webuser@mockebay';
  $password = 'Pa55word!';
  $db_name = 'mockebay';
  
  //Establishes the connection
  $db = mysqli_init();
  mysqli_real_connect($db, $host, $username, $password, $db_name, 3306);

?>