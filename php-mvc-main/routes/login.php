<?php
// Assume that login success

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (checkLogin($username, $password)) {
        $id = getUserId($username);
        $unix_timestamp = time();
        $_SESSION['timestamp'] = $unix_timestamp;
        $_SESSION['user_id'] = $id;
        header('Location: /');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }
} else {
    renderView('login');
}