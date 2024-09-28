<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Haal de statussen op uit de database
$stmt = $conn->prepare("SELECT ID, StatusCode, Status, Verwijderbaar, PINtoekennen FROM statussen");
$stmt->execute();
$statussen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statussen Overzicht</title>
</head>
<body>
    <h1>Statussen Overzicht</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>StatusCode</th>
            <th>Status</th>
            <th>Verwijderbaar</th>
            <th>PINtoekennen</th>
        </tr>
        <?php foreach ($statussen as $status): ?>
            <tr>
                <td><?= $status['ID'] ?></td>
                <td><?= $status['StatusCode'] ?></td>
                <td><?= $status['Status'] ?></td>
                <td><?= $status['Verwijderbaar'] ?></td>
                <td><?= $status['PINtoekennen'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
