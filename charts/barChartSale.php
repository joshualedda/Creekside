<?php
include "../controllers/Index.php";
$conn = new db();

$sql = "SELECT dish_name, SUM(quantity) as total_quantity FROM dishes_ordered GROUP BY dish_name ORDER BY total_quantity DESC LIMIT 10";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    echo json_encode(["message" => "0 results"]);
    exit;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
