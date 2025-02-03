<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch current stories
$query = "SELECT * FROM stories ORDER BY date_added DESC";
$result = $conn->query($query);
$stories = [];
while ($row = $result->fetch_assoc()) {
    $stories[] = $row;
}

// Fetch content management data for Success Stories section
$query_cm = "SELECT * FROM content_management WHERE page = 'success' AND section = 'Success Stories'";
$result_cm = $conn->query($query_cm);
$content_management = [];
while ($row_cm = $result_cm->fetch_assoc()) {
    $content_management[] = $row_cm;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_story'])) {
        // Handle form submission for adding a new story
        $title = $_POST['title_new'];
        $content = $_POST['content_new'];
        $archived = isset($_POST['archived_new']) ? 1 : 0;
        $date_added = $_POST['date_added_new'];
        $image_filename = '';
        if (isset($_FILES['image_new']['name']) && $_FILES['image_new']['name'] != '') {
            $image_filename = basename($_FILES['image_new']['name']);
            if (!move_uploaded_file($_FILES['image_new']['tmp_name'], __DIR__ . '/uploads/' . $image_filename)) {
                echo "Error uploading file: " . $_FILES['image_new']['error'];
            }
        }
        $stmt = $conn->prepare("INSERT INTO stories (title, content, image, archived, date_added) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssds', $title, $content, $image_filename, $archived, $date_added);
        if (!$stmt->execute()) {
            echo "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['edit_content_management'])) {
        // Handle form submission for editing content management
        $id_cm = $_POST['id_cm'];
        $title_cm = $_POST['title_cm'];
        $content_cm = $_POST['content_cm'];
        $image_filename_cm = $_POST['current_image_cm'];
        if (isset($_FILES['image_cm']['name']) && $_FILES['image_cm']['name'] != '') {
            $image_filename_cm = basename($_FILES['image_cm']['name']);
            if (!move_uploaded_file($_FILES['image_cm']['tmp_name'], __DIR__ . '/uploads/' . $image_filename_cm)) {
                echo "Error uploading file: " . $_FILES['image_cm']['error'];
            }
        }
        $stmt_cm = $conn->prepare("UPDATE content_management SET title=?, content=?, image_path=? WHERE id=?");
        $stmt_cm->bind_param('sssi', $title_cm, $content_cm, $image_filename_cm, $id_cm);
        if (!$stmt_cm->execute()) {
            echo "Error updating record: " . $stmt_cm->error;
        }
    } else {
        // Handle form submission for editing stories
        foreach ($_POST['content'] as $id => $content) {
            $title = $_POST['title'][$id];
            $archived = isset($_POST['archived'][$id]) ? 1 : 0;
            $date_added = $_POST['date_added'][$id];
            $image_filename = $_POST['current_image'][$id];
            if (isset($_FILES['image']['name'][$id]) && $_FILES['image']['name'][$id] != '') {
                $image_filename = basename($_FILES['image']['name'][$id]);
                if (!move_uploaded_file($_FILES['image']['tmp_name'][$id], __DIR__ . '/uploads/' . $image_filename)) {
                    echo "Error uploading file: " . $_FILES['image']['error'][$id];
                }
            }
            $stmt = $conn->prepare("UPDATE stories SET title=?, content=?, image=?, archived=?, date_added=? WHERE id=?");
            $stmt->bind_param('sssisi', $title, $content, $image_filename, $archived, $date_added, $id);
            if (!$stmt->execute()) {
                echo "Error updating record: " . $stmt->error;
            }
        }
    }
    header("Location: success_page.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Success Stories</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .table-fixed th.title, .table-fixed td.title {
            width: 20%;
        }
        .table-fixed th.content, .table-fixed td.content {
            width: 60%;
        }
        .table-fixed th.date, .table-fixed td.date {
            width: 10%;
        }
        .table-fixed th.actions, .table-fixed td.actions {
            width: 10%;
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
        .add-story-button {
            float: right;
            margin-top: -5px;
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Success Stories
                        <button type="button" class="btn btn-primary add-story-button" data-toggle="modal" data-target="#addStoryModal">Add Stories</button>
                    </h1>

                    <!-- Success Stories Banner Section -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Success Stories Banner</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-fixed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="title">Title</th>
                                            <th class="content">Content</th>
                                            <th class="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($content_management as $cm): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($cm['title']) ?></td>
                                                <td class="content preserve-format"><?= nl2br(htmlspecialchars($cm['content'])) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editContentManagementModal-<?= $cm['id'] ?>">Edit</button>
                                                </td>
                                            </tr>

                                            <!-- Edit Content Management Modal -->
                                            <div class="modal fade" id="editContentManagementModal-<?= $cm['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editContentManagementModalLabel-<?= $cm['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editContentManagementModalLabel-<?= $cm['id'] ?>">Edit Success Stories Banner</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label for="title_cm">Title</label>
                                                                    <input type="text" class="form-control" id="title_cm" name="title_cm" value="<?= htmlspecialchars($cm['title']) ?>" required>

                                                                    <label for="content_cm">Content</label>
                                                                    <textarea class="form-control wide-textarea" id="content_cm" name="content_cm" required><?= htmlspecialchars($cm['content']) ?></textarea>

                                                                    <label for="image_cm">Image</label>
                                                                    <input type="file" class="form-control-file" id="image_cm" name="image_cm">
                                                                    <input type="hidden" name="current_image_cm" value="<?= htmlspecialchars($cm['image_path']) ?>">
                                                                    <span id="current_image_cm"><?= htmlspecialchars($cm['image_path']) ?></span>
                                                                </div>
                                                                <input type="hidden" name="id_cm" value="<?= $cm['id'] ?>">
                                                                <button type="submit" class="btn btn-primary" name="edit_content_management">Save changes</button>
                                                            </form>
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

                    <form method="POST" enctype="multipart/form-data">
                        <!-- Non-archived Stories Section -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Active Success Stories</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-fixed" id="activeStoriesTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="title">Title</th>
                                                <th class="content">Content</th>
                                                <th class="date">Date</th>
                                                <th class="actions">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($stories as $story): ?>
                                                <?php if (!$story['archived']): ?>
                                                    <tr>
                                                        <td class="title"><?= htmlspecialchars($story['title']) ?></td>
                                                        <td class="content preserve-format"><?= nl2br(htmlspecialchars($story['content'])) ?></td>
                                                        <td class="date"><?= htmlspecialchars(date('Y-m-d', strtotime($story['date_added']))) ?></td>
                                                        <td class="actions">
                                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $story['id'] ?>">Edit</button>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-<?= $story['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $story['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-<?= $story['id'] ?>">Edit Story</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form for editing stories -->
                                                                    <div class="form-group">
                                                                        <label for="story-title-<?= $story['id'] ?>">Title</label>
                                                                        <input type="text" class="form-control" id="story-title-<?= $story['id'] ?>" name="title[<?= $story['id'] ?>]" value="<?= htmlspecialchars($story['title']) ?>">

                                                                        <label for="story-content-<?= $story['id'] ?>">Content</label>
                                                                        <textarea class="form-control wide-textarea" id="story-content-<?= $story['id'] ?>" name="content[<?= $story['id'] ?>]"><?= htmlspecialchars($story['content']) ?></textarea>

                                                                        <label for="story-image-<?= $story['id'] ?>">Image</label>
                                                                        <input type="file" class="form-control-file" id="story-image-<?= $story['id'] ?>" name="image[<?= $story['id'] ?>]" onchange="updateFilename(this, 'story-filename-<?= $story['id'] ?>')">
                                                                        <input type="hidden" name="current_image[<?= $story['id'] ?>]" value="<?= htmlspecialchars($story['image']) ?>">
                                                                        <span id="story-filename-<?= $story['id'] ?>"><?= htmlspecialchars($story['image']) ?></span><br>

                                                                        <label for="story-date-<?= $story['id'] ?>">Date Added</label>
                                                                        <input type="date" class="form-control" id="story-date-<?= $story['id'] ?>" name="date_added[<?= $story['id'] ?>]" value="<?= htmlspecialchars(date('Y-m-d', strtotime($story['date_added']))) ?>">

                                                                        <label for="story-archived-<?= $story['id'] ?>">Archived</label>
                                                                        <input type="checkbox" id="story-archived-<?= $story['id'] ?>" name="archived[<?= $story['id'] ?>]" <?= $story['archived'] ? 'checked' : '' ?>>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Archived Stories Section -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Archived Success Stories</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-fixed" id="archivedStoriesTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="title">Title</th>
                                                <th class="content">Content</th>
                                                <th class="date">Date</th>
                                                <th class="actions">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($stories as $story): ?>
                                                <?php if ($story['archived']): ?>
                                                    <tr>
                                                        <td class="title"><?= htmlspecialchars($story['title']) ?></td>
                                                        <td class="content preserve-format"><?= nl2br(htmlspecialchars($story['content'])) ?></td>
                                                        <td class="date"><?= htmlspecialchars(date('Y-m-d', strtotime($story['date_added']))) ?></td>
                                                        <td class="actions">
                                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $story['id'] ?>">Edit</button>
                                                        </td>
                                                    </tr>

<!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-<?= $story['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $story['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-<?= $story['id'] ?>">Edit Story</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form for editing stories -->
                                                                    <div class="form-group">
                                                                        <label for="story-title-<?= $story['id'] ?>">Title</label>
                                                                        <input type="text" class="form-control" id="story-title-<?= $story['id'] ?>" name="title[<?= $story['id'] ?>]" value="<?= htmlspecialchars($story['title']) ?>">

                                                                        <label for="story-content-<?= $story['id'] ?>">Content</label>
                                                                        <textarea class="form-control wide-textarea" id="story-content-<?= $story['id'] ?>" name="content[<?= $story['id'] ?>]"><?= htmlspecialchars($story['content']) ?></textarea>

                                                                        <label for="story-image-<?= $story['id'] ?>">Image</label>
                                                                        <input type="file" class="form-control-file" id="story-image-<?= $story['id'] ?>" name="image[<?= $story['id'] ?>]" onchange="updateFilename(this, 'story-filename-<?= $story['id'] ?>')">
                                                                        <input type="hidden" name="current_image[<?= $story['id'] ?>]" value="<?= htmlspecialchars($story['image']) ?>">
                                                                        <span id="story-filename-<?= $story['id'] ?>"><?= htmlspecialchars($story['image']) ?></span><br>

                                                                        <label for="story-date-<?= $story['id'] ?>">Date Added</label>
                                                                        <input type="date" class="form-control" id="story-date-<?= $story['id'] ?>" name="date_added[<?= $story['id'] ?>]" value="<?= htmlspecialchars(date('Y-m-d', strtotime($story['date_added']))) ?>">

                                                                        <label for="story-archived-<?= $story['id'] ?>">Archived</label>
                                                                        <input type="checkbox" id="story-archived-<?= $story['id'] ?>" name="archived[<?= $story['id'] ?>]" <?= $story['archived'] ? 'checked' : '' ?>>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Add Story Modal -->
                    <div class="modal fade" id="addStoryModal" tabindex="-1" role="dialog" aria-labelledby="addStoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStoryModalLabel">Add New Story</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="title_new">Title</label>
                                            <input type="text" class="form-control" id="title_new" name="title_new" required>

                                            <label for="content_new">Content</label>
                                            <textarea class="form-control wide-textarea" id="content_new" name="content_new" required></textarea>

                                            <label for="image_new">Image</label>
                                            <input type="file" class="form-control-file" id="image_new" name="image_new" required>

                                            <label for="date_added_new">Date Added</label>
                                            <input type="date" class="form-control" id="date_added_new" name="date_added_new" required>

                                            <label for="archived_new">Archived</label>
                                            <input type="checkbox" id="archived_new" name="archived_new">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="add_story">Add Story</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <a class="btn btn-primary" href="login.php">Logout</a>
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
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#contentManagementTable').DataTable();
            $('#activeStoriesTable').DataTable();
            $('#archivedStoriesTable').DataTable();
        });

        function updateFilename(input, spanId) {
            const fileName = input.files[0] ? input.files[0].name : '';
            document.getElementById(spanId).textContent = fileName;
        }
    </script>
</body>
</html>