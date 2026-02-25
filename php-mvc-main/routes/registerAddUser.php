<?php
// require_once DATABASES_DIR . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // รับค่าจาก form
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $occupation = $_POST['occupation'];
    $province = $_POST['province'];
    $password = $_POST['password'];

    if(!checkDuplicateEmail($email)){
        $result =
        insertUserInfo($name, $gender, $email, $birthdate, $occupation, $province, $password);
        renderView('login');
    } else {
        echo "No";
    }

}

// require DATABASES_DIR . '/templates/register.php';