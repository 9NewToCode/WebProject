<?php
require_once INCLUDES_DIR . '/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนสร้างกิจกรรม'); window.location.href='/login';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $participant_limit = (int)($_POST['participant_limit'] ?? 0);
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';     
    
    $cid = $_SESSION['user_id'];

    $sql = "INSERT INTO Activity (CID, Title, Description, Max_Participants, StartDate, EndDate) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississ", $cid, $title, $description, $participant_limit, $start_date, $end_date);
    
    if ($stmt->execute()) {
        $activity_id = $stmt->insert_id;
        
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (isset($_FILES['images'])) {
            $total_images = count($_FILES['images']['name']);
            for ($i = 0; $i < $total_images; $i++) {
                $file_name = $_FILES['images']['name'][$i];
                $file_tmp = $_FILES['images']['tmp_name'][$i];
                
                if (!empty($file_name)) {
                    $new_file_name = time() . '_' . basename($file_name);
                    $destination = $upload_dir . $new_file_name;
                    
                    // เช็คว่าย้ายไฟล์สำเร็จไหม
                    if (move_uploaded_file($file_tmp, $destination)) {
                        $image_path = '/public/uploads/' . $new_file_name; 
                        $sql_img = "INSERT INTO Activity_Image (AID, Image_Path) VALUES (?, ?)";
                        $stmt_img = $conn->prepare($sql_img);
                        
                        // เช็คว่าชื่อตารางในฐานข้อมูลผิดไหม
                        if (!$stmt_img) {
                            die("<div style='background:#fff; padding:20px; border:3px solid red;'><h3>❌ พังที่ฐานข้อมูล! (เช็คชื่อตาราง Activity_Image ด่วน)</h3>Error: " . $conn->error . "</div>");
                        }
                        
                        $stmt_img->bind_param("is", $activity_id, $image_path);
                        $stmt_img->execute();
                    } else {
                        // ถ้าแอบย้ายไฟล์ไม่สำเร็จ ให้แฉออกมา
                        $sys_error = error_get_last();
                        die("<div style='background:#fff; padding:20px; border:3px solid red;'><h3>❌ ย้ายไฟล์เข้าโฟลเดอร์ไม่สำเร็จ!</h3>พยายามย้ายไปที่: $destination <br>สาเหตุ: " . print_r($sys_error, true) . "</div>");
                    }
                }
            }
        }
        
        echo "<script>alert('สร้างกิจกรรมและอัปโหลดรูปภาพสำเร็จ!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

renderView('create_activity');