<?php
require_once INCLUDES_DIR . '/database.php';

$conn = getConnection();
// รับค่า ID ว่ากำลังจะแก้ไขกิจกรรมไหน
$id = $_GET['id'] ?? $_POST['id'] ?? 0;

// ถ้ามีการกดปุ่ม "บันทึกการแก้ไข" (ส่งข้อมูลแบบ POST มา)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $participant_limit = (int)($_POST['participant_limit'] ?? 0);
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    
    // คำสั่ง SQL อัปเดตข้อมูล (ยังไม่รวมแก้ไขรูปภาพ เพื่อความง่ายก่อนครับ)
    $sql = "UPDATE Activity SET Title=?, Description=?, Max_Participants=?, StartDate=?, EndDate=? WHERE AID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $title, $description, $participant_limit, $start_date, $end_date, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('แก้ไขข้อมูลกิจกรรมสำเร็จ!'); window.location.href='/activity_detail?id=$id';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}


// ถ้าเข้ามาดูเฉยๆ ให้ดึงข้อมูลเก่ามาแสดงที่ฟอร์ม
$sql = "SELECT * FROM Activity WHERE AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรม";
    exit;
}

renderView('edit_activity', ['activity' => $activity]);