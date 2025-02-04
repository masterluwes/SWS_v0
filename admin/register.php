<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'admin';

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif (!ctype_alpha(str_replace(' ', '', $first_name)) || !ctype_alpha(str_replace(' ', '', $last_name))) {
        $message = "First and Last name should only contain letters!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } else {
        // **Check if username or email already exists**
        // **Check if username already exists** (Remove email check)
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert into database (Remove email & gender since they don't exist in the table)
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                $message = "Registration successful!";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F6F3E6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border: none;
            width: 100%;
            max-width: 400px;
        }

        .card-header {
            background-color: #2B3467;
            color: white;
        }

        .btn-primary {
            background-color: #EB455F;
            border: none;
        }

        .btn-primary:hover {
            background-color: #757575;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header text-center">
            <h3>Register</h3>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-info text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <input type="hidden" name="role" value="staff">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <a href="login.php" class="text-muted">Already have an account? Login here</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").submit(function(event) {
                let email = $("#email").val();
                let password = $("#password").val();
                let confirmPassword = $("#confirm_password").val();

                if (!email.includes("@")) {
                    alert("Invalid email format!");
                    event.preventDefault();
                } else if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    event.preventDefault();
                } else if (password.length < 6) {
                    alert("Password must be at least 6 characters long!");
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>