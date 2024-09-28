<?php
session_start();
include('navbar.php');
require_once 'PDO_connect.php';

// Haal de restaurants op uit de database
$stmt = $conn->prepare("SELECT ID, Naam, Adres, Email, Telefoon, Coordinaten, Gewijzigd FROM restaurants");
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants Overzicht</title>
</head>
<body>
    <h1>Restaurants Overzicht</h1>

    <?php if (!empty($restaurants)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Adres</th>
                    <th>Email</th>
                    <th>Telefoon</th>
                    <th>Coordinaten</th>
                    <th>Gewijzigd</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurants as $restaurant): ?>
                    <tr>
                        <td><?= $restaurant['ID'] ?></td>
                        <td><?= $restaurant['Naam'] ?></td>
                        <td><?= $restaurant['Adres'] ?></td>
                        <td><?= $restaurant['Email'] ?></td>
                        <td><?= $restaurant['Telefoon'] ?></td>
                        <td><?= $restaurant['Coordinaten'] ?></td>
                        <td><?= $restaurant['Gewijzigd'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen restaurants gevonden.</p>
    <?php endif; ?>
</body>
</html>
