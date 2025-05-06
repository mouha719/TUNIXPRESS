<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "tunixpress";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  
            $_SESSION['user_email'] = $user['email'];  
            $message = "Login successful! Redirecting to home...";
            $redirect = "home.php"; 
        } else {
            $message = "Incorrect password.";
            $redirect = "login.html";
        }
    } else {
        $message = "Email not found.";
        $redirect = "login.html";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Status</title>
  <meta http-equiv="refresh" content="3;url=<?= $redirect ?>"> 
  <link rel="stylesheet" href="../css/global-style.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
    }
    .message-box {
      background-color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message-box h2 {
      color: #333;
    }
    .message-box p {
      color: #555;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2><?= htmlspecialchars($message) ?></h2>
    <p>You will be redirected shortly...</p>
  </div>
</body>
</html>
