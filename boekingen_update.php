<?php
include('navbar.php');

session_start(); // Start de sessie

require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Controleer of de gebruiker is ingelogd
if(isset($_SESSION['klant_id'])) {
    $klantID = $_SESSION['klant_id'];

    // Haal boekingen op uit de database voor dropdown menu
    $stmt = $conn->prepare("SELECT ID, StartDatum FROM boekingen WHERE FKklantenID = :klantID");
    $stmt->bindParam(':klantID', $klantID);
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Haal tochten op uit de database voor dropdown menu
    $stmt = $conn->prepare("SELECT ID, Omschrijving FROM tochten");
    $stmt->execute();
    $tochten = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Controleren of een boeking is geselecteerd
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['boeking'])) {
            echo "Geen boeking geselecteerd.";
            exit();
        }

        // Het opgegeven boeking ID
        $boekingID = $_POST['boeking'];

        // Haal de geselecteerde boeking op uit de database
        $stmt = $conn->prepare("SELECT * FROM boekingen WHERE ID = :id");
        $stmt->bindParam(':id', $boekingID);
        $stmt->execute();
        $boeking = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of de boeking bestaat
        if (!$boeking) {
            echo "Geen geldige boeking gevonden.";
            exit();
        }

        // Controleer of de boekingstatus nog niet Definitief is
        if ($boeking['FKstatussenID'] == 3) {
            echo "Deze boeking heeft de status Definitief en kan niet meer gewijzigd worden.";
            exit();
        }

        // Controleer of de startdatum minstens een week na de huidige datum valt
        $huidigeDatum = date('Y-m-d');
        $minimaleStartdatum = date('Y-m-d', strtotime($huidigeDatum . ' + 7 days'));

        if ($_POST['startdatum'] < $minimaleStartdatum) {
            echo "De startdatum moet minstens een week na de huidige datum zijn.";
            exit();
        }

        // Update de boeking in de database
        $stmt = $conn->prepare("UPDATE boekingen SET StartDatum = :startdatum, FKtochtenID = :tocht WHERE ID = :id");
        $stmt->bindParam(':startdatum', $_POST['startdatum']);
        $stmt->bindParam(':tocht', $_POST['tocht']);
        $stmt->bindParam(':id', $boekingID);

        if ($stmt->execute()) {
            echo "Boeking succesvol gewijzigd.";
        } else {
            echo "Er is een fout opgetreden bij het wijzigen van de boeking.";
            var_dump($stmt->errorInfo()); // Laat de eventuele foutmelding zien
        }
    }

} else {
    // Als de gebruiker niet is ingelogd, geef een foutmelding of stuur ze naar de inlogpagina
    echo "Gebruiker is niet ingelogd."; // Of voeg een redirect toe naar de inlogpagina
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boeking Wijzigen</title>
</head>
<body>
    <h1>Boeking Wijzigen</h1>

    <form action="" method="post">
        Boeking:
        <select id="boekingDropdown" name="boeking" required>
            <?php foreach ($boekingen as $boeking): ?>
                <option value="<?= $boeking['ID'] ?>" data-startdatum="<?= $boeking['StartDatum'] ?>"><?= $boeking['StartDatum'] ?></option>
            <?php endforeach; ?>
        </select><br>
        Startdatum: <input type="date" id="startdatumInput" name="startdatum" required><br>
        Tocht:
        <select name="tocht" required>
            <?php foreach ($tochten as $tocht): ?>
                <option value="<?= $tocht['ID'] ?>"><?= $tocht['Omschrijving'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Wijzigen">
    </form>

    <script>
        // JavaScript om de startdatum dynamisch in te vullen
        document.getElementById('boekingDropdown').addEventListener('change', function() {
            var selectedDate = this.options[this.selectedIndex].getAttribute('data-startdatum');
            document.getElementById('startdatumInput').value = selectedDate;
        });
    </script>
</body>
</html>
