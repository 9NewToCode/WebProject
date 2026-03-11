<html>

<head></head>

<body>
    <?php include 'header.php' ?>
    <!-- ส่วนแสดงผลหลักของหน้า -->
    <section>
        <h2>ติดต่อเรา</h2>
        <form method="POST">
            <label>ชื่อ</label><br>
            <input type="text" name="name" /><br>
            <label>อีเมล</label><br>
            <input type="email" name="email" /><br>
            <label>ข้อความ</label><br>
            <textarea rows="4" name="message"></textarea><br>
            <button type="submit">ส่งข้อความ</button>
        </form>
    </section>
    <!-- ส่วนแสดงผลหลักของหน้า -->
    <?php include 'footer.php' ?>

</body>

</html>