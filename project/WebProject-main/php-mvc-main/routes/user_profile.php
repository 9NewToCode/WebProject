<?php
require_once INCLUDES_DIR . '/database.php';

$uid = $_GET['uid'] ?? 0;
$aid = $_GET['aid'] ?? 0; // รับ AID กลับมาด้วยเพื่อไว้ทำปุ่มกดย้อนกลับ
$conn = getConnection();

// ดึงข้อมูลทั้งหมดของ User คนนี้ 
$sql = "SELECT Name, Gender, BirthDate, Occupation, Email, Province FROM User WHERE UID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "ไม่พบข้อมูลผู้ใช้งาน";
    exit;
}

renderView('user_profile', [
    'user' => $user,
    'aid' => $aid
]);