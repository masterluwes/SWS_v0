<?php
include '../admin/db.php';

$fundraising_name = "FUNDRAISING FOR CHUCKY";

// Fetch total amount raised and donor count
$query = "SELECT IFNULL(SUM(amount), 0) AS total_raised, COUNT(id) AS donor_count 
          FROM fundraising_donations 
          WHERE fundraising_name = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("s", $fundraising_name);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Debugging: Print fetched values
error_log("Total Raised: " . $data['total_raised']);
error_log("Donor Count: " . $data['donor_count']);

// Ensure default values
$totalRaised = $data['total_raised'] ?? 0;
$donorCount = $data['donor_count'] ?? 0;
$goalAmount = 7000; // Goal for Chucky's fundraiser
$progressPercentage = ($totalRaised / $goalAmount) * 100;
$progressPercentage = min($progressPercentage, 100); // Cap at 100%
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="media2/logo1.png">
    <title> SWS - Fundraising for Chucky! </title>
    <link rel="stylesheet" href="fundraisingpage-styles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header-btns">
            <div class="cta-btns">
                <a href="../getinvolved.php#volunteer-section" class="join-btn">Join</a>
                <a href="../getinvolved.php#donate-section" class="donate-btn">Donate</a>
            </div>
        </div>
        <div class="header-container">
            <div class="logo">
                <img src="../media2/logo1.png" alt="Strays Worth Saving Logo">
            </div>
            <nav>
                <ul class="navbar">
                    <li><a href="../homepage.php">Home</a></li>
                    <li><a href="../adopt.php">Adopt a Pet</a></li>
                    <li><a href="../getinvolved.php">Get Involved</a></li>
                    <li><a href="../success-stories.php">Success Stories</a></li>
                    <li><a href="../events-campaign.php">Events & Campaigns</a></li>
                    <li><a href="../contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="main-column">
        <section class="fundraising-header">
            <h2 class="fundraising-title"> FUNDRAISING FOR CHUCKY! </h2>
        </section>

        <section class="fundraising-body">
            <div class="image-donation-cont">
                <div class="images-container">
                    <div class="main-image">
                        <img src="../media/fp-chucky1.jpg" class="main-image" />
                    </div>
                    <div class="thumbnails">
                        <img src="../media/fp-chucky2.jpg" />
                        <img src="../media/fp-chucky3.jpg" />
                        <img src="../media/fp-chucky4.jpg" />
                    </div>
                </div>
                <div class="donation-container">
                    <div class="card">
                        <div class="donation-value">
                            <p class="donation-asof">₱ <?= number_format($totalRaised, 2) ?></p>
                            <p class="donation-aim">raised of ₱ <?= number_format($goalAmount, 2) ?> goal</p>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar">
                                <div class="progress" style="width: <?= $progressPercentage ?>%;"></div>
                            </div>
                            <div class="donor-count"><?= $donorCount ?> donors</div>
                        </div>
                        <button class="donate-button">Donate Now!</button>
                    </div>
                </div>
            </div>

            <!-- Donation Modal -->
            <div id="fundraising-donation-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Donate to <span id="fundraising-title"></span></h2>
                    <br>
                    <form id="fundraising-donation-form" enctype="multipart/form-data">
                        <input type="hidden" id="fundraising-name" name="fundraising-name" value="CHUCKY">


                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name">

                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name">

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">

                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">

                        <label for="amount">Amount *</label>
                        <input type="number" id="amount" name="amount" min="1" required>

                        <label for="bank">Select Bank *</label>
                        <select id="bank" name="bank" required>
                            <option value="" disabled selected>-- Choose Bank --</option>
                            <option value="BDO">Banco de Oro (BDO)</option>
                            <option value="BPI">Bank of the Philippine Islands (BPI)</option>
                            <option value="Unionbank">Unionbank</option>
                            <option value="Paypal">Paypal</option>
                            <option value="Paymaya/Coins.ph/Gcash">Paymaya / Coins.ph / Gcash</option>
                        </select>

                        <label for="proof-of-payment">Upload Proof of Donation *</label>
                        <input type="file" id="proof-of-payment" name="proof-of-payment"
                            accept=".png, .jpeg, .jpg, .pdf" required>

                        <button type="submit" class="donate-submit">Donate</button>
                    </form>
                </div>
            </div>

            <div class="campaign-deets-section">
                <section class="campaign-details">
                    <p class="campstory-label"> Campaign Story </p>
                    <p class="about-label"> About Chucky </p>
                    <p class="about-details">
                        When informed about this poor dog with a huge tumor on its rear, we had it searched and when found, our rescuer Jun brought the dog to Vetlink Vet Clinic.
                        The dog named Chucky indeed has a big lump, which is actually perineal hernia, according to his attending vets. <br> <br>
                        Chucky was found negative for distemper but positive for ehrlichia and babesia. He has a severe skin problem. The mass in his rear are full of feces.
                        Chucky would need surgery to repair the problem. He is now on IV fluids and meds. <br> <br>
                        Chucky’s CBC and bloodchem test results are as follows: “CBC, mataas po ang lymphocytes and monocytes nia signifies infection po. Anemia noted rin po. Sobrang baba rin po ng kanyang platelet; <br> <br>
                        Biochemistry, high total protein and globulin due to inflammation and infection and mababa po cholesterol possibly dahil di pa nakain and dahil payat rin po.
                        High total bilirubin and low alp possibly liver problem po. CK (Muscle enzymes) are high due to muscle trauma dahil po sa hernia.” <br> <br>
                        Since he has very low platelet count, Chucky has to be monitored closely and the blood tests repeated after several days to know if he is fit for surgery as now, he is not.
                        Please pray for this poor dog and his successful operation. May he get a second chance at a better life. <br> <br>
                        To those with extra to share for this poor dog as well as our many other confined rescues, please kindly send them your support.
                        We need all the help we can get to allow us to rescue more as we have no more funds. Thank you and God bless! <br> </p>
                    <!--<p class="petnamestory-label"> 's Story </p>
                    <p class="petname-story"> 
                        <br> </p> -->
                    <p class="donation-details-label"> Donate Now! </p>
                    <p class="donation-details">
                        To those who want to donate, please send thru: <br> <br>
                        <b>GCash</b> <br>
                        09129141555 (ME…E G.) <br>
                        09706957555 (AR…N AN…Y C.) <br> <br>
                        <b>Paymaya</b> & <a href="https://coins.ph/" style="text-decoration: none; color: #2B3467; font-weight: bold;"> Coins.ph </a> - 09176363824 <br>
                        <b>Paypal:</b> <a href="https://www.paypal.com/paypalme/straysworthsaving" style="text-decoration: underline; color: #2B3467; font-weight: bold;"> paypal.me/straysworthsaving </a>
                        or <a href="mailto:straysworthsaving@gmail.com" class="info-detail" style="text-decoration: none; color: #2B3467; font-weight: bold;">straysworthsaving@gmail.com</a> <br> <br>
                        <b>Unionbank</b> <br>
                        109452801813 <br>
                        Melanie Ramirez <br> <br>
                        <b>Bank of the Phil Islands (BPI)</b> <br>
                        1289494037 <br>
                        Melanie Ramirez <br> <br>
                        <b>BDO</b> <br>
                        0022 8600 2637 <br>
                        Strays Worth Saving - SWS <br> <br>
                    </p>
                </section>
                <div class="campaign-section">
                    <h2 class="campaign-title">More Fundraising Campaigns</h2>
                    <div class="campaign-list">
                        <a href="fp-ghost.html" style="text-decoration: none;">
                            <div class="campaign-card">
                                <img src="../media/fp-ghost6.jpg" class="campaign-image" />
                                <h3 class="campaign-name">HELP GHOST!</h3>
                            </div>
                        </a>
                        <a href="fp-granny.html" style="text-decoration: none;">
                            <div class="campaign-card">
                                <img src="../media/fp-img1.jpg" class="campaign-image" />
                                <h3 class="campaign-name">5PHP FUND DRIVE FOR GRANNY!</h3>
                            </div>
                        </a>
                        <a href="fp-general.html" style="text-decoration: none;">
                            <div class="campaign-card">
                                <img src="../media/fp-general2.jpg" class="campaign-image" />
                                <h3 class="campaign-name">FUNDRAISING FOR GENERAL</h3>
                            </div>
                        </a>
                    </div>
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


    const mainImage = document.querySelector('.main-image img');
    const thumbnails = document.querySelectorAll('.thumbnails img');

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => {

            const thumbnailSrc = thumbnail.src;
            const mainImageSrc = mainImage.src;

            mainImage.src = thumbnailSrc;
            thumbnail.src = mainImageSrc;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("fundraising-donation-modal");
        const closeBtn = document.querySelector(".close");
        const donationForm = document.getElementById("fundraising-donation-form");

        // Ensure modal stays hidden on page load
        modal.style.display = "none";

        // Open modal when "Donate Now!" button is clicked
        document.querySelectorAll(".donate-button").forEach(button => {
            button.addEventListener("click", function() {
                let fundraisingName = document.querySelector(".fundraising-title").textContent;
                document.getElementById("fundraising-title").textContent = fundraisingName;
                document.getElementById("fundraising-name").value = fundraisingName;
                modal.style.display = "flex"; // Show modal
            });
        });

        // Close modal when clicking the close button
        closeBtn.onclick = () => {
            modal.style.display = "none";
        };

        // Close modal when clicking outside the modal
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Fetch updated donation data from server
        function fetchUpdatedDonations() {
            fetch('../fundraising/fetch_fundraising_data.php?nocache=' + new Date().getTime(), {
                    cache: "no-store"
                }) // Prevents cached data
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched Data:", data); // Debugging output

                    if (data.totalRaised !== undefined) {
                        document.querySelector(".donation-asof").textContent = `₱ ${parseFloat(data.totalRaised).toLocaleString()}`;
                        document.querySelector(".donor-count").textContent = `${data.donorCount} donors`;
                        document.querySelector(".progress").style.width = `${data.progressPercentage}%`;
                    } else {
                        console.error("Invalid data format", data);
                    }
                })
                .catch(error => console.error("Error fetching donation data:", error));
        }

        // Handle Form Submission
        donationForm.addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent page reload

            let formData = new FormData(donationForm);

            fetch("../admin/process_fundraising_donation.php", { // Ensure path is correct
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Server Response:", data); // Debugging output
                    if (data.status === "success") {
                        alert("Thank you! Your donation has been submitted.");
                        modal.style.display = "none";
                        updateDonationProgress(data.totalRaised, data.donorCount, data.goal);
                        donationForm.reset(); // Clear form after submission
                        fetchUpdatedDonations(); // Fetch updated donations immediately
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        });

        // Update Donation Progress Bar
        function updateDonationProgress(totalRaised, donorCount, goal) {
            document.querySelector(".donation-asof").textContent = `₱ ${parseFloat(totalRaised).toLocaleString()}`;
            document.querySelector(".donor-count").textContent = `${donorCount} donors`;
            document.querySelector(".progress").style.width = `${(totalRaised / goal) * 100}%`;
        }

        // ✅ Fetch updated donations immediately on page load
        fetchUpdatedDonations();

        // ✅ Also refresh data every 5 seconds
        setInterval(fetchUpdatedDonations, 5000);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    function fetchUpdatedDonations() {
        fetch('../fundraising/fetch_fundraising_data.php?fundraising_name=FUNDRAISING%20FOR%20CHUCKY&nocache=' + new Date().getTime(), {
                cache: "no-store"
            })
            .then(response => response.json())
            .then(data => {
                console.log("Fetched Data:", data);
                if (data.totalRaised !== undefined) {
                    document.querySelector(".donation-asof").textContent = `₱ ${parseFloat(data.totalRaised).toLocaleString()}`;
                    document.querySelector(".donor-count").textContent = `${data.donorCount} donors`;
                    document.querySelector(".progress").style.width = `${data.progressPercentage}%`;
                } else {
                    console.error("Invalid data format", data);
                }
            })
            .catch(error => console.error("Error fetching donation data:", error));
    }

    fetchUpdatedDonations();
    setInterval(fetchUpdatedDonations, 2000);
});

</script>

</html>