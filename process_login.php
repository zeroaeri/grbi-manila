
<?php
session_start();

$database_name = 'barangay_db';

$conn = mysqli_connect("localhost", "your_mysql_username", "your_mysql_password", $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($username) || empty($password)) {
  echo "<body style='display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;'>";

  echo "<div class='error-container' style='text-align: center; padding: 20px; border: 3px solid #dc3545; border-radius: 10px; background-color: #ffffff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.4); max-width: 400px; width: 150%;'>";
  echo "<i class='fas fa-lock shake' style='font-size: 58px; color: red; animation: shake 0.5s infinite alternate;'></i>";
  echo "<h2>Error</h2>";
  echo "<p style='font-size: 20px; margin-bottom: 20px;'>Username and password are required. Please <a href='login.php'draggable='false' style='color: #007bff; text-decoration: none;'>try again</a>.</p>";
  echo "</div>";
  echo "</body>";
    exit;
}


$sql = "SELECT id, username, role FROM users WHERE BINARY username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if ($result !== false) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
      
        if ($row['role'] == 'admin') {
          header("Location: admin_homepage.php");
          exit;
      } elseif ($row['role'] == 'dilg_manila') {
          header("Location: dilg_homepage.php");
          exit;
      } else {
          header("Location: barangay_homepage.php");
          exit;
      }
    } else {

        
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Error</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f8f9fa; 
  }
  .error-container {
    text-align: center;
    padding: 20px;
    border: 3px solid #dc3545; 
    border-radius: 10px; 
    background-color: #ffffff; 
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.4);
    max-width: 400px; 
    width: 150%; 
  }
  .error-container h2 {
    margin-bottom: 22px;
  }
  .error-container p {
    font-size: 20px; 
    margin-bottom: 20px; 
  }
  .error-container a {
    color: #007bff; 
    text-decoration: none; 
  }
  .error-container a:hover {
    text-decoration: underline; 
  }
  .shake {
    animation: shake 0.5s infinite;
  }

  @keyframes shake {
    0% {
      transform: translateX(-5px);
    }
    25% {
      transform: translateX(5px);
    }
    50% {
      transform: translateY(-5px);
    }
    75% {
      transform: translateY(5px);
    }
    100% {
      transform: translateY(-5px);
    }
  }
</style>
</head>
<body>
  <div class="error-container">
  <i class='fas fa-exclamation-triangle shake' style='font-size:65px;color:orange;padding-bottom:15px'></i>
    <h2>Incorrect Username or Password</h2>
    <p>Please <a href="login.php" draggable="false">try again</a>.</p>
  </div>
</body>
</html>