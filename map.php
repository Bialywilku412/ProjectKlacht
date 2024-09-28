<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marker Kaart</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            margin: 300px, auto;
        }
    </style>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>

<div id="map"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([51.9225, 4.47917], 13); // Coördinaten voor het startpunt

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Haal klachtgegevens op uit de database en voeg markers toe
        <?php
        include 'connectie.php';

        $query = "SELECT * FROM klachten";
        $result = $conn->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $naam = $row['naam'];
            $email = $row['email'];
            $klacht_text = $row['klacht_text'];
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];
            $foto_url = $row['foto_url'];
            $created_at = $row['created_at'];

            echo "L.marker([$latitude, $longitude]).addTo(map).bindPopup('Klacht ID: $id<br>Naam: $naam<br>Email: $email<br>Klacht: $klacht_text<br>Created At: $created_at<br><img src=\"$foto_url\" alt=\"Foto\">');\n";
        }

        $conn->close();
        ?>
    });
</script>

</body>
</html>
