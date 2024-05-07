<?php
session_start();

$database_name = 'barangay_db';

$conn = mysqli_connect("localhost", "your_mysql_username", "your_mysql_password", $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['savechanges'])) {
    $selectedBarangayId = isset($_POST['selectedBarangayId']) ? $_POST['selectedBarangayId'] : null;
    $newPassword = isset($_POST['newpassword']) ? trim($_POST['newpassword']) : '';
    $confirmPassword = isset($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : '';


  // Check if the new password is the same as the existing password
  $sqlCheckPassword = "SELECT password FROM users WHERE id = ?";
  $stmtCheckPassword = mysqli_prepare($conn, $sqlCheckPassword);
  mysqli_stmt_bind_param($stmtCheckPassword, "i", $selectedBarangayId);
  mysqli_stmt_execute($stmtCheckPassword);
  mysqli_stmt_bind_result($stmtCheckPassword, $storedPassword);
  mysqli_stmt_fetch($stmtCheckPassword);
  mysqli_stmt_close($stmtCheckPassword);

  if ($newPassword === $storedPassword) {
      echo "<script>alert('New password is the same as the existing password');</script>";
      echo "<script>window.location.href='admin_homepage.php';</script>";
      die();
  }

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match');</script>";
        echo "<script>window.location.href='admin_homepage.php';</script>";
        die();
    }

   
    $sqlUpdatePassword = "UPDATE users SET password = ? WHERE id = ?";
    $stmtUpdatePassword = mysqli_prepare($conn, $sqlUpdatePassword);
    mysqli_stmt_bind_param($stmtUpdatePassword, "si", $newPassword, $selectedBarangayId);
    mysqli_stmt_execute($stmtUpdatePassword);
    mysqli_stmt_close($stmtUpdatePassword);

    echo "<script>alert('Password updated successfully');</script>";
    echo "<script>window.location.href='admin_homepage.php';</script>";
    exit();

} else {
 
    die("Invalid request");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
</body>
</html>