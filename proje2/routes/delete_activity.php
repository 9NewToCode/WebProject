<?php
require_once INCLUDES_DIR . '/database.php';

// รับค่า ID ของกิจกรรมที่ต้องการลบจาก URL
$current_uid = $_SESSION['user_id'] ?? 0;
$user_role = $_SESSION['role'] ?? 'user'; // ดึงบทบาทจาก Session

if ($current_uid <= 0) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='/login';</script>";
    exit;
}
$id = $_GET['id'] ?? 0;

if ($id > 0) {
    $conn = getConnection();

    // ✨ 2. เพิ่มส่วนตรวจสอบสิทธิ์: ดึงข้อมูลเจ้าของกิจกรรม (CID) มาเช็คก่อน ✨
    $sql_check = "SELECT CID FROM Activity WHERE AID = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $activity = $result_check->fetch_assoc();

    if (!$activity) {
        echo "<script>alert('ไม่พบกิจกรรมที่ต้องการลบ'); window.location.href='/';</script>";
        exit;
    }

    // ✅ เงื่อนไขหัวใจสำคัญ: ต้องเป็นเจ้าของ (CID ตรงกัน) หรือ เป็น Admin เท่านั้น
    if ($current_uid !== $activity['CID'] && $user_role !== 'admin') {
        echo "<script>alert('คุณไม่มีสิทธิ์ลบกิจกรรมนี้!'); window.location.href='/';</script>";
        exit;
    }

    // --- เริ่มกระบวนการลบ (โค้ดเดิมของคุณ) ---

    //ค้นหารูปภาพของกิจกรรมนี้ เพื่อลบไฟล์ออกจากโฟลเดอร์ uploads ก่อน
    $sql_img = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
    $stmt_img = $conn->prepare($sql_img);
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();

    //ลูปอ่านชื่อไฟล์และสั่งลบทิ้งทีละรูป
    while ($row = $result_img->fetch_assoc()){
        $file_path = __DIR__ . '/../public' . $row['Image_Path']; // หาตำแหน่งไฟล์จริง
        if (file_exists($file_path)) {
            unlink($file_path);
    }
}
    //ลบข้อมูลรูปจากตาราง Activity_Image
    $sql_del_img = "DELETE FROM Activity_Image WHERE AID = ?";
    $stmt_del_img = $conn->prepare($sql_del_img);
    $stmt_del_img->bind_param("i", $id);
    $stmt_del_img->execute();

    //ลบข้อมูลจากตาราง Activity (main)
    $sql_del_act = "DELETE FROM Activity WHERE AID = ?";
    $stmt_del_act = $conn->prepare($sql_del_act);
    $stmt_del_act->bind_param("i", $id);

    if ($stmt_del_act->execute()) {
        // ลบสำเร็จ ให้แจ้งเตือนและกลับไปหน้าแรก
        echo "<script>alert('ลบกิจกรรมเรียบร้อยแล้ว!'); window.location.href='/';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบ: " . $conn->error . "'); window.location.href='/';</script>";
    }
} else {
    // ถ้าไม่มีการส่ง ID มา ให้เด้งกลับหน้าแรก
    header("Location: /");
}
exit;