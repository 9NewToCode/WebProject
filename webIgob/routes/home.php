<?php
require_once INCLUDES_DIR . '/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='/login';</script>";
    exit;
}

$uid = $_SESSION['user_id'];

// เรียก function ดึงกิจกรรมที่ผู้ใช้สร้าง
$activities = getActivitiesByCreator($uid);

renderView('home', [
    'activities' => $activities
]);