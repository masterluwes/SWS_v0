<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch current events
$query = "SELECT * FROM events ORDER BY date DESC";
$result = $conn->query($query);
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// Fetch content management data for Events and Campaigns section
$query_cm = "SELECT * FROM content_management WHERE page = 'events' AND section = 'Events and Campaigns'";
$result_cm = $conn->query($query_cm);
$content_management = [];
while ($row_cm = $result_cm->fetch_assoc()) {
    $content_management[] = $row_cm;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_event'])) {
        // Handle form submission for adding a new event
        $title = $_POST['title_new'];
        $description = $_POST['description_new'];
        $date = $_POST['date_new'];
        $start_time = $_POST['start_time_new'];
        $end_time = $_POST['end_time_new'];
        $location = $_POST['location_new'];
        $participants = $_POST['participants_new'];
        $archived = isset($_POST['archived_new']) ? 1 : 0;
        $image_filename = '';
        if (isset($_FILES['image_new']['name']) && $_FILES['image_new']['name'] != '') {
            $image_filename = basename($_FILES['image_new']['name']);
            if (!move_uploaded_file($_FILES['image_new']['tmp_name'], __DIR__ . '/uploads/' . $image_filename)) {
                echo "Error uploading file: " . $_FILES['image_new']['error'];
            }
        }
        $stmt = $conn->prepare("INSERT INTO events (title, description, date, start_time, end_time, location, participants, image_path, archived) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssisi', $title, $description, $date, $start_time, $end_time, $location, $participants, $image_filename, $archived);
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
        // Handle form submission for editing events
        foreach ($_POST['description'] as $id => $description) {
            $title = $_POST['title'][$id];
            $date = $_POST['date'][$id];
            $start_time = $_POST['start_time'][$id];
            $end_time = $_POST['end_time'][$id];
            $location = $_POST['location'][$id];
            $participants = $_POST['participants'][$id];
            $image_filename = $_POST['current_image'][$id];
            
            // Determine if the event should be archived
            $current_date = date('Y-m-d');
            $archived = (strtotime($date) < strtotime($current_date)) ? 1 : 0;

            if (isset($_FILES['image']['name'][$id]) && $_FILES['image']['name'][$id] != '') {
                $image_filename = basename($_FILES['image']['name'][$id]);
                if (!move_uploaded_file($_FILES['image']['tmp_name'][$id], __DIR__ . '/uploads/' . $image_filename)) {
                    echo "Error uploading file: " . $_FILES['image']['error'][$id];
                }
            }
            $stmt = $conn->prepare("UPDATE events SET title=?, description=?, date=?, start_time=?, end_time=?, location=?, participants=?, image_path=?, archived=? WHERE id=?");
            $stmt->bind_param('ssssssisis', $title, $description, $date, $start_time, $end_time, $location, $participants, $image_filename, $archived, $id);
            if (!$stmt->execute()) {
                echo "Error updating record: " . $stmt->error;
            }
        }
    }
    header("Location: event_page.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Events and Campaigns</title>
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
        .add-event-button {
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Events and Campaigns
                        <button type="button" class="btn btn-primary add-event-button" data-toggle="modal" data-target="#addEventModal">Add Event</button>
                    </h1>

                    <!-- Events and Campaigns Banner Section -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Events and Campaigns Banner</h6>
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
                                                            <h5 class="modal-title" id="editContentManagementModalLabel-<?= $cm['id'] ?>">Edit Events and Campaigns Banner</h5>
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
                        <!-- Active Events Section -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Active Events</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-fixed" id="activeEventsTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="title">Title</th>
                                                <th class="content">Description</th>
                                                <th class="date">Date</th>
                                                <th class="actions">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($events as $event): ?>
                                                <?php if (!$event['archived']): ?>
                                                    <tr>
                                                        <td class="title"><?= htmlspecialchars($event['title']) ?></td>
                                                        <td class="content preserve-format"><?= nl2br(htmlspecialchars($event['description'])) ?></td>
                                                        <td class="date"><?= htmlspecialchars(date('Y-m-d', strtotime($event['date']))) ?></td>
                                                        <td class="actions">
                                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $event['id'] ?>">Edit</button>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-<?= $event['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $event['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-<?= $event['id'] ?>">Edit Event</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form for editing events -->
                                                                    <div class="form-group">
                                                                        <label for="event-title-<?= $event['id'] ?>">Title</label>
                                                                        <input type="text" class="form-control" id="event-title-<?= $event['id'] ?>" name="title[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['title']) ?>">

                                                                        <label for="event-description-<?= $event['id'] ?>">Description</label>
                                                                        <textarea class="form-control wide-textarea" id="event-description-<?= $event['id'] ?>" name="description[<?= $event['id'] ?>]"><?= htmlspecialchars($event['description']) ?></textarea>

                                                                        <label for="event-date-<?= $event['id'] ?>">Date</label>
                                                                        <input type="date" class="form-control" id="event-date-<?= $event['id'] ?>" name="date[<?= $event['id'] ?>]" value="<?= htmlspecialchars(date('Y-m-d', strtotime($event['date']))) ?>">

                                                                        <label for="event-start-time-<?= $event['id'] ?>">Start Time</label>
                                                                        <input type="time" class="form-control" id="event-start-time-<?= $event['id'] ?>" name="start_time[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['start_time']) ?>">

                                                                        <label for="event-end-time-<?= $event['id'] ?>">End Time</label>
                                                                        <input type="time" class="form-control" id="event-end-time-<?= $event['id'] ?>" name="end_time[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['end_time']) ?>">

                                                                        <label for="event-location-<?= $event['id'] ?>">Location</label>
                                                                        <input type="text" class="form-control" id="event-location-<?= $event['id'] ?>" name="location[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['location']) ?>">

                                                                        <label for="event-participants-<?= $event['id'] ?>">Participants</label>
                                                                        <input type="number" class="form-control" id="event-participants-<?= $event['id'] ?>" name="participants[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['participants']) ?>">

                                                                        <label for="event-image-<?= $event['id'] ?>">Image</label>
                                                                        <input type="file" class="form-control-file" id="event-image-<?= $event['id'] ?>" name="image[<?= $event['id'] ?>]" onchange="updateFilename(this, 'event-filename-<?= $event['id'] ?>')">
                                                                        <input type="hidden" name="current_image[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['image_path']) ?>">
                                                                        <span id="event-filename-<?= $event['id'] ?>"><?= htmlspecialchars($event['image_path']) ?></span><br>
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

                        <!-- Archived Events Section -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Archived Events</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-fixed" id="archivedEventsTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="title">Title</th>
                                                <th class="content">Description</th>
                                                <th class="date">Date</th>
                                                <th class="actions">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($events as $event): ?>
                                                <?php if ($event['archived']): ?>
                                                    <tr>
                                                        <td class="title"><?= htmlspecialchars($event['title']) ?></td>
                                                        <td class="content preserve-format"><?= nl2br(htmlspecialchars($event['description'])) ?></td>
                                                        <td class="date"><?= htmlspecialchars(date('Y-m-d', strtotime($event['date']))) ?></td>
                                                        <td class="actions">
                                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal-<?= $event['id'] ?>">Edit</button>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-<?= $event['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-<?= $event['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-<?= $event['id'] ?>">Edit Event</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form for editing events -->
                                                                    <div class="form-group">
                                                                        <label for="event-title-<?= $event['id'] ?>">Title</label>
                                                                        <input type="text" class="form-control" id="event-title-<?= $event['id'] ?>" name="title[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['title']) ?>">

                                                                        <label for="event-description-<?= $event['id'] ?>">Description</label>
                                                                        <textarea class="form-control wide-textarea" id="event-description-<?= $event['id'] ?>" name="description[<?= $event['id'] ?>]"><?= htmlspecialchars($event['description']) ?></textarea>

                                                                        <label for="event-date-<?= $event['id'] ?>">Date</label>
                                                                        <input type="date" class="form-control" id="event-date-<?= $event['id'] ?>" name="date[<?= $event['id'] ?>]" value="<?= htmlspecialchars(date('Y-m-d', strtotime($event['date']))) ?>">

                                                                        <label for="event-start-time-<?= $event['id'] ?>">Start Time</label>
                                                                        <input type="time" class="form-control" id="event-start-time-<?= $event['id'] ?>" name="start_time[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['start_time']) ?>">

                                                                        <label for="event-end-time-<?= $event['id'] ?>">End Time</label>
                                                                        <input type="time" class="form-control" id="event-end-time-<?= $event['id'] ?>" name="end_time[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['end_time']) ?>">

                                                                        <label for="event-location-<?= $event['id'] ?>">Location</label>
                                                                        <input type="text" class="form-control" id="event-location-<?= $event['id'] ?>" name="location[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['location']) ?>">

                                                                        <label for="event-participants-<?= $event['id'] ?>">Participants</label>
                                                                        <input type="number" class="form-control" id="event-participants-<?= $event['id'] ?>" name="participants[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['participants']) ?>">

                                                                        <label for="event-image-<?= $event['id'] ?>">Image</label>
                                                                        <input type="file" class="form-control-file" id="event-image-<?= $event['id'] ?>" name="image[<?= $event['id'] ?>]" onchange="updateFilename(this, 'event-filename-<?= $event['id'] ?>')">
                                                                        <input type="hidden" name="current_image[<?= $event['id'] ?>]" value="<?= htmlspecialchars($event['image_path']) ?>">
                                                                        <span id="event-filename-<?= $event['id'] ?>"><?= htmlspecialchars($event['image_path']) ?></span><br>
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

                    <!-- Add Event Modal -->
                    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="title_new">Title</label>
                                            <input type="text" class="form-control" id="title_new" name="title_new" required>

                                            <label for="description_new">Description</label>
                                            <textarea class="form-control wide-textarea" id="description_new" name="description_new" required></textarea>

                                            <label for="date_new">Date</label>
                                            <input type="date" class="form-control" id="date_new" name="date_new" required>

                                            <label for="start_time_new">Start Time</label>
                                            <input type="time" class="form-control" id="start_time_new" name="start_time_new" required>

                                            <label for="end_time_new">End Time</label>
                                            <input type="time" class="form-control" id="end_time_new" name="end_time_new" required>

                                            <label for="location_new">Location</label>
                                            <input type="text" class="form-control" id="location_new" name="location_new" required>

                                            <label for="participants_new">Participants</label>
                                            <input type="number" class="form-control" id="participants_new" name="participants_new" required>

                                            <label for="image_new">Image</label>
                                            <input type="file" class="form-control-file" id="image_new" name="image_new" required>

                                            <label for="archived_new">Archived</label>
                                            <input type="checkbox" id="archived_new" name="archived_new">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="add_event">Add Event</button>
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
            $('#activeEventsTable').DataTable();
            $('#archivedEventsTable').DataTable();
        });

        function updateFilename(input, spanId) {
            const fileName = input.files[0] ? input.files[0].name : '';
            document.getElementById(spanId).textContent = fileName;
        }
    </script>
</body>
</html>