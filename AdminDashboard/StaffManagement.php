<?php
// Database connection
$host = 'localhost';
$dbname = 'stockmate';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle AJAX deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM staff WHERE id = :id");
    $stmt->execute(['id' => $delete_id]);

    // Return updated staff list
    loadStaffTable($pdo);
    exit();
}

// Handle Add Staff
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_staff') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert into staff table
    $stmt = $pdo->prepare("INSERT INTO staff (name, role, email, password, created_at) VALUES (:name, :role, :email, :password, NOW())");
    $stmt->execute(['name' => $name, 'role' => $role, 'email' => $email, 'password' => $password]);

    // Reload the staff table after inserting
    loadStaffTable($pdo);
    exit();
}

function loadStaffTable($pdo) {
    $query = "SELECT * FROM staff";
    $stmt = $pdo->query($query);
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($staff as $member) {
        echo "<tr>
                <td>" . htmlspecialchars($member['id']) . "</td>
                <td>" . htmlspecialchars($member['name']) . "</td>
                <td>" . htmlspecialchars($member['email']) . "</td>
                <td>" . htmlspecialchars($member['role']) . "</td> <!-- Display Role -->
                <td>" . htmlspecialchars($member['created_at']) . "</td>
                <td class='action'> <!-- Added class for centering -->
                    <a href='#' onclick='deleteStaff({$member['id']});' class='delete-btn'>Delete</a>
                </td>
              </tr>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <link rel="stylesheet" href="staffstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function deleteStaff(id) {
            if (confirm('Are you sure you want to delete this staff member?')) {
                $.ajax({
                    url: 'StaffManagement.php',
                    type: 'POST',
                    data: { action: 'delete', delete_id: id },
                    success: function(response) {
                        $('.staff-table tbody').html(response);
                    },
                    error: function() {
                        alert('Error deleting staff member.');
                    }
                });
            }
        }

        function addStaff() {
            var name = $('#staff_name').val();
            var role = $('#staff_role').val();
            var email = $('#staff_email').val();
            var password = $('#staff_password').val();

            $.ajax({
                url: 'StaffManagement.php',
                type: 'POST',
                data: {
                    action: 'add_staff',
                    name: name,
                    role: role,
                    email: email,
                    password: password
                },
                success: function(response) {
                    $('#staff_name').val('');
                    $('#staff_role').val('');
                    $('#staff_email').val('');
                    $('#staff_password').val('');
                    $('.staff-table tbody').html(response);
                },
                error: function() {
                    alert('Error adding staff member.');
                }
            });
        }
    </script>
</head>
<body>
    <div class="staff-content">
        <div class="staff-header">
            <input type="text" placeholder="Search staff" class="search-bar">
            <button class="searchbtn"><img src="Assets/search.png" alt="Search"></button>
            <!-- Add Staff Button -->
            <button onclick="document.getElementById('add-staff-form').style.display='block'">Add Staff</button>
        </div>

        <!-- Add Staff Form -->
        <div id="add-staff-form" style="display:none; padding: 20px; background-color: #f4f4f4; border-radius: 8px;">
            <h2>Add New Staff</h2>
            <form id="addStaffForm">
                <label for="staff_name">Staff Name:</label>
                <input type="text" id="staff_name" name="name" required><br><br>
                <label for="staff_role">Role:</label>
                <select id="staff_role" name="role" required>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select><br><br>
                <label for="staff_email">Email:</label>
                <input type="email" id="staff_email" name="email" required><br><br>
                <label for="staff_password">Password:</label>
                <input type="password" id="staff_password" name="password" required><br><br>
                <button type="button" onclick="addStaff()">Add Staff</button>
                <button type="button" onclick="document.getElementById('add-staff-form').style.display='none'">Cancel</button>
            </form>
        </div>

        <div class="table-container">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th> <!-- Added Role column -->
                        <th>Registered Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php loadStaffTable($pdo); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php } ?>
