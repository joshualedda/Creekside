<?php
include 'connection.php';

if (isset($_POST['searchQuery'])) {
    $searchQuery = mysqli_real_escape_string($con, $_POST['searchQuery']);
    
    // Modify your query to fetch matching dishes based on the search query
    $sql = "SELECT * FROM dishes WHERE dish_name LIKE '%$searchQuery%' AND status = 'Available' ORDER BY dish_name ASC";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            // Output HTML for the table row with a unique identifier
            $dishId = $row['dish_id'];
            echo '<tr id="dishRow_' . $dishId . '">';
            echo '<td hidden>' . $dishId . '</td>';
            echo '<td>' . $row['dish_name'] . '</td>';
            echo '<td hidden>' . $row['main_'] . '</td>';
            echo '<td hidden>' . $row['weight'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td><button type="button" class="badge btn btn-primary addToList" data-dish-id="' . $dishId . '" data-dish-name="' . $row['dish_name'] . '" data-dish-price="' . $row['price'] . '"><i class="bi bi-plus-square"></i></button></td>';
            echo '</tr>';
        }
    }
}
?>
