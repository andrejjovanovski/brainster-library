<?php
include 'db.php';

header('Content-Type: application/json');

$bookID = $_GET['bookID'];
$clientID = $_GET['clientID'];

if ($bookID) {
    $stmt = $conn->prepare("SELECT notes.*, clients.name as client_note_name, clients.last_name as client_note_lastname
         FROM notes
         JOIN clients ON notes.client_id = clients.id
         WHERE book_id = ? AND client_id = ?");
    $stmt->bind_param("ii", $bookID, $clientID);
    $stmt->execute();
    $result = $stmt->get_result();

    $notes = [];
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }

    echo json_encode($notes);

    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
?>