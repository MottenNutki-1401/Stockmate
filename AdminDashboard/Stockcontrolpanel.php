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

// Handle AJAX deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM stock_items WHERE id = :id");
    $stmt->execute(['id' => $delete_id]);

    // Return updated stock list
    loadStockTable($pdo);
    exit();
}

// Function to load stock table with product data
function loadStockTable($pdo) {
    $query = "SELECT * FROM stock_items";
    $stmt = $pdo->query($query);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as $item) {
        echo "<tr>
                <td><input type='checkbox'></td>
                <td><img src='" . htmlspecialchars($item['image_path']) . "' alt='Product Image' width='50'></td>
                <td>" . htmlspecialchars($item['item_name']) . "</td>
                <td>" . htmlspecialchars($item['quantity']) . "</td>
                <td>" . htmlspecialchars($item['item_id']) . "</td>
                <td>" . htmlspecialchars($item['price']) . "</td>
                <td>
                    <button onclick='loadEditProductForm({$item['id']})' class='edit-btn'>Edit</button>
                    <button onclick='deleteProduct({$item['id']})' class='remove-btn'>Remove</button>
                </td>
              </tr>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Control</title>
    <link rel="stylesheet" href="AdminDashboard.css">
</head>
<body>
    <div class="stock-content">
        <div class="stockheader">
            <input type="text" placeholder="Search an item" class="search-bar">
            <button class="searchbtn"><img src="Assets/search.png" alt="Search"></button>
            <a href="addproduct.php" class="add-product"><img src="Assets/add.png"> Add Product</a>
        </div>
        <div class="table-container">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th></th>
                        <th>Product</th>
                        <th>Stock Quantity</th>
                        <th>ID No.</th>
                        <th>Price (Php)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php loadStockTable($pdo); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php } ?>
