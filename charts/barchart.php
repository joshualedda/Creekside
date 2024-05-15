<?php
include "../controllers/Index.php";
$conn = new db;

// Use a prepared statement to prevent SQL injection
$sql = "SELECT MAX(quantity) AS max_quantity, MIN(quantity) AS min_quantity, MONTH(transactions.delivery_date) AS month
        FROM (
            SELECT SUM(quantity) AS quantity, dishes_ordered.dish_id, transactions.delivery_date
            FROM dishes_ordered
            JOIN transactions ON dishes_ordered.trans_id = transactions.trans_id
            GROUP BY dishes_ordered.dish_id, MONTH(transactions.delivery_date)
        ) AS aggregated_data
        GROUP BY month";

$stmt = $conn->prepare($sql);

// Check for errors in preparing the statement
if ($stmt === false) {
    echo json_encode(array('success' => false, 'message' => 'Error preparing statement: ' . $conn->error));
    exit();
}

// Execute the statement
$result = $stmt->execute();

// Check for errors in executing the statement
if ($result === false) {
    echo json_encode(array('success' => false, 'message' => 'Error executing query: ' . $stmt->error));
    exit();
}

// Get the result set
$resultSet = $stmt->get_result();

// Initialize data array with default values for all months
$data = array_fill(1, 12, array('max_quantity' => 0, 'min_quantity' => 0));

// Fetch the highest and lowest quantity for each month
while ($row = $resultSet->fetch_assoc()) {
    $month = $row['month'];
    $data[$month] = array(
        'max_quantity' => $row['max_quantity'],
        'min_quantity' => $row['min_quantity']
    );
}

// Debugging: Echo the fetched data to check if it's correct
echo json_encode(array('success' => true, 'data' => $data));

// Close the statement
$stmt->close();
?>
