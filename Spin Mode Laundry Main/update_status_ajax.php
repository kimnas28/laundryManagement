<?php
include 'sql.php';
include 'status.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'refresh') {
        
        showTransaction($conn);
        exit;
    }

    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type === 'claim') {
        updateStatus($conn, $id, 'Claimed');
    } elseif ($type === 'payment') {
        updatePayment($conn, $id, 'Paid');
    }

    echo 'success';
    exit;
}
?>
