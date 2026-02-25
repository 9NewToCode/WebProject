<?php
require_once INCLUDES_DIR . '/database.php';

$conn = getConnection();

// 1. รับค่าและตัดช่องว่าง
$search_name = trim($_GET['search_name'] ?? '');
$start_date = trim($_GET['start_date'] ?? '');
$end_date = trim($_GET['end_date'] ?? '');

$sql = "SELECT a.*, 
        (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
        FROM Activity a WHERE 1=1";

$types = "";
$params = [];

// 2. เช็คชื่อ
if ($search_name !== '') {
    $sql .= " AND a.Title LIKE ?";
    $types .= "s";
    $params[] = "%" . $search_name . "%";
}

// 3. เช็ควันเริ่มต้น (ใช้ DATE() ครอบ เพื่อเทียบแค่วัน-เดือน-ปี ไม่เอาเวลา)
if ($start_date !== '') {
    $sql .= " AND DATE(a.StartDate) >= ?";
    $types .= "s";
    $params[] = $start_date;
}

// 4. เช็ควันสิ้นสุด
if ($end_date !== '') {
    $sql .= " AND DATE(a.StartDate) <= ?";
    $types .= "s";
    $params[] = $end_date;
}

$sql .= " ORDER BY a.AID DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$activities = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

// ส่งข้อมูลไปให้หน้า Template
renderView('search', ['activities' => $activities]);