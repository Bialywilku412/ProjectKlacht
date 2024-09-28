<?php
include('navbar.php');
require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verwerk het formulier wanneer het wordt ingediend
    $tochtID = $_POST['tochtID'];
    $omschrijving = $_POST['omschrijving'];
    $route = $_POST['route'];
    $aantalDagen = $_POST['aantalDagen'];

    // Update de tocht in de database
    $sql = "UPDATE tochten 
            SET Omschrijving = :omschrijving, Route = :route, AantalDagen = :aantalDagen
            WHERE ID = :tochtID";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':tochtID', $tochtID);
    $stmt->bindParam(':omschrijving', $omschrijving);
    $stmt->bindParam(':route', $route);
    $stmt->bindParam(':aantalDagen', $aantalDagen);

    if ($stmt->execute()) {
        echo "Tocht is succesvol bijgewerkt.";
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van de tocht: " . $stmt->errorInfo()[2];
    }
}

// Haal alle tochten op voor de dropdown
$sql = "SELECT ID, Omschrijving, Route, AantalDagen FROM tochten";
$stmt = $conn->query($sql);

if (!$stmt) {
    die('Query failed: ' . $conn->errorInfo()[2]);
}

$tochten = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tocht</title>
    <script>
    function populateFields() {
        var selectedTochtId = document.getElementById("tochtID").value;

        // Zoek de geselecteerde tocht in de lijst
        var selectedTocht = <?php echo json_encode($tochten); ?>.find(function (tocht) {
            return tocht.ID == selectedTochtId;
        });

        // Vul de inputvelden met de informatie van de geselecteerde tocht
        document.getElementById("omschrijving").value = selectedTocht.Omschrijving;
        document.getElementById("route").value = selectedTocht.Route;
        document.getElementById("aantalDagen").value = selectedTocht.AantalDagen;
    }

    // Roep populateFields() aan zodra de pagina is geladen
    document.addEventListener("DOMContentLoaded", function () {
        populateFields();
    });
    </script>
</head>
<body>
    <h2>Update Tocht</h2>
    <form action="" method="post" id="updateForm">
        <label for="tochtID">Selecteer een tocht:</label>
        <select name="tochtID" id="tochtID" onchange="populateFields()">
            <?php foreach ($tochten as $tocht): ?>
                <option value="<?php echo $tocht['ID']; ?>"><?php echo $tocht['Omschrijving']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="omschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving" id="omschrijving" required>
        <br>
        <label for="route">Route:</label>
        <input type="text" name="route" id="route" required>
        <br>
        <label for="aantalDagen">Aantal Dagen:</label>
        <input type="number" name="aantalDagen" id="aantalDagen" required>
        <br>
        <input type="submit" name="submit" value="Bijwerken">
    </form>
</body>
</html>
