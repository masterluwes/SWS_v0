<?php
include './admin/db.php';

// Fetch current content for the homepage
$query = "SELECT * FROM content_management WHERE page='homepage'";
$result = $conn->query($query);
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['section']][] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strays Worth Saving</title>
    <link rel="stylesheet" href="swsstyles.css">
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
                <img src="logo1.png" alt="Strays Worth Saving Logo">
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
        <section class="home-banner" style="background-image: url(<?php echo htmlspecialchars($content['home_banner'][0]['image_path']); ?>);">
            <div class="banner-content">
                <h1><?php echo htmlspecialchars($content['home_banner'][0]['title']); ?></h1>
                <p><?php echo htmlspecialchars($content['home_banner'][0]['content']); ?></p>
                <a href="getinvolved.php" class="donate-btn">Be Part of the Change</a>
            </div>
        </section>
        <section class="nav-section">
            <div class="nav-container">
                <?php foreach ($content['nav_section'] as $navItem): ?>
                <a href="<?php echo htmlspecialchars($navItem['url']); ?>" class="nav-link">
                    <div class="nav-item">
                        <img src="<?php echo htmlspecialchars($navItem['image_path']); ?>" alt="<?php echo htmlspecialchars($navItem['title']); ?>" class="nav-icon"/>
                        <h3><?php echo htmlspecialchars($navItem['title']); ?></h3>
                        <p><?php echo htmlspecialchars($navItem['content']); ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <h2 class="section-title">Highlights of Hope</h2>
        <section class="highlights-section">
            <div class="article-grid">
                <?php foreach ($content['highlights'] as $highlight): ?>
                <a href="<?php echo htmlspecialchars($highlight['url']); ?>" class="article-card">
                    <img src="<?php echo htmlspecialchars($highlight['image_path']); ?>" alt="<?php echo htmlspecialchars($highlight['title']); ?>" class="article-image"/>
                    <div class="article-content">
                        <h3><?php echo htmlspecialchars($highlight['title']); ?></h3>
                        <p><?php echo htmlspecialchars($highlight['content']); ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="about-section" id="about-us">
            <h2>About Us</h2>
            <div class="about-container">
                <?php foreach ($content['about_us'] as $about): ?>
                    <div class="section">
                        <div class="section-image">
                            <img src="<?php echo htmlspecialchars($about['image_path']); ?>" alt="<?php echo htmlspecialchars($about['title']); ?>">
                        </div>
                        <div class="section-text">
                            <h3><?php echo htmlspecialchars($about['title']); ?></h3>
                            <p><?php echo htmlspecialchars($about['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
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
</body>
</html>