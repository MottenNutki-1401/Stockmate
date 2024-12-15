<?php


$host = 'localhost';
$dbname = 'stockmate'; // Replace with your MySQL database name
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $serial_no = $_POST['serial_no'];
    $contact = $_POST['contact'];

    
    $query = "UPDATE suppliers SET company_name = ?, address = ?, serial_no = ?, contact = ? WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$company_name, $address, $serial_no, $contact, $id]);

    // Redirect back to supplier panel
    header('Location: supplier.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM suppliers WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);
    $company = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$company) {
        die("Supplier not found.");
    }
} else {
    die("Invalid request.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
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
                <li ><a href="#"><img src="/Stockmate/Assets/stockcontrol.png" alt="Stock Control Icon"> Stock Control</a></li>
                <li class="stockcontrol"><a href="supplier.php"><img src="/Stockmate/Assets/supplier.png" alt="Suppliers Icon"> Suppliers</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/staffs.png" alt="Staff Management Icon"> Staff Management</a></li>
                <li><a href="#"><img src="/Stockmate/Assets/logs.png" alt="Activity Log Icon"> Activity Log</a></li>
            </ul>
          </nav>
          </div>

                   <div class="stock-container">
                <h1>Edit Supplier</h1>
            <form action="editsupplier.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($company['id']); ?>">

                  <div class="form-layout">
                <div class="image-upload">
                    <label for="product_image">
                        <div class="upload-area">
                            <img src="/Stockmate/Assets/truck.png">
                            <p>Change Distributor's Details</p>
                        </div>
                               </label>
                </div>
                <div class="details-form">
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                       </div>

                            <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($company['address']); ?>" required>
                          </div>

                          <div class="form-group">
                        <label for="serial_no">Serial No.:</label>
                        <input type="text" id="serial_no" name="serial_no" value="<?php echo htmlspecialchars($company['serial_no']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Telephone Number:</label>
                        <input type="number" id="contact" name="contact" step="0.01" value="<?php echo htmlspecialchars($company['contact']); ?>" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-btn">Update Supplier Details</button>
        </form>
           </div>
</body>
</html>