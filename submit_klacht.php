<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'PDO_connect.php'; // Voeg de PDO-connectie toe

// Ontvang gegevens van het klachtformulier
$naam = $_POST['naam'];
$email = $_POST['email'];
$klacht_text = $_POST['klacht_text'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Verwerk de foto-upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
$foto_url = $target_file;

try {
    // Voeg de klacht toe aan de database
    $sql = "INSERT INTO klacht (naam, email, klacht_text, latitude, longitude, foto_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddss", $naam, $email, $klacht_text, $latitude, $longitude, $foto_url);
    
    if ($stmt->execute()) {
        echo "Klacht succesvol toegevoegd!";
    } else {
        echo "Er is een fout opgetreden bij het uitvoeren van de databasequery.";
    }
} catch (Exception $e) {
    echo "Fout: " . $e->getMessage();
}

// Sluit de databaseverbinding
$conn->close();
?>
