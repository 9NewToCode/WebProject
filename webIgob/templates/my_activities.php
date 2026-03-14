<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px;">
    <h2>📝 กิจกรรมที่ฉันขอเข้าร่วม</h2>
    <a href="/" style="display: inline-block; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            🏠 กลับหน้าหลัก
        </a>
    
    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
        <?php if (!empty($data['activities'])): ?>
            <?php foreach ($data['activities'] as $activity): ?>
                <div style="border: 1px solid #ddd; border-radius: 8px; width: 300px; overflow: hidden; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);">
                    
                    <?php if (!empty($activity['cover_image'])): ?>
                        <img src="/public<?= htmlspecialchars($activity['cover_image']) ?>" alt="ภาพปกกิจกรรม" style="width: 100%; height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 100%; height: 180px; background: #eee; display: flex; align-items: center; justify-content: center; color: #888;">ไม่มีรูปภาพ</div>
                    <?php endif; ?>

                    <div style="padding: 15px;">
                        <h3 style="margin-top: 0;"><?= htmlspecialchars($activity['Title']) ?></h3>
                        <p style="margin: 5px 0;"><strong>📅 วันที่จัด:</strong> <?= date('d/m/Y', strtotime($activity['StartDate'])) ?>
                        <p style="margin: 5px 0;"><strong> วันที่สิ้นสุด:</strong> <?= date('d/m/Y', strtotime($activity['EndDate'])) ?></p>
                        
                        <div style="margin: 15px 0; padding-top: 10px; border-top: 1px solid #eee;">
                            <strong>สถานะของฉัน: </strong>
                            <?php if ($activity['Status'] === 'approved'): ?>
                                <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 14px;">✅ เข้าร่วมแล้ว (อนุมัติ)</span>
                            <?php elseif ($activity['Status'] === 'rejected'): ?>
                                <span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 14px;">❌ ถูกปฏิเสธการเข้าร่วม</span>
                            <?php else: ?>
                                <span style="background: #ffc107; color: black; padding: 4px 8px; border-radius: 4px; font-size: 14px;">⏳ รอการอนุมัติ</span>
                            <?php endif; ?>
                        </div>
                        <a href="/details-of-my_activities?id=<?= $activity['AID'] ?>" style="display: block; text-align: center; margin-top: 15px; padding: 8px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">ดูรายละเอียด</a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="width: 100%; padding: 30px; background: #f8f9fa; color: #666; border-radius: 8px; border: 1px dashed #ccc; text-align: center;">
                <h3 style="margin-top:0;">คุณยังไม่ได้สมัครเข้าร่วมกิจกรรมใดๆ เลย</h3>
                <p>ลองไปที่หน้าหลักเพื่อค้นหากิจกรรมที่น่าสนใจ แล้วกดสมัครดูสิ!</p>
                <a href="/" style="display: inline-block; margin-top: 10px; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">กลับไปหน้าหลัก</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>