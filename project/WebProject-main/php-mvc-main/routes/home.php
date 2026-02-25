<?php
require_once INCLUDES_DIR . '/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='/login';</script>";
    exit;
}

$uid = $_SESSION['user_id'];

// เชื่อมต่อฐานข้อมูล
$conn = getConnection();

// ดึงข้อมูลกิจกรรมทั้งหมด ดึงรูปภาพแรกมาเป็นหน้าปกด้วย
$sql = "SELECT a.*, 
        (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
        FROM Activity a
        WHERE a.CID = ? 
        ORDER BY a.AID DESC"; // เรียงจากกิจกรรมล่าสุด

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

$activities = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

renderView('home', ['activities' => $activities]);