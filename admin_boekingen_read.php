<?php
include('navbar.php');
session_start(); // Start de sessie

require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd en een admin is
if (isset($_SESSION['klant_id']) && $_SESSION['rol'] === 'Admin') {
    // Haal alle boekingen op uit de database
    $stmt = $conn->prepare("SELECT boekingen.StartDatum, boekingen.PINCode, tochten.Omschrijving, tochten.AantalDagen, statussen.Status, klanten.Naam as KlantNaam, klanten.Email, klanten.Telefoon 
                            FROM boekingen 
                            LEFT JOIN tochten ON boekingen.FKtochtenID = tochten.ID
                            LEFT JOIN statussen ON boekingen.FKstatussenID = statussen.ID
                            LEFT JOIN klanten ON boekingen.FKklantenID = klanten.ID");
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Als de gebruiker niet is ingelogd of geen admin is, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Toegang geweigerd."; // Of voeg een redirect toe naar een foutpagina
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boekingen Overzicht</title>
</head>
<body>
    <h1>Boekingen Overzicht</h1>

    <table border="1">
        <tr>
            <th>StartDatum</th>
            <th>EindDatum</th>
            <th>PINCode</th>
            <th>Tocht</th>
            <th>AantalDagen</th>
            <th>Status</th>
            <th>KlantNaam</th>
            <th>Email</th>
            <th>Telefoon</th>
        </tr>
        <?php foreach ($boekingen as $boeking): ?>
            <tr>
                <td><?= $boeking['StartDatum'] ?></td>
                <td>
                    <?php
                        // Bereken de einddatum
                        $startDatum = new DateTime($boeking['StartDatum']);
                        $aantalDagen = $boeking['AantalDagen'];
                        $eindDatum = $startDatum->add(new DateInterval("P{$aantalDagen}D"));
                        echo $eindDatum->format('Y-m-d');
                    ?>
                </td>
                <td><?= $boeking['PINCode'] ?></td>
                <td><?= $boeking['Omschrijving'] ?></td>
                <td><?= $boeking['AantalDagen'] ?></td>
                <td><?= $boeking['Status'] ?></td>
                <td><?= $boeking['KlantNaam'] ?></td>
                <td><?= $boeking['Email'] ?></td>
                <td><?= $boeking['Telefoon'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
