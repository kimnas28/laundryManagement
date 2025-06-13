<?php
include 'sql.php'; 

$res = "SELECT c.ID, c.name, p.id, p.amount, p.method, p.date, p.weight, p.customer_id, p.Choice, p.addonns, p.billing, p.addonstotal, c.contact_number, c.Status1, c.Payment
                    FROM status c
                    JOIN history p ON c.ID = p.customer_id
                    ORDER BY customer_id DESC LIMIT 7";

$result = $conn->query($res);

echo "<h2>Recent Orders</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='Update'>";
        echo "<p><strong>{$row['name']}</strong> - {$row['Choice']}</p>";
        echo "<small class='text-muted'>Total: ₱{$row['amount']}</small>";
        echo "<small class='text-muted'>Date & Time: {$row['date']}</small>";
        echo "</div>";
    }
} else {
    echo "<p>No recent status found.</p>";
}


?>