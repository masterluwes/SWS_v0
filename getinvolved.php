<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo1.png">
    <title>Get Involved • Strays Worth Saving</title>
    <link rel="stylesheet" href="swsstyles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <div class="header-btns">
            <div class="cta-btns">
                <a href="#volunteer-section" class="join-btn">Join</a>
                <a href="#donate-section" class="donate-btn">Donate</a>
            </div>
        </div>
        <div class="header-container">
            <div class="logo">
                <a href="homepage.php">
                    <img src="media2/logo1.png" alt="Strays Worth Saving Logo">
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
    <section class="get-involved">
        <div class="get-involved-container">
            <h2>Get Involved</h2>
            <p class="involvement-description">Be part of the change! Whether you donate, volunteer, or fundraise, your support makes a world of difference for the strays we care for. Together, we can save lives and give every animal the love and safety they deserve. Join us today and make an impact!</p>
            <div class="involvement-boxes">
                <div class="involvement-box">
                    <h3>Donate</h3>
                    <p>Help us save more stray lives! Your donation provides food, medical care, and shelter for abandoned animals in need. Every contribution brings us closer to giving them a second chance at life.</p>
                    <a href="#donate-section" class="involvement-btn">Send a Gift</a>
                </div>
                <div class="involvement-box">
                    <h3>Fundraising</h3>
                    <p>Be a hero for strays! Organize or support fundraising efforts to help us provide the care and resources needed to save lives. Together, we can create a world where every stray finds a safe and loving home.</p>
                    <a href="#fundraising-section" class="involvement-btn">Learn More</a>
                </div>
                <div class="involvement-box">
                    <h3>Volunteer</h3>
                    <p>Join our mission to rescue and care for strays! As a volunteer, you'll play a vital role in nurturing, rehabilitating, and finding loving homes for animals who deserve a brighter future.</p>
                    <a href="#volunteer-section" class="involvement-btn">Lend a Paw</a>
                </div>
            </div>
        </div>
    </section>
    <section class="donate-section" id="donate-section">
        <h2>Donate</h2>
        <div class="container">
            <div class="donate-content">
                <div class="donation-form">
                    <h3>Donate For Us!</h3>
                    <p style="text-align: left;">A <strong>small</strong> donation from you will make a whole world of difference to these strays while waiting for their forever homes.</p>
                    <form id="one-time-form" enctype="multipart/form-data">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" placeholder="Enter your first name">

                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" placeholder="Enter your last name">

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">

                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">

                        <label for="amount">Amount *</label>
                        <input type="number" id="amount" name="amount" placeholder="Enter donation amount" required>

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
                        <input type="file" id="proof-of-payment" name="proof-of-payment" accept=".png, .jpeg, .jpg, .pdf" required>

                        <button type="submit" class="donate-submit">Donate</button>
                    </form>
                </div>

                <!-- Success Modal -->
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Donation Submitted</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="successMessage">Your donation has been successfully submitted.</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Fix the OK button by adding proper Bootstrap dismiss -->
                                <button type="button" class="btn btn-primary" id="reloadPage" data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="donate-info">
                    <div class="donation-section">
                        <p><strong>Banco de Oro (BDO)</strong><br>Account Name: Strays Worth Saving - SWS<br>Account No.: 0022 8600 2637</p><br>
                        <P><strong>Bank of the Philippine Islands (BPI)</strong><br>Account Name: Melanie Ramirez<br>Account No.: 1289494037</P><br>
                        <p><strong>Unionbank</strong><br>Account Name: Melanie Ramirez<br>Account No.: 109452801813</p><br>
                        <p><strong>Paypal</strong><br><a href="paypal.me/straysworthsaving">paypal.me/straysworthsaving</a> or straysworthsaving@gmail.com</p><br>
                        <p><strong>Paymaya and Coins.ph</strong><br>Account No.: 09176363824</p><br>
                        <p><strong>GCash</strong><br>09176363824 (ME…E R.)<br>09051110018 (VL...R NI...L G.)</p>
                    </div>
                    <div class="articles">
                        <div class="article-box">
                            <h4>Qr to</h4>
                        </div>
                        <div class="article-box">
                            <h4>Qr to<h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="donors-section">
        <div class="donors-container">
            <div class="donors-box">
                <h2>Thank you for our Donors!</h2>
                <div class="certificate-section">
                    <div class="certificate-container">
                        <div class="certificate-grid">
                            <div class="certificate-card" onclick="openModal('jan-fourth')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (January 19-25, 2025)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('jan-third')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (January 12-18, 2025)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('jan-second')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (January 5-11, 2025)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('dec-fifth')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (December 29-31, 2024)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('dec-fourth')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (December 22-28, 2024)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('dec-third')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (December 15-21, 2024)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('dec-second')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (December 8-14, 2024)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                            <div class="certificate-card" onclick="openModal('dec-first')">
                                <img src="media2/certificate.png" alt="Adoption Highlight" class="certificate-image" />
                                <div class="certificate-content">
                                    <h3>Certificates of Donation (December 1-7, 2024)</h3>
                                    <p>We’d like to extend our many thanks to our donors and we appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wish-lists">
                <div class="wish-list">
                    <h3>RESCUE ANIMALS WISH LIST</h3>
                    <ul>
                        <li>🐾 Dog food (kibble and canned)</li>
                        <li>🐾 Shampoo and Pee pads</li>
                        <li>🐾 Brushes and Toys</li>
                        <li>🐾 Medicine and Vitamins</li>
                        <li>🐾 Leashes, harness, and collars</li>
                    </ul>
                </div>
                <div class="wish-list">
                    <h3>RESCUE ANIMALS WISH LIST</h3>
                    <ul>
                        <li>🐾 Mops and Brooms</li>
                        <li>🐾 Garbage Bags</li>
                        <li>🐾 Bath Towels</li>
                        <li>🐾 Detergent powder and bleach</li>
                        <li>🐾 Dishwashing Soap</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div id="jan-fourth-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('jan-fourth')">&times;</span>
            <h3>January 19-25, 2025</h3>
            <img src="certificates/jan-24-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-24-2.jpg" class="cert-modal-image" />
            <img src="certificates/jan-22-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-20-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-20-2.jpg" class="cert-modal-image" />
            <img src="certificates/jan-20-3.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="jan-third-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('jan-third')">&times;</span>
            <h3>January 12-18, 2025</h3>
            <img src="certificates/jan-15-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-12-1.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="jan-second-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('jan-second')">&times;</span>
            <h3>January 5-11, 2025</h3>
            <img src="certificates/jan-11-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-11-2.jpg" class="cert-modal-image" />
            <img src="certificates/jan-9-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-8-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-7-1.jpg" class="cert-modal-image" />
            <img src="certificates/jan-5-1.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="dec-fifth-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('dec-fifth')">&times;</span>
            <h3>December 29-31, 2024</h3>
            <img src="certificates/dec-31-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-31-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-30-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-30-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-30-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-29-1.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="dec-fourth-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('dec-fourth')">&times;</span>
            <h3>December 22-28, 2024</h3>
            <img src="certificates/dec-28-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-4.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-5.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-6.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-7.jpg" class="cert-modal-image" />
            <img src="certificates/dec-28-8.jpg" class="cert-modal-image" />
            <img src="certificates/dec-27-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-26-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-25-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-25-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-4.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-5.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-6.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-7.jpg" class="cert-modal-image" />
            <img src="certificates/dec-24-8.jpg" class="cert-modal-image" />
            <img src="certificates/dec-23-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-23-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-23-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-22-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-22-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-22-3.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="dec-third-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('dec-third')">&times;</span>
            <h3>December 15-21, 2024</h3>
            <img src="certificates/dec-21-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-20-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-20-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-19-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-19-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-19-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-19-4.jpg" class="cert-modal-image" />
            <img src="certificates/dec-17-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-17-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-17-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-17-4.jpg" class="cert-modal-image" />
            <img src="certificates/dec-17-5.jpg" class="cert-modal-image" />
            <img src="certificates/dec-16-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-16-2.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="dec-second-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('dec-second')">&times;</span>
            <h3>December 8-14, 2024</h3>
            <img src="certificates/dec-14-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-13-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-13-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-4.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-5.jpg" class="cert-modal-image" />
            <img src="certificates/dec-12-6.jpg" class="cert-modal-image" />
            <img src="certificates/dec-11-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-11-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-9-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-9-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-9-3.jpg" class="cert-modal-image" />
            <img src="certificates/dec-8-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-8-2.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="dec-first-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('dec-first')">&times;</span>
            <h3>December 1-7, 2024</h3>
            <img src="certificates/dec-7-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-6-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-5-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-4-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-4-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-2-1.jpg" class="cert-modal-image" />
            <img src="certificates/dec-2-2.jpg" class="cert-modal-image" />
            <img src="certificates/dec-1-1.jpg" class="cert-modal-image" />
        </div>
    </div>
    <div id="jan-third-modal" class="cert-modal">
        <div class="cert-modal-content">
            <span class="cert-close" onclick="closeModal('jan-third')">&times;</span>
            <h3>January 19-25, 2025</h3>
            <img src="" class="cert-modal-image" />
            <img src="" class="cert-modal-image" />
            <img src="" class="cert-modal-image" />
            <img src="" class="cert-modal-image" />
            <img src="" class="cert-modal-image" />
            <img src="" class="cert-modal-image" />
        </div>
    </div>
    <section class="fundraising-section" id="fundraising-section">
        <h2 class="section-title">Fundraising</h2>
        <div class="fundraising-container">
            <div class="fundraising-card">
                <img src="media2/highlight-fundraising.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">₱5 Fund drive for GRANNY!</h3>
                    <p class="fund-description">Granny, a senior stray dog, was reported for help by animal advocate Tiktak Jordan. Tragically, she was run over by a vehicle, leaving her with severe injuries, including both hips broken.</p>
                    <a href="fundraising/fp-granny.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media2/fundraising-general.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Fundraising for the surgery of GENERAL!</h3>
                    <p class="fund-description">General is currently on meds to stabilize his body before he gets his much needed surgery — scrotaI abIation. Due to lack of funds, we badly need your support.<br><br></p>
                    <a href="fundraising/fp-general.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-img7.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">₱5 Fund Drive for SWS Shelter Rescues</h3>
                    <p class="fund-description">
                        SWS appeals for your help to provide food and care for 300 rescues at our Batangas shelter. These strays endured pain, illness, and abandonment. Your Php5 donation can make a difference in their lives.</p>
                    <a href="fundraising/fp-5forshelter.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-marina1.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Fundraising for Marina</h3>
                    <p class="fund-description">Marina was found by Rescuer Jun, weak and in pain with severe injuries. She was treated for wounds, fractures, infection, and anemia at the Vetlink Clinic. Her recovery will be long and costly. Please support Marina’s fight and help us continue saving lives. Thank you.</p>
                    <a href="fundraising/fp-marina.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-sia1.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Fundraising for Sia, the Cat</h3>
                    <p class="fund-description">Sia is considered to be in critical condition and is now on intensive care and meds. She is nebulized regularly and on syringe feeding. Please pray for her survival. </p>
                    <a href="fundraising/fp-sia.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-jade3.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Fundraising for Jade</h3>
                    <p class="fund-description">We are fundraising ₱7,000 for Jade, a stray dog found helpless and in pain at a gas station on Molino Blvd. She was reportedly run over by a vehicle while asleep and urgently needs rescue and initial vet care. Please help Jade recover!</p>
                    <a href="fundraising/fp-jade.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-holly1.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Justice for Holly</h3>
                    <p class="fund-description">
                        This poor cat, cruelly thrown and hit by a rock, remains in intensive care. While her condition has improved, she still has head tilting and shallow breathing. Please keep her in your prayers. </p>
                    <a href="fundraising/fp-holly.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-ross1.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Help Ross!</h3>
                    <p class="fund-description">Ross, a pregnant dog run over by a vehicle, sustained a broken jaw and severe mouth injuries. After initial treatment at Vetlink, she was transferred to Deloso Vet Clinic for jaw repair and spay/abort surgery.</p>
                    <a href="fundraising/fp-ross.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-chucky2.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Fundraising for Chucky!</h3>
                    <p class="fund-description">Chucky has a perineal hernia, severe skin issues, and ehrlichia and babesia. His support Chucky’s treatment and recovery. With your help, we can provide him the care he desperately needs. Thank you!</p>
                    <a href="fundraising/fp-chucky.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
            <div class="fundraising-card">
                <img src="media/fp-ghost6.jpg" class="fundraising-image">
                <div class="fund-card-content">
                    <h3 class="fund-card-title">Help Ghost!</h3>
                    <p class="fund-description">Ghost, a dog with severe TVT, needs urgent chemo. His owner can't afford treatment, so SWS is fundraising. He’s had his first shot but needs more. Please help us support his recovery!</p>
                    <a href="fundraising/fp-ghost.php" class="learn-more-btn">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['form_errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>


    <section class="volunteer-section" id="volunteer-section">
        <h2>Volunteer</h2>
        <div class="volunteer-container">
            <div class="volunteer-form">
                <h3>Want to be part of the team?</h3>
                <form id="volunteerForm">
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" required />
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required />
                    <input type="email" name="email" id="email" placeholder="Email" required />
                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                        Submit
                    </button>
                </form>
            </div>
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content text-center p-3">
                <div class="modal-header border-0">
                    <h4 class="modal-title w-100 fw-bold" id="successModalLabel">✅ Success!</h4>
                </div>
                <div class="modal-body p-3" id="successMessage" style="font-size: 18px; line-height: 1.6;">
                    Thank you for signing up as a volunteer! 🎉
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-lg btn-primary px-5 py-3 fw-bold" data-bs-dismiss="modal">
                        OK
                    </button> <!-- Enlarged button -->
                </div>
            </div>
        </div>
    </div>




    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorMessage">
                    An error occurred. Please try again.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



</body>

<!-- jQuery should load first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS should load after jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your custom scripts should be last -->
<script>
    $(document).ready(function() {
        $("#volunteerForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Get form data

            $.ajax({
                type: "POST",
                url: "admin/process_volunteer.php", // Ensure the correct path
                data: formData,
                dataType: "json",
                contentType: "application/x-www-form-urlencoded",
                beforeSend: function() {
                    $("button[type='submit']").prop("disabled", true);
                },
                success: function(response) {
                    $("button[type='submit']").prop("disabled", false);

                    if (response.status === "success") {
                        $("#successMessage").html(response.message);
                        $("#successModal").modal("show"); // ✅ Bootstrap Modal should work now!

                        // ✅ Properly clear form **after** modal shows
                        $("#successModal").on("shown.bs.modal", function() {
                            $("#volunteerForm")[0].reset();
                        });

                    } else {
                        $("#errorMessage").html(response.message);
                        $("#errorModal").modal("show");
                    }
                },
                error: function() {
                    $("button[type='submit']").prop("disabled", false);
                    $("#errorMessage").html("An unexpected error occurred. Please try again.");
                    $("#errorModal").modal("show");
                }
            });
        });

        // ✅ Ensure the form clears when the success modal is closed
        $("#successModal, #errorModal").on("hidden.bs.modal", function() {
            $("#volunteerForm")[0].reset();
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const oneTimeBtn = document.getElementById("one-time-btn");
        const recurringBtn = document.getElementById("recurring-btn");
        const oneTimeForm = document.getElementById("one-time-form");
        const recurringForm = document.getElementById("recurring-form");

        // ✅ Check if elements exist before adding event listeners
        if (oneTimeBtn && recurringBtn && oneTimeForm && recurringForm) {
            oneTimeBtn.addEventListener("click", () => {
                oneTimeForm.style.display = "block";
                recurringForm.style.display = "none";
                oneTimeBtn.classList.add("active");
                recurringBtn.classList.remove("active");
            });

            recurringBtn.addEventListener("click", () => {
                recurringForm.style.display = "block";
                oneTimeForm.style.display = "none";
                recurringBtn.classList.add("active");
                oneTimeBtn.classList.remove("active");
            });
        }
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

<script>
    $(document).ready(function() {
        $("#one-time-form").submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(this); // Get form data

            $.ajax({
                type: "POST",
                url: "admin/process_donation.php", // Ensure the correct path
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[type='submit']").prop("disabled", true);
                },
                success: function(response) {
                    $("button[type='submit']").prop("disabled", false);

                    if (response.status === "success") {
                        $("#successMessage").html(response.message);
                        $("#successModal").modal("show"); // Show Bootstrap Modal

                        // ✅ Clear form after modal is displayed
                        $("#successModal").on("shown.bs.modal", function() {
                            $("#one-time-form")[0].reset();
                        });

                    } else {
                        $("#errorMessage").html(response.message);
                        $("#errorModal").modal("show");
                    }
                },
                error: function() {
                    $("button[type='submit']").prop("disabled", false);
                    $("#errorMessage").html("An unexpected error occurred. Please try again.");
                    $("#errorModal").modal("show");
                }
            });
        });

        // ✅ Ensure form clears when modal is closed
        $("#successModal, #errorModal").on("hidden.bs.modal", function() {
            $("#one-time-form")[0].reset();
        });
    });
</script>





</html>