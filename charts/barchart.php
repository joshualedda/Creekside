<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../controllers/Index.php";
$conn = new db;

// Corrected SQL query
$sql = "SELECT 
            d.dish_id, 
            dishes.name AS dish_name, 
            SUM(d.quantity_ordered) AS quantity_ordered
        FROM 
            dishes_ordered d
        LEFT JOIN 
            dishes ON d.dish_id = dishes.id
        GROUP BY 
            d.dish_id, dishes.name
        ORDER BY 
            quantity_ordered DESC
        LIMIT 5";

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

// Initialize data array
$data = array();

// Fetch the top 5 dishes
while ($row = $resultSet->fetch_assoc()) {
    $data[] = array(
        'dish_name' => $row['dish_name'],
        'quantity_ordered' => $row['quantity_ordered']
    );
}

// Output the JSON response
echo json_encode(array('success' => true, 'data' => $data));

// Close the statement
$stmt->close();
