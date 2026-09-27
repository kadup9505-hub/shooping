<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url("top-view-raspberry-flavor-ice-cream.jpg") no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .welcome-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 50px 40px;
      border-radius: 20px;
      text-align: center;
      width: 400px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      animation: fadeIn 1s ease-in-out;
    }

    .welcome-box h1 {
      font-size: 28px;
      color: #333;
      margin-bottom: 10px;
    }

    .welcome-box p {
      font-size: 20px;
      color: #555;
      margin-bottom: 30px;
    }

    .logout-btn {
      background: linear-gradient(135deg, #ff4b5c, #ff6b81);
      border: none;
      padding: 14px 25px;
      border-radius: 10px;
      color: white;
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .logout-btn:hover {
      background: linear-gradient(135deg, #e63946, #ff4b5c);
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="welcome-box">
    <h1>🎉 Welcome!</h1>
    <p>Hello, <b><?php echo htmlspecialchars($username); ?></b> 👋</p>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>
</body>
</html>
