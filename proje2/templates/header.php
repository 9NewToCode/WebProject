<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เว็บสร้างกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

            <h1 class="text-xl font-bold text-gray-800">
                เว็บดำๆ
            </h1>

            <div class="flex items-center gap-4 text-sm">

                <?php if (isset($_SESSION['user_id'])): ?>

                    <span class="text-gray-600">
                        👤 สวัสดี,
                        <strong class="text-gray-800">
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'ผู้ใช้งาน') ?>
                        </strong>
                    </span>

                    <a href="/my_activities"
                        class="text-green-600 font-semibold hover:text-green-700">
                        📝 กิจกรรมของฉัน
                    </a>

                    <a href="/logout"
                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                        ออกจากระบบ
                    </a>

                <?php else: ?>

                    <a href="/login"
                        class="text-blue-600 hover:text-blue-800 font-medium">
                        เข้าสู่ระบบ
                    </a>

                    <a href="/register"
                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                        สมัครสมาชิก
                    </a>
                <?php endif; ?>
            </div>
    </header>