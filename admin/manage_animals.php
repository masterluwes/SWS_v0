<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch animals list
$animals_query = "SELECT * FROM animals";
$animals_result = $conn->query($animals_query);
$animals = [];
while ($row = $animals_result->fetch_assoc()) {
    $animals[] = $row;
}
?>

<!-- Our Animals Section -->
<div class="my-4">
    <h2 class="h4 text-primary">Our Animals</h2>
    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addAnimalModal">Add Animal</button>
    <table class="table table-fixed table-bordered">
        <thead>
            <tr>
                <th class="id">ID</th> <!-- Added ID column -->
                <th class="name">Name</th>
                <th class="breed">Breed</th>
                <th class="date_added">Date Added</th>
                <th class="status">Status</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <tr>
                        <td class="id"><?= htmlspecialchars($animal['id']) ?></td> <!-- Display animal ID -->
                        <td class="name"><?= htmlspecialchars($animal['name']) ?></td>
                        <td class="breed"><?= htmlspecialchars($animal['breed']) ?></td>
                        <td class="date_added"><?= htmlspecialchars($animal['created_at']) ?></td>
                        <td class="status"><?= $animal['adopted'] ? 'Adopted' : 'Available' ?></td>
                        <td class="actions">
                            <button class="btn btn-info btn-sm view-btn" data-id="<?= $animal['id'] ?>" data-toggle="modal" data-target="#viewAnimalModal">View</button>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $animal['id'] ?>" data-toggle="modal" data-target="#editAnimalModal">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $animal['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No animals available for adoption.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Animal Modal -->
<div class="modal fade" id="addAnimalModal" tabindex="-1" role="dialog" aria-labelledby="addAnimalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnimalModalLabel">Add New Animal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="animal-name">Name</label>
                    <input type="text" class="form-control" id="animal-name" required>
                </div>
                <div class="form-group">
                    <label for="animal-age-years">Age (Years)</label>
                    <input type="number" class="form-control" id="animal-age-years" min="0" required>
                </div>
                <div class="form-group">
                    <label for="animal-age-months">Age (Months)</label>
                    <input type="number" class="form-control" id="animal-age-months" min="0" max="11" required>
                </div>
                <div class="form-group">
                    <label for="animal-breed">Breed</label>
                    <input type="text" class="form-control" id="animal-breed" required>
                </div>
                <div class="form-group">
                    <label for="animal-medical-condition">Medical Condition</label>
                    <textarea class="form-control" id="animal-medical-condition" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="animal-disabilities">Disabilities</label>
                    <textarea class="form-control" id="animal-disabilities" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="animal-description">Description</label>
                    <textarea class="form-control" id="animal-description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="animal-gender">Gender</label>
                    <select class="form-control" id="animal-gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="animal-adopted">Adopted</label>
                    <select class="form-control" id="animal-adopted" required>
                        <option value="0">Available</option>
                        <option value="1">Adopted</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="animal-image">Image</label>
                    <input type="file" class="form-control-file" id="animal-image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAnimal">Add Animal</button>
            </div>
        </div>
    </div>
</div>

<!-- View Animal Modal -->
<div class="modal fade" id="viewAnimalModal" tabindex="-1" role="dialog" aria-labelledby="viewAnimalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAnimalModalLabel">Animal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="animal-details">
                    <!-- Details will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Animal Modal -->
<div class="modal fade" id="editAnimalModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnimalModalLabel">Edit Animal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-animal-name">Name</label>
                    <input type="text" class="form-control" id="edit-animal-name" required>
                </div>
                <div class="form-group">
                    <label for="edit-animal-age-years">Age (Years)</label>
                    <input type="number" class="form-control" id="edit-animal-age-years" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit-animal-age-months">Age (Months)</label>
                    <input type="number" class="form-control" id="edit-animal-age-months" min="0" max="11" required>
                </div>
                <div class="form-group">
                    <label for="edit-animal-breed">Breed</label>
                    <input type="text" class="form-control" id="edit-animal-breed" required>
                </div>
                <div class="form-group">
                    <label for="edit-animal-medical-condition">Medical Condition</label>
                    <textarea class="form-control" id="edit-animal-medical-condition" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-animal-disabilities">Disabilities</label>
                    <textarea class="form-control" id="edit-animal-disabilities" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-animal-description">Description</label>
                    <textarea class="form-control" id="edit-animal-description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-animal-gender">Gender</label>
                    <select class="form-control" id="edit-animal-gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-animal-adopted">Adopted</label>
                    <select class="form-control" id="edit-animal-adopted" required>
                        <option value="0">Available</option>
                        <option value="1">Adopted</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-animal-image">Image</label>
                    <input type="file" class="form-control-file" id="edit-animal-image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateAnimal">Update Animal</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#submitAnimal').click(function () {
            const formData = new FormData();
            formData.append('name', $('#animal-name').val());
            formData.append('age_years', $('#animal-age-years').val());
            formData.append('age_months', $('#animal-age-months').val());
            formData.append('breed', $('#animal-breed').val());
            formData.append('medical_condition', $('#animal-medical-condition').val());
            formData.append('disabilities', $('#animal-disabilities').val());
            formData.append('description', $('#animal-description').val());
            formData.append('gender', $('#animal-gender').val());
            formData.append('adopted', $('#animal-adopted').val());
            if ($('#animal-image')[0].files[0]) {
                formData.append('image', $('#animal-image')[0].files[0]);
            }

            $.ajax({
                url: 'add_animal_handler.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                    location.reload(); // Reload the page after update
                },
                error: function () {
                    alert('An error occurred while adding the animal.');
                }
            });
        });
    });

    $(document).ready(function () {
        // View button click event
        $('.view-btn').click(function () {
            const animalId = $(this).data('id'); // Get animal ID from data-id attribute

            $.ajax({
                url: 'view_animal.php', // Ensure this file handles fetching details
                type: 'GET',
                data: { id: animalId }, // Send the animal ID to the server
                success: function (response) {
                    const animal = JSON.parse(response); // Parse the JSON response
                    let details = `
                            <div class="text-center">
                                ${animal.image ? `<img src="${animal.image}" alt="${animal.name}" class="img-fluid fixed-size-image">` : ''}
                            </div>
                            <p><strong>Name:</strong> ${animal.name}</p>
                            <p><strong>Breed:</strong> ${animal.breed}</p>
                            <p><strong>Age:</strong> ${animal.age_years} years, ${animal.age_months} months</p>
                            <p><strong>Medical Condition:</strong> ${animal.medical_condition || 'None'}</p>
                            <p><strong>Disabilities:</strong> ${animal.disabilities || 'None'}</p>
                            <p><strong>Description:</strong> ${animal.description}</p>
                            <p><strong>Gender:</strong> ${animal.gender}</p>
                            <p><strong>Status:</strong> ${animal.adopted ? 'Adopted' : 'Available'}</p>
                            <p><strong>Date Added:</strong> ${animal.created_at}</p>
                        `;
                        $('#animal-details').html(details); // Populate modal with details
                        $('#viewAnimalModal').modal('show'); // Show the modal
                    },
                error: function () {
                    alert('Failed to fetch animal details.');
                }
            });
        });
    });

     $(document).ready(function () {
        // Edit button click event
        $('.edit-btn').click(function () {
            const animalId = $(this).data('id'); // Get animal ID from data-id attribute

            $.ajax({
                url: 'view_animal.php', // Ensure this file handles fetching details
                type: 'GET',
                data: { id: animalId }, // Send the animal ID to the server
                success: function (response) {
                    const animal = JSON.parse(response); // Parse the JSON response
                    $('#edit-animal-name').val(animal.name);
                    $('#edit-animal-age-years').val(animal.age_years);
                    $('#edit-animal-age-months').val(animal.age_months);
                    $('#edit-animal-breed').val(animal.breed);
                    $('#edit-animal-medical-condition').val(animal.medical_condition);
                    $('#edit-animal-disabilities').val(animal.disabilities);
                    $('#edit-animal-description').val(animal.description);
                    $('#edit-animal-gender').val(animal.gender);
                    $('#edit-animal-adopted').val(animal.adopted ? '1' : '0'); // Set the adopted field
                    $('#edit-animal-image').val(''); // Clear file input

                    $('#updateAnimal').data('id', animalId); // Store animal ID in the button
                },
                error: function () {
                    alert('Failed to fetch animal details.');
                }
            });
        });

        // Update animal details (Edit functionality)
        $('#updateAnimal').click(function () {
            const animalId = $(this).data('id'); // Get the animal ID stored in the button

            const formData = new FormData();
            formData.append('id', animalId);
            formData.append('name', $('#edit-animal-name').val());
            formData.append('age_years', $('#edit-animal-age-years').val());
            formData.append('age_months', $('#edit-animal-age-months').val());
            formData.append('breed', $('#edit-animal-breed').val());
            formData.append('medical_condition', $('#edit-animal-medical-condition').val());
            formData.append('disabilities', $('#edit-animal-disabilities').val());
            formData.append('description', $('#edit-animal-description').val());
            formData.append('gender', $('#edit-animal-gender').val());
            formData.append('adopted', $('#edit-animal-adopted').val());
            if ($('#edit-animal-image')[0].files[0]) {
                formData.append('image', $('#edit-animal-image')[0].files[0]);
            }

            $.ajax({
                url: 'edit_animal_handler.php', // This file should handle updating the animal in the database
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                    location.reload(); // Reload the page after update
                },
                error: function () {
                    alert('An error occurred while updating the animal.');
                }
            });
        });
    });

    $(document).ready(function () {
        // Delete button click event
        $('.delete-btn').click(function () {
            const animalId = $(this).data('id'); // Get animal ID from data-id attribute

            if (confirm('Are you sure you want to delete this animal?')) {
                $.ajax({
                    url: 'delete_animal_handler.php',
                    type: 'POST',
                    data: { id: animalId },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function () {
                        alert('An error occurred while deleting the animal.');
                    }
                });

            }
        });
    });

</script>
