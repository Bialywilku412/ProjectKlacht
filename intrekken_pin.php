<?php
// intrekken_pin.php

require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $boekingID = $_GET['id'];

    // Controleer of de boeking bestaat en of er een PIN-code is ingesteld
    $stmt = $conn->prepare("SELECT * FROM boekingen WHERE ID = :id AND PINCode IS NOT NULL");
    $stmt->bindParam(':id', $boekingID);
    $stmt->execute();
    $boeking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($boeking) {
        // Wis de PIN-code
        $stmt = $conn->prepare("UPDATE boekingen SET PINCode = NULL WHERE ID = :id");
        $stmt->bindParam(':id', $boekingID);

        if ($stmt->execute()) {
            echo "PIN-code ingetrokken.";
        } else {
            echo "Er is een fout opgetreden bij het intrekken van de PIN-code.";
        }
    } else {
        echo "Geen geldige boeking gevonden of er is geen PIN-code ingesteld.";
    }
}
?>
