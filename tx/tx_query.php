<html>
  <title>
    Transaction Query Results
  </title>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      Transaction ID: <input type="text" name="txID">    
      <input type="submit" value="Find">
    </form>
    <?php
    
      /* define variables, set to empty */
      $txID = $pregMatch = "";
    
      if ($_SERVER["REQUEST_METHOD] == "POST") {
        $txID = validate_input($_POST["txID"]);
        $pregMatch = pattern_match($txID);
        
        /* Check that the Transaction ID entered matches the expected patter of TX12345678901234 */
        if ($pregMatch = 0 then) {
          /* The Transaction ID supplied does not match the expected format - stopping */
          exit("Invalid Transaction ID");          
        }
      }
      
      function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data
      }
      
      function pattern_match($str) {
        $pattern = "TX[0-9]{14}";
        $result = preg_match($pattern, $str);
        return $result
      }
      
      
      /* Use prepared statements to query Transaction ID on MySQL */
      $servername = "fakeServer"; 
      $username = "";
      $password = "";
      $dnmame = "mpDB";

      /* Connect to the Database */
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      echo "Connected successfully";

      /* prepare the query and bind to variables */
      /* REF: https://www.w3schools.com/php/php_mysql_prepared_statements.asp */
      /* REF: https://phpdelusions.net/mysqli_examples/prepared_select */
      /* REF: https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection */
      $sql = "SELECT txDate, txPayMethod, txComments FROM " + $dbname + " WHERE txID = ?"
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $txID);
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("Transaction not found");
      while($row = $result->fetch_assoc() {
        $txDate = $row["txDate"];
        $txPayMethod = $row["txPayMethod"];
        $txComments = $row["txComments"];
      }
      $stmt->close();
      
      /* Close the database connection */
      mysqli_close($conn); 

      print "Transaction ID: " <?php echo $_POST["txID"]; ?><br>
      print "Transaction Date: " <?php echo $_POST["txDate"]; ?><br>
      print "Payment Method: " <?php echo $_POST["txPayMethod"]; ?><br>
      print "Comments: " <?php echo $_POST["txComments"]; ?><br>
    ?>
  </body>
</html>
