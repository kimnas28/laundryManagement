<?php
include 'sql.php';
include 'orders.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_query'])) {
    $conn = new mysqli("localhost", "root", "", "spinmode_laundry");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    searchName($conn);

    
}
?>
