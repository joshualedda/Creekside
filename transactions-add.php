<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {
	
		$customer = $_POST['customer'];
		$id = $_POST['id'];
		$status = $_POST['status'];

		$sql = "INSERT INTO transactions 
                  (customer,
								   user_id,
								   status)
						   VALUES ('$customer',
								   $id,
								   '$status')"; 
		if (mysqli_query($con, $sql)) { 
//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'New Transaction', 'Listed new transaction with $customer')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log
?>


<?php		
			echo "
				<script = 'text/javascript>
					alert('You have successfuly added a new order!');
					location.href = 'transactions-pending.php';
				</script>
				";
		} else { echo "Error: " . $sql . "<br>" . mysqli_error($con);
			// echo "
			// 	<script = 'text/javascript>
			// 		alert('Adding new user profile was unsuccessful!');
			// 		location.href = 'settings-account.php';
			// 	</script>
			// 	";
			}

	}
?>