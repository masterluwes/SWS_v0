<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Dashboard</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="admin_dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="users.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span></a>
    </li>

    <!-- Divider
    <hr class="sidebar-divider"> -->

    <!-- Nav Item - Report and Analytics
    <li class="nav-item">
        <a class="nav-link" href="report_analytics.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Report and Analytics</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Content Management -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContentManagement"
            aria-expanded="true" aria-controls="collapseContentManagement">
            <i class="fas fa-fw fa-folder"></i>
            <span>Content Management</span>
        </a>
        <div id="collapseContentManagement" class="collapse" aria-labelledby="headingContentManagement" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="admin_homepage.php">Homepage</a>
                <a class="collapse-item" href="adopt_page.php">Adopt a Pet Page</a>
                <a class="collapse-item" href="success_page.php">Success Stories Blog Page</a>
                <a class="collapse-item" href="event_page.php">Events & Campaign</a>
                <a class="collapse-item" href="#">Contact Us</a>
            </div>
        </div>
    </li>

     <!-- Divider
    <hr class="sidebar-divider"> -->

    <!-- Nav Item - Fundraising and Donations 
    <li class="nav-item">
        <a class="nav-link" href="donation_fundraising.php">
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>Donation and Fundraising</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Forms Management -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFormsManagement"
            aria-expanded="true" aria-controls="collapseFormsManagement">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Forms Management</span>
        </a>
        <div id="collapseFormsManagement" class="collapse" aria-labelledby="headingFormsManagement" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="admin_adoption_forms.php">Adoption</a>
                <a class="collapse-item" href="admin_volunteer_forms.php">Volunteer</a>
                <a class="collapse-item" href="admin_contact_forms.php">Contact Forms</a>
                <a class="collapse-item" href="#">Donation</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>