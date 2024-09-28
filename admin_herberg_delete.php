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
            $herbergID = $_POST['herberg'];

            // Verwijder de herberg en gerelateerde gegevens
            $verwijderStmt = $conn->prepare("DELETE FROM herbergen WHERE ID = :herberg_id");
            $verwijderStmt->bindParam(':herberg_id', $herbergID, PDO::PARAM_INT);

            if ($verwijderStmt->execute()) {
                // Voeg hier extra logica toe om gerelateerde gegevens te verwijderen
                echo "Herberg succesvol verwijderd!";
            } else {
                echo "Fout bij het verwijderen van de herberg.";
                print_r($verwijderStmt->errorInfo()); // Toon eventuele foutinformatie
            }
        }
    }

    // Haal de herbergen op uit de database
    $stmt = $conn->prepare("SELECT ID, Naam FROM herbergen");
    $stmt->execute();
    $herbergen = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Herberg Verwijderen</title>
</head>
<body>
    <h1>Herberg Verwijderen</h1>

    <form action="" method="post">
    Herberg:
    <select id="herbergDropdown" name="herberg" required>
        <?php foreach ($herbergen as $herberg): ?>
            <option value="<?= $herberg['ID'] ?>"><?= $herberg['Naam'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" name="verwijderen" value="Verwijderen">
</form>

</body>
</html>