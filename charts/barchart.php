<?php
include "../controllers/Index.php";
$conn = new db;

// Use a prepared statement to prevent SQL injection
$sql = "SELECT MAX(quantity) AS max_quantity, MIN(quantity) AS min_quantity FROM (
            SELECT SUM(quantity) AS quantity_sum
            FROM dishes_ordered
            GROUP BY dish_id
        ) AS quantities";

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

// Fetch the highest and lowest quantity
$data = $resultSet->fetch_assoc();

// Debugging: Echo the fetched data to check if it's correct
echo json_encode(array('success' => true, 'data' => $data));

// Close the statement
$stmt->close();
?>
