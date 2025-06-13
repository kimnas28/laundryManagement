<?php
include 'sql.php';

$gross = 0;
$net = 0;
$expenses = 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date']) && isset($_POST['type'])) {
    $date = $_POST['date'];
    $type = $_POST['type'];

    
    $res = $conn->query("SELECT SUM(amount) AS total FROM history WHERE DATE(date) = '$date'");
    
    if ($row = $res->fetch_assoc()) {
        $gross = ($row['total'] !== null) ? (float)$row['total'] : 0;
    }

    
    $res2 = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE DATE(date) = '$date'");
    
    if ($row2 = $res2->fetch_assoc()) {
        $expenses = ($row2['total'] !== null) ? (float)$row2['total'] : 0;
    }


    $net = $gross - $expenses;


    
    switch ($type) {
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
} else {
    echo "<p>Invalid request. Please provide a date and income type.</p>";
}
?>