<?php
// Database connection
$host = 'localhost';
$dbname = 'test';
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch stock items
$query = "SELECT * FROM stock_items";
$statement = $pdo->prepare($query);
$statement->execute();
$stock_items = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="profile.png" alt="Profile Picture" class="profile-img">
            <p>Ritchell Malang</p>
        </div>
        <ul class="menu">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><a href="#">Stock Control</a></li>
            <li><a href="#">Suppliers</a></li>
            <li><a href="#">Staff Management</a></li>
            <li><a href="#">Activity Log</a></li>
        </ul>
        <a href="#" class="logout">⟲ Logout</a>
    </div>

    <div class="main">
        <div class="header">
            <input type="text" placeholder="Search an item..." class="search-bar">
            <button class="search-btn">🔍</button>
            <a href="addproduct.php" class="add-product">+ Add Product</a>
        </div>

        <table class="stock-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Stock Quantity</th>
                    <th>ID No.</th>
                    <th>Price (Php)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($stock_items) > 0): ?>
                    <?php foreach ($stock_items as $item): ?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td><?= htmlspecialchars($item['item_name']); ?></td>
                            <td><?= htmlspecialchars($item['quantity']); ?></td>
                            <td><?= htmlspecialchars($item['item_id']); ?></td>
                            <td><?= htmlspecialchars($item['price']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $item['id']; ?>" class="edit-btn">Edit</a>
                                <a href="delete_product.php?id=<?= $item['id']; ?>" class="remove-btn" onclick="return confirm('Are you sure?')">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No more items</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
