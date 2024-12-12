<?php
// Database connection (reuse from stock_control.php)
require 'stock_control.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $item_id = $_POST['item_id'];
    $price = $_POST['price'];

    // Insert into database
    $query = "INSERT INTO stock_items (item_name, quantity, item_id, price) VALUES (?, ?, ?, ?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$item_name, $quantity, $item_id, $price]);

    // Redirect back to stock control
    header('Location: stock_control.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <h1>Add Product</h1>
        <form method="POST">
            <label for="item_name">Product Name:</label>
            <input type="text" id="item_name" name="item_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="item_id">ID Number:</label>
            <input type="number" id="item_id" name="item_id" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <button type="submit">Add Product</button>
        </form>
        <a href="stock_control.php">Back to Stock Control</a>
    </div>
</body>
</html>
