<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "creekside";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a `dish_name` column. Adjust the query if needed.
$sql = "SELECT dish_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_subtotal 
        FROM dishes_ordered 
        GROUP BY dish_id 
        ORDER BY total_subtotal DESC 
        LIMIT 10";
$result = $conn->query($sql);

$data = array();

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $data = ["message" => "No results found"];
    }
} else {
    $data = ["message" => "Query failed: " . $conn->error];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
