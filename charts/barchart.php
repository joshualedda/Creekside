<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../controllers/Index.php";
$conn = new db;

// Use a prepared statement to prevent SQL injection
$sql = "SELECT 
MONTH(t.delivery_date) AS month,
MAX(d.quantity) AS max_quantity,
MIN(d.quantity) AS min_quantity
FROM 
transactions t
JOIN 
dishes_ordered d ON d.trans_id = t.trans_id
GROUP BY 
MONTH(t.delivery_date)
";

$stmt = $conn->con->prepare($sql);

// Check for errors in preparing the statement
if ($stmt === false) {
    echo json_encode(array('success' => false, 'message' => 'Error preparing statement: ' . $conn->con->error));
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

// Output the JSON response
echo json_encode(array('success' => true, 'data' => $data));

// Close the statement
$stmt->close();
?>