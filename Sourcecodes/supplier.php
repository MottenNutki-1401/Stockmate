<?php
// filepath: /c:/xampp/htdocs/Stockmate/Sourcecodes/supplier.php

$host = 'localhost'; 
$dbname = 'stockmate'; // Database name
$username = 'root'; 
$password = '';

// Error handling for database connection
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
    $query = "SELECT * FROM suppliers WHERE company_name LIKE :search_query";
    $statement = $pdo->prepare($query);
    $statement->execute(['search_query' => '%' . $search_query . '%']);
} else {
    $query = "SELECT * FROM suppliers";
    $statement = $pdo->prepare($query);
    $statement->execute();
}

// Fetch suppliers
$suppliers = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
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
                <li><a href="#"><img src="/Stockmate/Assets/icon.png"> Dashboard</a></li>
                <li><a href="Stockcontrolpanel.php"><img src="/Stockmate/Assets/stockcontrol.png"> Stock Control</a></li>
                <li class="stockcontrol"><a href="supplier.php"><img src="/Stockmate/Assets/supplier.png"> Suppliers</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/staffs.png"> Staff Management</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/logs.png"> Activity Log</a></li>
                
            </ul>
        </nav>
    </div>
    <form action="supplier.php" method="GET"> <!--search query-->
    <form action="deletesupplier.php" method="post"> <!-- Ensure the form action is set to deletesupplier.php -->
        <div class="stock-content">
            <div class="stockheader">
                <input type="text" name="search" placeholder="Search a distributor" class="search-bar" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="searchbtn"><img src="/Stockmate/Assets/search.png" alt="search icon"></button>
                <a href="addsupplier.php" class="add-product"><img src="/Stockmate/Assets/add.png"> Add supplier</a>
                <button type="submit" class="deletebtn"><img src="/Stockmate/Assets/delete.png"></button> <!-- Ensure the button type is submit -->
            </div>
        </div>

        <div class="table-container">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="toggle(this);" /></th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Serial No.</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $company): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="<?php echo $company['id']; ?>" /></td>
                            <td><?php echo htmlspecialchars($company['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($company['address']); ?></td>
                            <td><?php echo htmlspecialchars($company['serial_no']); ?></td>
                            <td><?php echo htmlspecialchars($company['contact']); ?></td>
                            <td class="actions">
                                <a href="editsupplier.php?id=<?php echo $company['id']; ?>" class="edit-supplier">Edit</a>
                                <a href="deletesupplier.php?id=<?php echo $company['id']; ?>" class="remove-supplier" onclick="return confirm('Are you sure you want to delete this supplier?');">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
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