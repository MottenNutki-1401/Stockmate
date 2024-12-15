<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stockmate</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="LoginHeader">
            <h1>Stockmate</h1>
        </div>

        <div class="AdminButtonContainer">
            <button type="button" onclick="location.href='admin.php'">Admin</button>
        </div>

        <div class="LoginBody">
            <form action="login.php" method="post">
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
                <div class="RegisterButtonContainer">
                    <button type="button" onclick="location.href='register.php'">Register</button>
                </div>
            </form>
        </div>
    </div>

    <div class="big-line"></div>

    <?php
    session_start();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to the 'stockmate' database
        $conn = new mysqli("localhost", "root", "", "stockmate");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update the query to use the 'staff' table instead of 'users'
        $sql = "SELECT id, name, password, role FROM staff WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // 's' for string type
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $hashed_password, $role);

        // Check if the username exists and verify the password
        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Set session and redirect on success
            $_SESSION['username'] = $name;
            $_SESSION['user_id'] = $id; // Store user id in session if needed
            $_SESSION['role'] = $role;  // Store user role in session

            header("Location: welcome.php");
            exit();
        } else {
            echo "<p>Invalid username or password</p>";
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
