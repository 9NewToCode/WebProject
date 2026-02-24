<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px;">
    <h2> จัดการผู้สมัคร: <?= htmlspecialchars($data['activity']['Title']) ?></h2>
    <a href="/activity_detail?id=<?= $data['aid'] ?>" style="text-decoration: none; color: #007bff;"> กลับไปหน้ารายละเอียด</a>

    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse; text-align: left;">
        <thead style="background: #f4f4f4;">
            tr>
            <th style="padding: 10px;">ชื่อผู้ใช้</th>
            <th style="padding: 10px;">อีเมล</th>
            <th style="padding: 10px;">สถานะ</th>
            <th style="padding: 10px;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = $data['participants']->fetch_assoc()): ?>
                <tr>
                    <td style="padding: 10px;">
                        <<a href="/user_profile?uid=<?= $p['UID'] ?>&aid=<?= $data['aid'] ?>" style="text-decoration: none; color: #007bff; font-weight: bold;">
                            <?= htmlspecialchars($p['Name']) ?> 
                        </a>
                    </td>
                    <td style="padding: 10px;"><?= htmlspecialchars($p['Email']) ?></td>
                    <td style="padding: 10px;">
                        <span style="padding: 4px 8px; border-radius: 4px; background: <?= $p['Status'] == 'approved' ? '#d4edda' : ($p['Status'] == 'rejected' ? '#f8d7da' : '#fff3cd') ?>;">
                            <?= $p['Status'] ?>
                        </span>
                    </td>
                    <td style="padding: 10px;">
                        <a href="/update_status?aid=<?= $data['aid'] ?>&uid=<?= $p['UID'] ?>&status=approved" style="color: green; text-decoration: none; font-weight: bold;">อนุมัติ</a> |
                        <a href="/update_status?aid=<?= $data['aid'] ?>&uid=<?= $p['UID'] ?>&status=rejected" style="color: red; text-decoration: none; font-weight: bold;">ปฏิเสธ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

</main>
<?php include __DIR__ . '/footer.php'; ?>