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
    
      if ($_SERVER["REQUEST_METHOD} == "POST") {
        $txID = validate_input($_POST["txID"]);
        $pregMatch = pattern_match($txID);
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
      
      if ($pregMatch = 0 then) {
        /* The Transaction ID supplied does not match the expected format - stopping */
        exit("Invalid Transaction ID");          
      }
    
      print "Transaction ID: " <?php echo $_POST["txID"]; ?><br>
      print "Transaction Date: " <?php echo $_POST["txDate"]; ?><br>
      print "Payment Method: " <?php echo $_POST["txPayMethod"]; ?><br>
      print "Comments: " <?php echo $_POST["txComments"]; ?><br>
    ?>
  </body>
</html>
