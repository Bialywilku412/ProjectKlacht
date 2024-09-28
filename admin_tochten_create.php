<?php
include('navbar.php');
require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verwerk het formulier wanneer het wordt ingediend
    $omschrijving = $_POST['omschrijving'];
    $route = $_POST['route'];
    $aantalDagen = $_POST['aantalDagen'];

    // Voeg een nieuwe tocht toe aan de database
    $sql = "INSERT INTO tochten (Omschrijving, Route, AantalDagen) VALUES (:omschrijving, :route, :aantalDagen)";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':omschrijving', $omschrijving);
    $stmt->bindParam(':route', $route);
    $stmt->bindParam(':aantalDagen', $aantalDagen);

    if ($stmt->execute()) {
        echo "Tocht is succesvol toegevoegd.";
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van de tocht: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Tocht Toevoegen</title>
</head>
<body>
    <h1>Nieuwe Tocht Toevoegen</h1>

    <form action="" method="post">
        <label for="omschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving" id="omschrijving" required>
        <br>
        <label for="route">Route:</label>
        <input type="text" name="route" id="route" required>
        <br>
        <label for="aantalDagen">Aantal Dagen:</label>
        <input type="number" name="aantalDagen" id="aantalDagen" required>
        <br>
        <input type="submit" name="submit" value="Toevoegen">
    </form>
</body>
</html>
