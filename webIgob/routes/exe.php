<?php
require_once INCLUDES_DIR . '/database.php';

// รับค่า ID
$id = $_GET['id'] ?? 0;

// ดึงข้อมูลกิจกรรม
$activity = getActivityById($id);

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

// ดึงรูปภาพกิจกรรม
$images = getActivityImages($id);

// ส่งไป view
renderView('exe', [
    'activity' => $activity,
    'images' => $images
]);