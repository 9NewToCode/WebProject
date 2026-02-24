<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['id'] ?? 0;

// ชั่วคราว: สมมติว่าคนที่กดสมัครคือ User หมายเลข 2 (ผู้เข้าร่วม) 
$uid = 2; 

if ($aid > 0) {
    $conn = getConnection();
    
    // เช็คก่อนว่า Userคนนี้ เคยสมัครกิจกรรมนี้ไปแล้วหรือยัง?
    $check_sql = "SELECT * FROM Registration WHERE AID = ? AND UID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $aid, $uid);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        // ถ้าเคยสมัครแล้ว ให้เด้งกลับไปพร้อมแจ้งเตือน
        echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้ไปแล้วครับ!'); window.location.href='/activity_detail?id=$aid';</script>";
        exit;
    }

    // ถ้ายังไม่เคยสมัคร ให้บันทึกข้อมูลลงตาราง Registration
    $status = 'pending'; // สถานะเริ่มต้นคือ รอการอนุมัติ
    
    // ตรวจสอบชื่อคอลัมน์ให้ตรงกับตาราง Registration ในดาตาเบส
    $sql = "INSERT INTO Registration (AID, UID, Status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $aid, $uid, $status);
    
    if ($stmt->execute()) {
        echo "<script>alert('ส่งคำขอเข้าร่วมกิจกรรมสำเร็จ! กรุณารอผู้สร้างกิจกรรมอนุมัติ'); window.location.href='/activity_detail?id=$aid';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการสมัคร: " . $conn->error . "'); window.location.href='/activity_detail?id=$aid';</script>";
    }
} else {
    // ถ้าไม่มีการส่ง ID กิจกรรมมา ให้เด้งกลับหน้าแรก
    header("Location: /");
}
exit;