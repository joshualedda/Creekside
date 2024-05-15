<?php
	session_start();
    error_reporting(0);

	include 'backup_function.php';
	include 'connection.php';

	if(isset($_POST['backupnow'])){

		$server = $_POST['server'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$dbname = $_POST['dbname'];

		
		backDb($server, $username, $password, $dbname);

//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'System Backup', 'Created a system backup')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log

		exit();
		
	}
	else{
		echo 'Add All Required Field';
	}

?>