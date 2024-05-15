<?php
include 'connection.php'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the filter value from the AJAX request
  $filter = $_POST['filter'];

  // Use this filter value in your SQL query to fetch the total transactions
  // Modify the SQL query according to your database structure
  $sql = "SELECT COUNT(trans_id) as total_transactions FROM transactions WHERE DATE_COLUMN >= :start_date AND DATE_COLUMN <= :end_date";
  // Adjust the date conditions based on the selected filter

  // Execute the query and fetch the result
  // Make sure to use prepared statements to prevent SQL injection


  $stmt = $con->prepare($sql);
  // Adjust the date conditions based on the selected filter
  if ($filter == 'Today') {
    $stmt->bindParam(':start_date', date('Y-m-d') . ' 00:00:00');
    $stmt->bindParam(':end_date', date('Y-m-d') . ' 23:59:59');
  } elseif ($filter == 'This Month') {
    $stmt->bindParam(':start_date', date('Y-m-01') . ' 00:00:00');
    $stmt->bindParam(':end_date', date('Y-m-t') . ' 23:59:59');
  } elseif ($filter == 'This Year') {
    $stmt->bindParam(':start_date', date('Y-01-01') . ' 00:00:00');
    $stmt->bindParam(':end_date', date('Y-12-31') . ' 23:59:59');
  }

  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Return the total transactions count to the frontend
  echo $result['total_transactions'];
}
?>
