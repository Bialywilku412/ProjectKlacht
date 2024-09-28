<?php
session_start(); // Start de sessie
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd en een admin is
if (isset($_SESSION['klant_id']) && $_SESSION['rol'] === 'Admin') {
    // Haal de boekingen op uit de database
    $stmt = $conn->prepare("SELECT boekingen.ID, boekingen.StartDatum, boekingen.PINCode, boekingen.FKklantenID, klanten.Naam as KlantNaam, tochten.Omschrijving 
                            FROM boekingen 
                            LEFT JOIN klanten ON boekingen.FKklantenID = klanten.ID
                            LEFT JOIN tochten ON boekingen.FKtochtenID = tochten.ID");
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Haal de klanten op uit de database
    $klantenStmt = $conn->prepare("SELECT * FROM klanten");
    $klantenStmt->execute();
    $klanten = $klantenStmt->fetchAll(PDO::FETCH_ASSOC);

    // Haal de tochten op uit de database
    $tochtenStmt = $conn->prepare("SELECT * FROM tochten");
    $tochtenStmt->execute();
    $tochten = $tochtenStmt->fetchAll(PDO::FETCH_ASSOC);

    // Controleer of het formulier is ingediend
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verkrijg de boeking-ID van het formulier
        $boekingID = $_POST['boeking'];
        
        // Update de gegevens in de database
        $updateStmt = $conn->prepare("UPDATE boekingen 
                                      SET StartDatum = :startdatum, 
                                          FKtochtenID = :tocht, 
                                          FKstatussenID = :nieuwe_status, 
                                          PINCode = :nieuwe_pincode, 
                                          FKklantenID = :klant 
                                      WHERE ID = :boeking_id");
        $updateStmt->bindParam(':startdatum', $_POST['startdatum'], PDO::PARAM_STR);
        $updateStmt->bindParam(':tocht', $_POST['tocht'], PDO::PARAM_INT);
        $updateStmt->bindParam(':nieuwe_status', $_POST['nieuwe_status'], PDO::PARAM_INT);
        $updateStmt->bindParam(':nieuwe_pincode', $_POST['nieuwe_pincode'], PDO::PARAM_INT);
        $updateStmt->bindParam(':klant', $_POST['klant'], PDO::PARAM_INT);
        $updateStmt->bindParam(':boeking_id', $boekingID, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            echo "Boeking succesvol gewijzigd!";
        } else {
            echo "Fout bij het wijzigen van de boeking.";
        }
    }
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
    <title>Boeking Wijzigen</title>
</head>
<body>
    <h1>Boeking Wijzigen</h1>

    <form action="" method="post">
        Boeking:
        <select id="boekingDropdown" name="boeking" required>
            <?php foreach ($boekingen as $boeking): ?>
                <option value="<?= $boeking['ID'] ?>" 
                        data-startdatum="<?= $boeking['StartDatum'] ?>" 
                        data-klant="<?= $boeking['FKklantenID'] ?>"
                        data-tocht="<?= $boeking['FKtochtenID'] ?>"
                        data-pincode="<?= $boeking['PINCode'] ?>"><?= $boeking['StartDatum'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        Startdatum: <input type="date" id="startdatumInput" name="startdatum" required><br>
        Klant:
        <select name="klant" required>
            <?php foreach ($klanten as $klant): ?>
                <option value="<?= $klant['ID'] ?>"><?= $klant['Naam'] ?></option>
            <?php endforeach; ?>
        </select><br>
        Tocht:
        <select id="tochtDropdown" name="tocht" required>
            <?php foreach ($tochten as $tocht): ?>
                <option value="<?= $tocht['ID'] ?>"><?= $tocht['Omschrijving'] ?></option>
            <?php endforeach; ?>
        </select><br>
        Wijzig Status:
        <select name="nieuwe_status">
            <!-- Opties voor verschillende boekingsstatussen -->
            <option value="1">Offerte</option>
            <option value="2">Definitief</option>
            <!-- Voeg meer opties toe afhankelijk van je statussen in de database -->
        </select><br>
        Nieuwe PIN-code: <input type="text" name="nieuwe_pincode"><br>
        <input type="submit" value="Wijzigen">
    </form>

    <script>
        // JavaScript om de startdatum, klant, tocht en PIN-code dynamisch in te vullen
        document.getElementById('boekingDropdown').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('startdatumInput').value = selectedOption.getAttribute('data-startdatum');
            document.getElementsByName('klant')[0].value = selectedOption.getAttribute('data-klant');
            document.getElementById('tochtDropdown').value = selectedOption.getAttribute('data-tocht');
            document.getElementsByName('nieuwe_pincode')[0].value = selectedOption.getAttribute('data-pincode');
        });
    </script>
</body>
</html>
