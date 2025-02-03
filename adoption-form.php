<?php
session_start();
?>

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strays Worth Saving</title>
    <link rel="stylesheet" href="swsstyles.css">
    <script src="https://kit.fontawesome.com/799ba5711e.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
    <div class="adoption-form-container">
        <h2>Adoption Application Form</h2>
        <p>* indicates required fields</p>
        <form id="adoptionForm" action="./admin/process_adoption.php" method="POST" novalidate>
            <div class="form-row">
                <div>
                    <label for="first-name">First Name *</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['first_name'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="last-name">Last Name *</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['last_name'] ?? ''); ?>" required>
                </div>
            </div>
            <div>
                <div>
                    <label for="address">Address *</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($_SESSION['form_data']['address'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="phone">Phone Number *</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($_SESSION['form_data']['phone'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="email">Email *</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['form_data']['email'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="birthdate">Birth Date *</label>
                    <input type="date" name="birthdate" value="<?php echo htmlspecialchars($_SESSION['form_data']['birthdate'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="occupation">Occupation *</label>
                    <input type="text" name="occupation" value="<?php echo htmlspecialchars($_SESSION['form_data']['occupation'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Status</label>
                    <div>
                        <input type="radio" name="status" value="single" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] == 'single') ? 'checked' : ''; ?>>
                        <label for="single">Single</label>
                        <input type="radio" name="status" value="married" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] == 'married') ? 'checked' : ''; ?>>
                        <label for="married">Married</label>
                    </div>
                </div>
                <div>
                    <label>Pronouns</label>
                    <div>
                        <input type="radio" id="she" name="pronouns" value="she"
                            <?php echo (isset($_SESSION['form_data']['pronouns']) && $_SESSION['form_data']['pronouns'] == 'she') ? 'checked' : ''; ?>>
                        <label for="she">She/Her</label>

                        <input type="radio" id="he" name="pronouns" value="he"
                            <?php echo (isset($_SESSION['form_data']['pronouns']) && $_SESSION['form_data']['pronouns'] == 'he') ? 'checked' : ''; ?>>
                        <label for="he">He/Him</label>

                        <input type="radio" id="they" name="pronouns" value="they"
                            <?php echo (isset($_SESSION['form_data']['pronouns']) && $_SESSION['form_data']['pronouns'] == 'they') ? 'checked' : ''; ?>>
                        <label for="they">They/Them</label>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div>
                    <label>What prompted you to adopt from SWS?</label>
                    <div>
                        <input type="checkbox" id="friends" name="prompt[]" value="friends"
                            <?php echo (isset($_SESSION['form_data']['prompt']) && in_array("friends", $_SESSION['form_data']['prompt'])) ? 'checked' : ''; ?>>
                        <label for="friends">Friends</label>

                        <input type="checkbox" id="website" name="prompt[]" value="website"
                            <?php echo (isset($_SESSION['form_data']['prompt']) && in_array("website", $_SESSION['form_data']['prompt'])) ? 'checked' : ''; ?>>
                        <label for="website">Website</label>

                        <input type="checkbox" id="social-media" name="prompt[]" value="social-media"
                            <?php echo (isset($_SESSION['form_data']['prompt']) && in_array("social-media", $_SESSION['form_data']['prompt'])) ? 'checked' : ''; ?>>
                        <label for="social-media">Social Media</label>

                        <input type="checkbox" id="others" name="prompt[]" value="others"
                            <?php echo (isset($_SESSION['form_data']['prompt']) && in_array("others", $_SESSION['form_data']['prompt'])) ? 'checked' : ''; ?>>
                        <label for="others">Others</label>
                    </div>
                </div>

                <div>
                    <label>Have you adopted from SWS before?</label>
                    <div>
                        <input type="radio" id="yes-before" name="adopt_before" value="yes"
                            <?php echo (isset($_SESSION['form_data']['adopt_before']) && $_SESSION['form_data']['adopt_before'] == 'yes') ? 'checked' : ''; ?> required>
                        <label for="yes-before">Yes</label>

                        <input type="radio" id="no-before" name="adopt_before" value="no"
                            <?php echo (isset($_SESSION['form_data']['adopt_before']) && $_SESSION['form_data']['adopt_before'] == 'no') ? 'checked' : ''; ?>>
                        <label for="no-before">No</label>
                    </div>
                </div>

            </div>
            <div>
                <div>
                    <label for="animal-interest">Which of our animals are you interested in adopting? *</label>
                    <select name="animal_interest" id="animal-interest" required>
                        <option value="">-- Select an Animal --</option>
                        <?php
                        include 'admin/db.php'; // Ensure correct path

                        $animals_query = "SELECT id, name FROM animals WHERE adopted = 0"; // Show only available animals
                        $animals_result = $conn->query($animals_query);

                        if ($animals_result->num_rows > 0) {
                            while ($animal = $animals_result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($animal['name']) . '">' . htmlspecialchars($animal['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No available animals</option>';
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-footer">
                <label for="terms">
                    <input type="checkbox" id="terms" name="terms"
                        <?php echo isset($_SESSION['form_data']['terms']) ? 'checked' : ''; ?> required>
                    I agree to the <a href="">terms and conditions</a>
                </label>
                <br>

                <label for="consent">
                    <input type="checkbox" id="consent" name="consent"
                        <?php echo isset($_SESSION['form_data']['consent']) ? 'checked' : ''; ?> required>
                    I consent to being contacted by Strays Worth Saving.
                </label>

                <br>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmSubmitModal">
                    Submit
                </button>
            </div>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmSubmitLabel">Confirm Submission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to submit your adoption form?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <!-- Actual Submit Button inside the Modal -->
                            <button type="button" class="btn btn-success" id="confirmSubmit">Yes, Submit</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Success & Error Modals -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <h2>Success</h2>
                    <p>Adoption form submitted successfully!</p>
                    <button onclick="closeModal()">OK</button>
                </div>
            </div>

            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <h2>Error</h2>
                    <p id="errorMessage"></p>
                    <button onclick="closeModal()">OK</button>
                </div>
            </div>


        </form>
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

    <!-- Bootstrap JS & jQuery (Required for Modal) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#confirmSubmit").click(function(event) {
                event.preventDefault(); // Prevent default form submission

                if (!validateForm()) {
                    return;
                }

                var formData = $("#adoptionForm").serialize();

                $.ajax({
                    type: "POST",
                    url: $("#adoptionForm").attr("action"),
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $("#confirmSubmit").prop("disabled", true); // Prevent double clicks
                    },
                    success: function(response) {
                        $("#confirmSubmit").prop("disabled", false); // Re-enable button

                        if (response.status === "success") {
                            $("#successModal").modal("show");
                            $("#adoptionForm")[0].reset();
                        } else {
                            $("#errorMessage").html(response.message);
                            $("#errorModal").modal("show");
                        }
                    },
                    error: function() {
                        $("#confirmSubmit").prop("disabled", false);
                        $("#errorMessage").html("An unexpected error occurred. Please try again.");
                        $("#errorModal").modal("show");
                    }
                });
            });

            // Prevent JSON errors from appearing
            $("#errorModal").on("hidden.bs.modal", function() {
                return false;
            });

            // Function to validate form fields
            function validateForm() {
                let valid = true;
                let errorMessage = "";

                $(".is-invalid").removeClass("is-invalid");

                $("input[type='text'], input[type='email'], input[type='tel'], input[type='date']").each(function() {
                    if ($(this).val().trim() === "") {
                        valid = false;
                        errorMessage += `• ${$(this).prev("label").text()} is required.<br>`;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (!$("input[name='terms']").prop("checked")) {
                    valid = false;
                    errorMessage += "• You must agree to the Terms and Conditions.<br>";
                }
                if (!$("input[name='consent']").prop("checked")) {
                    valid = false;
                    errorMessage += "• You must consent to being contacted.<br>";
                }

                if ($("input[name='status']:checked").length === 0) {
                    valid = false;
                    errorMessage += "• Please select a Status.<br>";
                }
                if ($("input[name='pronouns']:checked").length === 0) {
                    valid = false;
                    errorMessage += "• Please select your Pronouns.<br>";
                }
                if ($("input[name='adopt_before']:checked").length === 0) {
                    valid = false;
                    errorMessage += "• Please indicate if you have adopted before.<br>";
                }

                if ($("#animal-interest").val() === "") {
                    valid = false;
                    errorMessage += "• Please select an Animal of Interest.<br>";
                }

                if (!valid) {
                    $("#errorMessage").html(errorMessage);
                    $("#errorModal").modal("show");
                    return false;
                }

                return true;
            }
        });
    </script>




    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Submission Successful</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Thank you! Your adoption form has been submitted successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="refreshPage" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>