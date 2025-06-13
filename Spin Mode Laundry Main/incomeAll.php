<?php
include 'sql.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type'])) {
    $check = ($_POST['type']);

    $gross = 0;
    $net = 0;

    $res = $conn->query("SELECT SUM(amount) AS total FROM history WHERE date != '0000-00-00 00:00:00'");

    if ($row = $res->fetch_assoc()) {
        if ($row['total'] !== null) { 
            $gross = $row['total']; 
        } else {
            $gross = 0; 
        }
    }

    $res2 = $conn->query("SELECT SUM(amount) AS total FROM expenses");
    if ($row = $res2->fetch_assoc()) {
        if ($row['total'] !== null) {
            $expenses = $row['total']; 
        } else {
            $expenses = 0; 
        }
    } else {
        $expenses = 0; 
    }

    $net = $gross - $expenses;

    switch ($check) {
        case 'gross':
            echo number_format($gross, 2) . "</p>";
            break;
        case 'net':
            echo number_format($net, 2) . "</p>";
            break;
        default:
            echo "<p>Please select a valid option (gross or net).</p>";
            break;
    }
}
?>