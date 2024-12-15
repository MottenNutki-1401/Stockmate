<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="LoginHeader">
            <h1>Admin</h1>
        </div>
        
        <div class="AdminButtonContainer">
            <button type="button" onclick="location.href='login.php'">Login</button>
        </div>
        
        <div class="LoginBody">
            <form action="admin.php" method="post">
                <div class="LoginInputsContainer">
                    <label for="">Username</label>
                    <input placeholder="Username" name="username" type="text" required>
                </div>
                
                <div class="LoginInputsContainer">
                    <label for="">Password</label>
                    <input placeholder="Password" name="password" type="password" required>
                </div>
                
                <div class="LoginButtonContainer">
                    <button>Login</button>
                </div>
            </form>
        </div>
    </div>

    <div class="big-line"></div>

    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to the 'stockmate' database
        $conn = new mysqli("localhost", "root", "", "stockmate");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to check the username and password in the 'staff' table
        $sql = "SELECT id, name, password, role FROM staff WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // 's' for string type
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $hashed_password, $role);

        // Check if the username exists and verify the password
        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Check if the role is 'admin' before allowing access
            if ($role === 'admin') {
                $_SESSION['username'] = $name;
                $_SESSION['user_id'] = $id; // Store user id in session if needed
                header("Location: /Stockmate/AdminDashboard/AdminDashboard.php");
                exit;
            } else {
                echo "Access denied. Only admins can log in.";
            }
        } else {
            echo "Invalid username or password.";
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
