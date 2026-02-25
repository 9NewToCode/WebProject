<?php
require_once INCLUDES_DIR . '/database.php';

// ถ้ามีการกดปุ่ม "เข้าสู่ระบบ" ส่งข้อมูลแบบ POST มา
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkLogin($email, $password)) {
        // 1. ถ้ารหัสถูก ให้ดึง UID มาเก็บไว้ใน Session
        $uid = getUserId($email);
        $_SESSION['user_id'] = $uid;
        
        // ✨ 2. เพิ่มโค้ดดึงชื่อผู้ใช้จากฐานข้อมูล มาเก็บลง Session ✨
        $conn = getConnection();
        // ** สำคัญ: เช็คชื่อตาราง (User) และชื่อคอลัมน์ที่เก็บชื่อ (Name) ให้ตรงกับในฐานข้อมูลของคุณด้วยนะครับ **
        $stmt = $conn->prepare("SELECT Name FROM User WHERE UID = ?"); 
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $_SESSION['user_name'] = $row['Name']; // เก็บชื่อลง Session
        }
        
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