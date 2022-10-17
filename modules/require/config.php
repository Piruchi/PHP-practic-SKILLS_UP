<?php
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "newsletters_reg";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully<br>";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "<br>";
}

?>

<?php