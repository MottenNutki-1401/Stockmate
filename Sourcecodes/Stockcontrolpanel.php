<?php
$host = 'localhost'; 
$dbname = 'stockmate'; 
$username = 'root'; 
$password = ''; 

//handle for error handling
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $query = "SELECT * FROM stock_items WHERE item_name LIKE :search_query";
    $statement = $pdo->prepare($query);
    $statement->execute(['search_query' => '%' . $search_query . '%']);
} else {
    $query = "SELECT * FROM stock_items";
    $statement = $pdo->prepare($query);
    $statement->execute();
}

// Fetch stock items
$stock_items = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockmate</title>
    <link rel="stylesheet" type="text/css" href="AdminDashboard.css">
    
</head>
<body>
    <div class="top-border">
        <a href="#" class="logout-link" title="Logout">
            <img src="/Stockmate/Assets/Logout03.png" alt="Logout Icon" class="logout-icon">
        </a>
    </div>
     
    <div class="sidebar">
        <div class="avatar">
            <img src="/Stockmate/Assets/Avatar.png" alt="admin">
        </div>
        <nav>
            <ul>
                <li><a href="Stockcontrolpanel.php"><img src="/Stockmate/Assets/icon.png" alt="Dashboard Icon"> Dashboard</a></li>
                <li class="stockcontrol"><a href="#"><img src="/Stockmate/Assets/stockcontrol.png" alt="Stock Control Icon"> Stock Control</a></li>
                <li><a href="supplier.php"><img src="/Stockmate/Assets/supplier.png" alt="Suppliers Icon"> Suppliers</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/staffs.png" alt="Staff Management Icon"> Staff Management</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/logs.png" alt="Activity Log Icon"> Activity Log</a></li>
                <form action="Stockcontrolpanel.php" method="GET"> <!--search query-->
            </ul>
        </nav>
    </div>
    
    <div class="stock-content">
        <div class="stockheader">
        
                <input type="text" name="search" placeholder="Search an item" class="search-bar" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="searchbtn"><img src="/Stockmate/Assets/search.png" alt="search icon"></button>
                
            </form>
            <a href="addproduct.php" class="add-product"><img src="/Stockmate/Assets/add.png" alt="Add Icon"> Add Product</a>
            <form action="deleteproduct.php" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected items?');">
                <button type="submit" class="deletebtn"><img src="/Stockmate/Assets/delete.png" alt="Delete Icon"></button>
        </div>

        <div class="table-container">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="toggle(this);" /></th>
                        <th>Product Image</th>
                        <th>Product</th>
                        <th>Stock Quantity</th>
                        <th>ID No.</th>
                        <th>Price (Php)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stock_items as $item): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="<?php echo $item['id']; ?>" /></td>
                            <td><img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Product Image" width="50"></td>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                            <td class="actions">
                                <a href="editproduct.php?id=<?php echo $item['id']; ?>" class="edit-btn">Edit</a>
                                <a href="deleteproduct.php?id=<?php echo $item['id']; ?>" class="remove-btn" onclick="return confirm('Are you sure you want to delete this item?');">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </form>
    </div>
</body>
</html>

<script>
function toggle(source) {
    checkboxes = document.getElementsByName('selected_items[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
}
</script>