<?php include __DIR__ . '/header.php'; ?>

<main>
    <h2>สร้างกิจกรรมใหม่</h2>
    <form action="/create_activity" method="POST" enctype="multipart/form-data">
        
        <label>ชื่อกิจกรรม:</label><br>
        <input type="text" name="title" required><br><br>
        
        <label>รายละเอียด:</label><br>
        <textarea name="description" rows="5" required></textarea><br><br>
        
        <label>จำนวนที่รับสมัคร (คน):</label><br>
        <input type="number" name="participant_limit" min="1" required><br><br>
        
        <label>วันที่จัดกิจกรรม:</label><br>
        <input type="date" name="event_date" required><br><br>
        
        <label>อัปโหลดรูปภาพกิจกรรม (เลือกได้หลายรูป):</label><br>
        <input type="file" name="images[]" accept="image/*" multiple required><br><br>
        
        <button type="submit">บันทึกกิจกรรม</button>
    </form>
</main>

<?php include __DIR__ . '/footer.php'; ?>