<?php
require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Zoek de gebruiker op basis van het e-mailadres
        $stmt = $conn->prepare("SELECT * FROM klanten WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of de gebruiker bestaat en het wachtwoord overeenkomt
        if ($user && password_verify($password, $user['Wachtwoord'])) {
            // Gebruiker is succesvol ingelogd

            session_start();

            // Voeg de gebruikersnaam, email en telefoonnummer toe aan de sessie
            $_SESSION['gebruikersnaam'] = $user['Naam'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['telefoon'] = $user['Telefoon'];
            $_SESSION['klant_id'] = $user['ID']; // Voeg de klant-ID toe aan de sessie
            $_SESSION['rol'] = $user['Rol']; // Voeg de rol toe

            // Stuur gebruiker door op basis van de rol
            switch ($user['Rol']) {
                case 'Admin':
                    header("Location: admin_panel.php");
                    break;
                case 'Gast':
                    header("Location: gast_panel.php");
                    break;
                default:
                    echo "Onbekende rol.";
                    break;
            }

            exit();
        } else {
            echo "Ongeldige inloggegevens.";
        }
    } catch(PDOException $e) {
        echo "Verbinding met de database is mislukt: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inloggen</title>
</head>
<body>
    <h1>Mijn Donkey Travel inloggen</h1>
    <form action="inloggen.php" method="post">
        E-mail: <input type="email" name="email" required><br>
        Wachtwoord: <input type="password" name="password" required><br>
        <input type="submit" value="Inloggen">
    </form>
    <p>Nog geen account? <a href="registreren.php"><button>Maak er hier eentje aan!</button></a></p>
</body>
</html>
