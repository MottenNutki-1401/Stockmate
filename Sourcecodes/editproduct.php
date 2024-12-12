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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $item_id = $_POST['item_id'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Handle file upload if a new image is uploaded
    if ($image['name']) {
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

        // Update the product with the new image path
        $query = "UPDATE stock_items SET item_name = ?, quantity = ?, item_id = ?, price = ?, image_path = ? WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$item_name, $quantity, $item_id, $price, $target_file, $id]);
    } else {
        // Update the product without changing the image
        $query = "UPDATE stock_items SET item_name = ?, quantity = ?, item_id = ?, price = ? WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$item_name, $quantity, $item_id, $price, $id]);
    }

    // Redirect back to stock control panel
    header('Location: stockcontrolpanel.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM stock_items WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        die("Product not found.");
    }
} else {
    die("Invalid request.");
}
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

  <div class="stock-container">
    <h1>Stock Details</h1>
    <form action="addproduct.php" method="POST" enctype="multipart/form-data">
      <div class="form-layout">
        <div class="image-upload">
          <label for="product_image">
            <div class="upload-area">
              <img src="/Stockmate/Assets/Upload.png" alt="Upload Icon">
              <p>upload an image</p>
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
</body>
</html>
