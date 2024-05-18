<?php
session_start();
include 'connection.php';
if (isset($_POST['submit'])) {

    $trans_id = $_POST['trans_id'];
    $qry = "SELECT customer FROM transactions WHERE trans_id = $trans_id";
    $result = $con->query($qry);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cName = $row['customer'];
        }
    }

    // Prepare the UPDATE query
    $sql = "UPDATE transactions SET status = 'Cancelled', date_cancelled = NOW() WHERE trans_id = ?";

    // Prepare and bind the parameter
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $trans_id);

    // Execute the query
    if ($stmt->execute()) {
        // Transaction cancellation successful

        // Transaction log
        date_default_timezone_set('Asia/Manila');
        $timestamp = date('Y-m-d H:i:s');
        $user_id = $_SESSION['user_id'];
        $name = $_SESSION['name'];

        $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          (?, ?, ?, 'Cancel Transaction', ?)";

        // Prepare and bind parameters for log query
        $logStmt = $con->prepare($query);
        $logStmt->bind_param('siss', $timestamp, $user_id, $name, $cName);

        // Execute log query
        if ($logStmt->execute()) {
            // Log entry successful
        } else {
            echo "Error: " . $query . "<br>" . $con->error;
        }

        // Close log statement
        $logStmt->close();

        // Redirect after successful cancellation
        echo "<script>
                alert('You have cancelled an order');
                window.location.href = 'transactions-cancelled.php';
              </script>";
    } else {
        // Error in cancellation
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close statement
    $stmt->close();

    // Close connection
    $con->close();
}
?>
