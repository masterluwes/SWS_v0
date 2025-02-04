<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all adoption forms
$query = "SELECT * FROM adoption_forms ORDER BY submission_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Adoption Forms</title>

    <!-- Bootstrap & Custom CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
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
                    <h1 class="h3 mb-4 text-gray-800">Manage Adoption Forms</h1>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Birthdate</th>
                                <th>Occupation</th>
                                <th>Pronouns</th>
                                <th>What prompted you?</th>
                                <th>Animal Interested</th>
                                <th>Adopted Before?</th>
                                <th>Adoption Status</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr data-id="<?= $row['id'] ?>">
                                    <td class="non-editable"><?= htmlspecialchars($row['id']) ?></td>
                                    <td class="editable" data-field="first_name"><?= htmlspecialchars($row['first_name']) ?></td>
                                    <td class="editable" data-field="last_name"><?= htmlspecialchars($row['last_name']) ?></td>
                                    <td class="editable" data-field="email"><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="editable" data-field="phone"><?= htmlspecialchars($row['phone']) ?></td>
                                    <td class="editable" data-field="address"><?= htmlspecialchars($row['address']) ?></td>
                                    <td class="editable" data-field="birthdate"><?= htmlspecialchars($row['birthdate']) ?></td>
                                    <td class="editable" data-field="occupation"><?= htmlspecialchars($row['occupation']) ?></td>
                                    <td class="editable" data-field="pronouns"><?= htmlspecialchars($row['pronouns']) ?></td>

                                    <td class="editable" data-field="prompted">
                                        <?= isset($row['prompted']) ? htmlspecialchars($row['prompted']) : 'N/A' ?>
                                    </td>

                                    <td class="editable" data-field="animal_interest">
                                        <?= isset($row['animal_interest']) ? htmlspecialchars($row['animal_interest']) : 'N/A' ?>
                                    </td>

                                    <td>
                                        <select class="adoption-status-dropdown" data-id="<?= $row['id']; ?>">
                                            <option value="Pending" <?= ($row['adoption_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Accepted" <?= ($row['adoption_status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                            <option value="Rejected" <?= ($row['adoption_status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </td>

                                    <!-- ✅ FIXED: Correct column name -->
                                    <td class="editable" data-field="adopt_before">
                                        <?= isset($row['adopt_before']) ? htmlspecialchars($row['adopt_before']) : 'N/A' ?>
                                    </td>

                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm edit-btn">Edit</button>
                                        <button class="btn btn-success btn-sm save-btn d-none">Save</button>
                                        <button class="btn btn-danger btn-sm delete-btn">Delete</button>
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
                        <span>&copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
            // Ensure all dropdowns start as disabled
            $(".adoption-status-dropdown").prop("disabled", true);

            // Enable editing when "Edit" button is clicked
            $(".edit-btn").click(function() {
                let row = $(this).closest("tr");
                row.find(".editable").attr("contenteditable", "true").addClass("table-warning");
                row.find(".adoption-status-dropdown").prop("disabled", false); // ✅ Enable dropdown
                row.find(".edit-btn").addClass("d-none");
                row.find(".save-btn").removeClass("d-none");
            });

            // Save button click event
            $(".save-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");
                let updates = {};

                // Collect text fields
                row.find(".editable").each(function() {
                    let field = $(this).data("field");
                    let value = $(this).text().trim();
                    updates[field] = value;
                });

                // Collect updated adoption status
                updates["adoption_status"] = row.find(".adoption-status-dropdown").val();

                $.ajax({
                    type: "POST",
                    url: "update_adoption.php",
                    data: {
                        id: id,
                        updates: JSON.stringify(updates)
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // ✅ Disable fields after saving
                            row.find(".editable").removeAttr("contenteditable").removeClass("table-warning");
                            row.find(".adoption-status-dropdown").prop("disabled", true); // ✅ Disable dropdown
                            row.find(".edit-btn").removeClass("d-none");
                            row.find(".save-btn").addClass("d-none");

                            alert("Record updated successfully!");
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function() {
                        alert("An error occurred. Please try again.");
                    }
                });
            });

            // Handle Delete Action
            $(".delete-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");

                if (confirm("Are you sure you want to delete this record?")) {
                    $.post("delete_adoption.php", {
                        id: id
                    }, function(response) {
                        row.remove();
                        alert("Record deleted successfully!");
                    });
                }
            });
        });
    </script>
</body>

</html>