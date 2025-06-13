<?php
include 'sql.php';
function printReceipt($customerName, $customerId, $amount, $serviceDate, $method, $weight, $choice, $addons, $billing, $addonTotal, $cnum) {
    $method = ucfirst(strtolower($method)); 

    
    $addonsString = '';
    if (!empty($addons)) {
        $addonsString = '<p><strong>Add-ons:</strong> ₱' . number_format($addonTotal, 2) . '</p><ul>';
        $addonsString .= '</ul>';
    }
    


    $receiptContent = "
    <br><div style='border:1px solid #000; padding:10px; width:350px; margin:left;'>
      
        <p><strong>Customer ID:</strong> $customerId</p>
        <p><strong>Customer:</strong> $customerName</p>
        <p><strong>Contact Number:</strong> $cnum</p>
        <p><strong>Laundry Weight:</strong> $weight kg</p>
        <p><strong>Service Availed:</strong> $choice - ₱" . number_format($amount, 2) . "</p>
        $addonsString
        <p><strong>Total Amount Balance:</strong> ₱" . number_format($billing, 2) . "</p>
        <p><strong>Payment Method:</strong> $method</p>
        <p><strong>Date:</strong> $serviceDate</p>
         <p style='margin-top: 2rem;'>Thank you for choosing us!</p>
    </div>
    ";


    echo $receiptContent;

    echo "
    <script>
        function printReceipt() {
            var printWindow = window.open('', '', 'width=600,height=400');
            printWindow.document.write('<html><head><title>Print Receipt</title></head><body>');
            printWindow.document.write(`$receiptContent`);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
    ";
}
?>