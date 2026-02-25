<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px; max-width: 600px; margin: auto;">
    <h2>แก้ไขกิจกรรม</h2>
    <?php 
        $act = $data['activity']; 
        // ดึงข้อมูลอาร์เรย์รูปภาพที่แนบมาจากหลังบ้าน
        $existing_images = $data['images'] ?? []; 
    ?>
    
    <form action="/edit_activity?id=<?= $act['AID'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $act['AID'] ?>">
        
        <label>ชื่อกิจกรรม:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($act['Title']) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <label>รายละเอียด:</label><br>
        <textarea name="description" rows="5" required style="width: 100%; padding: 8px;"><?= htmlspecialchars($act['Description']) ?></textarea><br><br>
        
        <label>จำนวนที่รับสมัคร (คน):</label><br>
        <input type="number" name="participant_limit" min="1" value="<?= htmlspecialchars($act['Max_Participants']) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <label>วันที่จัดกิจกรรม:</label><br>
        <input type="date" name="start_date" value="<?= date('Y-m-d', strtotime($act['StartDate'])) ?>" required style="width: 100%; padding: 8px;"><br><br>

        <label>วันที่สิ้นสุด:</label><br>
        <input type="date" name="end_date" value="<?= date('Y-m-d', strtotime($act['EndDate'])) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <?php if (!empty($existing_images)): ?>
            <label>รูปภาพปัจจุบัน (กด ❌ เพื่อลบรูปที่ไม่ได้ใช้):</label><br>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px; margin-top: 5px;">
                <?php foreach ($existing_images as $img): ?>
                    <div style="border: 1px solid #ddd; padding: 5px; border-radius: 5px; text-align: center; background: #f9f9f9;">
                        <img src="<?= htmlspecialchars($img) ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 3px; display: block; margin-bottom: 5px;">
                        <label style="cursor: pointer; color: #dc3545; font-size: 14px; font-weight: bold;">
                            <input type="checkbox" name="delete_images[]" value="<?= htmlspecialchars($img) ?>"> ลบรูปนี้
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <label>อัปโหลดรูปภาพเพิ่มเติม (เลือกได้หลายรูป):</label><br>
        <input type="file" name="images[]" accept="image/*" multiple style="width: 100%; padding: 8px; margin-bottom: 20px;"><br>
        
        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">บันทึกการแก้ไข</button>
        <a href="/activity_detail?id=<?= $act['AID'] ?>" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">ยกเลิก</a>
    </form>
</main>

<?php include __DIR__ . '/footer.php'; ?>