<?php
include('navbar.php');
session_start(); // Start de sessie

require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd
if(isset($_SESSION['klant_id'])) {
    $klantID = $_SESSION['klant_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['boeking'])) {
            echo "Geen boeking geselecteerd.";
            exit();
        }

        // Het opgegeven boeking ID
        $boekingID = $_POST['boeking'];

        // Haal de geselecteerde boeking op uit de database
        $stmt = $conn->prepare("SELECT * FROM boekingen WHERE ID = :id AND FKklantenID = :klantID");
        $stmt->bindParam(':id', $boekingID);
        $stmt->bindParam(':klantID', $klantID);
        $stmt->execute();
        $boeking = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of de boeking bestaat
        if (!$boeking) {
            echo "Geen geldige boeking gevonden.";
            exit();
        }

        // Controleer of de boekingstatus nog niet Definitief is
        if ($boeking['FKstatussenID'] == 3) {
            echo "Deze boeking heeft de status Definitief en kan niet meer verwijderd worden.";
            exit();
        }

        // Verwijder locatiegegevens uit 'overnachtingen'
        $stmt = $conn->prepare("DELETE FROM overnachtingen WHERE FKboekingenID = :boekingID");
        $stmt->bindParam(':boekingID', $boekingID);
        $stmt->execute();

        // Verwijder locatiegegevens uit 'pauzeplaatsen'
        $stmt = $conn->prepare("DELETE FROM pauzeplaatsen WHERE FKboekingenID = :boekingID");
        $stmt->bindParam(':boekingID', $boekingID);
        $stmt->execute();

        // Verwijder de boeking zelf
        $stmt = $conn->prepare("DELETE FROM boekingen WHERE ID = :boekingID");
        $stmt->bindParam(':boekingID', $boekingID);

        if ($stmt->execute()) {
            echo "Boeking succesvol verwijderd.";
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de boeking.";
            var_dump($stmt->errorInfo()); // Laat de eventuele foutmelding zien
        }
    }

} else {
    // Als de gebruiker niet is ingelogd, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Gebruiker is niet ingelogd."; // Of voeg een redirect toe naar de inlogpagina
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boeking Verwijderen</title>
</head>
<body>
    <h1>Boeking Verwijderen</h1>

    <form action="" method="post">
        Boeking:
        <select name="boeking" required>
            <?php 
                $stmt = $conn->prepare("SELECT boekingen.ID, boekingen.StartDatum, boekingen.FKtochtenID, tochten.Omschrijving 
                                    FROM boekingen 
                                    LEFT JOIN tochten ON boekingen.FKtochtenID = tochten.ID 
                                    WHERE boekingen.FKklantenID = :klantID");
                $stmt->bindParam(':klantID', $klantID);
                $stmt->execute();
                $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($boekingen as $boeking):
                    echo "<option value='" . $boeking['ID'] . "'>" . 
                    "Startdatum: " . $boeking['StartDatum'] . 
                    " - Tocht: " . $boeking['Omschrijving'] . 
                    "</option>";
                endforeach;
            ?>
        </select><br>

        <input type="submit" value="Verwijderen">
    </form>
</body>
</html>
