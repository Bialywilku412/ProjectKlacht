<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de gegevens op uit het formulier
    $statusID = $_POST['statusID'];
    $statusCode = $_POST['statusCode'];
    $statusNaam = $_POST['statusNaam'];

    // Controleer of "Verwijderbaar" is aangevinkt
    $verwijderbaar = isset($_POST['verwijderbaar']) ? 1 : 0;

    // Controleer of "PINtoekennen" is aangevinkt
    $pinToekennen = isset($_POST['pinToekennen']) ? 1 : 0;

    // Update de status in de database
    $updateStmt = $conn->prepare("UPDATE statussen SET StatusCode = :code, Status = :naam, Verwijderbaar = :verwijderbaar, PINtoekennen = :pinToekennen WHERE ID = :statusID");
    $updateStmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
    $updateStmt->bindParam(':code', $statusCode, PDO::PARAM_INT);
    $updateStmt->bindParam(':naam', $statusNaam, PDO::PARAM_STR);
    $updateStmt->bindParam(':verwijderbaar', $verwijderbaar, PDO::PARAM_INT);
    $updateStmt->bindParam(':pinToekennen', $pinToekennen, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        echo "Status succesvol bijgewerkt!";
    } else {
        echo "Fout bij het bijwerken van de status.";
        print_r($updateStmt->errorInfo()); // Toon eventuele foutinformatie
    }
}

// Haal alle statussen op voor de dropdown
$sql = "SELECT ID, StatusCode, Status, Verwijderbaar, PINtoekennen FROM statussen";
$stmt = $conn->query($sql);

if (!$stmt) {
    die('Query failed: ' . $conn->errorInfo()[2]);
}

$statussen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Bijwerken</title>
</head>
<body>
    <h1>Status Bijwerken</h1>

    <form action="" method="post">
        <label for="statusID">Selecteer een status:</label>
        <select name="statusID" onchange="populateFields()">
            <?php foreach ($statussen as $status): ?>
                <option value="<?= $status['ID']; ?>"><?= $status['StatusCode'] . ' - ' . $status['Status']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="statusCode">Status Code:</label>
        <input type="number" name="statusCode" id="statusCode" required>
        <br>
        <label for="statusNaam">Status Naam:</label>
        <input type="text" name="statusNaam" id="statusNaam" required>
        <br>
        <label>Verwijderbaar:</label>
        <input type="checkbox" name="verwijderbaar" id="verwijderbaar">
        <br>
        <label>PINtoekennen:</label>
        <input type="checkbox" name="pinToekennen" id="pinToekennen">
        <br>
        <input type="submit" name="bijwerken" value="Bijwerken">
    </form>

    <script>
        function populateFields() {
            var selectedStatusId = document.querySelector("select[name='statusID']").value;

            // Zoek de geselecteerde status in de lijst
            var selectedStatus = <?= json_encode($statussen); ?>.find(function (status) {
                return status.ID == selectedStatusId;
            });

            // Vul de inputvelden met de informatie van de geselecteerde status
            document.getElementById("statusCode").value = selectedStatus.StatusCode;
            document.getElementById("statusNaam").value = selectedStatus.Status;
            document.getElementById("verwijderbaar").checked = selectedStatus.Verwijderbaar == 1;
            document.getElementById("pinToekennen").checked = selectedStatus.PINtoekennen == 1;
        }

        // Roep populateFields() aan zodra de pagina is geladen
        document.addEventListener("DOMContentLoaded", function () {
            populateFields();
        });
    </script>

</body>
</html>
