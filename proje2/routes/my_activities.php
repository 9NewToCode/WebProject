<?php
require_once INCLUDES_DIR . '/database.php';

// 1. เช็คก่อนว่าล็อกอินหรือยัง
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนดูข้อมูลกิจกรรมของฉัน'); window.location.href='/login';</script>";
    exit;
}

$uid = $_SESSION['user_id'];
$conn = getConnection();

// 2. ดึงข้อมูลจากตาราง Registration และเชื่อมตาราง Activity เพื่อเอาข้อมูลกิจกรรมมาแสดง
$sql = "SELECT a.AID, a.Title, a.StartDate, a.EndDate, r.Status, 
        (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
        FROM Registration r 
        JOIN Activity a ON r.AID = a.AID 
        WHERE r.UID = ? 
        ORDER BY a.StartDate DESC"; // เรียงจากวันที่จัดกิจกรรมล่าสุดขึ้นก่อน

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

// 3. ส่งข้อมูลไปให้หน้า Template เพื่อแสดงผล
renderView('my_activities', ['activities' => $activities]);