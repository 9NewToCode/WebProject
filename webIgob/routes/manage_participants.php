<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['id'] ?? 0;
$conn = getConnection();

// ดึงข้อมูลกิจกรรม เพื่อเอาชื่อกิจกรรมมาโชว์
$sql_act = "SELECT Title FROM Activity WHERE AID = ?";
$stmt_act = $conn->prepare($sql_act);
$stmt_act->bind_param("i", $aid);
$stmt_act->execute();
$activity = $stmt_act->get_result()->fetch_assoc();

// ดึงรายชื่อคนลงทะเบียน 
$sql = "SELECT r.UID, r.Status, r.Check_In_Status, u.Name, u.Email 
        FROM Registration r 
        JOIN User u ON r.UID = u.UID 
        WHERE r.AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aid);
$stmt->execute();
$participants = $stmt->get_result();
$conn->close();

// ระบบจัดการ OTP เมื่อมีการส่งฟอร์ม (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $insertedOtp = $_POST['otp'];
    $uid = $_POST['target_uid'];
    if (verifyOTP($uid, $aid, $insertedOtp)){
        if (StatusChk($uid, $aid)){
            $chkin = "Checked";
            ChkinUser($chkin, $uid, $aid);
            echo "<script>alert('อัปเดตสถานะเรียบร้อย!'); window.location.href='/manage_participants?id=$aid';</script>";
        } else {
            echo "<script>alert('ยังไม่อนุมัติเข้างาน'); window.location.href='/manage_participants?id=$aid';</script>";
        }
    } else {
        echo "<script>alert('OTP ไม่ถูกต้อง หรืออาจหมดอายุ'); window.location.href='/manage_participants?id=$aid';</script>";
    }
} else {
    // แสดงผลหน้าจัดการผู้สมัคร
    renderView('manage_participants', [
        'activity' => $activity,
        'participants' => $participants,
        'aid' => $aid
    ]);
}