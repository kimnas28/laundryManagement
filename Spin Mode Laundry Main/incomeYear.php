<?php

include 'sql.php';

$gross = 0;
$net = 0;
$expenses = 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['year']) && isset($_POST['type'])) {
    $year = $_POST['year'];
    $type = $_POST['type'];
    
    $start = "$year-01-01"; 
    $end = "$year-12-31";   
    
    $gross = 0; 
    $net = 0;   

    $res = $conn->query("SELECT SUM(amount) AS total FROM history WHERE Date(date) BETWEEN '$start' AND '$end'");
    
    if ($row = $res->fetch_assoc()) {
        if ($row['total'] != null) { 
            $gross = $row['total']; 
        } else {
            $gross = 0; 
        }
    }

    $res2 = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE Date(date) BETWEEN '$start' AND '$end'");
    if ($row = $res2->fetch_assoc()) {

        if ($row['total'] != null) {
            $expenses = $row['total']; 
        } else {
            $expenses = 0; 
        }
    } else {
        $expenses = 0; 
    }
    

    $net = $gross - $expenses;
    
    switch ($type) {
        case 'net':
            echo number_format($net, 2) . "</p>";
            break;
        case 'gross':
            echo number_format($gross, 2) . "</p>";
            break;
        default:
            echo "<p>Please select a valid option (gross or net).</p>";
            break;
    }
}
?>