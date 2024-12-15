<?php
// Database connection
$host = 'localhost';
$dbname = 'stockmate';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM stock_items WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo '<h1>Edit Product</h1>';
        echo '<form action="editproduct.php" method="POST" enctype="multipart/form-data">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($product['id']) . '">';
        echo '<div class="form-group">';
        echo '<label for="item_name">Product Name</label>';
        echo '<input type="text" id="item_name" name="item_name" value="' . htmlspecialchars($product['item_name']) . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="quantity">Quantity</label>';
        echo '<input type="number" id="quantity" name="quantity" value="' . htmlspecialchars($product['quantity']) . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="item_id">ID No.</label>';
        echo '<input type="text" id="item_id" name="item_id" value="' . htmlspecialchars($product['item_id']) . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="price">Price (₱)</label>';
        echo '<input type="number" id="price" name="price" step="0.01" value="' . htmlspecialchars($product['price']) . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="image">Product Image</label>';
        echo '<input type="file" id="image" name="image">';
        echo '</div>';
        echo '<button type="submit">Save Changes</button>';
        echo '</form>';
    }
}
?>
