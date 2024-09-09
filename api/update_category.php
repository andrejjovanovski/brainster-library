<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$title = $data->name;
$is_archived = $data->is_archived;

$sql = "UPDATE categories SET title = ?, is_archived = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $title, $is_archived, $id);

if ($stmt->execute()) {
echo json_encode(['status' => 'success']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
}