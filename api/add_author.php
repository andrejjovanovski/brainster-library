<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$lastname = $data['lastname'];
$short_bio = $data['short_bio'];

if ($name && $lastname && $short_bio) {
$stmt = $conn->prepare("INSERT INTO authors (name, last_name, bio) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $lastname, $short_bio);

if ($stmt->execute()) {
echo json_encode(['status' => 'success', 'message' => 'Author added successfully!']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Error adding author to the database!']);
}

$stmt->close();
} else {
echo json_encode(['status' => 'error', 'message' => 'Invalid data!']);
}

$conn->close();
?>