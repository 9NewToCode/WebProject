<?php
require_once INCLUDES_DIR . '/database.php';

$conn = getConnection();
// รับค่า ID ว่ากำลังจะแก้ไขกิจกรรมไหน
$id = $_GET['id'] ?? $_POST['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $participant_limit = (int)($_POST['participant_limit'] ?? 0);
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    
    // อัปเดตข้อมูลข้อความและวันที่ 
    $sql = "UPDATE Activity SET Title=?, Description=?, Max_Participants=?, StartDate=?, EndDate=? WHERE AID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $title, $description, $participant_limit, $start_date, $end_date, $id);
    
    if ($stmt->execute()) {
        
        //  ระบบจัดการรูปภาพ (เช็คว่าแนบไฟล์รูปมาด้วยมั้ย)
        if (!empty($_FILES['images']['name'][0])) {
            
            // --- ลบรูปเก่าทิ้ง ---
            $sql_old_img = "SELECT Image_Path FROM Activity_Image WHERE AID = ?";
            $stmt_old_img = $conn->prepare($sql_old_img);
            $stmt_old_img->bind_param("i", $id);
            $stmt_old_img->execute();
            $result_old_img = $stmt_old_img->get_result();

            while ($row = $result_old_img->fetch_assoc()){
                $file_path = __DIR__ . '/../public' . $row['Image_Path']; 
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $sql_del_img = "DELETE FROM Activity_Image WHERE AID = ?";
            $stmt_del_img = $conn->prepare($sql_del_img);
            $stmt_del_img->bind_param("i", $id);
            $stmt_del_img->execute();

            // --- อัปโหลดรูปใหม่เข้าโฟลเดอร์ ---
            $upload_dir = __DIR__ . '/../public/uploads/';
            $total_images = count($_FILES['images']['name']);
            
            for ($i = 0; $i < $total_images; $i++) {
                $file_name = $_FILES['images']['name'][$i];
                $file_tmp = $_FILES['images']['tmp_name'][$i];
                
                if (!empty($file_name)) {
                    $new_file_name = time() . '_' . basename($file_name);
                    $destination = $upload_dir . $new_file_name;
                    
                    if (move_uploaded_file($file_tmp, $destination)) {
                        $image_path = '/uploads/' . $new_file_name; 
                        $sql_new_img = "INSERT INTO Activity_Image (AID, Image_Path) VALUES (?, ?)";
                        $stmt_new_img = $conn->prepare($sql_new_img);
                        $stmt_new_img->bind_param("is", $id, $image_path);
                        $stmt_new_img->execute();
                    }
                }
            }
        }
        
        echo "<script>alert('แก้ไขข้อมูลและรูปภาพสำเร็จ!'); window.location.href='/activity_detail?id=$id';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

// ถ้าเข้ามาดูเฉยๆ ให้ดึงข้อมูลเก่ามาแสดงที่ฟอร์ม
$sql = "SELECT * FROM Activity WHERE AID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();

if (!$activity) {
    echo "ไม่พบข้อมูลกิจกรรมนี้";
    exit;
}

renderView('edit_activity', ['activity' => $activity]);