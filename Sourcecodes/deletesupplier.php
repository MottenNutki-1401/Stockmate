<?php
// filepath: /c:/xampp/htdocs/Stockmate/Sourcecodes/deletesupplier.php

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

// Delete from MySQL tables
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
        $selected_items = $_POST['selected_items'];
        foreach ($selected_items as $id) {
            $query = "DELETE FROM suppliers WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$id]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM suppliers WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);
}

// Redirect back to supplier panel
header('Location: supplier.php');
exit();
?>