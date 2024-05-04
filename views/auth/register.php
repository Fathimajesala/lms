<?php
require_once('./../../config.php');
include __DIR__ . '/../../helpers/AppManager.php';
require_once __DIR__ . '/../../models/Student.php';

$sm = AppManager::getSM();
$error = $sm->getAttribute("error");

$studentModel = new Student();
$students = $studentModel->getAll();



$currentUrl = $_SERVER['SCRIPT_NAME'];

// Extract the last filename from the URL
$currentFilename = basename($currentUrl);  // e.g., "dashboard.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library</title>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= asset('assets/vendor/fonts/boxicons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= asset('assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= asset('assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= asset('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <link rel="stylesheet" href="<?= asset('assets/vendor/libs/apex-charts/apex-charts.css') ?>" />

    <!-- Page -->
    <link rel="stylesheet" href="<?= asset('assets/vendor/css/pages/page-auth.css') ?>" />
    

    <!-- Helpers -->
    <script src=" <?= asset('assets/vendor/js/helpers.js') ?>">
    </script>

<style>
    .login-form {
        border: 3px solid #ccc;
        border-radius: 5px;
        padding: 5px;
    }
</style>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="mb-3 login-form"> 

                <div class="card">
                    
                        <!-- Logo -->
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                            <img src="<?= asset('assets/img/avatars/22.png') ?>" width="150" height="200" alt="library image" class="img-fluid custom-border">
                            </a>
                        </div>
                        <!-- /Logo -->
                       
                   <form id="create-student-form" action="<?= url('services/ajax_functions.php') ?>" enctype="multipart/form-data">
                      <input type="hidden" name="action" value="create_student">
                       <div class="mb-3">
                       <label for="idcard" class="form-label">idcard</label>
                       <input type="text" class="form-control" id="idcard" name="idcard" placeholder="SID111" autofocus required>
               </div>
              <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                   <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus required>
    
              </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="mobilenumber" class="form-label">mobilenumber</label>
                  <input type="number" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Enter your mobilenumber" autofocus required>       
                 </div>
               <div class="mb-3">
                 <label for="position" class="form-label">position</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Student" autofocus required>
               </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div>
                <button type="button" id="create-now" class="btn btn-primary d-grid w-100">Sign up</button>
               </form>

        <!-- Success and Error message containers -->
        <div id="success-message" class="alert alert-success" style="display: none;"></div>
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="./login.php">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>
    

<?php require_once('../layouts/Footer.php');
?>
<script>
            $(document).ready(function() {
                $('#create-now').on('click', function() {
                    // Get the form element
                    var form = $('#create-student-form')[0];
                    $('#create-student-form')[0].reportValidity();

                    // Check form validity
                    if (form.checkValidity()) {
                        // Create a FormData object
                        var formData = new FormData($('#create-student-form')[0]);

                        // Perform AJAX request
                        $.ajax({
                            url: $('#create-student-form').attr('action'),
                            type: 'POST',
                            data: formData,
                            contentType: false, // Don't set content type
                            processData: false, // Don't process the data
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#success-message').text(response.message).show(); // Show success message
                                    $('#error-message').hide(); // Hide error message
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    $('#error-message').text(response.message).show(); // Show error message
                                    $('#success-message').hide(); // Hide success message
                                }
                            },
                            error: function(error) {
                                // Handle the error
                                console.error('Error submitting the form:', error);
                                $('#error-message').text('Error submitting the form. Please try again later.').show(); // Show generic error message
                                $('#success-message').hide(); // Hide success message
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
        </script>

</body>

</html>