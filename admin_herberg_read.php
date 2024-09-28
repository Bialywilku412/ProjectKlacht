<?php
session_start();
include('navbar.php');
require_once 'PDO_connect.php';

// Haal de herbergen op uit de database
$stmt = $conn->prepare("SELECT ID, Naam, Adres, Email, Telefoon, Coordinaten, Gewijzigd FROM herbergen");
$stmt->execute();
$herbergen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbergen Overzicht</title>
</head>
<body>
    <h1>Herbergen Overzicht</h1>

    <?php if (!empty($herbergen)): ?>
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
                <?php foreach ($herbergen as $herberg): ?>
                    <tr>
                        <td><?= $herberg['ID'] ?></td>
                        <td><?= $herberg['Naam'] ?></td>
                        <td><?= $herberg['Adres'] ?></td>
                        <td><?= $herberg['Email'] ?></td>
                        <td><?= $herberg['Telefoon'] ?></td>
                        <td><?= $herberg['Coordinaten'] ?></td>
                        <td><?= $herberg['Gewijzigd'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen herbergen gevonden.</p>
    <?php endif; ?>
</body>
</html>
