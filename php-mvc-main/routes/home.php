<?php
require_once INCLUDES_DIR . '/database.php';

// เชื่อมต่อฐานข้อมูล
$conn = getConnection();

// ดึงข้อมูลกิจกรรมทั้งหมด ดึงรูปภาพแรกมาเป็นหน้าปกด้วย
$sql = "SELECT a.*, 
        (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
        FROM Activity a 
        ORDER BY a.AID DESC"; // เรียงจากกิจกรรมล่าสุด

$result = $conn->query($sql);
$activities = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

renderView('home', ['activities' => $activities]);