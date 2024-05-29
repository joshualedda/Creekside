<?php
// Include your database connection or any necessary files here
include "../controllers/Index.php";
$conn = new db;

// Get the filter parameters from the GET request
$startYear = isset($_GET['startYear']) ? intval($_GET['startYear']) : null;
$endYear = isset($_GET['endYear']) ? intval($_GET['endYear']) : null;
$selectedMonth = isset($_GET['month']) ? intval($_GET['month']) : null;

// Validate input
if (!is_numeric($startYear) || !is_numeric($endYear) || !is_numeric($selectedMonth)) {
    echo json_encode(array('success' => false, 'message' => 'Invalid input for year or month'));
    exit();
}

// Calculate the number of days in the selected month for the start year
$daysInMonthStart = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $startYear);

// Calculate the number of days in the selected month for the end year
$daysInMonthEnd = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $endYear);

// Construct the start and end dates
$startYearDate = date('Y-m-d', mktime(0, 0, 0, $selectedMonth, 1, $startYear));
$endYearDate = date('Y-m-d', mktime(0, 0, 0, $selectedMonth, $daysInMonthEnd, $endYear));

// Prepare and execute the SQL query with the filters applied
$query = "SELECT dishes.dish_name AS label, SUM(dishes_ordered.subtotal) AS value
          FROM transactions
          LEFT JOIN dishes_ordered ON transactions.trans_id = dishes_ordered.trans_id
          LEFT JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
          WHERE dishes_ordered.subtotal > 0
            AND transactions.delivery_date BETWEEN ? AND ?
          GROUP BY dishes.dish_id 
          ORDER BY value ASC 
          LIMIT 5";

$stmt = $conn->con->prepare($query);
$stmt->bind_param("ss", $startYearDate, $endYearDate);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['label'],
        'value' => $row['value'],
    ];
}

// Sort the data based on the count in descending order
usort($data, function ($a, $b) {
    return $b['value'] - $a['value'];
});

// Encode the final data array as JSON and return it
header('Content-Type: application/json');
echo json_encode(['data' => $data]);
?>
