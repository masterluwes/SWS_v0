<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch current content for the adopt page
$query = "SELECT * FROM content_management WHERE page='adopt'";
$result = $conn->query($query);
$content = [];
while ($row = $result->fetch_assoc()) {
    $section = $row['section'];
    if (!isset($content[$section])) {
        $content[$section] = [];
    }
    $content[$section][] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_faq'])) {
        // Adding a new FAQ
        $newTitle = $_POST['new_title'];
        $newContent = $_POST['new_content'];

        $stmt = $conn->prepare("INSERT INTO content_management (page, section, title, content) VALUES ('adopt', 'adopt_faq', ?, ?)");
        $stmt->bind_param('ss', $newTitle, $newContent);
        if (!$stmt->execute()) {
            echo "Error adding FAQ: " . $stmt->error;
        }
    } elseif (isset($_POST['edit_faq'])) {
        // Updating existing FAQ
        $faq_id = $_POST['faq_id'];
        $edit_title = $_POST['edit_title'];
        $edit_content = $_POST['edit_content'];

        $stmt = $conn->prepare("UPDATE content_management SET title=?, content=? WHERE id=?");
        $stmt->bind_param('ssi', $edit_title, $edit_content, $faq_id);
        if (!$stmt->execute()) {
            echo "Error updating FAQ: " . $stmt->error;
        }
    } elseif (isset($_POST['delete_faq'])) {
        // Deleting an FAQ
        $faqId = $_POST['faq_id'];

        $stmt = $conn->prepare("DELETE FROM content_management WHERE id=?");
        $stmt->bind_param('i', $faqId);
        if (!$stmt->execute()) {
            echo "Error deleting FAQ: " . $stmt->error;
        }
    } elseif (isset($_POST['edit_adopt_sec'])) {
        // Updating existing adopt section content
        foreach ($_POST['content']['adopt_sec'] as $id => $text) {
            $title = $_POST['title']['adopt_sec'][$id];
            $url = $_POST['url']['adopt_sec'][$id] ?? ''; // Optional URL field

            $stmt = $conn->prepare("UPDATE content_management SET title=?, content=?, url=? WHERE id=?");
            $stmt->bind_param('sssi', $title, $text, $url, $id);
            if (!$stmt->execute()) {
                echo "Error updating adopt section record: " . $stmt->error;
            }
        }
    }
    header("Location: adopt_page.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Adopt Page</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .table-fixed {
            width: 100%;
            table-layout: fixed;
        }
        .table-fixed th, .table-fixed td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .table-fixed th.title, .table-fixed td.title {
            width: 20%;
        }
        .table-fixed th.content, .table-fixed td.content {
            width: 60%;
        }
        .table-fixed th.actions, .table-fixed td.actions {
            width: 20%;
        }
        .wide-textarea {
            width: 100%;
        }
        .preserve-format {
            white-space: pre-wrap; /* Preserve whitespace */
        }
        .fixed-size-image {
            max-width: 200px;  /* Adjust to your preferred width */
            max-height: 200px; /* Adjust to your preferred height */
            object-fit: cover; /* Ensure the image doesn't stretch */
            margin-bottom: 20px; /* Space between image and text */
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
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'admin_topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Edit Adopt Page Content</h1>

                    <form method="POST">

                        <!-- Adopt Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">Adopt Section</h2>
                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['adopt_sec'])): ?>
                                        <?php foreach ($content['adopt_sec'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content preserve-format"><?= nl2br(htmlspecialchars($item['content'])) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAdoptModal-<?= $item['id'] ?>">Edit</button>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="faq_id" value="<?= $item['id'] ?>">
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Edit Adopt Modal -->
                                            <div class="modal fade" id="editAdoptModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editAdoptModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editAdoptModalLabel-<?= $item['id'] ?>">Edit Adopt Section</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <input type="hidden" name="faq_id" value="<?= $item['id'] ?>">
                                                                <div class="form-group">
                                                                    <label for="adopt-title-<?= $item['id'] ?>">Title</label>
                                                                    <input type="text" class="form-control" id="adopt-title-<?= $item['id'] ?>" name="title[adopt_sec][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['title']) ?>">
                                                                    
                                                                    <label for="adopt-content-<?= $item['id'] ?>">Content</label>
                                                                    <textarea class="form-control wide-textarea" id="adopt-content-<?= $item['id'] ?>" name="content[adopt_sec][<?= $item['id'] ?>]" rows="10"><?= htmlspecialchars($item['content']) ?></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="edit_adopt_sec" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No content available for Adopt section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Adoption FAQ Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">Adoption FAQ Section</h2>

                            <!-- Add FAQ Button -->
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addFAQModal">Add FAQ</button>

                            <!-- Add FAQ Modal -->
                            <div class="modal fade" id="addFAQModal" tabindex="-1" role="dialog" aria-labelledby="addFAQModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFAQModalLabel">Add New FAQ</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <div class="form-group">
                                                    <label for="new-title">Title</label>
                                                    <input type="text" class="form-control" id="new-title" name="new_title" required>

                                                    <label for="new-content">Content</label>
                                                    <textarea class="form-control wide-textarea" id="new-content" name="new_content" rows="5" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="new_faq" class="btn btn-primary">Add FAQ</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['adopt_faq'])): ?>
                                        <?php foreach ($content['adopt_faq'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content preserve-format"><?= nl2br(htmlspecialchars($item['content'])) ?></td>
                                                <td class="actions">
                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editFAQModal-<?= $item['id'] ?>">Edit</button>

                                                    <!-- Delete Button -->
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="faq_id" value="<?= $item['id'] ?>">
                                                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $item['id'] ?>)">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Edit FAQ Modal -->
                                            <div class="modal fade" id="editFAQModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editFAQModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editFAQModalLabel-<?= $item['id'] ?>">Edit FAQ</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <input type="hidden" name="faq_id" value="<?= $item['id'] ?>">
                                                                <div class="form-group">
                                                                    <label for="edit-title-<?= $item['id'] ?>">Title</label>
                                                                    <input type="text" class="form-control" id="edit-title-<?= $item['id'] ?>" name="edit_title" value="<?= htmlspecialchars($item['title']) ?>" required>

                                                                    <label for="edit-content-<?= $item['id'] ?>">Content</label>
                                                                    <textarea class="form-control wide-textarea" id="edit-content-<?= $item['id'] ?>" name="edit_content" rows="5" required><?= htmlspecialchars($item['content']) ?></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="edit_faq" class="btn btn-primary">Save Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No FAQs available for this section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </form>

                    <!-- Our Animals Section -->
                    <?php include 'manage_animals.php'; ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Script to handle tab indentation in textarea -->
    <script>
        function confirmDelete(faqId) {
            if (confirm("Are you sure you want to delete this FAQ?")) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'adopt_page.php';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'faq_id';
                input.value = faqId;
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_faq';
                deleteInput.value = 'true';
                form.appendChild(input);
                form.appendChild(deleteInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.wide-textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 1;
                }
            });
        });
    });
    </script>
</body>

</html>