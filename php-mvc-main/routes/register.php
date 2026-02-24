<?php
require_once DATABASES_DIR . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // รับค่าจาก form
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $occupation = $_POST['occupation'];
    $province = $_POST['province'];
    $password = $_POST['password'];

    // เข้ารหัส password
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL
    $sql = "INSERT INTO users 
            (name, gender, email, birthdate, occupation, province, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name,
        $gender,
        $email,
        $birthdate,
        $occupation,
        $province,
        $hashPassword
    ]);

    echo "สมัครสมาชิกสำเร็จ!";
}

require DATABASES_DIR . '/templates/register.php';