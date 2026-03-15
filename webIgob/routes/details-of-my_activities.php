<?php
require_once INCLUDES_DIR . '/database.php';

// รับค่า ID ของกิจกรรมจาก URL
$aid = $_GET['id'] ?? 0;
$conn = getConnection();

//  ดึงข้อมูลกิจกรรม
$sql = "SELECT * FROM Activity WHERE AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aid);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

// ดึงรูปภาพ "ทั้งหมด" ของกิจกรรมนี้
$sql_img = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
$stmt_img = $conn->prepare($sql_img);
$stmt_img->bind_param("i", $aid);
$stmt_img->execute();
$result_img = $stmt_img->get_result();

$images = [];
while ($row = $result_img->fetch_assoc()) {
    $images[] = $row['Image_Path'];
}

//  ดึงสถานะการสมัครของผู้ใช้ที่ล็อกอินอยู่
$user_status = null;
$current_uid = $_SESSION['user_id'] ?? 0;

if ($current_uid > 0) {
    // สมมติว่าตารางชื่อ Registration มีคอลัมน์ UID, AID และ Status
    $sql_status = "SELECT Status FROM Registration WHERE UID = ? AND AID = ?";
    $stmt_status = $conn->prepare($sql_status);
    $stmt_status->bind_param("ii", $current_uid, $aid);
    $stmt_status->execute();
    $result_status = $stmt_status->get_result();
    
    if ($row_status = $result_status->fetch_assoc()) {
        $user_status = $row_status['Status']; // เช่น 'เข้าร่วมแล้ว (อนุมัติ)'
    }
}
$conn->close();

$Check = CheckChkin($current_uid, $aid);
$otp = "";
if ($user_status === 'approved' && $current_uid > 0 && $Check) {
    $otp = generateOTP($current_uid, $aid);
}

// ส่งข้อมูลและรูปภาพไปให้หน้าเว็บแสดงผล
renderView('details-of-my_activities', [
    'activity' => $activity,
    'images' => $images,
    'user_status' => $user_status,
    'otp' => $otp,
    'user_chk_in' => $Check
]);