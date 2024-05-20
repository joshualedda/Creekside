<?php
include "../controllers/Index.php";
$conn = new db;

// Get the selected year and month from the AJAX request
$startYear = isset($_GET['startYear']) ? intval($_GET['startYear']) : null;
$endYear = isset($_GET['endYear']) ? intval($_GET['endYear']) : null;
$selectedMonth = isset($_GET['month']) ? intval($_GET['month']) : null;

if (!is_numeric($startYear) || !is_numeric($endYear) || !is_numeric($selectedMonth)) {
    echo json_encode(array('success' => false, 'message' => 'Invalid input for year or month'));
    exit();
}

// Calculate the number of days in the selected month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $startYear);

// Construct the start and end dates
$startYearDate = date('Y-m-d', mktime(0, 0, 0, $selectedMonth, 1, $startYear));
$endYearDate = date('Y-m-d', mktime(0, 0, 0, $selectedMonth, $daysInMonth, $endYear));

$query = "SELECT dishes.dish_name AS label, SUM(dishes_ordered.quantity) AS value
          FROM transactions
          JOIN dishes_ordered ON transactions.trans_id = dishes_ordered.trans_id
          JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
          WHERE transactions.delivery_date >= '$startYearDate' 
            AND transactions.delivery_date <= '$endYearDate'
            AND (transactions.status = 'Paid' OR transactions.status = 'Completed')
          GROUP BY dishes.dish_name";

$result = mysqli_query($conn->con, $query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['label'],
        'value' => $row['value'],
    ];
}

// Sort the data based on the count in descending order
usort($data, function($a, $b) {
    return $b['value'] - $a['value'];
});

// Keep only the top 5 dishes, and aggregate the rest
$top5 = array_slice($data, 0, 5);
$otherTotal = array_sum(array_column(array_slice($data, 5), 'value'));

$finalData = $top5;
$finalData[] = ['label' => 'Other', 'value' => $otherTotal];

// Encode the final data array as JSON and return it
header('Content-Type: application/json');
echo json_encode(['data' => $finalData]);
?>
