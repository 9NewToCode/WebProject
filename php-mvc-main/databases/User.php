<?php
// ฟังก์ชันสำหรับดึงข้อมูลนักเรียนจากฐานข้อมูล
function checkLogin(string $email, string $password): bool
{
    global $conn;
    $sql = 'select password from students where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return password_verify($password, $row['password']);
    }
    return false;
}

function getUserId(string $email): ?int
{
    global $conn;
    $sql = 'select student_id from students where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? (int)$row['student_id'] : null;
}

function getCourse(): mysqli_result|bool
{
    global $conn;
    $sql = 'select * from User';
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}