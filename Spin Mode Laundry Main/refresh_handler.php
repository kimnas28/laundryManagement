<?php
include 'sql.php';
include 'status.php';
include 'orders.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'unclaimed') {
        showUnclaimedTable($conn);
    } elseif ($action === 'unpaid') {
        showUnpaidTable($conn);
    } elseif ($action === 'transaction') {
        showTransaction($conn);
    } elseif ($action === 'history') {
        viewAll($conn);
    }

    exit; 
}

?>