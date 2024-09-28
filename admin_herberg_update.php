<?php
include('navbar.php');
session_start(); // Start de sessie
require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verwerk het formulier wanneer het wordt ingediend
    $herbergID = $_POST['herbergID'];
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $telefoon = $_POST['telefoon'];
    $coordinaten = $_POST['coordinaten'];

    // Update de herberg in de database
    $sql = "UPDATE herbergen 
            SET Naam = :naam, Adres = :adres, Email = :email, Telefoon = :telefoon, Coordinaten = :coordinaten
            WHERE ID = :herbergID";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':herbergID', $herbergID);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':adres', $adres);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':coordinaten', $coordinaten);

    if ($stmt->execute()) {
        echo "Herberg is succesvol bijgewerkt.";
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van de herberg: " . $stmt->errorInfo()[2];
    }
}

// Haal alle herbergen op voor de dropdown
$sql = "SELECT ID, Naam, Adres, Email, Telefoon, Coordinaten FROM herbergen";
$stmt = $conn->query($sql);

if (!$stmt) {
    die('Query failed: ' . $conn->errorInfo()[2]);
}

$herbergen = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Herberg</title>
    <script>
    function populateFields() {
        var selectedHerbergId = document.getElementById("herbergID").value;

        // Zoek de geselecteerde herberg in de lijst
        var selectedHerberg = <?php echo json_encode($herbergen); ?>.find(function (herberg) {
            return herberg.ID == selectedHerbergId;
        });

        // Vul de inputvelden met de informatie van de geselecteerde herberg
        document.getElementById("naam").value = selectedHerberg.Naam;
        document.getElementById("adres").value = selectedHerberg.Adres;
        document.getElementById("email").value = selectedHerberg.Email;
        document.getElementById("telefoon").value = selectedHerberg.Telefoon;
        document.getElementById("coordinaten").value = selectedHerberg.Coordinaten;
    }

    // Roep populateFields() aan zodra de pagina is geladen
    document.addEventListener("DOMContentLoaded", function () {
        populateFields();
    });
    </script>
</head>
<body>
    <h2>Update Herberg</h2>
    <form action="" method="post" id="updateForm">
        <label for="herbergID">Selecteer een herberg:</label>
        <select name="herbergID" id="herbergID" onchange="populateFields()">
            <?php foreach ($herbergen as $herberg): ?>
                <option value="<?php echo $herberg['ID']; ?>"><?php echo $herberg['Naam']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="naam">Naam:</label>
        <input type="text" name="naam" id="naam" required>
        <br>
        <label for="adres">Adres:</label>
        <input type="text" name="adres" id="adres" required>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="telefoon">Telefoon:</label>
        <input type="tel" name="telefoon" id="telefoon" required>
        <br>
        <label for="coordinaten">Coördinaten:</label>
        <input type="text" name="coordinaten" id="coordinaten" required>
        <br>
        <input type="submit" name="submit" value="Bijwerken">
    </form>
</body>
</html>
