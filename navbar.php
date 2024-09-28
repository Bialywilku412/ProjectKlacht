<!DOCTYPE html>
<html>
<head>
    <title>Navbar</title>
    <style>
        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar p {
            color: #f2f2f2;
            padding: 0px 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    
    <?php
    session_start();

    if (isset($_SESSION['gebruikersnaam'])) {
        // Als de gebruiker is ingelogd
        echo "<a href='account.php'>Account</a>"; // Account-link blijft hetzelfde

        // Controleer de rol van de gebruiker
        if (isset($_SESSION['rol'])) {
            $rol = $_SESSION['rol'];
            if ($rol === 'Admin') {
                // Als de gebruiker de rol 'Admin' heeft
                echo "<a href='admin_panel.php'>Beheerpaneel</a>";
            } elseif ($rol === 'Gast') {
                // Als de gebruiker de rol 'Gast' heeft
                echo "<a href='gast_panel.php'>Gastpaneel</a>";
            } else {
                // Voeg hier meer rollen toe en pas de links en tekst aan zoals nodig
            }
        }

        echo "<a style='float: right;' href='uitloggen.php'>Uitloggen</a>";
        echo "<p style='float: right;' href='#'>" . $_SESSION['telefoon'] . "</p>";
        echo "<p style='float: right;' href='#'>" . $_SESSION['email'] . "</p>";
        echo "<p style='float: right;' href='#'>Ingelogd als: " . $_SESSION['gebruikersnaam'] . "</p>";
    } else {
        // Als de gebruiker niet is ingelogd
        echo "<a style='float: right;' href='inloggen.php'>Inloggen</a>";
    }
    ?>
</div>

</body>
</html>
