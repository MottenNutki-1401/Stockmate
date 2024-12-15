<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
    <div class="RegisterHeader">
        <h1>Register</h1>
    </div>

    <div class="LoginButtonContainer">
        <button type="button" onclick="location.href='login.php'">Back to Login</button>
    </div>

    <div class="RegisterBody">
        <form action="register.php" method="post">
            <div class="RegisterInputsContainer">
                <label for="">Username</label>
                <input placeholder="Username" name="name" type="text" required>
            </div>
            <div class="RegisterInputsContainer">
                <label for="">Email</label>
                <input placeholder="Email" name="email" type="email" required>
            </div>
            <div class="RegisterInputsContainer">
                <label for="">Password</label>
                <input placeholder="Password" name="password" type="password" required>
            </div>
            <div class="RegisterButtonContainer">
                <button type="submit" value="Register">Register</button>
            </div>
        </form>
    </div>

    <div class="big-line"></div>
    
    <?php
    // Handle the form submission for registration
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $role = 'staff'; // Default role is 'staff'

        // Database connection
        $pdo = new PDO("mysql:host=localhost;dbname=stockmate", "root", "");

        // Prepare and execute the query to insert the new user into the staff table
        $stmt = $pdo->prepare("INSERT INTO staff (name, email, password, role, created_at) VALUES (:name, :email, :password, :role, NOW())");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role]);

        echo "Registration successful! You can now log in.";
    }
    ?>

</body>
</html>
