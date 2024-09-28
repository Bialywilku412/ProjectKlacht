<?php
include 'connectie.php';

$query = "SELECT id, naam, email, klacht_text, latitude, longitude, foto_url, created_at FROM pełne_teksty";
$result = $conn->query($query);

$klachten = array();

while ($row = $result->fetch_assoc()) {
    $klachten[] = $row;
}

echo json_encode($klachten);

$conn->close();
?>
