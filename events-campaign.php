<?php
include './admin/db.php';

// Fetch current date
$current_date = date('Y-m-d');

// Fetch active (upcoming) events
$query_active = "SELECT * FROM events WHERE date >= '$current_date' ORDER BY date ASC";
$result_active = $conn->query($query_active);
$active_events = [];
while ($row = $result_active->fetch_assoc()) {
    $active_events[] = $row;
}

// Fetch archived (past) events
$query_archived = "SELECT * FROM events WHERE date < '$current_date' ORDER BY date DESC";
$result_archived = $conn->query($query_archived);
$archived_events = [];
while ($row = $result_archived->fetch_assoc()) {
    $archived_events[] = $row;
}

// Fetch banner data for Events and Campaigns section
$query_banner = "SELECT * FROM content_management WHERE page = 'events' AND section = 'Events and Campaigns' LIMIT 1";
$result_banner = $conn->query($query_banner);
$banner_data = $result_banner->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo1.png">
    <title>SWS - Events and Campaign</title>
    <link rel="stylesheet" href="eventscampaign-styles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script> 
</head>
<body>
    <header>
        <div class="header-btns">
            <div class="cta-btns">
                <a href="getinvolved.php#volunteer-section" class="join-btn">Join</a>
                <a href="getinvolved.php#donate-section" class="donate-btn">Donate</a>
            </div>
        </div>
        <div class="header-container">
            <div class="logo">
                <img src="media2/logo1.png" alt="Strays Worth Saving Logo">
            </div>
            <nav>
                <ul class="navbar">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="adopt.php">Adopt a Pet</a></li>
                    <li><a href="getinvolved.php">Get Involved</a></li>
                    <li><a href="success-stories.php">Success Stories</a></li>
                    <li><a href="events-campaign.php">Events & Campaigns</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-column">
        <section class="eventcampaignbanner" style="background-image: url('admin/uploads/<?php echo htmlspecialchars($banner_data['image_path']); ?>');">
            <div class="banner-content">
                <h2 class="section-title"><?php echo htmlspecialchars($banner_data['title']); ?></h2>
                <p class="content preserve-format"><?php echo nl2br(htmlspecialchars($banner_data['content'])); ?></p>
            </div>
        </section>
        <section class="event-campaign-section">
            <div class="eventcamp-section">
                <div class="label-container">
                    <p class="sectionlabel">Our Events and Campaigns</p>
                </div>
                <div class="eventcamp-grid">
                    <?php foreach ($archived_events as $event): ?>
                        <div class="eventcamp-card">
                            <div class="eventcamp-content">
                                <img src="admin/uploads/<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" class="eventcamp-image"/>
                                <a href=""> <h2><?= htmlspecialchars($event['title']) ?></h2> </a>
                                <p><?= nl2br(htmlspecialchars($event['description'])) ?></p> <br>
                                <div class="detail-container">
                                    <img src="media/calendar-icon.png" alt="Date" class="smolicons-image"/>
                                    <p class="date-details"><?= htmlspecialchars(date('d F Y', strtotime($event['date']))) ?> (<?= htmlspecialchars(date('h:i A', strtotime($event['start_time']))) ?> - <?= htmlspecialchars(date('h:i A', strtotime($event['end_time']))) ?>)</p>
                                </div>
                                <div class="detail-container">
                                    <img src="media/pin-icon.png" alt="Location" class="smolicons-image"/>
                                    <p class="location-details"><?= htmlspecialchars($event['location']) ?></p>
                                </div>
                                <div class="detail-container">
                                    <img src="media/participants-icon.png" alt="Participants" class="smolicons-image"/>
                                    <p class="participants-details"><?= htmlspecialchars($event['participants']) ?>+ participants interested</p>
                                </div>
                                <button class="readmore-btn"> <i class="fa-solid fa-star"></i> Read More</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="event-campaign-section">
            <div class="eventcamp-section">
                <div class="label-container">
                    <p class="sectionlabel">Upcoming Events and Campaigns</p>
                </div>
                <div class="eventcamp-grid">
                    <?php foreach ($active_events as $event): ?>
                        <div class="eventcamp-card">
                            <div class="eventcamp-content">
                                <img src="admin/uploads/<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" class="eventcamp-image"/>
                                <a href=""> <h2><?= htmlspecialchars($event['title']) ?></h2> </a>
                                <p><?= nl2br(htmlspecialchars($event['description'])) ?></p> <br>
                                <div class="detail-container">
                                    <img src="media/calendar-icon.png" alt="Date" class="smolicons-image"/>
                                    <p class="date-details"><?= htmlspecialchars(date('d F Y', strtotime($event['date']))) ?> (<?= htmlspecialchars(date('h:i A', strtotime($event['start_time']))) ?> - <?= htmlspecialchars(date('h:i A', strtotime($event['end_time']))) ?>)</p>
                                </div>
                                <div class="detail-container">
                                    <img src="media/pin-icon.png" alt="Location" class="smolicons-image"/>
                                    <p class="location-details"><?= htmlspecialchars($event['location']) ?></p>
                                </div>
                                <div class="detail-container">
                                    <img src="media/participants-icon.png" alt="Participants" class="smolicons-image"/>
                                    <p class="participants-details"><?= htmlspecialchars($event['participants']) ?>+ participants interested</p>
                                </div>
                                <button class="readmore-btn"> <i class="fa-solid fa-star"></i> Read More</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <p>Contact Us</p>
            <div class="socials">
                <a href="https://www.facebook.com/straysworthsaving" target="_blank">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://x.com/SWSFoundationPH" target="_blank">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="https://www.instagram.com/straysworthsaving/" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://shopee.ph/straysworthsaving" target="_blank">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>
            <div class="copyright">
                &copy; 2024 Strays Worth Saving. All rights reserved.
            </div>
            <div class="policies">
                <a href="">Privacy Policy</a>
                <a href="">Terms of Use</a>
            </div>
        </div>
    </footer>
    <button id="back-to-top" title="Go to top">↑</button>
</body>
<script>
    const backToTopButton = document.getElementById("back-to-top");

    window.onscroll = function () {
      if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        backToTopButton.style.display = "block";
      } else {
        backToTopButton.style.display = "none";
      }
    };
  
    backToTopButton.onclick = function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    };
</script>
</html>