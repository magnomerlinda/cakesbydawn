<?php
include "../../db_connection.php"; 

// Fetch total amount of orders where status is 'complete'
$sql_complete = "SELECT SUM(TotalAmount) as total_complete FROM orders WHERE Status = 'complete'";
$result_complete = $conn->query($sql_complete);
$total_complete = $result_complete->fetch_assoc()['total_complete'];

// Fetch total amount of orders where status is 'process'
$sql_process = "SELECT SUM(TotalAmount) as total_process FROM orders WHERE Status = 'process'";
$result_process = $conn->query($sql_process);
$total_process = $result_process->fetch_assoc()['total_process'];

// Fetch data for graph based on date_updated
$sql_graph = "SELECT DATE(date_updated) as date, SUM(TotalAmount) as total FROM orders WHERE Status = 'complete' GROUP BY DATE(date_updated)";
$result_graph = $conn->query($sql_graph);

$dates = [];
$totals = [];
while ($row = $result_graph->fetch_assoc()) {
    $dates[] = $row['date'];
    $totals[] = $row['total'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div style="color: #2E8BC0;" >
    <h1 style="color: orange;">Sales Report</h1>
    <h2>Total Amount (Complete Orders): <?php echo $total_complete; ?></h2>
    <h2>Total Amount (Process Orders): <?php echo $total_process; ?></h2>
<div style="width: 200px;">
    <canvas id="statusPieChart"  style="width: 250px;"></canvas><br><br>
	</div>
	<div style="width: 300px;">
    <canvas id="salesGraph" width="400" height="400"></canvas>
</div>
    <script>
        // Pie chart for order status
        var ctxPie = document.getElementById('statusPieChart').getContext('2d');
        var statusPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Complete', 'Process'],
                datasets: [{
                    label: 'Order Status',
                    data: [<?php echo $total_complete; ?>, <?php echo $total_process; ?>],
                    backgroundColor: ['#36A2EB', '#FFCE56']
                }]
            }
        });

        // Line graph for sales over time
        var ctxGraph = document.getElementById('salesGraph').getContext('2d');
        var salesGraph = new Chart(ctxGraph, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Sales',
                    data: <?php echo json_encode($totals); ?>,
                    backgroundColor: '#36A2EB',
                    borderColor: '#36A2EB',
                    fill: false
                }]
            }
        });
    </script>
	</div>
</body>
</html>
