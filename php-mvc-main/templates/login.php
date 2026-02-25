<html>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <h2>เข้าสู่ระบบ</h2>
        <form action="login" method="post">
            <label for="email">อีเมลผู้ใช้</label><br>
            <input type="email" name="email" id="email" required/><br><br>

            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="password" id="password" required/><br>

            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>
</body>

</html>