<?php
require_once('../layouts/header.php');
require_once __DIR__ . '/../../models/Student.php';

$studentModel = new Student();
$students = $studentModel->getAll();

$numRows = count($students);


?>

<div class="container">

    <h2 class="mx-3 my-5">
    Reading students devour books with
     passion and curiosity

        <?php if ($position == 'librarian') : ?>  
        <!-- Button trigger modal -->
        <button type="button" class="btn rounded-pill btn-secondary float-end m-2" data-bs-toggle="modal" data-bs-target="#createStudentModal">
        <img data-v-24a05c19="" srcset="https://img.icons8.com/?size=48&amp;id=OYbFh7PuEW4n&amp;format=png 1x, https://img.icons8.com/?size=96&amp;id=OYbFh7PuEW4n&amp;format=png 2x" width="40" height="40" alt="Student icon" class="loaded">
        </button>
        <?php endif; ?>
    </h2>


    <section class="content m-3">
        <div class="container-fluid">
        <h3>Total number of students: <?= $numRows ?></h3>
        <div class="row my-3">
        <div class="col">
        <input type="text" id="username" class="form-control" placeholder="Search Student">
        </div>
         <div class="col-auto">
        <button id="searchBtn" class="btn btn-dark"><i class="bx bx-search fs-4 lh-0"></i>
        </button>
        </div>
       </div>
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th class="">idcard</th>
                                <th class="">username</th>
                                <?php if ($position == 'librarian') : ?>
                                <th class="">email</th>
                                <th class="">mobilenumber</th>  
                                <?php endif; ?>
                                <?php if ($position == 'librarian' || $position == 'student') : ?>
                                <th class="">position</th>  
                                <?php endif; ?>
                                <?php if ($position == 'librarian') : ?>
                                <th class=""></th>
                                <th class="">status</th>
                                <?php endif; ?>

                                <!-- <th style="width: 200px">Options</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($students as $key => $c) {
                            ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td> <?= $c['idcard'] ?? ""; ?> </td>
                                    <td> <?= $c['username'] ?? ""; ?> </td>
                                    <?php if ($position == 'librarian') : ?>
                                    <td> <?= $c['email'] ?? ""; ?> </td>
                                    <td> <?= $c['mobilenumber'] ?? ""; ?> </td>
                                    <?php endif; ?>
                                    <?php if ($position == 'librarian' || $position == 'student') : ?>
                                    <td> <?= $c['position'] ?? ""; ?> </td>
                                    <?php endif; ?>

                                    
                                    <td> </td>
                                    <?php if ($position == 'librarian') : ?>
                                    <td>
                                        <div class="">
                                            <?php if ($c['status'] == 1) { ?>
                                                <span class="badge rounded-pill bg-success">Enable</span>
                                            <?php } else { ?>
                                                <span class="badge rounded-pill bg-danger">Disable</span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <button class="btn rounded-pill btn-sm btn-info m-2 edit-student" data-id="<?= $c['id']; ?>">Edit</button>
                                            <button class="btn rounded-pill btn-sm btn-danger m-2 delete-student" data-id="<?= $c['id']; ?>">Delete</button>

                                        </div>
                                    </td>
                                    <?php endif; ?>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade " id="createStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-student-form" action="<?= url('services/ajax_functions.php') ?>">
                <input type="hidden" name="action" value="create_student">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Create Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="idcard" class="form-label">idcard</label>
                            <input type="text" id="idcard" name="idcard" class="form-control" placeholder="Enter StudentId" required />
                        </div> 
                    </div>
                        <div class="col mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required />
                        </div>
                        <div class="col mb-3">
                            <label for="mobilenumber" class="form-label">mobilenumber</label>
                            <input type="number" id="mobilenumber" name="mobilenumber" class="form-control" placeholder="Enter MobileNumber" required />
                        </div>
                    <div class="row g-1">
                        <div class="col mb-0">
                            <label for="email" class="form-label">email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxx.xx" required />
                        </div>

                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0 form-password-toggle">
                            <label class="form-label" for="password">password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="············" aria-describedby="basic-default-password2" required>
                                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="col mb-0 form-password-toggle">
                            <label class="form-label" for="basic-default-password12">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control" id="basic-default-password12" placeholder="············" aria-describedby="basic-default-password2" required>
                                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-3">
                            <label for="position" class="form-label">position</label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="Enter position" required />
                        </div>
                    </div>
                    <div id="additional-fields"></div>
                    <div class="mb-3 mt-3">
                        <div id="alert-container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn rounded-pill btn-primary" data-bs-dismiss="modal">Close</button>

                    <button type="button" id="create-now" class="btn rounded-pill btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Student Modal -->
<div class="modal fade " id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="update-student-form" action="<?= url('services/ajax_functions.php') ?>" autocomplete="off">
                <input type="hidden" name="action" value="update_student">
                <input type="hidden" name="id" id="student_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="idcard" class="form-label">idcard</label>
                            <input type="text" id="idcard" name="idcard" class="form-control" placeholder="Enter idcard" required />
                        </div> 
                    </div>
                        <div class="col mb-3">
                            <label for="username" class="form-label">UserName</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required />
                        </div>
                        <div class="col mb-3">
                            <label for="mobilenumber" class="form-label">MobileNumber</label>
                            <input type="number" id="mobilenumber" name="mobilenumber" class="form-control" placeholder="Enter MobileNumber" required />
                        </div>
                    <div class="row g-1">
                        <div class="col mb-0">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxx.xx" required />
                        </div>

                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="············" aria-describedby="basic-default-password2" required>
                                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="col mb-0 form-password-toggle">
                            <label class="form-label" for="basic-default-password12">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control" id="basic-default-password12" placeholder="············" aria-describedby="basic-default-password2" required>
                                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-1 mt-2">
                        <div class="col mb-3">
                            <label for="position" class="form-label">position</label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="Enter position" required />
                        </div>
                    </div>
                    
                    <div class="row g-1">
                        <div class="col mb-0">
                            <label class="form-label" for="status">Status</label>
                            <div class="input-group">
                                <select class="form-select" id="status" name="status" required>
                                    <option selected="" value="">Choose...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <div id="alert-container-update-form"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" id="update-now" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('../layouts/footer.php');
?>

<script>

$(document).ready(function() {
        $("#username").on("input", function() {
            var searchTerm = $(this).val().toLowerCase();

            // Loop through each row in the table body
            $("tbody tr").filter(function() {
                // Toggle the visibility based on the search term
                $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
            });
        });
    });
    $(document).ready(function() {

        // Handle modal button click
        $('#create-now').on('click', function() {

            // Get the form element
            var form = $('#create-student-form')[0];
            $('#create-student-form')[0].reportValidity();

            // Check form validity
            if (form.checkValidity()) {
                // Serialize the form data
                var formData = $('#create-student-form').serialize();
                var formAction = $('#create-student-form').attr('action');

                // Perform AJAX request
                $.ajax({
                    url: formAction,
                    type: 'POST',
                    data: formData, // Form data
                    dataType: 'json',
                    success: function(response) {
                        showAlert(response.message, response.success ? 'primary' : 'danger');
                        if (response.success) {
                            $('#createStudentModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        // Handle the error
                        console.error('Error submitting the form:', error);
                    },
                    complete: function(response) {
                        // This will be executed regardless of success or error
                        console.log('Request complete:', response);
                    }
                });
            } else {
                var message = ('Form is not valid. Please check your inputs.');
                showAlert(message, 'danger');
            }
        });

        $('.edit-student').on('click', async function() {
            var student_id = $(this).data('id');
            await getStudentById(student_id);
        })

        $('.delete-student').on('click', async function() {
            var student_id = $(this).data('id');
            var is_confirm = confirm('Are you sure,Do you want to delete?');
            if (is_confirm) await deleteById(student_id);
        })

        $('#update-now').on('click', function() {

            // Get the form element
            var form = $('#update-student-form')[0];
            $('#update-student-form')[0].reportValidity();

            // Check form validity
            if (form.checkValidity()) {
                // Serialize the form data
                var formData = $('#update-student-form').serialize();
                var formAction = $('#update-student-form').attr('action');

                // Perform AJAX request
                $.ajax({
                    url: formAction,
                    type: 'POST',
                    data: formData, // Form data
                    dataType: 'json',
                    success: function(response) {
                        showAlert(response.message, response.success ? 'primary' : 'danger', 'alert-container-update-form');
                        if (response.success) {
                            $('#editStudentModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        // Handle the error
                        console.error('Error submitting the form:', error);
                    },
                    complete: function(response) {
                        // This will be executed regardless of success or error
                        console.log('Request complete:', response);
                    }
                });
            } else {
                var message = ('Form is not valid. Please check your inputs.');
                showAlert(message, 'danger');
            }
        });

        
        });

        


        
    async function getStudentById(id) {
        var formAction = $('#update-student-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                student_id: id,
                action: 'get_student'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                showAlert(response.message, response.success ? 'primary' : 'danger');
                if (response.success) {
                    var student_id = response.data.id;
                    var idcard = response.data.idcard;
                    var username = response.data.username;
                    var email = response.data.email;
                    var mobilenumber = response.data.mobilenumber;
                    var position = response.data.position;
                    var status = response.data.status;

                    $('#editStudentModal #student_id').val(student_id);
                    $('#editStudentModal #idcard').val(idcard);
                    $('#editStudentModal #username').val(username);
                    $('#editStudentModal #email').val(email);
                    $('#editStudentModal #mobilenumber').val(mobilenumber);
                    $('#editStudentModal #position').val(position);               
                    $('#editStudentModal #status option[value="' + status + '"]').prop('selected', true);
                    $('#editStudentModal').modal('show');
                }
            },
            error: function(error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function(response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    }

    async function deleteById(id) {
        var formAction = $('#update-student-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                student_id: id,
                action: 'delete_student'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function(response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    }
</script>

