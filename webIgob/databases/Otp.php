<?php
function generateOTP($uid, $aid)
{
    $secret = "HELLO_WORLD_EIEI";
    $time_block = floor(time() / (5 * 60));
    $data = $uid . $aid . $time_block . $secret;
    $hash = hash('sha256', $data);

    return substr($hash, 0, length: 6);
}

function verifyOTP($uid, $aid, $otp)
{
    $current_time_block = floor(time() / (5 * 60));
    $previous_time_block = $current_time_block - 1;

    // เช็คกับบล็อกปัจจุบัน
    if ($otp === substr(hash('sha256', $uid . $aid . $current_time_block . "HELLO_WORLD_EIEI"), 0, 6)) {
        return true;
    }

    // เช็คเผื่อบล็อกที่เพิ่งผ่านมา (ป้องกันปัญหารอยต่อเวลา)
    if ($otp === substr(hash('sha256', $uid . $aid . $previous_time_block . "HELLO_WORLD_EIEI"), 0, 6)) {
        return true;
    }

    return false;
}

function ChkinUser($chkin, $uid, $aid): bool
{
    global $conn;
    $sql = "UPDATE Registration SET Chk_In_Status = ? WHERE AID = ? AND UID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $chkin, $aid, $uid);
    $stmt->execute();
    return  $stmt->affected_rows > 0;
}

function StatusChk($uid, $aid): bool
{
    global $conn;
    $sql = 'select Status from Registration
            where uid = ?
            and aid = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $uid, $aid);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return trim($row['Status']) === 'approved';
    }
    
    return false;
}

function CheckChkin($uid, $aid): bool
{
    global $conn;
    $sql = 'select Chk_In_Status from Registration
            where uid = ?
            and aid = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $uid, $aid);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return trim($row['Chk_In_Status']) === 'Unchecked';
    }
    
    return false;
}