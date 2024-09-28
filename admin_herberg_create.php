<?php
session_start();
include('navbar.php');
require_once 'PDO_connect.php';

// Controleer of de gebruiker is ingelogd en een admin is
if (isset($_SESSION['klant_id']) && $_SESSION['rol'] === 'Admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verwerk het formulier voor het toevoegen van een herberg
        $naam = $_POST['naam'];
        $adres = $_POST['adres'];
        $email = $_POST['email'];
        $telefoon = $_POST['telefoon'];
        $coordinaten = $_POST['coordinaten'];

        $insertStmt = $conn->prepare("INSERT INTO herbergen (Naam, Adres, Email, Telefoon, Coordinaten) 
                                      VALUES (:naam, :adres, :email, :telefoon, :coordinaten)");
        $insertStmt->bindParam(':naam', $naam, PDO::PARAM_STR);
        $insertStmt->bindParam(':adres', $adres, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':telefoon', $telefoon, PDO::PARAM_STR);
        $insertStmt->bindParam(':coordinaten', $coordinaten, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            echo "Herberg succesvol toegevoegd!";
        } else {
            echo "Fout bij het toevoegen van de herberg.";
        }
    }
} else {
    echo "Toegang geweigerd.";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herberg Toevoegen</title>
</head>
<body>
    <h1>Herberg Toevoegen</h1>

    <form action="" method="post">
        Naam: <input type="text" name="naam" required><br>
        Adres: <input type="text" name="adres" required><br>
        Email: <input type="email" name="email" required><br>
        Telefoon: <input type="tel" name="telefoon" required><br>
        Coördinaten: <input type="text" name="coordinaten" required><br>
        <input type="submit" value="Toevoegen">
    </form>
</body>
</html>
