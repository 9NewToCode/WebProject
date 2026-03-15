<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['id'] ?? 0;
$conn = getConnection();

// ดึงข้อมูลกิจกรรม
$sql_act = "SELECT Title, Max_Participants FROM Activity WHERE AID = ?";
$stmt_act = $conn->prepare($sql_act);
$stmt_act->bind_param("i", $aid);
$stmt_act->execute();
$activity = $stmt_act->get_result()->fetch_assoc();

//  นับจำนวนคนแยกตามสถานะ (
$stats_count = ['approved' => 0, 'pending' => 0, 'rejected' => 0];
$sql_count = "SELECT Status, COUNT(*) as total FROM Registration WHERE AID = ? GROUP BY Status";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $aid);
$stmt_count->execute();
$res_count = $stmt_count->get_result();
while ($row = $res_count->fetch_assoc()) { $stats_count[$row['Status']] = $row['total']; }

//  นับสัดส่วนเพศ (เฉพาะคนที่อนุมัติแล้ว)
$stats_gender = ['male' => 0, 'female' => 0, 'other' => 0];
$sql_gender = "SELECT u.Gender, COUNT(*) as total 
               FROM Registration r 
               JOIN User u ON r.UID = u.UID 
               WHERE r.AID = ? AND r.Status = 'approved' 
               GROUP BY u.Gender";
$stmt_gender = $conn->prepare($sql_gender);
$stmt_gender->bind_param("i", $aid);
$stmt_gender->execute();
$res_gender = $stmt_gender->get_result();
while ($row = $res_gender->fetch_assoc()) { $stats_gender[$row['Gender']] = $row['total']; }

// คำนวณช่วงอายุโดยใช้ TIMESTAMPDIFF (เฉพาะคนที่อนุมัติแล้ว)
$stats_age = [];
$sql_age = "SELECT 
                CASE 
                    WHEN age < 18 THEN 'ต่ำกว่า 18 ปี'
                    WHEN age BETWEEN 18 AND 24 THEN '18-24 ปี'
                    WHEN age BETWEEN 25 AND 35 THEN '25-35 ปี'
                    ELSE '36 ปีขึ้นไป'
                END as age_group, COUNT(*) as total 
            FROM (
                SELECT TIMESTAMPDIFF(YEAR, u.BirthDate, CURDATE()) AS age 
                FROM Registration r 
                JOIN User u ON r.UID = u.UID 
                WHERE r.AID = ? AND r.Status = 'approved' AND u.BirthDate IS NOT NULL
            ) as AgeData GROUP BY age_group";
$stmt_age = $conn->prepare($sql_age);
$stmt_age->bind_param("i", $aid);
$stmt_age->execute();
$res_age = $stmt_age->get_result();
$conn->close();
while ($row = $res_age->fetch_assoc()) { $stats_age[$row['age_group']] = $row['total']; }

renderView('activity_stats', [
    'activity' => $activity,
    'aid' => $aid,
    'stats_count' => $stats_count,   
    'stats_gender' => $stats_gender, 
    'stats_age' => $stats_age        
]);