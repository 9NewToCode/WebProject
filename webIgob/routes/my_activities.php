<?php
require_once INCLUDES_DIR . '/database.php';

// 1. เช็คการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนดูข้อมูลกิจกรรมของฉัน'); window.location.href='/login';</script>";
    exit;
}

// 2. เรียกใช้ฟังก์ชัน ดึงข้อมูลมาใส่ตัวแปร
$uid = $_SESSION['user_id'];
$activities = getUserRegisteredActivities($uid);

// 3. ส่งไปแสดงผล
renderView('my_activities', ['activities' => $activities]);