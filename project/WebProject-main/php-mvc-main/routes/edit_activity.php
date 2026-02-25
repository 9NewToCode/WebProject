<?php
require_once INCLUDES_DIR . '/database.php';

$conn = getConnection();
// รับค่า ID และบังคับให้เป็นตัวเลข
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id === 0) {
    die("<script>alert('ไม่พบข้อมูล ID กิจกรรม กรุณาลองใหม่อีกครั้ง'); window.history.back();</script>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $participant_limit = (int)($_POST['participant_limit'] ?? 0);
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    
    // อัปเดตข้อมูลข้อความ
    $sql = "UPDATE Activity SET Title=?, Description=?, Max_Participants=?, StartDate=?, EndDate=? WHERE AID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $title, $description, $participant_limit, $start_date, $end_date, $id);
    
    if ($stmt->execute()) {
        
        // --- ระบบลบรูปภาพเฉพาะที่ติ๊กเลือก ---
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $del_path) {
                // ลบไฟล์ออกจากโฟลเดอร์จริง
                $file_path = __DIR__ . '/..' . $del_path; 
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                // ลบข้อมูลรูปนั้นออกจาก Database
                $sql_del = "DELETE FROM Activity_Image WHERE AID = ? AND Image_Path = ?";
                $stmt_del = $conn->prepare($sql_del);
                $stmt_del->bind_param("is", $id, $del_path);
                $stmt_del->execute();
            }
        }

        // --- เพิ่มรูปภาพใหม่ ไม่แตะรูปเก่าที่ไม่ได้ติ๊กลบ ---
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = __DIR__ . '/../public/uploads/';
            $total_images = count($_FILES['images']['name']);
            
            for ($i = 0; $i < $total_images; $i++) {
                $file_name = $_FILES['images']['name'][$i];
                $file_tmp = $_FILES['images']['tmp_name'][$i];
                
                if (!empty($file_name)) {
                    $new_file_name = time() . '_' . basename($file_name);
                    $destination = $upload_dir . $new_file_name;
                    
                    if (move_uploaded_file($file_tmp, $destination)) {
                        $image_path = '/public/uploads/' . $new_file_name; 
                        $sql_new_img = "INSERT INTO Activity_Image (AID, Image_Path) VALUES (?, ?)";
                        $stmt_new_img = $conn->prepare($sql_new_img);
                        $stmt_new_img->bind_param("is", $id, $image_path);
                        $stmt_new_img->execute();
                    }
                }
            }
        }
        
        echo "<script>alert('อัปเดตข้อมูลและรูปภาพสำเร็จ!'); window.location.href='/activity_detail?id=$id';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

// ดึงข้อมูลกิจกรรม
$sql = "SELECT * FROM Activity WHERE AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

// ดึงรูปภาพเก่าเพื่อส่งไปแสดงให้ติ๊กลบที่หน้าเว็บ
$sql_imgs = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
$stmt_imgs = $conn->prepare($sql_imgs);
$stmt_imgs->bind_param("i", $id);
$stmt_imgs->execute();
$result_imgs = $stmt_imgs->get_result();

$images = [];
while ($row = $result_imgs->fetch_assoc()) {
    $images[] = $row['Image_Path'];
}

// โยนข้อมูลไปที่ Template 
renderView('edit_activity', ['activity' => $activity, 'images' => $images]);