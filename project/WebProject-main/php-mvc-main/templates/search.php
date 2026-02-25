<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px;">
    
    <div style="margin-bottom: 15px;">
        <a href="/" style="display: inline-block; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            🏠 กลับหน้าหลัก
        </a>
    </div>

    <h2>🔍 ค้นหากิจกรรม</h2>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #ddd;">
        <form action="/search" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; margin: 0;">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">ชื่อกิจกรรม:</label>
                <input type="text" name="search_name" placeholder="ระบุชื่อกิจกรรมที่ต้องการหา..." value="<?= htmlspecialchars($_GET['search_name'] ?? '') ?>" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">ตั้งแต่วันที่:</label>
                <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">ถึงวันที่:</label>
                <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            
            <div>
                <button type="submit" style="padding: 10px 20px; background: #343a40; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">ค้นหา</button>
                <a href="/search" style="margin-left: 10px; color: #dc3545; text-decoration: none; font-size: 14px;">ล้างค่า</a>
            </div>
            
        </form>
    </div>

    <h3 style="border-bottom: 2px solid #eee; padding-bottom: 10px; color: #333;">ผลลัพธ์การค้นหา</h3>
    
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
                        <p style="margin: 5px 0;"><strong>📅 วันที่จัด:</strong> <?= htmlspecialchars($activity['StartDate']) ?></p>
                        <p style="margin: 5px 0;"><strong>👥 รับสมัคร:</strong> <?= htmlspecialchars($activity['Max_Participants']) ?> คน</p>
                        <a href="/activity_detail?id=<?= $activity['AID'] ?>" style="display: block; text-align: center; margin-top: 15px; padding: 8px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">ดูรายละเอียด</a>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="width: 100%; padding: 20px; background: #f8d7da; color: #721c24; border-radius: 5px; border: 1px solid #f5c6cb;">
                ไม่พบกิจกรรมที่คุณค้นหาครับ
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>