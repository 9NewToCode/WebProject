<?php
require_once INCLUDES_DIR . '/database.php';

// รับค่า ID ของกิจกรรม
$aid = $_GET['id'] ?? 0;

// ดึงข้อมูลกิจกรรม
$activity = getActivityById($aid);

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

// ดึงรูปภาพกิจกรรม
$images = getActivityImages($aid);

// สถานะผู้ใช้
$current_uid = $_SESSION['user_id'] ?? 0;
$user_status = null;

if ($current_uid > 0) {
    $user_status = getUserActivityStatus($current_uid, $aid);
}

$Check = CheckChkin($current_uid, $aid);

$otp = "";
if ($user_status === 'approved' && $current_uid > 0 && $Check) {
    $otp = generateOTP($current_uid, $aid);
}

renderView('details-of-my_activities', [
    'activity' => $activity,
    'images' => $images,
    'user_status' => $user_status,
    'otp' => $otp,
    'user_chk_in' => $Check
]);