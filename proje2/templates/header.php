<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เว็บสร้างกิจกรรม</title>
</head>

<body style="margin: 20px;">
    <header style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 20px;">
        <h1 style="margin: 0;">เว็บดำๆ</h1>

        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="margin-right: 15px; color: #555;">
                    👤 สวัสดี, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'ผู้ใช้งาน') ?></strong>
                </span>
                <a href="/logout">ออกจากระบบ</a>
                <a href="/my_activities" style="margin-right: 15px; font-weight: bold; color: #28a745; text-decoration: none;">📝 กิจกรรมของฉัน</a>
            <?php else: ?>
                <a href="/login">เข้าสู่ระบบ</a> |
                <a href="/register">สมัครสมาชิก</a>
            <?php endif; ?>
        </div>
    </header>