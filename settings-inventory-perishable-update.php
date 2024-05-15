<?php 
  session_start();
  include 'connection.php';
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];

    // Get the current quantity before the update
    $queryBeforeUpdate = "SELECT quantity FROM inventory_perishable WHERE id = $id";
    $resultBeforeUpdate = mysqli_query($con, $queryBeforeUpdate);

    if ($resultBeforeUpdate) {
      $rowBeforeUpdate = mysqli_fetch_assoc($resultBeforeUpdate);
      $oldQuantity = $rowBeforeUpdate['quantity'];

      // Update the inventory_perishable table
      $sql = "UPDATE inventory_perishable SET item_name = '$item_name', quantity = $quantity WHERE id = $id";

      if (mysqli_query($con, $sql)) {
        // Calculate the difference in quantity
        $quantityDifference = $quantity - $oldQuantity;

        // Insert a log entry
        date_default_timezone_set('Asia/Manila');
        $timestamp = date('Y-m-d H:i:s');
        $user_id = $_SESSION['user_id'];
        $name = $_SESSION['name'];

        $action = ($quantityDifference >= 0) ? 'Added' : 'Deducted';
        $preposition = ($quantityDifference >= 0) ? 'into' : 'from';
        $description = "$action " . abs($quantityDifference) . " kilogram(s) of $item_name $preposition inventory of perishables";

        $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
        ('$timestamp', $user_id, '$name', 'Update Item', '$description')";

        if (mysqli_query($con, $query)) {
          echo "
          <script type='text/javascript'>
            alert('You have successfully updated item details!');
            location.href = 'settings-inventory.php';
          </script>
          ";
        } else {
          echo "Error: " . $query . "<br>" . mysqli_error($con); 
        }
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
      }
    } else {
      echo "Error: " . $queryBeforeUpdate . "<br>" . mysqli_error($con);
    }
  }
?>
