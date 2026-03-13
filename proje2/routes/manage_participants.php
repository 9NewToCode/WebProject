<?php
require_once INCLUDES_DIR . '/database.php';

$aid = $_GET['id'] ?? 0;
$conn = getConnection();

//ดึงข้อมูลกิจกรรม เพื่อเอาชื่อกิจกรรมมาโชว์
$sql_act = "SELECT Title FROM Activity WHERE AID = ?";
$stmt_act = $conn->prepare($sql_act);
$stmt_act->bind_param("i", $aid);
$stmt_act->execute();
$activity = $stmt_act->get_result()->fetch_assoc();

// ดึงรายชื่อคนที่ลงทะเบียนกิจกรรมนี้ พร้อมข้อมูลจากตาราง User
$sql = "SELECT r.UID, r.Status, u.Name, u.Email 
        FROM Registration r 
        JOIN User u ON r.UID = u.UID 
        WHERE r.AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aid);
$stmt->execute();
$participants = $stmt->get_result();

renderView('manage_participants', [
    'activity' => $activity,
    'participants' => $participants,
    'aid' => $aid
]);