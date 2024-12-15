<?php
// Database connection
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['product_name'];
    $quantity = $_POST['stock_quantity'];
    $item_id = $_POST['control_number'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Handle file upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (5MB max)
    if ($image["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Insert into database
    $query = "INSERT INTO stock_items (item_name, quantity, item_id, price, image_path) VALUES (?, ?, ?, ?, ?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$item_name, $quantity, $item_id, $price, $target_file]);

    // Return success response as JSON and signal redirect to AdminDashboard.php
    echo json_encode(['success' => true, 'redirect' => 'AdminDashboard.php']);
    exit();
}
?>

<!DOCTYPE html>
<html> 
<head>
    <title>Stockmate</title>
    <link rel="stylesheet" type="text/css" href="AdminDashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head> 
<body> 
    <div class="top-border">
        <a href="#" class="logout-link" title="Logout">
            <img src="/Stockmate/AdminDashboard/Assets/Logout03.png" alt="Logout Icon" class="logout-icon">
        </a>
    </div>

    <div class="sidebar">
        <div class="avatar">
            <img src="/Stockmate/AdminDashboard/Assets/Avatar.png" alt="admin">
        </div>
        <nav>
            <ul>
                <li><a href="Stockcontrolpanel.php"><img src="/Stockmate/AdminDashboard/Assets/icon.png"> Dashboard </a></li>
                <li class="stockcontrol"><a href="#"><img src="/Stockmate/AdminDashboard/Assets/stockcontrol.png"> Stock Control </a></li>
                <li><a href="#"><img src="/Stockmate/AdminDashboard/Assets/supplier.png"> Suppliers </a></li>
                <li><a href="#"><img src="/Stockmate/AdminDashboard/Assets/staffs.png"> Staff Management</a></li>
                <li><a href="#"><img src="/Stockmate/AdminDashboard/Assets/logs.png"> Activity Log</a></li>
            </ul>
        </nav>
    </div>

    <div class="stock-container">
        <h1>Stock Details</h1>
        <form id="addProductForm" method="POST" enctype="multipart/form-data">
            <div class="form-layout">
                <div class="image-upload">
                    <label for="product_image">
                        <div class="upload-area">
                            <img src="/Stockmate/AdminDashboard/Assets/Upload.png" alt="Upload Icon">
                            <p>Upload an image</p>
                        </div>
                    </label>
                    <input type="file" id="product_image" name="image" accept="image/*">
                </div>
                <div class="details-form">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="control_number">ID No. / Control No.</label>
                        <input type="text" id="control_number" name="control_number" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Unit Price (₱)</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-btn">Submit Item</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#addProductForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this); // Get the form data

                $.ajax({
                    url: 'addproduct.php',  // URL where the form will be submitted
                    type: 'POST',
                    data: formData,
                    contentType: false,  // Let jQuery handle content type
                    processData: false,  // Let jQuery handle data processing
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            alert(data.message);  // Show success message
                            window.location.href = data.redirect;  // Redirect to AdminDashboard.php
                        } else {
                            alert('Error: ' + data.message);
                        }
                    },
                    error: function() {
                        alert('Error submitting the form.');
                    }
                });
            });
        });
    </script>
</body>
</html>
