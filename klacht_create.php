<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<h2>Klacht Indienen</h2>

<form id="klachtForm" enctype="multipart/form-data">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>

    <label for="klacht_text">Klacht:</label>
    <textarea id="klacht_text" name="klacht_text" required></textarea>

    <input type="hidden" id="latitude" name="latitude">
    <input type="hidden" id="longitude" name="longitude">

    <label for="foto">Foto uploaden:</label>
    <input type="file" id="foto" name="foto">

    <button type="button" onclick="submitKlacht()">Indienen</button>
</form>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocatie wordt niet ondersteund door deze browser.");
        }
    }

    function showPosition(position) {
        $('#latitude').val(position.coords.latitude);
        $('#longitude').val(position.coords.longitude);
    }

    function submitKlacht() {
        getLocation();

        // Verzend het formulier via AJAX naar de PHP-handler
        var formData = new FormData($('#klachtForm')[0]);

        $.ajax({
            type: 'POST',
            url: 'submit_klacht.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Klacht succesvol ingediend!');
                // Hier kun je verdere acties ondernemen, zoals het tonen van een bevestiging of het herladen van de pagina.
            },
            error: function(error) {
                alert('Er is een fout opgetreden bij het indienen van de klacht.');
                console.log(error);
            }
        });
    }
</script>

</body>
</html>
