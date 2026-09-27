<?php
session_start();

$host = "sql209.infinityfree.com";
$user = "if0_43024631";
$pass = "joNyaKm3Fp4n57";
$dbname = "if0_43024631_online";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;

            // ✅ Stylish Welcome Screen
            echo "
            <div style='
                font-family: Arial, sans-serif;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
                text-align: center;
            '>
                <div style='background: white; padding: 40px; border-radius: 15px; 
                            box-shadow: 0 4px 20px rgba(0,0,0,0.2); width: 400px;'>
                    <h1 style='color: #333;'>Welcome, <span style='color: #007bff;'>$username</span> 🎉</h1>
                    <p style='font-size: 18px; margin: 15px 0;'>You are successfully logged in!</p>
                    
                    <a href='index.html' style='
                        display: inline-block;
                        margin: 10px 0;
                        padding: 12px 25px;
                        background: #28a745;
                        color: white;
                        text-decoration: none;
                        border-radius: 8px;
                        font-size: 16px;
                    '>Go to Home Page</a>
                    
                    <a href='logout.php' style='
                        display: inline-block;
                        margin: 10px 0;
                        padding: 12px 25px;
                        background: #dc3545;
                        color: white;
                        text-decoration: none;
                        border-radius: 8px;
                        font-size: 16px;
                    '>Logout</a>
                </div>
            </div>
            ";
        } else {
            echo "<p style='color:red; font-size:18px;'>❌ Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red; font-size:18px;'>⚠️ No user found with that email.</p>";
    }
}
$conn->close();
?>
