<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM authors";
$result = $conn->query($sql);

$authors = [];

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
$authors[] = $row;
}
}

echo json_encode($authors);

$conn->close();