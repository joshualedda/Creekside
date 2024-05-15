<?php
include('connection.php');

if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];
    
    $sql = "SELECT * FROM dishes WHERE status = 'Available' AND dish_name LIKE '%$searchQuery%' ORDER BY dish_name ASC";
    $result = $con->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>' .
                '<td hidden>' . $row['dish_id'] . '</td>' .
                '<td>' . $row['dish_name'] . '</td>' .
                '<td>' . $row['price'] . '</td>' .
                '<td><button type="button" class="btn btn-primary btn-sm addToList"><i class="bi bi-plus-circle"></i></button></td>' .
                '</tr>';
        }
    }
}
?>
