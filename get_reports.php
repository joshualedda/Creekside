<?php
include('connection.php');

date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportType = $_POST['reportType'];
    $filterType = $_POST['filterType'];
    $limit = $_POST['limit'];

    $whereClause = '';

    if ($limit === ' ') {
        $limitClause = " ";
    } elseif ($limit === '10') {
        $limitClause = "LIMIT 10";
    } elseif ($limit === '25') {
        $limitClause = "LIMIT 25";
    } elseif ($limit === '50') {
        $limitClause = "LIMIT 50";
    }

    if ($filterType === 'Today') {
        $whereClause = " DATE(date_paid) = CURDATE()";
    } elseif ($filterType === 'This Month') {
        $whereClause = " MONTH(date_paid) = MONTH(CURDATE()) AND YEAR(date_paid) = YEAR(CURDATE())";
    } elseif ($filterType === 'This Year') {
        $whereClause = " YEAR(date_paid) = YEAR(CURDATE())";
    }

    $result = [];

    if ($reportType === 'Sales by staff') {
        $query = "SELECT CONCAT(users.fname,' ',users.lname) AS name, SUM(transactions.total_price) AS sales 
                  FROM `transactions` 
                  LEFT JOIN `users` ON users.user_id = transactions.user_id 
                  WHERE $whereClause AND transactions.status IN ('Completed', 'Paid')
                  GROUP BY transactions.user_id 
                  ORDER BY sales DESC
                  $limitClause";
    } elseif ($reportType === 'Sales per dish') {
        $query = "SELECT transactions.date_paid, dishes.dish_name as name, SUM(dishes_ordered.subtotal) AS sales 
                  FROM `dishes_ordered` 
                  LEFT JOIN `dishes` ON dishes.dish_id = dishes_ordered.dish_id
                  LEFT JOIN `transactions` ON transactions.trans_id = dishes_ordered.trans_id 
                  WHERE $whereClause AND transactions.status IN ('Completed', 'Paid')
                  GROUP BY dishes.dish_id 
                  ORDER BY sales DESC
                  $limitClause";
    } elseif ($reportType === 'Sales reports') {
        $query = "SELECT DATE(transactions.date) as date, dishes.dish_name, SUM(dishes_ordered.quantity) as quantity, dishes_ordered.price, SUM(dishes_ordered.subtotal) as subtotal, transactions.status
                  FROM transactions LEFT JOIN dishes_ordered ON dishes_ordered.trans_id = transactions.trans_id
                                  LEFT JOIN dishes ON dishes.dish_id = dishes_ordered.dish_id
                  WHERE $whereClause 
                  GROUP BY transactions.date, dishes_ordered.dish_id
                  ORDER BY transactions.date DESC, dishes.dish_name ASC
                  $limitClause";
    }

    $resultQuery = $con->query($query);

    if ($resultQuery) {
        while ($row = $resultQuery->fetch_assoc()) {
            $result[] = $row;
        }
    } else {
        $result['error'] = "Error: " . $query . "<br>" . $con->error;
    }

    echo json_encode($result);

    // Close the database connection
    $con->close();
}
