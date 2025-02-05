<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<?php
include 'db.php';

// Get total accepted volunteers count
$accepted_volunteer_query = "SELECT COUNT(*) AS accepted_volunteers FROM volunteers WHERE status = 'Accepted'";
$accepted_volunteer_result = $conn->query($accepted_volunteer_query);
$accepted_volunteer_data = $accepted_volunteer_result->fetch_assoc();
$total_accepted_volunteers = $accepted_volunteer_data['accepted_volunteers'];

// Get total number of animals
$total_pets_query = "SELECT COUNT(*) AS total_pets FROM animals";
$total_pets_result = $conn->query($total_pets_query);
$total_pets_data = $total_pets_result->fetch_assoc();
$total_pets = $total_pets_data['total_pets'];

// Get number of adopted animals (adopted = 1 means adopted)
$adopted_pets_query = "SELECT COUNT(*) AS adopted_pets FROM animals WHERE adopted = 1";
$adopted_pets_result = $conn->query($adopted_pets_query);
$adopted_pets_data = $adopted_pets_result->fetch_assoc();
$adopted_pets = $adopted_pets_data['adopted_pets'];

// Calculate adoption rate (Prevent division by zero)
$adoption_rate = ($total_pets > 0) ? round(($adopted_pets / $total_pets) * 100, 2) : 0;

// Get total donation amount
$total_donations_query = "SELECT SUM(amount) AS total_donations FROM donations";
$total_donations_result = $conn->query($total_donations_query);
$total_donations_data = $total_donations_result->fetch_assoc();
$total_donations = $total_donations_data['total_donations'] ?? 0; // Default to 0 if no donations

// Fetch total number of users
$user_count_query = "SELECT COUNT(*) AS total_users FROM users";
$user_count_result = $conn->query($user_count_query);
$user_count_data = $user_count_result->fetch_assoc();
$total_users = $user_count_data['total_users'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
        type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"
        type="text/javascript">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>

    <style>
        .chart-area {
            width: 100%;
            height: 400px;
            /* Adjust height as needed */
            background-color: white;
            /* White background */
            padding: 20px;
            /* Padding for spacing */
            border-radius: 8px;
            /* Smooth corners */
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Users -->
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="users.php" class="text-decoration-none">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-5">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase">Users</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-user fa-2x text-gray-300" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Donations -->
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="admin_donations.php" class="text-decoration-none">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-5">
                                                <div class="text-xs font-weight-bold text-success text-uppercase">Donations</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($total_donations, 2); ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-envelope-open fa-2x text-gray-300" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Adoption Rate -->
                        <div class="col-xl-3 col-md-6 mb-2">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Adoption Rate</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php echo $adoption_rate; ?>%
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo $adoption_rate; ?>%;"
                                                            aria-valuenow="<?php echo $adoption_rate; ?>"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Volunteers -->
                        <div class="col-xl-3 col-md-6 mb-2">
                            <a href="admin_volunteer_forms.php" class="text-decoration-none">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-5">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase">Accepted Volunteers</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $total_accepted_volunteers; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-address-card fa-2x text-gray-300" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <br>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header (Now inside the card, like the Pie Chart) -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Donation Statistics</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area position-relative">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header (FIXED) -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Adoption Stats</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area position-relative">
                                        <canvas id="pie-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->



            </div>
            <!-- End of Content Wrapper -->

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

        <!-- For the donation chart -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("fetch_donations.php")
                    .then(response => response.json())
                    .then(data => {
                        let ctx = document.getElementById("myChart").getContext("2d");

                        let labels = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                        let donationAmounts = labels.map(day => data[day] || 0); // Ensure order matches labels

                        let myChart = new Chart(ctx, {
                            type: "line",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Total Donations (₱)",
                                    data: donationAmounts,
                                    backgroundColor: "rgba(78, 115, 223, 0.2)", // Light blue fill
                                    borderColor: "rgba(78, 115, 223, 1)", // Darker blue line
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                maintainAspectRatio: false,
                                responsive: true,
                                plugins: {
                                    legend: {
                                        labels: {
                                            font: {
                                                size: 14
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 50 // Y-axis increments by 50
                                        },
                                        grid: {
                                            color: "rgba(200, 200, 200, 0.2)"
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error("Error fetching donation data:", error));
            });
        </script>


        <!-- For the Pie Chart -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("../admin/fetch_dashboard_data.php")
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched Data:", data); // Debugging output

                        let pieCtx = document.getElementById("pie-chart").getContext("2d");

                        let pieChart = new Chart(pieCtx, {
                            type: "pie",
                            data: {
                                labels: ["Total Donations", "Total Adoptions", "Total Fundraising"],
                                datasets: [{
                                    data: [data.totalDonations, data.totalAdoptions, data.totalFundraising],
                                    backgroundColor: [
                                        "rgba(78, 115, 223, 0.7)", // Blue
                                        "rgba(28, 200, 138, 0.7)", // Green
                                        "rgba(246, 194, 62, 0.7)" // Yellow
                                    ],
                                    hoverBackgroundColor: [
                                        "rgba(78, 115, 223, 1)",
                                        "rgba(28, 200, 138, 1)",
                                        "rgba(246, 194, 62, 1)"
                                    ],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                maintainAspectRatio: false,
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: "bottom"
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error("Error fetching dashboard data:", error));
            });
        </script>




</body>

</html>