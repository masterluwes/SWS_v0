<?php
include './admin/db.php';

// Fetch adopt section content
$query = "SELECT * FROM content_management WHERE page='adopt' AND section='adopt_sec'";
$result = $conn->query($query);
$adopt_sec = $result->fetch_assoc();

// Fetch adopt FAQ content
$query = "SELECT * FROM content_management WHERE page='adopt' AND section='adopt_faq'";
$result = $conn->query($query);
$adopt_faqs = [];
while ($row = $result->fetch_assoc()) {
    $adopt_faqs[] = $row;
}

// Fetch animals
$query = "SELECT * FROM animals WHERE adopted = 0"; // Only fetch animals that are not adopted
$animals_result = $conn->query($query);
$animals = [];
while ($row = $animals_result->fetch_assoc()) {
    $animals[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo1.png">
    <title>Adoption • Strays Worth Saving</title>
    <link rel="stylesheet" href="swsstyles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script>

    <style>
        /* Include the necessary CSS for the modals here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                <a href="homepage.php">
                    <img src="logo1.png" alt="Strays Worth Saving Logo">
                </a>
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
    <section class="adopt-section">
        <div class="adopt-container">
            <div class="adopt-text">
                <h2 class="section-title"><?= htmlspecialchars($adopt_sec['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($adopt_sec['content'])) ?></p>
                <div class="adopt-buttons">
                    <a href="adoption-form.php" class="apply-btn">Adopt Now</a>
                    <a href="#adoption-faq" class="adopt-faq-btn">Adoption FAQ</a>
                </div>
            </div>
            <div class="adopt-images">
                <div class="adopt-grid">
                    <div class="adopt-image"></div>
                    <div class="adopt-image" id="adopt-image2"></div>
                    <div class="adopt-image large"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-animals">
        <h2 class="sub-title">Our Animals</h2>
        <div class="animals-grid" id="animals-grid">
            <!-- Animal cards will be populated dynamically here -->
        </div>
    </section>
    <section class="adoption-faq" id="adoption-faq">
        <h2 class="sub-title">Adoption Frequently Asked Questions (FAQs)</h2>
        <div class="faq-container">
            <?php if ($adopt_faqs) : ?>
                <?php foreach ($adopt_faqs as $faq) : ?>
                    <div class="faq-item">
                        <h3><?= htmlspecialchars($faq['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($faq['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="faq-item">
                    <h3>No FAQs available.</h3>
                </div>
            <?php endif; ?>
        </div>
    </section>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch animals on page load
        $.ajax({
            url: 'fetch_animals.php', // PHP file to fetch animal data
            type: 'GET',
            success: function(response) {
                console.log(response); // Debugging: Check if the response is correct
                const animals = JSON.parse(response); // Parse the JSON response

                if (animals.length === 0) {
                    $('#animals-grid').html('<p>No animals available at the moment.</p>');
                    return;
                }

                let animalsHtml = ''; // Variable to store the HTML for animal cards
                animals.forEach(animal => {
                    // Build HTML for each animal card
                    animalsHtml += `
                        <div class="animal-card" onclick="openModal('${animal.id}')">
                            <img src="${animal.image}" class="animal-image" alt="${animal.name}" />
                            <h3>${animal.name}</h3>
                            <p><strong>Description:</strong> ${animal.description}</p>
                            <p><strong>Breed:</strong> ${animal.breed}</p>
                            <p><strong>Gender:</strong> ${animal.gender}</p>
                            <p><strong>Age:</strong> ${animal.age_years} years ${animal.age_months} months</p>
                        </div>
                    `;

                    // Append modal for each animal
                    $('body').append(`
                        <div id="${animal.id}-modal" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal('${animal.id}')">&times;</span>
                                <h3>${animal.name}</h3>
                                <div class="modal-body" style="display: flex; gap: 20px;">
                                    <!-- Left Section -->
                                    <div class="modal-left" style="flex: 1;">
                                        <p><strong>Description:</strong> ${animal.description}</p>
                                        <p><strong>Breed:</strong> ${animal.breed}</p>
                                        <p><strong>Age:</strong> ${animal.age_years} years, ${animal.age_months} months</p>
                                        <p><strong>Gender:</strong> ${animal.gender}</p>
                                    </div>
                                    <!-- Right Section -->
                                    <div class="modal-right" style="flex: 1;">
                                        <p><strong>Medical Condition:</strong> ${animal.medical_condition || 'None'}</p>
                                        <p><strong>Disabilities:</strong> ${animal.disabilities || 'None'}</p>
                                        <p><strong>Status:</strong> Available</p>
                                        <p><strong>Date Added:</strong> ${animal.date_added}</p>
                                    </div>
                                </div>
                                <img src="${animal.image}" class="modal-image" alt="${animal.name}" style="margin-top: 20px; width: 100%; border-radius: 10px;" />
                            </div>
                        </div>
                    `);
                });

                // Append the generated HTML to the animals grid
                $('#animals-grid').html(animalsHtml);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Debugging: Check if there is an error
                alert('Failed to fetch animals.');
            }
        });
    });


    const backToTopButton = document.getElementById("back-to-top");

    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    };

    backToTopButton.onclick = function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    };

    function openModal(id) {
        document.getElementById(`${id}-modal`).style.display = "flex";
    }

    function closeModal(id) {
        document.getElementById(`${id}-modal`).style.display = "none";
    }

    window.onclick = function(event) {
        const modals = document.querySelectorAll(".modal");
        modals.forEach((modal) => {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    };
</script>

</html>