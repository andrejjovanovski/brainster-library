<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$note = $data->note;

$sql = "UPDATE notes SET note = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $note, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
}