<?php
// vraag_pin.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $boekingID = $_GET['id'];

    // Controleer of de boeking bestaat en de voorwaarden kloppen (definitief en huidige datum valt in de tocht)
    $stmt = $conn->prepare("SELECT * FROM boekingen WHERE ID = :id AND FKstatussenID = 3 AND CURDATE() BETWEEN StartDatum AND (SELECT DATE_ADD(StartDatum, INTERVAL AantalDagen DAY) FROM tochten WHERE ID = FKtochtenID)");
    $stmt->bindParam(':id', $boekingID);
    $stmt->execute();
    $boeking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($boeking) {
        // Genereer en sla de PIN-code op
        $pinCode = mt_rand(1000, 9999); // Genereer een willekeurige 4-cijferige PIN-code
        $stmt = $conn->prepare("UPDATE boekingen SET PINCode = :pinCode WHERE ID = :id");
        $stmt->bindParam(':pinCode', $pinCode);
        $stmt->bindParam(':id', $boekingID);

        if ($stmt->execute()) {
            echo "PIN-code aangevraagd: " . $pinCode;
        } else {
            echo "Er is een fout opgetreden bij het aanvragen van de PIN-code.";
        }
    } else {
        echo "Geen geldige boeking gevonden of niet aan de voorwaarden voldaan.";
    }
}

?>
