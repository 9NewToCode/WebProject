<?php include __DIR__ . '/header.php'; ?>
<main style="padding: 20px; max-width: 1000px; margin: auto;">
    <h2> สถิติผู้เข้าร่วม: <?= htmlspecialchars($data['activity']['Title'] ?? '') ?></h2>
    <a href="/activity_detail?id=<?= $data['aid'] ?>" style="text-decoration: none; color: #007bff;">  กลับไปหน้ารายละเอียด</a>

    <div style="display: flex; gap: 20px; margin-top: 20px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-top: 5px solid #007bff;">
            <h3 style="margin-top: 0; color: #555;"> จำนวนผู้เข้าร่วม</h3>
            <p style="font-size: 28px; margin: 10px 0;">
                <strong style="color: #28a745;"><?= $data['stats_count']['approved'] ?? 0 ?></strong> 
                <span style="font-size: 16px; color: #666;">/ <?= htmlspecialchars($data['activity']['Max_Participants'] ?? 0) ?> คน</span>
            </p>
            <p style="font-size: 14px; color: #888; margin: 0;">รออนุมัติ: <?= $data['stats_count']['pending'] ?? 0 ?> คน</p>
        </div>

        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-top: 5px solid #28a745;">
            <h3 style="margin-top: 0; color: #555;"> เพศ (ที่อนุมัติ)</h3>
            <p style="margin: 5px 0;">ชาย: <strong style="color: #007bff;"><?= $data['stats_gender']['male'] ?? 0 ?></strong> คน</p>
            <p style="margin: 5px 0;">หญิง: <strong style="color: #e83e8c;"><?= $data['stats_gender']['female'] ?? 0 ?></strong> คน</p>
            <p style="margin: 5px 0;">อื่นๆ: <strong><?= $data['stats_gender']['other'] ?? 0 ?></strong> คน</p>
        </div>

        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-top: 5px solid #ffc107;">
            <h3 style="margin-top: 0; color: #555;">🎂 อายุ (ที่อนุมัติ)</h3>
            <?php if(!empty($data['stats_age'])): ?>
                <?php foreach($data['stats_age'] as $age_group => $count): ?>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #eee; padding: 4px 0;">
                        <span><?= $age_group ?></span>
                        <strong><?= $count ?> คน</strong>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999; font-style: italic;">ยังไม่มีข้อมูล</p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>