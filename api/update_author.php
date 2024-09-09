<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$name = $data->name;
$lastname = $data->lastname;
$shortBio = $data->short_bio;
$is_archived = $data->is_archived;

$sql = "UPDATE authors SET name = ?, last_name = ?, bio = ?, is_archived = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $name, $lastname, $shortBio, $is_archived, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
}