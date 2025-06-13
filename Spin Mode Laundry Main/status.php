<?php
include 'sql.php';

function showUnclaimedTable($conn) {
    $query = "SELECT * FROM status WHERE Status1 = 'Unclaimed'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td style='text-align: center;'><input type='checkbox' class='claim-checkbox' data-id='{$row['ID']}'>
</td>
                    <td style='text-align: center;'>{$row['ID']}</td>
                    <td style='text-align: center;'>{$row['name']}</td>
                    <td style='color: red; text-align: center;'>{$row['Status1']}</td>
                    </td>
                </tr>";
        }

    }
}

function updateStatus($conn, $paymentId, $claimStatus) {
    $stmt = $conn->prepare("UPDATE status SET Status1 = ? WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("si", $claimStatus, $paymentId);    
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error updating customer ID $paymentId: " . $stmt->error ;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

function showUnpaidTable($conn) {
    $query = "SELECT * FROM status WHERE Payment = 'Unpaid'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td style='text-align: center;'><input type='checkbox' class='payment-checkbox' data-id='{$row['ID']}'>
</td>
                    <td style='text-align: center;'>{$row['ID']}</td>
                    <td style='text-align: center;'>{$row['name']}</td>
                    <td style='color: red; text-align: center;'>{$row['Payment']}</td>
                    </td>
                </tr>";
        }

    }
}

function updatePayment($conn, $paymentId, $payment) {
    $stmt = $conn->prepare("UPDATE status SET Payment = ? WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("si", $payment, $paymentId);    
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error updating customer ID $paymentId: " . $stmt->error ;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}


function showTransaction($conn) {
    $query = "SELECT * FROM status WHERE Status1 = 'Unclaimed' OR Payment = 'Unpaid'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['Status1'] == 'Claimed') {
                $statusColor = 'green';
            } else {
                $statusColor = 'red';
            }

            if ($row['Payment'] == 'Paid') {
                $paymentColor = 'green';
            } else {
                $paymentColor = 'red';
            }

            echo "<tr>";
            echo "<td style='text-align: center;'>{$row['ID']}</td>";
            echo "<td style='text-align: center;'>{$row['name']}</td>";
            echo "<td style='color: $statusColor; text-align: center;'>{$row['Status1']}</td>";
            echo "<td style='color: $paymentColor; text-align: center;'>{$row['Payment']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No recent status found.</p>";
    }
}

?>