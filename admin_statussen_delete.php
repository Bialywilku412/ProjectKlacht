<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of de 'verwijderen'-knop is ingediend
    if (isset($_POST['verwijderen'])) {
        $statusID = $_POST['status'];

        try {
            // Start een transactie
            $conn->beginTransaction();

            // Verwijder gerelateerde gegevens uit de boekingen, overnachtingen en pauzeplaatsen tabellen
            $deleteBoekingenStmt = $conn->prepare("DELETE FROM boekingen WHERE FKstatussenID = :statusID");
            $deleteBoekingenStmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
            $deleteBoekingenStmt->execute();

            $deleteOvernachtingenStmt = $conn->prepare("DELETE FROM overnachtingen WHERE FKstatussenID = :statusID");
            $deleteOvernachtingenStmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
            $deleteOvernachtingenStmt->execute();

            $deletePauzeplaatsenStmt = $conn->prepare("DELETE FROM pauzeplaatsen WHERE FKstatussenID = :statusID");
            $deletePauzeplaatsenStmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
            $deletePauzeplaatsenStmt->execute();

            // Verwijder de status uit de statussen tabel
            $deleteStatusStmt = $conn->prepare("DELETE FROM statussen WHERE ID = :statusID");
            $deleteStatusStmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
            $deleteStatusStmt->execute();

            // Commit de transactie
            $conn->commit();

            echo "Status en gerelateerde gegevens succesvol verwijderd!";
        } catch (PDOException $e) {
            // Rolleer de transactie bij een fout
            $conn->rollBack();

            echo "Fout bij het verwijderen van de status en gerelateerde gegevens.";
            echo $e->getMessage();
        }
    }
}

// Haal de statussen op uit de database
$stmt = $conn->prepare("SELECT ID, StatusCode, Status FROM statussen");
$stmt->execute();
$statussen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Verwijderen</title>
</head>
<body>
    <h1>Status Verwijderen</h1>

    <form action="" method="post">
        Status:
        <select id="statusDropdown" name="status" required>
            <?php foreach ($statussen as $status): ?>
                <option value="<?= $status['ID'] ?>"><?= $status['StatusCode'] . ' - ' . $status['Status'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" name="verwijderen" value="Verwijderen">
    </form>

</body>
</html>
