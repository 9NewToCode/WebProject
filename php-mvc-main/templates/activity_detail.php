<?php include __DIR__ . '/header.php'; ?>
<main style="padding: 20px; max-width: 800px; margin: auto;">
    <?php $act = $data['activity']; ?>
    <h1 style="color: #333;"><?= htmlspecialchars($act['Title']) ?></h1>
    <p style="color: #666;"><strong> วันที่จัด:</strong> <?= htmlspecialchars($act['StartDate']) ?></p>
    <p style="color: #666;"><strong> จำนวนที่รับสมัคร:</strong> <?= htmlspecialchars($act['Max_Participants']) ?> คน</p>
    
    <hr>
    <h3>รายละเอียดกิจกรรม:</h3>
    <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($act['Description'])) ?></p>
    
    <h3>อัลบั้มรูปภาพ:</h3>
    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <?php if (!empty($data['images'])): ?>
            <?php foreach ($data['images'] as $img): ?>
                <img src="<?= htmlspecialchars($img) ?>" alt="รูปภาพกิจกรรม" style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px; box-shadow: 1px 1px 5px rgba(0,0,0,0.2);">
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีรูปภาพสำหรับกิจกรรมนี้</p>
        <?php endif; ?>
    </div>

    <div style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
    
    <a href="/" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;"> กลับหน้าแรก</a>

    <?php 
        // เช็คว่าใครล็อกอินอยู่ ถ้ายังเป็น0
        $current_uid = $_SESSION['user_id'] ?? 0; 
    ?>

    <?php if ($current_uid > 0): //ล็อกอินแล้ว ถึงจะเห็นปุ่ม ?>
    
        <?php if ($current_uid === $act['CID']): // เช็คว่า UID ตรงกับรหัสผู้สร้างกิจกรรมมั้ย ?>
            
            <a href="/edit_activity?id=<?= $act['AID'] ?>" style="padding: 10px 20px; background: #ffc107; color: black; text-decoration: none; border-radius: 5px;">แก้ไขกิจกรรม</a>
            <a href="/delete_activity?id=<?= $act['AID'] ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบกิจกรรมนี้?');" style="padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;">ลบกิจกรรม</a>
            <a href="/manage_participants?id=<?= $act['AID'] ?>" style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px;">รายชื่อผู้สมัคร</a>
            
        <?php else: ?>
            
            <a href="/register_activity?id=<?= $act['AID'] ?>" onclick="return confirm('ยืนยันการสมัครเข้าร่วมกิจกรรมนี้ใช่หรือไม่?');" style="padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">สมัครเข้าร่วมกิจกรรม</a>
            
        <?php endif; ?>

    <?php else: // ถ้ายังไม่ได้ล็อกอิน ?>
        <p style="color: red; margin-left: 10px;">*กรุณา <a href="/login">เข้าสู่ระบบ</a> เพื่อสมัครหรือจัดการกิจกรรม</p>
    <?php endif; ?>
    
</div>
</main>

<?php include __DIR__ . '/footer.php'; ?>