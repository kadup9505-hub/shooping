<?php
// order.php
header('Content-Type: application/json'); // Return JSON response

$servername = "sql209.infinityfree.com";
$username = "if0_43024631";
$password = "joNyaKm3Fp4n57";
$dbname = "if0_43024631_online";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Check if POST variables are set
if(isset($_POST['product_id']) && isset($_POST['quantity'])) {
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Validate stock before inserting order
    $stockCheck = $conn->prepare("SELECT stock FROM products WHERE product_id = ?");
    $stockCheck->bind_param("i", $product_id);
    $stockCheck->execute();
    $stockResult = $stockCheck->get_result();

    if($stockResult->num_rows == 0){
        echo json_encode(["status" => "error", "message" => "Product not found."]);
        exit;
    }

    $row = $stockResult->fetch_assoc();
    if($row['stock'] < $quantity){
        echo json_encode(["status" => "error", "message" => "Not enough stock available."]);
        exit;
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO admin_orders (product_id, quantity) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $quantity);

    if($stmt->execute()){
        // ✅ Decrease stock in products table
        $updateStock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
        $updateStock->bind_param("ii", $quantity, $product_id);
        $updateStock->execute();
        $updateStock->close();

        echo json_encode(["status" => "success", "message" => "Order placed successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error placing order: " . $stmt->error]);
    }

    $stmt->close();
    $stockCheck->close();

} else {
    echo json_encode(["status" => "error", "message" => "Product ID and quantity are required."]);
}

$conn->close();
?>
