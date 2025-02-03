<?php
include './admin/db.php';

// Fetch stories from the database, ordered by date in descending order
$query = "SELECT * FROM stories ORDER BY date_added DESC";
$result = $conn->query($query);
$stories = [];

// Group stories by month and year
while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['date_added']);
    $month_year = $date->format('F Y');
    $stories[$month_year][] = $row;
}

// Get the current date
$now = new DateTime();

// Identify the latest month in the stories
$all_months = array_keys($stories);
$latest_month = $all_months[0]; // The first key corresponds to the most recent month in descending order

// Get the previous two months (skip empty months)
$last_two_months = [];
$latest_date = new DateTime("first day of $latest_month");

// Collect valid months for the last two months
for ($i = 1; $i <= 2; $i++) {
    $prev_month = $latest_date->modify('-1 month')->format('F Y');
    if (isset($stories[$prev_month])) {
        $last_two_months[] = $prev_month;
    }
}

// Ensure that exactly three months (latest + 2 past months) are shown
if (count($last_two_months) < 2) {
    $missing_months = 2 - count($last_two_months);
    $last_two_months = array_merge($last_two_months, array_slice($all_months, 1, $missing_months));
}

// Fetch content management data for Success Stories section
$query_cm = "SELECT * FROM content_management WHERE page = 'success' AND section = 'Success Stories'";
$result_cm = $conn->query($query_cm);
$success_banner = $result_cm->fetch_assoc();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo1.png">
    <title> SWS - Success Stories</title>
    <link rel="stylesheet" href="sucessstories-styles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script>
    <style>
    .toggle-button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background-color: #2B3467;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .toggle-button:hover {
        background-color: #0056b3;
    }

    .toggle-button:active {
        background-color: #2B3467;
    }
    </style>
</head>
<body>
    <header>
        <div class="header-btns">
            <div class="cta-btns">
                <a href="getinvolved.html#volunteer-section" class="join-btn">Join</a>
                <a href="getinvolved.html#donate-section" class="donate-btn">Donate</a>
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
        <section class="successstories-banner" style="background-image: url(<?php echo htmlspecialchars($success_banner['image_path']); ?>);">
            <div class="banner-content">
                <p class="content preserve-format"><?php echo nl2br(htmlspecialchars($success_banner['content'])); ?></p>
            </div>
        </section>

        <!-- Latest Rescue Stories -->
        <section class="success-stories-section">
            <h2 class="section-title"><?php echo htmlspecialchars($success_banner['title']); ?></h2>
            <div class="label-container">
                <img src="media/rarrow.png" class="sarrow">
                <p class="section-label">Latest Rescue Stories</p>
            </div>
            <div class="article-grid">
                <?php if (isset($stories[$latest_month])): ?>
                    <?php foreach ($stories[$latest_month] as $story): ?>
                        <a href="" class="article-card">
                            <div class="article-content">
                                <h3><?= htmlspecialchars($story['title']) ?></h3>
                                <p class="content preserve-format"><?= nl2br(htmlspecialchars($story['content'])) ?></p>
                            </div>
                            <img src="admin/uploads/<?= htmlspecialchars($story['image']) ?>" alt="Adoption Highlight" class="article-image"/>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Past Two Months -->
        <?php foreach ($last_two_months as $month_year): ?>
            <?php if (isset($stories[$month_year])): ?>
                <section class="success-stories-section">
                    <div class="label-container">
                        <img src="media/rarrow.png" class="sarrow">
                        <p class="section-label"><?= htmlspecialchars($month_year) ?></p>
                    </div>
                    <div class="article-grid">
                        <?php foreach ($stories[$month_year] as $story): ?>
                            <a href="" class="article-card">
                                <div class="article-content">
                                    <h3><?= htmlspecialchars($story['title']) ?></h3>
                                    <p class="content preserve-format"><?= nl2br(htmlspecialchars($story['content'])) ?></p>
                                </div>
                                <img src="admin/uploads/<?= htmlspecialchars($story['image']) ?>" alt="Adoption Highlight" class="article-image"/>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Older Posts Section -->
        <section class="older-posts-section">
            <button id="older-posts-btn" class="toggle-button">Show Older Posts</button>
            <div class="stories-section older-posts" style="display: none;">
                <?php foreach ($stories as $month_year => $month_stories): ?>
                    <?php if (!in_array($month_year, array_merge([$latest_month], $last_two_months))): ?>
                        <section class="success-stories-section">
                            <div class="label-container">
                                <img src="media/rarrow.png" class="sarrow">
                                <p class="section-label"><?= htmlspecialchars($month_year) ?></p>
                            </div>
                            <div class="article-grid">
                                <?php foreach ($month_stories as $story): ?>
                                    <a href="" class="article-card">
                                        <div class="article-content">
                                            <h3><?= htmlspecialchars($story['title']) ?></h3>
                                            <p class="content preserve-format"><?= nl2br(htmlspecialchars($story['content'])) ?></p>
                                        </div>
                                        <img src="admin/uploads/<?= htmlspecialchars($story['image']) ?>" alt="Adoption Highlight" class="article-image"/>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    <footer class="footer">
        <!-- Footer Content -->
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const olderPostsBtn = document.getElementById("older-posts-btn");
        const olderPostsSection = document.querySelector(".older-posts");

        olderPostsBtn.addEventListener("click", () => {
            // Show the older posts and hide the button
            olderPostsSection.style.display = "block";
            olderPostsBtn.style.display = "none";
        });
    });
</script>
</html>
