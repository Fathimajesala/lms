<?php

require_once('./../../config.php');
include __DIR__ . '/../../helpers/AppManager.php';



$sm = AppManager::getSM();
$error = $sm->getAttribute("error");

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
                            <img src="<?= asset('assets/img/avatars/20.png') ?>" width="200" height="200" alt="library image" class="img-fluid custom-border">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <form id="formAuthentication" class="mb-3" action="../../services/auth.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                            <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"></span>
                                </div>
                            </div>
                            <?php if (!empty($error)) : ?>
                                <div class="alert alert-danger"><?= ($error ?? "") ?></div>
                            <?php endif; ?>
                            <p class="text-center">
                         <span>Visiting for the first time? </span>
                         <a href="./Guest page.php">
                        <span>Explore our library</span>
                         </a>
                     </p>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login </button>
                            </div>
                        </form>

                       

                     <p class="text-center">
                         <span>New to our library?</span>
                         <a href="./register.php">
                        <span>Create an account</span>
                         </a>
                     </p>
                     


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

</body>

</html>