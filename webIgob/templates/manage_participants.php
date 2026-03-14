<?php include __DIR__ . '/header.php'; ?>

<main style="padding: 20px;">
    <h2> จัดการผู้สมัคร: <?= htmlspecialchars($data['activity']['Title']) ?></h2>
    <a href="/activity_detail?id=<?= $data['aid'] ?>" style="text-decoration: none; color: #007bff;"> กลับไปหน้ารายละเอียด</a>

    <form action="/manage_participants?id=<?= $data['aid'] ?>" method="post">
        <div style="width: 30%; background: gray; margin-left: auto; margin-top: 10px; padding: 10px 0px; border-radius: 4px; border-color: black; border-width: 2px; display: flex; flex-direction: column;">
            <span style="font-size: large; padding: 4px 8px;">*กรอก UID ที่ต้องการเช็ค*</span>
            <input style="width: 50%; font-size: large; margin: 4px 8px;" type="number" name="target_uid">
            <div style="font-size: large; padding: 4px 8px;">*กรอก OTP ที่ต้องการเช็ค*</div>
            <div style="width: 50%;">
                <input style="width: 100%; font-size: large; margin: 4px 8px;" id="otp" name="otp" type="text">
                <button style="width: 100%; font-size: large; margin: 4px 8px; background: white;">Check</button>
            </div>
        </div>
    </form>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse; text-align: left; border-color: black; border-width: 1px;" border="1">
        <thead style="background: #f4f4f4;">
            <tr>
                <th style="padding: 10px;">ชื่อผู้ใช้</th>
                <th style="padding: 10px;">อีเมล</th>
                <th style="padding: 10px;">สถานะการเข้าร่วมงาน</th>
                <th style="padding: 10px;">เช็คชื่อ</th>
                <th style="padding: 10px;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = $data['participants']->fetch_assoc()): ?>
                <tr>
                    <td style="padding: 10px;">
                        <a href="/user_profile?uid=<?= $p['UID'] ?>&aid=<?= $data['aid'] ?>" style="text-decoration: none; color: #007bff; font-weight: bold;">
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
                        <span style="padding: 4px 8px; border-radius: 4px; background: <?= isset($p['Check_In_Status']) && $p['Check_In_Status'] == 'Checked' ? '#d4edda' : '#fff3cd' ?>;">
                            <input type="checkbox" <?= isset($p['Check_In_Status']) && $p['Check_In_Status'] == 'Checked' ? 'checked' : '' ?> disabled>
                            <?= $p['Check_In_Status'] ?? 'Unchecked' ?>
                        </span>
                    </td>
                    <td style="padding: 10px;">
                        <a href="/update_status?aid=<?= $data['aid'] ?>&uid=<?= $p['UID'] ?>&status=approved" style="color: green; text-decoration: none; font-weight: bold;">อนุมัติ</a> |
                        <a href="/update_status?aid=<?= $data['aid'] ?>&uid=<?= $p['UID'] ?>&status=rejected" style="color: red; text-decoration: none; font-weight: bold;">ปฏิเสธ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php include __DIR__ . '/footer.php'; ?>