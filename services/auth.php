<?php
include __DIR__ . '/../config.php';
include __DIR__ . '/../helpers/AppManager.php';


$pm = AppManager::getPM();
$sm = AppManager::getSM();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $sm->setAttribute("error", 'Please fill all required fields!');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Check if the user exists in either students or users table
    $user = getUser($pm, $email, $password);
    if ($user !== null) {
        // User exists, set session attributes
        $sm->setAttribute("userId", $user['id']);
        $sm->setAttribute("username", $user['username']);
        $sm->setAttribute("position", $user['position']);
        
        // Redirect to appropriate page based on user type
        if ($user['is_student']) {
            header('location: ../index.php');
        } else {
            header('location: ../index.php');
        }
        exit;
    } else {
        // Neither user nor student found
        $sm->setAttribute("error", 'Invalid username or password!');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

function getUser($pm, $email, $password) {
    $param = array(':email' => $email);
    $user = $pm->run("SELECT * FROM user WHERE email = :email", $param, true);
    if (!$user) {
        // If not found in users table, try in students table
        $user = $pm->run("SELECT * FROM students WHERE email = :email", $param, true);
        if ($user) {
            // Set a flag to identify student
            $user['is_student'] = true;
        }
    }
    return $user;
}
?>
