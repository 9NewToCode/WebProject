<html>

<head></head>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>เข้าสู่ระบบ</h1>
        <form action="login" method="post">
            <label for="username">อีเมลผู้ใช้</label><br>
            <input type="text" name="email" id="email" required/><br>
            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="password" id="password" required/><br>
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </main>
    <!-- ส่วนแสดงผลหลักของหน้า -->

    <?php include __DIR__ . '/footer.php'; ?>
</body>

</html>