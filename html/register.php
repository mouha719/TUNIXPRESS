<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "tunixpress";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $message = "Email already registered.";
        $redirect = "register.html";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            $message = "Registration successful! Redirecting to home...";
            $redirect = "home.html";
        } else {
            $message = "Registration failed. Please try again.";
            $redirect = "register.html";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Status</title>
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
