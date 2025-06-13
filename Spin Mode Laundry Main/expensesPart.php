<?php
include 'sql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
        $stmt->bind_param("i", $id);
        echo $stmt->execute() ? "success" : "error";
        exit;
    }

    if (isset($_POST['add'])) {
        $description = $_POST['description'];

        if (preg_match('/[^a-zA-Z\s]/', $description)) {
            echo "Error: Only characters are accepted.";
            exit;
        }
        $amount = floatval($_POST['amount']);
        $month = $_POST['month'];
        $year = $_POST['year'];

        if ($month == "02") {
            $date = ($year % 4 == 0) ? "$year-$month-29" : "$year-$month-28";
        } elseif (in_array($month, ["04", "06", "09", "11"])) {
            $date = "$year-$month-30";
        } else {
            $date = "$year-$month-31";
        }

        $stmt = $conn->prepare("INSERT INTO expenses (description, amount, date) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sds", $description, $amount, $date);
            echo $stmt->execute() ? "Expense added successfully." : "Error adding expense: " . $stmt->error;
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
        exit;
    }

    if (isset($_POST['fetch'])) {
        $month = intval($_POST['month']);
        $year = intval($_POST['year']);

        if ($month === 0) {
            $stmt = $conn->prepare("SELECT * FROM expenses WHERE YEAR(date) = ?");
            $stmt->bind_param("i", $year);

            $totalStmt = $conn->prepare("SELECT SUM(amount) AS total FROM expenses WHERE YEAR(date) = ?");
            $totalStmt->bind_param("i", $year);
        } else {
            $stmt = $conn->prepare("SELECT * FROM expenses WHERE MONTH(date) = ? AND YEAR(date) = ?");
            $stmt->bind_param("ii", $month, $year);

            $totalStmt = $conn->prepare("SELECT SUM(amount) AS total FROM expenses WHERE MONTH(date) = ? AND YEAR(date) = ?");
            $totalStmt->bind_param("ii", $month, $year);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $totalStmt->execute();
        $totalRes = $totalStmt->get_result();

        $expenses = [];
        $total = 0;

        if ($totalRow = $totalRes->fetch_assoc()) {
            $total = $totalRow['total'] ?? 0;
        }

        while ($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }

        echo json_encode([
            "expenses" => $expenses,
            "total" => number_format((float)$total, 2, '.', '')
        ]);
        exit;
    }
}
?>