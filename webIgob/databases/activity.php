<?php
function getUserRegisteredActivities($uid)
{
    global $conn;
    $activities = [];

    $sql = "SELECT a.AID, a.Title, a.StartDate, a.EndDate, r.Status, 
            (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
            FROM Registration r 
            JOIN Activity a ON r.AID = a.AID 
            WHERE r.UID = ? 
            ORDER BY a.StartDate DESC";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activities[] = $row;
            }
        }

        $stmt->close(); // ปิดแค่นี้พอ
    }

    return $activities;
}

function searchActivities($search_name = '', $start_date = '', $end_date = '', $current_uid = 0)
{
    global $conn;
    $activities = [];

    $sql = "SELECT a.*, 
            (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
            FROM Activity a WHERE 1=1";

    $types = "";
    $params = [];

    if ($search_name !== '') {
        $sql .= " AND a.Title LIKE ?";
        $types .= "s";
        $params[] = "%" . $search_name . "%";
    }

    if ($current_uid > 0) {
        $sql .= " AND a.CID != ?";
        $types .= "i";
        $params[] = $current_uid;
    }

    if ($start_date !== '') {
        $sql .= " AND DATE(a.StartDate) >= ?";
        $types .= "s";
        $params[] = $start_date;
    }

    if ($end_date !== '') {
        $sql .= " AND DATE(a.EndDate) <= ?";
        $types .= "s";
        $params[] = $end_date;
    }

    $sql .= " ORDER BY a.AID DESC";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activities[] = $row;
            }
        }

        $stmt->close(); // ปิด statement
    }

    return $activities;
}

function getActivityById($aid)
{
    global $conn;

    $sql = "SELECT * FROM Activity WHERE AID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $aid);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $result;
}

function getActivityImages($aid)
{
    global $conn;

    $sql = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $aid);
    $stmt->execute();

    $result = $stmt->get_result();

    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['Image_Path'];
    }

    $stmt->close();

    return $images;
}

function getUserActivityStatus($uid, $aid)
{
    global $conn;

    $sql = "SELECT Status FROM Registration WHERE UID = ? AND AID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $aid);
    $stmt->execute();

    $result = $stmt->get_result();

    $status = null;
    if ($row = $result->fetch_assoc()) {
        $status = $row['Status'];
    }

    $stmt->close();

    return $status;
}

function getActivitiesByCreator($uid)
{
    global $conn;

    $activities = [];

    $sql = "SELECT a.*, 
            (SELECT Image_Path FROM Activity_Image ai WHERE ai.AID = a.AID LIMIT 1) as cover_image 
            FROM Activity a
            WHERE a.CID = ? 
            ORDER BY a.AID DESC";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $uid);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activities[] = $row;
            }
        }

        $stmt->close(); // ปิด statement
    }

    return $activities;
}
