<?php
// ดึงการเชื่อมต่อฐานข้อมูลมาใช้
require_once INCLUDES_DIR . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    // รับค่าที่ส่งมาจากฟอร์ม
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $participant_limit = (int)($_POST['participant_limit'] ?? 0);
    $event_date = $_POST['event_date'] ?? '';
    
    // ชั่วคราว: กำหนด ID ของผู้สร้างกิจกรรมเป็น 1 ไปก่อน (ไว้ค่อยเชื่อมกับระบบ Login ทีหลัง)
    $cid = 1;

    //  คำสั่ง SQL สำหรับบันทึกลงตาราง Activity
    $sql = "INSERT INTO Activity (CID, Title, Description, Max_Participants, StartDate) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // s = string, i = integer
    $stmt->bind_param("issis", $cid, $title, $description, $participant_limit, $event_date);
    
    if ($stmt->execute()) {
        // ดึง ID ของกิจกรรมที่เพิ่งถูกสร้างขึ้นมา เพื่อเอาไปเชื่อมกับรูปภาพ
        $activity_id = $stmt->insert_id;
        
        //  จัดการอัปโหลดรูปภาพ
        // สร้างโฟลเดอร์ uploads ใน public ถ้ายังไม่มี
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // วนลูปอัปโหลดทีละรูป
        if (isset($_FILES['images'])) {
            $total_images = count($_FILES['images']['name']);
            for ($i = 0; $i < $total_images; $i++) {
                $file_name = $_FILES['images']['name'][$i];
                $file_tmp = $_FILES['images']['tmp_name'][$i];
                
                if (!empty($file_name)) {
                    // เปลี่ยนชื่อไฟล์ใหม่ไม่ให้ซ้ำกัน ป้องกันไฟล์ทับกัน
                    $new_file_name = time() . '_' . basename($file_name);
                    $destination = $upload_dir . $new_file_name;
                    
                    // ย้ายไฟล์รูปภาพไปเก็บที่โฟลเดอร์ public/uploads
                    if (move_uploaded_file($file_tmp, $destination)) {
                        // บันทึกเส้นทางรูปลงตาราง Activity_Image
                        $image_path = '/uploads/' . $new_file_name; 
                        $sql_img = "INSERT INTO Activity_Image (AID, Image_Path) VALUES (?, ?)";
                        $stmt_img = $conn->prepare($sql_img);
                        $stmt_img->bind_param("is", $activity_id, $image_path);
                        $stmt_img->execute();
                    }
                }
            }
        }
        
        // บันทึกสำเร็จ ให้แจ้งเตือนและกลับไปหน้าแรก
        echo "<script>alert('สร้างกิจกรรมและอัปโหลดรูปภาพสำเร็จ!'); window.location.href='/';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

// ถ้าไม่ได้ส่งข้อมูลเปิดเข้ามาดูหน้าเว็บเฉยๆ ให้แสดงหน้าฟอร์ม
renderView('create_activity');