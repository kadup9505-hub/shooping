<?php
// admin.php
$servername = "sql209.infinityfree.com";
$username = "if0_43024631";
$password = "joNyaKm3Fp4n57";
$dbname = "if0_43024631_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products from database
$sql = "SELECT * FROM products ORDER BY product_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Frosty Delights</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff4f8;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #ff4f8b;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }

    th {
      background: linear-gradient(90deg, #ff7eb3, #ff758c);
      color: white;
      font-size: 16px;
    }

    img {
      width: 80px;
      height: auto;
      border-radius: 8px;
    }

    .low-stock {
      color: red;
      font-weight: bold;
    }

    .out-of-stock {
      color: darkred;
      font-weight: bold;
      background-color: #ffd6d6;
    }
  </style>
</head>
<body>
  <h1>Admin Panel - Product Management</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Image</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Highlight low stock or out of stock
            if($row['stock'] == 0) {
                $stockClass = "out-of-stock";
                $stockText = "Out of Stock";
            } elseif($row['stock'] <= 5) {
                $stockClass = "low-stock";
                $stockText = $row['stock'];
            } else {
                $stockClass = "";
                $stockText = $row['stock'];
            }

            echo "<tr>
                    <td>{$row['product_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>₹{$row['price']}</td>
                    <td class='{$stockClass}'>{$stockText}</td>
                    <td><img src='{$row['image_url']}' alt='{$row['name']}'></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No products found in the database.</td></tr>";
    }
    $conn->close();
    ?>
  </table>
</body>
</html>
