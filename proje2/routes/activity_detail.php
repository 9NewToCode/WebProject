<?php
require_once INCLUDES_DIR . '/database.php';

// รับค่า ID ของกิจกรรมจาก URL 
$id = $_GET['id'] ?? 0;
$conn = getConnection();

//  ดึงข้อมูลกิจกรรม
$sql = "SELECT * FROM Activity WHERE AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

// ดึงรูปภาพ "ทั้งหมด" ของกิจกรรมนี้
$sql_img = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
$stmt_img = $conn->prepare($sql_img);
$stmt_img->bind_param("i", $id);
$stmt_img->execute();
$result_img = $stmt_img->get_result();

$images = [];
while ($row = $result_img->fetch_assoc()) {
    $images[] = $row['Image_Path'];
}

// ส่งข้อมูลและรูปภาพไปให้หน้าเว็บแสดงผล
renderView('activity_detail', [
    'activity' => $activity,
    'images' => $images 
]);