<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Initialisatie van variabelen
$statusCode = '';
$statusNaam = '';
$verwijderbaar = 0;
$pinToekennen = 0;

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de gegevens op uit het formulier
    $statusCode = $_POST['statusCode'];
    $statusNaam = $_POST['statusNaam'];

    // Controleer of "Verwijderbaar" is aangevinkt
    if (isset($_POST['verwijderbaar'])) {
        $verwijderbaar = 1;
    }

    // Controleer of "PINtoekennen" is aangevinkt
    if (isset($_POST['pinToekennen'])) {
        $pinToekennen = 1;
    }

    // Voeg de status toe aan de database
    $insertStmt = $conn->prepare("INSERT INTO statussen (StatusCode, Status, Verwijderbaar, PINtoekennen) VALUES (:code, :naam, :verwijderbaar, :pinToekennen)");
    $insertStmt->bindParam(':code', $statusCode, PDO::PARAM_INT);
    $insertStmt->bindParam(':naam', $statusNaam, PDO::PARAM_STR);
    $insertStmt->bindParam(':verwijderbaar', $verwijderbaar, PDO::PARAM_INT);
    $insertStmt->bindParam(':pinToekennen', $pinToekennen, PDO::PARAM_INT);

    if ($insertStmt->execute()) {
        echo "Status succesvol toegevoegd!";
    } else {
        echo "Fout bij het toevoegen van de status.";
        print_r($insertStmt->errorInfo()); // Toon eventuele foutinformatie
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Toevoegen</title>
</head>
<body>
    <h1>Status Toevoegen</h1>

    <form action="" method="post">
        <label for="statusCode">Status Code:</label>
        <input type="number" name="statusCode" required>
        <br>
        <label for="statusNaam">Status Naam:</label>
        <input type="text" name="statusNaam" required>
        <br>
        <label>Verwijderbaar:</label>
        <input type="checkbox" name="verwijderbaar">
        <br>
        <label>PINtoekennen:</label>
        <input type="checkbox" name="pinToekennen">
        <br>
        <input type="submit" name="toevoegen" value="Toevoegen">
    </form>

</body>
</html>
