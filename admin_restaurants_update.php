<?php
include('navbar.php');
session_start(); // Start de sessie
require_once 'PDO_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verwerk het formulier wanneer het wordt ingediend
    $restaurantID = $_POST['restaurantID'];
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $telefoon = $_POST['telefoon'];
    $coordinaten = $_POST['coordinaten'];

    // Update de restaurant in de database
    $sql = "UPDATE restaurants 
            SET Naam = :naam, Adres = :adres, Email = :email, Telefoon = :telefoon, Coordinaten = :coordinaten
            WHERE ID = :restaurantID";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':restaurantID', $restaurantID);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':adres', $adres);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':coordinaten', $coordinaten);

    if ($stmt->execute()) {
        echo "Restaurant is succesvol bijgewerkt.";
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van de restaurant: " . $stmt->errorInfo()[2];
    }
}

// Haal alle restaurants op voor de dropdown
$sql = "SELECT ID, Naam, Adres, Email, Telefoon, Coordinaten FROM restaurants";
$stmt = $conn->query($sql);

if (!$stmt) {
    die('Query failed: ' . $conn->errorInfo()[2]);
}

$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Restaurant</title>
    <script>
    function populateFields() {
        var selectedRestaurantId = document.getElementById("restaurantID").value;

        // Zoek de geselecteerde restaurant in de lijst
        var selectedRestaurant = <?php echo json_encode($restaurants); ?>.find(function (restaurant) {
            return restaurant.ID == selectedRestaurantId;
        });

        // Vul de inputvelden met de informatie van de geselecteerde restaurant
        document.getElementById("naam").value = selectedRestaurant.Naam;
        document.getElementById("adres").value = selectedRestaurant.Adres;
        document.getElementById("email").value = selectedRestaurant.Email;
        document.getElementById("telefoon").value = selectedRestaurant.Telefoon;
        document.getElementById("coordinaten").value = selectedRestaurant.Coordinaten;
    }

    // Roep populateFields() aan zodra de pagina is geladen
    document.addEventListener("DOMContentLoaded", function () {
        populateFields();
    });
    </script>
</head>
<body>
    <h2>Update Restaurant</h2>
    <form action="" method="post" id="updateForm">
        <label for="restaurantID">Selecteer een restaurant:</label>
        <select name="restaurantID" id="restaurantID" onchange="populateFields()">
            <?php foreach ($restaurants as $restaurant): ?>
                <option value="<?php echo $restaurant['ID']; ?>"><?php echo $restaurant['Naam']; ?></option>
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
