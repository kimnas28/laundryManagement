<?php
include 'sql.php';
include 'receipt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    $customerId = $_POST['orderId'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT c.ID, c.name, p.amount, p.method, p.date, p.weight, p.customer_id, 
                     p.Choice, p.addonns, p.billing, p.addonstotal, c.contact_number
              FROM status c 
              JOIN history p ON c.ID = p.customer_id
              WHERE p.customer_id = $customerId 
              ORDER BY p.date DESC 
              LIMIT 1";
    
    $res = $conn->query($query);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $customerName = $row['name'];
        $customerId = $row['customer_id'];
        $amount = $row['amount'];
        $serviceDate = $row['date'];
        $method = $row['method'];
        $weight = $row['weight'];
        $choice = $row['Choice'];
        $addons = $row['addonns'];
        $billing = $row['billing'];
        $addonTotal = $row['addonstotal'];
        $cnum = $row['contact_number'];

        printReceipt($customerName, $customerId, $billing, $serviceDate, $method, $weight, $choice, $addons, $amount, $addonTotal, $cnum);
    } else {
        echo "No data found for customer ID: $customerId";
    }

    $conn->close();
}

?>

