<?php
include 'sql.php'; 
header('Content-Type: application/json');

$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');

$query = "
    SELECT Choice AS label, COUNT(*) AS total
    FROM history
    WHERE YEAR(date) = '$year'
    GROUP BY Choice
    ORDER BY total DESC
    LIMIT 5
";

$result = $conn->query($query);

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['label'];
    $values[] = (int)$row['total'];
}

echo json_encode([
    'categories' => $labels,
    'series' => $values
]);
?>
