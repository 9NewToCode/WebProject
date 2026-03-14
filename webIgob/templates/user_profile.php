<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px; max-width: 500px; margin: auto; background: #f9f9f9; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333;">👤 ข้อมูลผู้สมัคร</h2>
    <hr>
    
    <?php $u = $data['user']; ?>
    <div style="line-height: 2; font-size: 16px;">
        <p><strong>ชื่อ-นามสกุล:</strong> <?= htmlspecialchars($u['Name']) ?></p>
        <p><strong>เพศ:</strong> <?= htmlspecialchars($u['Gender']) ?></p>
        <p><strong>วันเกิด:</strong> <?= htmlspecialchars($u['BirthDate']) ?></p>
        <p><strong>อาชีพ:</strong> <?= htmlspecialchars($u['Occupation']) ?></p>
        <p><strong>จังหวัด:</strong> <?= htmlspecialchars($u['Province']) ?></p>
        <p><strong>อีเมล:</strong> <?= htmlspecialchars($u['Email']) ?></p>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="/manage_participants?id=<?= $data['aid'] ?>" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">⬅️ กลับไปหน้าจัดการ</a>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>