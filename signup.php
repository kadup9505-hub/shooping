<?php
$host = "sql209.infinityfree.com";
$user = "if0_43024631";
$pass = "joNyaKm3Fp4n57";
$dbname = "if0_43024631_online";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>❌ Email already registered. Try another.</p>";
        echo "<a href='signup.html'>Go Back</a>";
    } else {
        // ✅ Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // ✅ Success → redirect to login
            header("Location: login.html?signup=success");
            exit;
        } else {
            echo "<p style='color:red;'>⚠️ Something went wrong. Please try again.</p>";
        }
    }
}
$conn->close();
?>
