<?php
session_start(); // Start de sessie

require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd
if(isset($_SESSION['klant_id'])) {
    $klantID = $_SESSION['klant_id'];

    // Haal boekingen op uit de database voor de ingelogde klant
    $stmt = $conn->prepare("SELECT boekingen.ID, boekingen.StartDatum, boekingen.PINCode, boekingen.FKtochtenID, tochten.Omschrijving, tochten.AantalDagen 
                            FROM boekingen 
                            INNER JOIN tochten ON boekingen.FKtochtenID = tochten.ID 
                            WHERE boekingen.FKklantenID = :klantID");
    $stmt->bindParam(':klantID', $klantID);
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Als de gebruiker niet is ingelogd, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Gebruiker is niet ingelogd."; // Of voeg een redirect toe naar de inlogpagina
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boekingen Overzicht</title>
</head>
<body>
    <h1>Boekingen Overzicht</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>StartDatum</th>
            <th>EindDatum</th>
            <th>PINCode</th>
            <th>Tocht</th>
            <th>Acties</th>
        </tr>
        <?php foreach ($boekingen as $boeking): ?>
            <tr>
                <td><?= $boeking['ID'] ?></td>
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
                <td>
                    <a href="vraag_pin.php?id=<?= $boeking['ID'] ?>">Vraag PIN</a> |
                    <a href="intrekken_pin.php?id=<?= $boeking['ID'] ?>">Intrekken PIN</a> |
                    <a href="preview_route.php?id=<?= $boeking['ID'] ?>">Preview Route</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
