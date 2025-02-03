<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch current content for the homepage
$query = "SELECT * FROM content_management WHERE page='homepage'";
$result = $conn->query($query);
$content = [];
while ($row = $result->fetch_assoc()) {
    $section = $row['section'];
    if (!isset($content[$section])) {
        $content[$section] = [];
    }
    $content[$section][] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['content'] as $section => $texts) {
        foreach ($texts as $id => $text) {
            $title = $_POST['title'][$section][$id];
            $url = $_POST['url'][$section][$id];
            $image_filename = $_POST['current_image'][$section][$id];
            if (isset($_FILES['image']['name'][$section][$id]) && $_FILES['image']['name'][$section][$id] != '') {
                $image_filename = basename($_FILES['image']['name'][$section][$id]);
                $image_path = 'uploads/' . $image_filename;
                if (!move_uploaded_file($_FILES['image']['tmp_name'][$section][$id], $image_path)) {
                    echo "Error uploading file: " . $_FILES['image']['error'][$section][$id];
                }
            }
            $stmt = $conn->prepare("UPDATE content_management SET title=?, content=?, url=?, image_path=? WHERE id=?");
            $stmt->bind_param('ssssi', $title, $text, $url, $image_filename, $id);
            if (!$stmt->execute()) {
                echo "Error updating record: " . $stmt->error;
            }
        }
    }
    header("Location: admin_homepage.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Homepage</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Homepage Content</h1>

                    <form method="POST" enctype="multipart/form-data">

                        <!-- Home Banner Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">Home Banner</h2>
                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['home_banner'])): ?>
                                        <?php foreach ($content['home_banner'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content"><?= htmlspecialchars($item['content']) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $item['id'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel-<?= $item['id'] ?>">Edit Home Banner</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="home-banner-title-<?= $item['id'] ?>">Title</label>
                                                                <input type="text" class="form-control" id="home-banner-title-<?= $item['id'] ?>" name="title[home_banner][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['title']) ?>">
                                                                
                                                                <label for="home-banner-content-<?= $item['id'] ?>">Content</label>
                                                                <textarea class="form-control" id="home-banner-content-<?= $item['id'] ?>" name="content[home_banner][<?= $item['id'] ?>]"><?= htmlspecialchars($item['content']) ?></textarea>
                                                                
                                                                <label for="home-banner-image-<?= $item['id'] ?>">Image</label>
                                                                <input type="file" class="form-control-file" id="home-banner-image-<?= $item['id'] ?>" name="image[home_banner][<?= $item['id'] ?>]" onchange="updateFilename(this, 'home-banner-filename-<?= $item['id'] ?>')">
                                                                <input type="hidden" name="current_image[home_banner][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['image_path']) ?>">
                                                                <span id="home-banner-filename-<?= $item['id'] ?>"><?= htmlspecialchars($item['image_path']) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No content available for Home Banner section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Nav Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">Navigation Section</h2>
                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['nav_section'])): ?>
                                        <?php foreach ($content['nav_section'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content"><?= htmlspecialchars($item['content']) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $item['id'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel-<?= $item['id'] ?>">Edit Navigation Item</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="nav-section-title-<?= $item['id'] ?>">Title</label>
                                                                <input type="text" class="form-control" id="nav-section-title-<?= $item['id'] ?>" name="title[nav_section][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['title']) ?>">
                                                                
                                                                <label for="nav-section-content-<?= $item['id'] ?>">Content</label>
                                                                <textarea class="form-control" id="nav-section-content-<?= $item['id'] ?>" name="content[nav_section][<?= $item['id'] ?>]"><?= htmlspecialchars($item['content']) ?></textarea>
                                                                
                                                                <label for="nav-section-url-<?= $item['id'] ?>">URL</label>
                                                                <input type="text" class="form-control" id="nav-section-url-<?= $item['id'] ?>" name="url[nav_section][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['url']) ?>">
                                                                
                                                                <label for="nav-section-image-<?= $item['id'] ?>">Image</label>
                                                                <input type="file" class="form-control-file" id="nav-section-image-<?= $item['id'] ?>" name="image[nav_section][<?= $item['id'] ?>]" onchange="updateFilename(this, 'nav-section-filename-<?= $item['id'] ?>')">
                                                                <input type="hidden" name="current_image[nav_section][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['image_path']) ?>">
                                                                <span id="nav-section-filename-<?= $item['id'] ?>"><?= htmlspecialchars($item['image_path']) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No content available for Navigation section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Highlights Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">Highlights</h2>
                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['highlights'])): ?>
                                        <?php foreach ($content['highlights'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content"><?= htmlspecialchars($item['content']) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $item['id'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel-<?= $item['id'] ?>">Edit Highlight</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form for editing highlights -->
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label for="highlights-title-<?= $item['id'] ?>">Title</label>
                                                                    <input type="text" class="form-control" id="highlights-title-<?= $item['id'] ?>" name="title[highlights][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['title']) ?>">

                                                                    <label for="highlights-content-<?= $item['id'] ?>">Content</label>
                                                                    <textarea class="form-control" id="highlights-content-<?= $item['id'] ?>" name="content[highlights][<?= $item['id'] ?>]"><?= htmlspecialchars($item['content']) ?></textarea>

                                                                    <label for="highlights-url-<?= $item['id'] ?>">URL</label>
                                                                    <input type="text" class="form-control" id="highlights-url-<?= $item['id'] ?>" name="url[highlights][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['url']) ?>">

                                                                    <label for="highlights-image-<?= $item['id'] ?>">Image</label>
                                                                    <input type="file" class="form-control-file" id="highlights-image-<?= $item['id'] ?>" name="image[highlights][<?= $item['id'] ?>]" onchange="updateFilename(this, 'highlights-filename-<?= $item['id'] ?>')">
                                                                    <input type="hidden" name="current_image[highlights][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['image_path']) ?>">
                                                                    <span id="highlights-filename-<?= $item['id'] ?>"><?= htmlspecialchars($item['image_path']) ?></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No content available for Highlights section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- About Us Section -->
                        <div class="my-4">
                            <h2 class="h4 text-primary">About Us</h2>
                            <table class="table table-fixed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title">Title</th>
                                        <th class="content">Content</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($content['about_us'])): ?>
                                        <?php foreach ($content['about_us'] as $item): ?>
                                            <tr>
                                                <td class="title"><?= htmlspecialchars($item['title']) ?></td>
                                                <td class="content"><?= htmlspecialchars($item['content']) ?></td>
                                                <td class="actions">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $item['id'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>

                        <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal-<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel-<?= $item['id'] ?>">Edit About Us</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="about-us-title-<?= $item['id'] ?>">Title</label>
                                                                <input type="text" class="form-control" id="about-us-title-<?= $item['id'] ?>" name="title[about_us][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['title']) ?>">
                                                                
                                                                <label for="about-us-content-<?= $item['id'] ?>">Content</label>
                                                                <textarea class="form-control" id="about-us-content-<?= $item['id'] ?>" name="content[about_us][<?= $item['id'] ?>]"><?= htmlspecialchars($item['content']) ?></textarea>

                                                                <label for="about-us-image-<?= $item['id'] ?>">Image</label>
                                                                <input type="file" class="form-control-file" id="about-us-image-<?= $item['id'] ?>" name="image[about_us][<?= $item['id'] ?>]" onchange="updateFilename(this, 'about-us-filename-<?= $item['id'] ?>')">
                                                                <input type="hidden" name="current_image[about_us][<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['image_path']) ?>">
                                                                <span id="about-us-filename-<?= $item['id'] ?>"><?= htmlspecialchars($item['image_path']) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No content available for About Us section.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2025</span>
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

    <!-- Script to update the filename display -->
    <script>
        function updateFilename(input, spanId) {
            const span = document.getElementById(spanId);
            span.textContent = input.files[0].name;
        }
    </script>
</body>

</html>