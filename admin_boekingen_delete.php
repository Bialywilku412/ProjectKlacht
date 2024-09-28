<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd en een admin is
if (isset($_SESSION['klant_id']) && $_SESSION['rol'] === 'Admin') {
    // Controleer of het formulier is ingediend
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Controleer of de 'verwijderen'-knop is ingediend
        if (isset($_POST['verwijderen'])) {
            $boekingID = $_POST['boeking'];

            // Verwijder de boeking en gerelateerde gegevens
            $verwijderStmt = $conn->prepare("DELETE FROM boekingen WHERE ID = :boeking_id");
            $verwijderStmt->bindParam(':boeking_id', $boekingID, PDO::PARAM_INT);

            if ($verwijderStmt->execute()) {
                // Voeg hier extra logica toe om gerelateerde gegevens te verwijderen
                echo "Boeking succesvol verwijderd!";
            } else {
                echo "Fout bij het verwijderen van de boeking.";
            }

        } else {
        }
    }

    // Haal de boekingen op uit de database
    $stmt = $conn->prepare("SELECT ID, StartDatum FROM boekingen");
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Als de gebruiker niet is ingelogd of geen admin is, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Toegang geweigerd."; 
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boeking Verwijderen</title>
</head>
<body>
    <h1>Boeking Verwijderen</h1>

    <form action="" method="post">
        Boeking:
        <select id="boekingDropdown" name="boeking" required>
            <?php foreach ($boekingen as $boeking): ?>
                <option value="<?= $boeking['ID'] ?>"><?= $boeking['StartDatum'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" name="verwijderen" value="Verwijderen">
    </form>
</body>
</html>
