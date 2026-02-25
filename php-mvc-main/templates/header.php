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
                <a href="/logout">ออกจากระบบ</a>
            <?php else: ?>
                <a href="/login">เข้าสู่ระบบ</a> | 
                <a href="/register">สมัครสมาชิก</a>
            <?php endif; ?>
        </div>  
    </header>