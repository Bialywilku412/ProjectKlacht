<?php
include('navbar.php');
require_once 'PDO_connect.php';

// Haal de tochten op uit de database
$stmt = $conn->prepare("SELECT ID, Omschrijving, Route, AantalDagen FROM tochten");
$stmt->execute();
$tochten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tochten Overzicht</title>
</head>
<body>
    <h1>Tochten Overzicht</h1>

    <?php if (!empty($tochten)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Omschrijving</th>
                <th>Route</th>
                <th>Aantal Dagen</th>
            </tr>
            <?php foreach ($tochten as $tocht): ?>
                <tr>
                    <td><?= $tocht['ID'] ?></td>
                    <td><?= $tocht['Omschrijving'] ?></td>
                    <td><?= $tocht['Route'] ?></td>
                    <td><?= $tocht['AantalDagen'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Geen tochten gevonden.</p>
    <?php endif; ?>
</body>
</html>
