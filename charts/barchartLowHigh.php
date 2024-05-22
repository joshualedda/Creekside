<?php
// Include your database connection or any necessary files here
include "../controllers/Index.php";
$conn = new db;


$query = "SELECT dishes.dish_name AS label, SUM(dishes_ordered.subtotal) AS value
          FROM transactions
          LEFT JOIN dishes_ordered ON transactions.trans_id = dishes_ordered.trans_id
          LEFT JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
          GROUP BY dishes.dish_id 
          ORDER BY value ASC 
          LIMIT 5";


$result = mysqli_query($conn->con, $query);

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
