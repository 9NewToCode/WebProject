<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px; max-width: 600px; margin: auto;">
    <h2> แก้ไขกิจกรรม</h2>
    <?php $act = $data['activity']; ?>
    
    <form action="/edit_activity" method="POST">
        <input type="hidden" name="id" value="<?= $act['AID'] ?>">
        
        <label>ชื่อกิจกรรม:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($act['Title']) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <label>รายละเอียด:</label><br>
        <textarea name="description" rows="5" required style="width: 100%; padding: 8px;"><?= htmlspecialchars($act['Description']) ?></textarea><br><br>
        
        <label>จำนวนที่รับสมัคร (คน):</label><br>
        <input type="number" name="participant_limit" min="1" value="<?= htmlspecialchars($act['Max_Participants']) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <label>วันที่จัดกิจกรรม:</label><br>
        <input type="date" name="event_date" value="<?= date('Y-m-d', strtotime($act['StartDate'])) ?>" required style="width: 100%; padding: 8px;"><br><br>
        
        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;"> บันทึกการแก้ไข</button>
        <a href="/activity_detail?id=<?= $act['AID'] ?>" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">ยกเลิก</a>
    </form>
</main>

<?php include __DIR__ . '/footer.php'; ?>