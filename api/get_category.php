<?php
include 'db.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            echo json_encode($category);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Category not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error fetching category: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No category ID provided']);
}

$conn->close();