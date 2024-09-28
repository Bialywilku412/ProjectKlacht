<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd en een admin is
if (isset($_SESSION['klant_id']) && $_SESSION['rol'] === 'Admin') {
    // Haal de gasten op uit de database
    $stmt = $conn->prepare("SELECT * FROM klanten");
    $stmt->execute();
    $gasten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Gasten</title>
</head>
<body>
    <h1>Overzicht Gasten</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Email</th>
            <th>Telefoonnummer</th>
            <!-- Voeg hier meer kolommen toe afhankelijk van de informatie die je wilt tonen -->
        </tr>
        <?php foreach ($gasten as $gast): ?>
            <tr>
                <td><?= $gast['ID'] ?></td>
                <td><?= $gast['Naam'] ?></td>
                <td><?= $gast['Email'] ?></td>
                <td><?= $gast['Telefoon'] ?></td>
                <!-- Voeg hier meer kolommen toe afhankelijk van de informatie die je wilt tonen -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php
} else {
    // Als de gebruiker niet is ingelogd of geen admin is, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Toegang geweigerd."; // Of voeg een redirect toe naar een foutpagina
}
?>
