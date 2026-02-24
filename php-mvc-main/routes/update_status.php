<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['aid'] ?? 0;
$uid = $_GET['uid'] ?? 0;
$status = $_GET['status'] ?? ''; // 'approved' หรือ 'rejected'

if ($aid > 0 && $uid > 0 && !empty($status)) {
    $conn = getConnection();
    
    // อัปเดตสถานะในตาราง Registration
    $sql = "UPDATE Registration SET Status = ? WHERE AID = ? AND UID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $aid, $uid);
    
    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตสถานะเรียบร้อย!'); window.location.href='/manage_participants?id=$aid';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
} else {
    header("Location: /");
}
exit;