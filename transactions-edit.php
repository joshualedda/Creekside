<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {
	
		$customer = $_POST['customer'];
		$trans_id = $_POST['trans_id'];

		$qry = "SELECT customer FROM transactions WHERE trans_id = $trans_id";
		$result = $con->query($qry);
		if ($result) {
			while ($row = $result->fetch_assoc()) { 
				$cName = $row['customer'];
			}
		}

		$sql = "UPDATE transactions SET customer = '$customer' WHERE trans_id = $trans_id"; 
		if (mysqli_query($con, $sql)) { 
//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Edit Customer Name', 'Edited $cName\'s name to $customer')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log
?>


<?php		
			echo "
				<script = 'text/javascript>
					alert('You have edited a customer\'s name');
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