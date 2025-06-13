<?php
include 'sql.php';
function viewAll($conn) {
    $res = $conn->query("SELECT c.ID, c.name, p.id, p.amount, p.method, p.date, p.weight, p.customer_id, p.Choice, p.addonns, p.billing, p.addonstotal, c.contact_number, c.Status1, c.Payment
                         FROM status c
                         JOIN history p ON c.ID = p.customer_id
                         ORDER BY customer_id DESC");

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {

            echo "<tr>
                <td>
                    <button class=\"icon-btn\" onclick='showHistoryReceipt(\"{$row['customer_id']}\")'>
                        <span class='material-symbols-outlined'>description</span>
                    </button>
                </td>
                <td style='text-align: center;'>{$row['date']}</td>
                <td style='text-align: center;'>{$row['customer_id']}</td>
                <td style='text-align: center;'>{$row['name']}</td>
                <td style='text-align: center;'>{$row['contact_number']}</td>
                <td style='text-align: center;'>{$row['weight']} kg</td>
                <td style='text-align: center;'>{$row['Choice']}</td>
                <td style='text-align: center;'>₱ {$row['billing']}</td>
                <td style='text-align: center;'>{$row['addonns']}</td>
                <td style='text-align: center;'>₱ {$row['addonstotal']}</td>
                <td style='text-align: center;'>{$row['method']}</td>
                
            </tr>";
            
        }
    } else {
        echo "<tr><td colspan='10' style='text-align:center;'>No records found.</td></tr>";
    }
}


function searchName($conn) {
    $search = $conn->real_escape_string($_POST['search_query']);

    $query = "SELECT c.ID, c.name, p.id, p.amount, p.method, p.date, p.weight, p.customer_id, p.Choice, p.addonns, p.billing, p.addonstotal, c.contact_number, c.Status1, c.Payment
              FROM status c
              JOIN history p ON c.ID = p.customer_id
              WHERE name LIKE '%$search%'
              ORDER BY customer_id DESC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<tr>
                <td>
                    <button class=\"icon-btn\" onclick='showHistoryReceipt(\"{$row['customer_id']}\")'>
                        <span class='material-symbols-outlined'>description</span>
                    </button>
                </td>
                <td style='text-align: center;'>{$row['date']}</td>
                <td style='text-align: center;'>{$row['customer_id']}</td>
                <td style='text-align: center;'>{$row['name']}</td>
                <td style='text-align: center;'>{$row['contact_number']}</td>
                <td style='text-align: center;'>{$row['weight']} kg</td>
                <td style='text-align: center;'>{$row['Choice']}</td>
                <td style='text-align: center;'>₱ {$row['billing']}</td>
                <td style='text-align: center;'>{$row['addonns']}</td>
                <td style='text-align: center;'>₱ {$row['addonstotal']}</td>
                <td style='text-align: center;'>{$row['method']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10' style='text-align:center;'>No matching records found for '<strong>$search</strong>'.</td></tr>";
    }
}
?>
<div class="order-box receipt-stored hidden" id="receipt-stored">
              <span class="material-symbols-outlined receipt-close" onclick="closeReceipt()">close</span>
              <h2>Receipt</h2>
              <button class="print-btn" onclick="printReceipt()">
                <span class="material-symbols-outlined">print</span>
              </button>
              <div id="receipt-content"></div>
            </div>
          </div>

<script>
  

function showHistoryReceipt(orderId) {
    const receiptBox = document.getElementById('receipt-stored');
    receiptBox.classList.remove('hidden');
    receiptBox.classList.add('visible');

    
    const formData = new FormData();
    formData.append('orderId', orderId);

    
    fetch('histReceipt_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('receipt-content').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching receipt:', error);
        document.getElementById('receipt-content').innerText = 'Error loading receipt.';
    });
}


  function closeReceipt() {
    document.getElementById('receipt-stored').classList.add('hidden');
    document.getElementById('receipt-box').classList.add('hidden');
  }
</script>
<script>
    function printReceipt() {
        var content = document.getElementById('receipt-content').innerHTML;
        var printWindow = window.open('', '', 'width=600,height=400');
        printWindow.document.write('<html><head><title>Print Receipt</title></head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>
