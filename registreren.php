<?php
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $telefoon = $_POST["telefoon"];
    $wachtwoord = password_hash($_POST["wachtwoord"], PASSWORD_DEFAULT); // Wachtwoord hashen

    // Standaardrol wordt ingesteld op 'Gast'
    $rol = 'Gast';

    try {
        // Voeg de gegevens toe aan de database
        $stmt = $conn->prepare("INSERT INTO klanten (Naam, Email, Telefoon, Wachtwoord, Rol) VALUES (:naam, :email, :telefoon, :wachtwoord, :rol)");
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefoon', $telefoon);
        $stmt->bindParam(':wachtwoord', $wachtwoord);
        $stmt->bindParam(':rol', $rol);

        $stmt->execute();

        header("Location: inloggen.php");
        exit();
    } catch(PDOException $e) {
        echo "Verbinding met de database is mislukt: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
</head>
<body>
    <h1>Donkey Travel account aanvragen</h1>
    <h2>Account</h2>
    <form action="registreren.php" method="post">
    Naam: <input type="text" name="naam" required placeholder="Voer uw naam in"><br>
    E-mail: <input type="email" name="email" required placeholder="Voer uw e-mailadres in"><br>
    Wachtwoord: <input type="password" name="wachtwoord" required placeholder="Voer uw wachtwoord in"><br>
    Mobiel Telefoonnummer: <input type="tel" name="telefoon" required placeholder="Voer uw telefoonnummer in"><br>
    <input type="submit" value="Maak account">
    <button type="button" onclick="window.location.href='inloggen.php'">Annuleren</button>
    </form>
</body>
</html>
