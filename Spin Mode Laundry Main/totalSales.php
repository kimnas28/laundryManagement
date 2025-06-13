<?php
include 'sql.php';

if (isset($_POST['date'])) {
    $date = $_POST['date']; 
    $gross = 0;


    $result = $conn->query("SELECT SUM(amount) AS total FROM history WHERE DATE(date) = '$date'");
    if ($row = $result->fetch_assoc()) {

        if ($row['total'] !== null) {
            $gross = $row['total'];
        } else {
            $gross = 0;
        }
    }

 
    $currentYear = date("Y");
    $resultAnnual = $conn->query("SELECT SUM(amount) AS annual_total FROM history WHERE YEAR(date) = '$currentYear'");
    $annualIncome = 0;
    if ($row = $resultAnnual->fetch_assoc()) {
  
        if ($row['annual_total'] !== null) {
            $annualIncome = $row['annual_total'];
        } else {
            $annualIncome = 0;
        }
    }

    
    $percentage = ($annualIncome > 0) ? ($gross / $annualIncome) * 100 : 0;

    
    echo json_encode([
        'sales' => number_format($gross, 2),
        'percent' => number_format($percentage, 2) 
    ]);
}
?>
