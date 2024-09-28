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
            $restaurantID = $_POST['restaurant'];

            // Verwijder het restaurant en gerelateerde gegevens
            $verwijderStmt = $conn->prepare("DELETE FROM restaurants WHERE ID = :restaurant_id");
            $verwijderStmt->bindParam(':restaurant_id', $restaurantID, PDO::PARAM_INT);

            if ($verwijderStmt->execute()) {
                // Voeg hier extra logica toe om gerelateerde gegevens te verwijderen
                echo "Restaurant succesvol verwijderd!";
            } else {
                echo "Fout bij het verwijderen van het restaurant.";
                print_r($verwijderStmt->errorInfo()); // Toon eventuele foutinformatie
            }
        }
    }

    // Haal de restaurants op uit de database
    $stmt = $conn->prepare("SELECT ID, Naam FROM restaurants");
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Restaurant Verwijderen</title>
</head>
<body>
    <h1>Restaurant Verwijderen</h1>

    <form action="" method="post">
    Restaurant:
    <select id="restaurantDropdown" name="restaurant" required>
        <?php foreach ($restaurants as $restaurant): ?>
            <option value="<?= $restaurant['ID'] ?>"><?= $restaurant['Naam'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" name="verwijderen" value="Verwijderen">
</form>

</body>
</html>
