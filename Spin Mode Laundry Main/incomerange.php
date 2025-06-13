<?php
include 'sql.php';
$gross = 0;
$net = 0;
$expenses = 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $type = $_POST['type'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

 
    $res = $conn->query("SELECT SUM(amount) AS total FROM history WHERE DATE(date) BETWEEN '$startDate' AND '$endDate'");
    if ($res) {
        $row = $res->fetch_assoc();
        $gross = ($row['total'] !== null) ? (float)$row['total'] : 0;
    } else {
        echo "Error executing query for gross income: " . $conn->error;
        exit;
    }


    $res2 = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE DATE(date) BETWEEN '$startDate' AND '$endDate'");
    if ($res2) {
        $row2 = $res2->fetch_assoc();
        $expenses = ($row2['total'] !== null) ? (float)$row2['total'] : 0;
    } else {
        echo "Error executing query for expenses: " . $conn->error;
        exit;
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
    echo "<p>Invalid request. Please provide type, start date, and end date.</p>";
}

?>