<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch users
$query = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($query);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_user'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];  // Include username here
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];

        // Handle password change
        if (!empty($_POST['new_password']) && $_POST['new_password'] === $_POST['confirm_password']) {
            $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            // Include username in the update query
            $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, role=?, gender=?, password=? WHERE id=?");
            $stmt->bind_param('sssssssi', $username, $first_name, $last_name, $email, $role, $gender, $hashed_password, $id);
        } else {
            // Include username in the update query
            $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, role=?, gender=? WHERE id=?");
            $stmt->bind_param('ssssssi', $username, $first_name, $last_name, $email, $role, $gender, $id);
        }

        if (!$stmt->execute()) {
            echo "Error updating record: " . $stmt->error;
        }
    }

    // Handle adding new user
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, role, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $username, $first_name, $last_name, $email, $role, $gender, $hashed_password);

            if (!$stmt->execute()) {
                echo "Error adding user: " . $stmt->error;
            }
        } else {
            echo "Passwords do not match!";
        }
    }

    header("Location: users.php");
    exit();
}

    // Handle user deletion
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Prepare DELETE query
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param('i', $delete_id);

        if (!$stmt->execute()) {
            echo "Error deleting record: " . $stmt->error;
        } else {
            header("Location: users.php"); // Redirect back to the page after deletion
            exit();
        }
    }


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'admin_sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'admin_topbar.php'; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-between">
                        Manage Users
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
                    </h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Gender</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($user['id']) ?></td>
                                                <td><?= htmlspecialchars($user['username']) ?></td>
                                                <td><?= htmlspecialchars($user['first_name']) ?></td>
                                                <td><?= htmlspecialchars($user['last_name']) ?></td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['role']) ?></td>
                                                <td><?= htmlspecialchars($user['gender']) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $user['id'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-<?= $user['id'] ?>">Delete</button>
                                                </td>
                                            </tr>

                                            <!-- Edit User Modal -->
                                            <div class="modal fade" id="editModal-<?= $user['id'] ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit User</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Role</label>
                                                                    <select class="form-control" name="role" required>
                                                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                                        <option value="staff" <?= $user['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                    <select class="form-control" name="gender" required>
                                                                        <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                                                        <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                                                    </select>
                                                                </div>
                                                                <hr>
                                                                <h6>Change Password (Optional)</h6>
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input type="password" class="form-control" name="new_password">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Confirm Password</label>
                                                                    <input type="password" class="form-control" name="confirm_password">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="edit_user">Save Changes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Edit Modal -->

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal-<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-<?= $user['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel-<?= $user['id'] ?>">Are you sure you want to delete this user?</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <a href="users.php?delete_id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Strays Worth Saving 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_user">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add User Modal -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "pageLength": 5, // Set default entries to 5
                "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]] // Add "5" option
            });
        });
    </script>

</body>
</html>