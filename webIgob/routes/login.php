<?php
require_once INCLUDES_DIR . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkLogin($email, $password)) {

        $uid = getUserId($email);
        $_SESSION['user_id'] = $uid;

        // ดึงชื่อและ role จาก database
        $user = getUserInfo($uid);

        if ($user) {
            $_SESSION['user_name'] = $user['Name'];
            $_SESSION['role'] = $user['Role'];
        }

        echo "<script>alert('เข้าสู่ระบบสำเร็จ!'); window.location.href='/';</script>";
        exit;

    } else {
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง!'); window.location.href='/login';</script>";
        exit;
    }

} else {
    renderView('login');
}