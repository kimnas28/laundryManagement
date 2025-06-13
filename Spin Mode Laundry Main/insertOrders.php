<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'sql.php';
include 'computeAll.php';
include 'receipt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer'] ?? '';
    $weight = (float) ($_POST['weight'] ?? 0);
    $contact = $_POST['cnum'] ?? '';
    $choice = $_POST['service'] ?? '';
    $method = $_POST['payment_method'] ?? 'Pending';
    $payment = $_POST['settlement'] ?? 'Unpaid';
    date_default_timezone_set('Asia/Manila');
    $date = date("y-m-d H:i:s T");


    $addons = $_POST['addons'] ?? [];
    $addonQuantities = json_decode($_POST['quantities'], true) ?? [];

    $amount = computeBilling($weight, $choice);
    $addontotal = computeAddons($addons, $addonQuantities);
    $billing = $amount  + $addontotal;

    $addonDetails = implode('', array_map(function($a) use ($addonQuantities) {
        $qty = isset($addonQuantities[$a]) ? $addonQuantities[$a] : 0;
        return "$a (Qty: $qty)<br>";
    }, $addons));


    $sql1 = "INSERT INTO status (name, contact_number, Status1, Payment)
             VALUES (?, ?, 'Unclaimed', ?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("sss", $name, $contact, $payment);
    $stmt1->execute();
    $customer_id = $stmt1->insert_id;
    $stmt1->close();


    $sql2 = "INSERT INTO history (weight, amount, addonstotal, billing, addonns, Choice, method, date, customer_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ddddssssi", $weight, $billing, $addontotal, $amount, $addonDetails, $choice, $method, $date, $customer_id);
    $stmt2->execute();
    $stmt2->close();


    
    $conn->close();
    printReceipt($name, $customer_id, $amount, $date, $method, $weight, $choice, $addons, $billing, $addontotal, $contact);
} else {
    echo "Invalid request.";
}
