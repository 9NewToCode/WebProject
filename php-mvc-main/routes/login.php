<?php
require_once INCLUDES_DIR . '/database.php';

// ถ้ามีการกดปุ่ม "เข้าสู่ระบบ" ส่งข้อมูลแบบ POST มา
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkLogin($email, $password)) {
        // ถ้ารหัสถูก ให้ดึง UID มาเก็บไว้ใน Session
        $uid = getUserId($email);
        $_SESSION['user_id'] = $uid;
        
        echo "<script>alert('เข้าสู่ระบบสำเร็จ!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง!'); window.location.href='/login';</script>";
        exit;
    }
} else {
    // ถ้าแค่พิมพ์ URL /login ให้โชว์หน้าฟอร์ม
    renderView('login');
}