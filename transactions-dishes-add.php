<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $trans_id = $_POST['trans_id'];
    $order_details_json = $_POST['order_details'];
    $delivery_method = $_POST['delivery_method'];
    $delivery_date = $_POST['delivery_date'];
    $total_price = $_POST['total_price'];
    $qry = "SELECT customer FROM transactions WHERE trans_id = $trans_id";
    $result = $con->query($qry);
    if ($result) {
        while ($row = $result->fetch_assoc()) { 
            $cName = $row['customer'];
        }
    }

    // Decode the JSON string to an array
    $order_details = json_decode($order_details_json, true);

    // Insert or update transaction details in the database
    $transactionQuery = "UPDATE transactions 
                         SET delivery_method = '$delivery_method', 
                             delivery_date = '$delivery_date',
                             total_price = '$total_price'
                         WHERE trans_id = $trans_id";

//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Take Order', 'Listed dishes ordered by $cName and updated transaction details')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log

    if ($con->query($transactionQuery) === TRUE) {
        // Delete existing order details for the specified trans_id
        $deleteQuery = "DELETE FROM dishes_ordered WHERE trans_id = $trans_id";
        $con->query($deleteQuery);

        // Insert or update order details into the database
        foreach ($order_details as $order) {
            $dish_id = $order['dishId'];
            $quantity = $order['quantity'];
            $price = $order['price'];
            $subtotal = $order['subtotal'];

            $dishesOrderedQuery = "INSERT INTO dishes_ordered (trans_id, dish_id, quantity, price, subtotal) 
                                  VALUES ('$trans_id', '$dish_id', '$quantity', '$price', '$subtotal')";

            $con->query($dishesOrderedQuery);
        }

        echo "
            <script = 'text/javascript>
                alert('You have successfuly updated order details!');
                location.href = 'transactions-pending.php';
            </script>
            ";
    } else {
        echo "Error: " . $transactionQuery . "<br>" . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>
