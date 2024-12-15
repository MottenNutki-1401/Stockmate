<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stockmate - Admin Panel</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Load the content dynamically when menu items are clicked
        function loadContent(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(response) {
                    $('.main-content').html(response);
                },
                error: function() {
                    alert('Error loading content.');
                }
            });
        }

        // Load the product edit form via AJAX
        function loadEditProductForm(productId) {
            $.ajax({
                url: 'getProductDetails.php',
                type: 'GET',
                data: { id: productId },
                success: function(response) {
                    $('.main-content').html(response);
                },
                error: function() {
                    alert('Error loading product details.');
                }
            });
        }

        // Delete product with AJAX
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: 'Stockcontrolpanel.php',
                    type: 'POST',
                    data: { action: 'delete', delete_id: id },
                    success: function(response) {
                        loadContent('Stockcontrolpanel.php'); // Reload stock control panel content
                    },
                    error: function() {
                        alert('Error deleting product.');
                    }
                });
            }
        }
    </script>
</head>
<body>
    <div class="top-border">
        <a href="logout.php" class="logout-link" title="Logout">
            <img src="Assets/Logout03.png" alt="Logout Icon" class="logout-icon">
        </a>
    </div>

    <div class="sidebar">
        <div class="avatar">
            <img src="Assets/Avatar.png" alt="admin">
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="loadContent('Dashboard.php');"><img src="Assets/icon.png"> Dashboard</a></li>
                <li><a href="#" onclick="loadContent('Stockcontrolpanel.php');"><img src="Assets/stockcontrol.png"> Stock Control</a></li>
                <li><a href="#" onclick="loadContent('Suppliers.php');"><img src="Assets/supplier.png"> Suppliers</a></li>
                <li><a href="#" onclick="loadContent('StaffManagement.php');"><img src="Assets/staffs.png"> Staff Management</a></li>
                <li><a href="#" onclick="loadContent('ActivityLog.php');"><img src="Assets/logs.png"> Activity Log</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <h1>Welcome to Stockmate Admin Panel</h1>
    </div>
</body>
</html>
