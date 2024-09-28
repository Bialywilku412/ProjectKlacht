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
            $tochtID = $_POST['tocht'];

            // Verwijder gerelateerde boekingen
            $verwijderBoekingenStmt = $conn->prepare("DELETE FROM boekingen WHERE FKtochtenID = :tocht_id");
            $verwijderBoekingenStmt->bindParam(':tocht_id', $tochtID, PDO::PARAM_INT);

            if ($verwijderBoekingenStmt->execute()) {
                // Verwijder de tocht
                $verwijderTochtStmt = $conn->prepare("DELETE FROM tochten WHERE ID = :tocht_id");
                $verwijderTochtStmt->bindParam(':tocht_id', $tochtID, PDO::PARAM_INT);

                if ($verwijderTochtStmt->execute()) {
                    echo "Tocht succesvol verwijderd!";
                } else {
                    echo "Fout bij het verwijderen van de tocht.";
                    print_r($verwijderTochtStmt->errorInfo()); // Toon eventuele foutinformatie
                }
            } else {
                echo "Fout bij het verwijderen van gerelateerde boekingen.";
                print_r($verwijderBoekingenStmt->errorInfo()); // Toon eventuele foutinformatie
            }
        }
    }

    // Haal de tochten op uit de database
    $stmt = $conn->prepare("SELECT ID, Omschrijving FROM tochten");
    $stmt->execute();
    $tochten = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Tocht Verwijderen</title>
</head>
<body>
    <h1>Tocht Verwijderen</h1>

    <form action="" method="post">
    Tocht:
    <select id="tochtDropdown" name="tocht" required>
        <?php foreach ($tochten as $tocht): ?>
            <option value="<?= $tocht['ID'] ?>"><?= $tocht['Omschrijving'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" name="verwijderen" value="Verwijderen">
</form>

</body>
</html>
