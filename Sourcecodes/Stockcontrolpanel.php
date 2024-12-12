<?php
$host = 'localhost'; // Replace with your MySQL host
$dbname = 'stockmate'; // Replace with your MySQL database name
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
<html> 
    <title>Stockmate</title>
    <link rel = "stylesheet" type ="text/css" href ="AdminDashboard.css">
    <head> 
    <body> 
    <div class="top-border">
  <a href="#" class="logout-link" title="Logout">
    <img src="/Stockmate/Assets/Logout03.png" alt="Logout Icon" class="logout-icon">
  </a>
</div>


    </div>
        <div class = "sidebar">
               <div class = "avatar">
                <img src ="/Stockmate/Assets/Avatar.png"  alt ="admin">
        </div>
        <nav>
         <ul class> 
               <li> <a href = "Stockcontrolpanel.php"> <img src ="/Stockmate/Assets/icon.png" > Dashboard </a></li>
               <li class="stockcontrol"> <a href ="#"><img src ="/Stockmate/Assets/stockcontrol.png" > Stock Control </a> </li>
               <li><a href="#"><img src ="/Stockmate/Assets/supplier.png" > Suppliers </a></li>
                <li><a href="#"><img src ="/Stockmate/Assets/staffs.png" > Staff Management</a></li>
                <li><a href="#"><img src ="/Stockmate/Assets/logs.png" > Activity Log</a></li>




         </ul>


        </nav>

        </div>
        <div class = stock-content> 
          <div class="stockheader">
           <input type="text" placeholder="Search an item" class="search-bar">
           <button class="searchbtn"><img src="/Stockmate/Assets/search.png" alt="search icon"></button>
           <a href="addproduct.php" class="add-product"><img src="/Stockmate/Assets/add.png"> Add Product </a> 
           <button class="deletebtn"><img src="/Stockmate/Assets/delete.png"></button>
          </div>


          <div class="table-container">
  <table class="stock-table">
    <thead>
      <tr>
        <th><input type="checkbox" /></th>
        <th></th>
        <th>Product</th>
        <th>Stock Quantity</th>
        <th>ID No.</th>
        <th>Price (Php)</th>
        <th>Actions</th>
      </tr>
    </thead>
    
    <?php foreach ($stock_items as $item): ?>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Product Image" width="50"></td>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                            <td class="actions">
                                <button class="edit-btn">Edit</button>
                                <button class="remove-btn">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>


