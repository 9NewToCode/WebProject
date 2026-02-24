<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px;">
    <h2>รายการกิจกรรมทั้งหมด</h2>
    <a href="/create_activity" style="display: inline-block; margin-bottom: 20px; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">+ สร้างกิจกรรมใหม่</a>
    <hr>

    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">

        <?php if (!empty($data['activities'])): ?>
            <?php foreach ($data['activities'] as $activity): ?>
                <div style="border: 1px solid #ddd; border-radius: 8px; width: 300px; overflow: hidden; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);">

                    <?php if (!empty($activity['cover_image'])): ?>
                        <img src="<?= htmlspecialchars($activity['cover_image']) ?>" alt="ภาพปกกิจกรรม" style="width: 100%; height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 100%; height: 180px; background: #eee; display: flex; align-items: center; justify-content: center; color: #888;">ไม่มีรูปภาพ</div>
                    <?php endif; ?>

                    <div style="padding: 15px;">
                        <h3 style="margin-top: 0;"><?= htmlspecialchars($activity['Title']) ?></h3>

                        <p style="color: #555; font-size: 14px; height: 40px; overflow: hidden;">
                            <?= htmlspecialchars($activity['Description']) ?>
                        </p>

                        <p style="margin: 5px 0;"><strong> วันที่จัด:</strong> <?= htmlspecialchars($activity['StartDate']) ?></p>

                        <p style="margin: 5px 0;"><strong> รับสมัคร:</strong> <?= htmlspecialchars($activity['Max_Participants']) ?> คน</p>

                        <a href="/activity_detail?id=<?= $activity['AID'] ?>" style="display: block; text-align: center; margin-top: 15px; padding: 8px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">ดูรายละเอียด</a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ยังไม่มีกิจกรรมในระบบตอนนี้ ลองสร้างกิจกรรมแรกดูสิ!</p>
        <?php endif; ?>

    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>