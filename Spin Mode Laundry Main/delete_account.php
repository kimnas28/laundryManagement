<?php
header('Content-Type: application/json');
include 'sql.php';

$data = json_decode(file_get_contents('php://input'), true);
$username = isset($data['username']) ? trim($data['username']) : '';

if (empty($username)) {
    die(json_encode(['success' => false, 'message' => 'Username is required']));
}

try {

    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die(json_encode(['success' => false, 'message' => 'User not found']));
    }


    $deleteStmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $deleteStmt->bind_param("s", $username);
    
    if ($deleteStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete account']);
    }
    
} catch (Exception $e) {
    die(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}

$conn->close();
?>