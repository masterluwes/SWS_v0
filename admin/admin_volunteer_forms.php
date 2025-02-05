<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all volunteer applications
$query = "SELECT * FROM volunteers ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management</title>

    <!-- Bootstrap & Custom CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Sidebar Responsive Improvements */
        @media (max-width: 768px) {
            #wrapper {
                flex-direction: column;
            }

            #sidebar {
                width: 100%;
                display: none;
            }

            #sidebar.active {
                display: block;
            }
        }

        .editable {
            cursor: pointer;
            background-color: #f9f9f9;
            border: 1px solid transparent;
            padding: 5px;
        }

        .editable:focus {
            background-color: #fff;
            border: 1px solid #007bff;
            outline: none;
        }

        .actions {
            width: 15%;
        }

        .non-editable {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'admin_sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include 'admin_topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Manage Volunteer Applications</h1>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Status</th> <!-- ✅ New Status Column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr data-id="<?= $row['id']; ?>">
                                    <td><?= $row['id']; ?></td>
                                    <td class="editable" data-field="first_name"><?= htmlspecialchars($row['first_name']); ?></td>
                                    <td class="editable" data-field="last_name"><?= htmlspecialchars($row['last_name']); ?></td>
                                    <td class="editable" data-field="email"><?= htmlspecialchars($row['email']); ?></td>

                                    <!-- ✅ Status Dropdown -->
                                    <td>
                                        <select class="status-dropdown" data-id="<?= $row['id']; ?>" disabled>
                                            <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Accepted" <?= ($row['status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                            <option value="Rejected" <?= ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </td>


                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn">✏️ Edit</button>
                                        <button class="btn btn-success btn-sm save-btn d-none">Save</button>
                                        <button class="btn btn-danger btn-sm delete-btn">❌ Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Strays Worth Saving 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".edit-btn").click(function() {
                let row = $(this).closest("tr");
                row.find(".editable").attr("contenteditable", "true").addClass("table-warning");
                row.find(".status-dropdown").prop("disabled", false); // ✅ Enable dropdown on edit
                row.find(".edit-btn").addClass("d-none");
                row.find(".save-btn").removeClass("d-none");
            });

            $(".save-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");
                let updates = {};

                // Get updated values from the row
                row.find(".editable").each(function() {
                    let field = $(this).data("field");
                    let value = $(this).text().trim();
                    updates[field] = value;
                });

                let newStatus = row.find(".status-dropdown").val();
                updates["status"] = newStatus; // ✅ Include status in update

                // ✅ Ensure this sends data to the correct backend file
                $.ajax({
                    type: "POST",
                    url: "process_edit_volunteer.php", // ✅ Use the correct PHP file
                    data: {
                        id: id,
                        updates: JSON.stringify(updates)
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("AJAX Success:", response); // ✅ Debugging
                        if (response.status === "success") {
                            row.find(".editable").removeAttr("contenteditable").removeClass("table-warning");
                            row.find(".status-dropdown").prop("disabled", true); // ✅ Disable dropdown after save
                            row.find(".edit-btn").removeClass("d-none");
                            row.find(".save-btn").addClass("d-none");

                            alert("Volunteer updated successfully!");
                            location.reload(); // ✅ Refresh to ensure consistency
                        } else {
                            alert("Error updating volunteer: " + response.message);
                            console.error("AJAX Error Response:", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText); // ✅ Detailed error logs
                        alert("An error occurred while updating the volunteer.");
                        location.reload(); // ✅ Ensure page consistency
                    }
                });
            });

            $(".delete-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");

                if (confirm("Are you sure you want to delete this record?")) {
                    $.ajax({
                        type: "POST",
                        url: "process_delete_volunteer.php",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            row.remove();
                            alert("Volunteer deleted successfully!");
                        },
                        error: function(xhr, status, error) {
                            console.error("Delete Error:", xhr.responseText);
                            alert("Failed to delete volunteer.");
                        }
                    });
                }
            });

            // ✅ Handle Status Dropdown Change
            $(".status-dropdown").change(function() {
                let id = $(this).data("id");
                let newStatus = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "process_update_status.php", // ✅ Ensure backend file is correct
                    data: {
                        id: id,
                        status: newStatus
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("Status Update Response:", response);
                        if (response.status === "success") {
                            alert("Volunteer status updated successfully!");
                            location.reload();
                        } else {
                            alert("Error updating status: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", xhr.responseText);
                        alert("An error occurred while updating the status.");
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>