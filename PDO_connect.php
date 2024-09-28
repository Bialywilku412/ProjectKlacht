<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "klacht_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbinding met de database is geslaagd!";
} catch(PDOException $e) {
    echo "Verbinding met de database is mislukt: " . $e->getMessage();
}
?>
