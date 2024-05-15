<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['email'];

    // Prepare and execute the query
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $userEmail); // 's' represents string type
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $con->close();

    $user = null;

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch the user data
    }

    if (!$user) {
        echo 'Email not found in the database. Password reset email was not sent.';
    } else {
        $resetToken = bin2hex(random_bytes(16));
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'reissathena64@gmail.com';
            $mail->Password   = 'jjvqrhyxbqefixoy'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; // You can also try port 587 for TLS

            $mail->setFrom('reissathena64@gmail.com', 'Admin');
            $mail->addAddress($userEmail);

            $resetLink = 'http://localhost/cms/auth/resetPass.php?token=' . $resetToken . '&username=' . urlencode($user['username']);

            $mail->Subject = 'Password Reset';
            $mail->Body = "Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";
            $mail->AltBody = 'Copy and paste the following URL in your browser: ' . $resetLink;
            $mail->send();

            // Redirect the user to the login page after sending the email
            header('Location: ../index.php');
            
        } catch (Exception $e) {
            echo 'An error occurred while sending the email: ' . $e->getMessage();
            // To get more detailed error information, uncomment the following line:
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?>


