<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all fundraising donation records
$query = "SELECT * FROM fundraising_donations ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fundraising Donations</title>

    <!-- Bootstrap & Custom CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .actions {
            width: 15%;
        }

        .proof-of-payment {
            max-width: 100px;
            max-height: 100px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .proof-of-payment:hover {
            transform: scale(1.5);
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
                    <h1 class="h3 mb-4 text-gray-800">Manage Fundraising Donations</h1>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Bank</th>
                                <th>Fundraising Name</th>
                                <th>Proof of Donation</th>
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
                                    <td class="editable" data-field="phone"><?= htmlspecialchars($row['phone']); ?></td>
                                    <td class="editable" data-field="amount">₱<?= number_format($row['amount'], 2); ?></td>
                                    <td class="editable" data-field="bank"><?= htmlspecialchars($row['bank']); ?></td>
                                    <td><?= htmlspecialchars($row['fundraising_name']); ?></td>
                                    <td>
                                        <?php if (!empty($row['proof_of_payment'])) : ?>
                                            <a href="<?= $row['proof_of_payment']; ?>" target="_blank">
                                                <img src="<?= $row['proof_of_payment']; ?>" class="proof-of-payment" alt="Proof">
                                            </a>
                                        <?php else : ?>
                                            No File
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm edit-btn">✏️ Edit</button>
                                        <button class="btn btn-success btn-sm save-btn d-none">💾 Save</button>
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
            // Handle Edit Action
            $(".edit-btn").click(function() {
                let row = $(this).closest("tr");
                row.find(".editable").attr("contenteditable", "true").addClass("table-warning");
                row.find(".edit-btn").addClass("d-none"); // Hide Edit button
                row.find(".save-btn").removeClass("d-none"); // Show Save button
            });

            // Handle Save Action
            $(".save-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");
                let updates = {};
                let invalidInput = false;

                row.find(".editable").each(function() {
                    let field = $(this).data("field");
                    let value = $(this).text().trim();

                    if (field === "amount") {
                        value = value.replace(/[₱,]/g, ""); 
                        if (isNaN(value) || value === "" || parseFloat(value) < 0) {
                            alert("Error: Amount must be valid.");
                            invalidInput = true;
                            return false;
                        }
                    }

                    updates[field] = value;
                });

                if (invalidInput) {
                    location.reload();
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "process_edit_fundraising.php",
                    data: {
                        id: id,
                        updates: JSON.stringify(updates)
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            row.find(".editable").removeAttr("contenteditable").removeClass("table-warning");
                            row.find(".edit-btn").removeClass("d-none");
                            row.find(".save-btn").addClass("d-none");

                            let formattedAmount = parseFloat(updates["amount"]).toLocaleString("en-PH", {
                                style: "currency",
                                currency: "PHP"
                            });
                            row.find(`[data-field='amount']`).text(formattedAmount);

                            alert("Donation updated successfully!");
                        } else {
                            alert("Error updating: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred. Please try again.");
                    }
                });
            });

            // Handle Delete Action
            $(".delete-btn").click(function() {
                let row = $(this).closest("tr");
                let id = row.data("id");

                if (confirm("Are you sure you want to delete this record?")) {
                    $.post("process_delete_fundraising.php", {
                        id: id
                    }, function(response) {
                        row.remove();
                        alert("Donation record deleted successfully!");
                    });
                }
            });
        });
    </script>

</body>

</html>
