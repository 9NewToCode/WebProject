<?php
require_once INCLUDES_DIR . '/database.php';

// 1. รับค่าจาก URL
$search_name = trim($_GET['search_name'] ?? '');
$start_date  = trim($_GET['start_date'] ?? '');
$end_date    = trim($_GET['end_date'] ?? '');
$current_uid = $_SESSION['user_id'] ?? 0;

// 2. เรียกใช้ฟังก์ชันที่แยกไว้ (ส่งค่าเข้าไปตามลำดับ)
$activities = searchActivities($search_name, $start_date, $end_date, $current_uid);

// 3. ส่งข้อมูลไปแสดงผล
renderView('search', ['activities' => $activities]);