<?php
include('navbar.php');
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

session_start();

if (!isset($_SESSION['klant_id'])) {
    echo "Gebruiker is niet ingelogd.";
    exit();
}

$klantID = $_SESSION['klant_id'];

// Haal de huidige gebruikersgegevens op
$stmt = $conn->prepare("SELECT * FROM klanten WHERE ID = :klantID");
$stmt->bindParam(':klantID', $klantID);
$stmt->execute();
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $naam = $_POST["naam"];
        $email = $_POST["email"];
        $telefoon = $_POST["telefoon"];
        $wachtwoord = $_POST["wachtwoord"];

        $hashWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE klanten SET Naam = :naam, Email = :email, Telefoon = :telefoon, Wachtwoord = :wachtwoord WHERE ID = :klantID");
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefoon', $telefoon);
        $stmt->bindParam(':wachtwoord', $hashWachtwoord);
        $stmt->bindParam(':klantID', $klantID);

        if ($stmt->execute()) {
            echo "Gebruikersgegevens succesvol bijgewerkt.";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van de gegevens.";
            var_dump($stmt->errorInfo());
        }
    } elseif (isset($_POST['delete_account'])) {
        // Eerst de gerelateerde boekingen van de klant verwijderen
        $stmt = $conn->prepare("DELETE FROM boekingen WHERE FKklantenID = :klantID");
        $stmt->bindParam(':klantID', $klantID);

        if ($stmt->execute()) {
            // Daarna de klant verwijderen
            $stmt = $conn->prepare("DELETE FROM klanten WHERE ID = :klantID");
            $stmt->bindParam(':klantID', $klantID);

            if ($stmt->execute()) {
                session_destroy();
                header("Location: inloggen.php");
                exit();
            } else {
                echo "Er is een fout opgetreden bij het verwijderen van het account.";
                var_dump($stmt->errorInfo());
            }
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de boekingen.";
            var_dump($stmt->errorInfo());
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gebruikersgegevens bijwerken</title>
</head>
<body>
    <h1>Gebruikersgegevens bijwerken</h1>

    <form action="" method="post">
        Naam: <input type="text" name="naam" value="<?= $gebruiker['Naam'] ?>" required><br>
        E-mail: <input type="email" name="email" value="<?= $gebruiker['Email'] ?>" required><br>
        Telefoon: <input type="tel" name="telefoon" value="<?= $gebruiker['Telefoon'] ?>" required><br>
        Wachtwoord: <input type="password" name="wachtwoord" required><br>
        <input type="submit" name="update" value="Gegevens Bijwerken">
    </form>

    <form action="" method="post">
        <input type="submit" name="delete_account" value="Account Verwijderen">
    </form>
</body>
</html>
