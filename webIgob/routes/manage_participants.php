<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['id'] ?? 0;

// ดึงข้อมูลกิจกรรม
$activity = getActivityTitle($aid);

if (!$activity) {
    echo "ไม่พบกิจกรรม";
    exit;
}

// ดึงรายชื่อผู้สมัคร
$participants = getParticipantsByActivity($aid);

// ระบบ OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $insertedOtp = $_POST['otp'] ?? '';
    $uid = $_POST['target_uid'] ?? 0;

    if (verifyOTP($uid, $aid, $insertedOtp)) {

        if (StatusChk($uid, $aid)) {

            $chkin = "Checked";
            ChkinUser($chkin, $uid, $aid);

            echo "<script>alert('อัปเดตสถานะเรียบร้อย!'); window.location.href='/manage_participants?id=$aid';</script>";

        } else {

            echo "<script>alert('ยังไม่อนุมัติเข้างาน'); window.location.href='/manage_participants?id=$aid';</script>";

        }

    } else {

        echo "<script>alert('OTP ไม่ถูกต้อง หรือหมดอายุ'); window.location.href='/manage_participants?id=$aid';</script>";

    }

} else {

    renderView('manage_participants', [
        'activity' => $activity,
        'participants' => $participants,
        'aid' => $aid
    ]);

}