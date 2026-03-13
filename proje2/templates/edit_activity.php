<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px; max-width: 600px; margin: auto;">
    <h2> แก้ไขกิจกรรม</h2>
    <?php $act = $data['activity']; ?>
    
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
        
        <label>รูปภาพปัจจุบัน (ติ๊กถูกที่ภาพเพื่อ <b>ลบทิ้ง</b>):</label><br>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; background: #f8d7da; padding: 10px; border-radius: 5px;">
            <?php if (!empty($data['images'])): ?>
                <?php foreach ($data['images'] as $img): ?>
                    <div style="text-align: center; background: white; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                        <img src="/public<?= htmlspecialchars($img) ?>" style="width: 100px; height: 80px; object-fit: cover; border-radius: 4px;"><br>
                        <input type="checkbox" name="delete_images[]" value="<?= htmlspecialchars($img) ?>"> ลบรูปนี้
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #666; margin: 0;">ยังไม่มีรูปภาพ</p>
            <?php endif; ?>
        </div>

        <label>อัปโหลดรูปภาพใหม่ (หากไม่ต้องการเปลี่ยนรูป ก็ไม่ต้องใส่):</label><br>
        <input type="file" name="images[]" accept="image/*" multiple style="width: 100%; padding: 8px;"><br><br>

        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;"> บันทึกการแก้ไข</button>
        <a href="/activity_detail?id=<?= $act['AID'] ?>" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">ยกเลิก</a>
    </form>
</main>

<?php include __DIR__ . '/footer.php'; ?>