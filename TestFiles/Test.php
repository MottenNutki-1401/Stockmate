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
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <img src="sample-image.png" alt="Product Image" class="product-img">
                        Sample1
                    </td>
                    <td>30</td>
                    <td>10763</td>
                    <td>500</td>
                    <td>
                        <button class="edit-btn">Edit</button>
                        <button class="remove-btn">Remove</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">No more items</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
