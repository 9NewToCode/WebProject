<?php include __DIR__ . '/header.php'; ?>
<main style="padding: 20px; max-width: 800px; margin: auto;">
    <?php $act = $data['activity']; ?>
    <h1 style="color: #333;"><?= htmlspecialchars($act['Title']) ?></h1>
    <p style="margin: 5px 0;"><strong> วันที่จัด:</strong> <?= date('d/m/Y', strtotime($act['StartDate'])) ?></p>
    <p style="margin: 5px 0;"><strong> วันที่สิ้นสุด:</strong> <?= date('d/m/Y', strtotime($act['EndDate'])) ?></p>
    <p style="color: #666;"><strong> จำนวนที่รับสมัคร:</strong> <?= htmlspecialchars($act['Max_Participants']) ?> คน</p>

    <hr>
    <h3>รายละเอียดกิจกรรม:</h3>
    <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($act['Description'])) ?></p>

    <h3>อัลบั้มรูปภาพ:</h3>
    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <?php if (!empty($data['images'])): ?>
            <?php foreach ($data['images'] as $img): ?>
                <img src="<?= htmlspecialchars($img) ?>" alt="รูปภาพกิจกรรม" style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px; box-shadow: 1px 1px 5px rgba(0,0,0,0.2);">
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีรูปภาพสำหรับกิจกรรมนี้</p>
        <?php endif; ?>
    </div>

    <div style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">

        <?php if (!empty($data['user_status'])): // ✨ ถ้าเคยสมัครแล้ว ให้โชว์ Badge สถานะ ✨ ?>
                <div style="margin-left: 10px; font-size: 16px;">
                    <strong>สถานะของฉัน: </strong>
                    <?php if ($data['user_status'] === 'approved'): ?>
                        <span style="background: #28a745; color: white; padding: 6px 10px; border-radius: 4px; font-size: 14px;">✅ เข้าร่วมแล้ว (อนุมัติ)</span>
                    <?php elseif ($data['user_status'] === 'rejected'): ?>
                        <span style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 4px; font-size: 14px;">❌ ถูกปฏิเสธการเข้าร่วม</span>
                    <?php else: ?>
                        <span style="background: #ffc107; color: black; padding: 6px 10px; border-radius: 4px; font-size: 14px;">⏳ รอการอนุมัติ</span>
                    <?php endif; ?>
                </div>
        <?php endif; ?>

        <a href="/my_activities" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;"> กลับ</a>
    </div>
    <?php
        if ($data['user_status'] === 'approved' && isset($_SESSION['user_id']) && $data['user_chk_in']){
            ?>
            <div class="bg-gray-400 p-4">
                <span class="font-bold text-xl">
                    OTP
                </span>
                <div class="bg-white">
                    <span class="font-bold text-xl">
                    <?php echo $data['otp']; ?>
                    </span>
                </div>
                <span class="text-xl">รหัสหมดอายุทุกๆ 5 นาที</span>
            </div>
        <?php
        } elseif (!$data['user_chk_in']) { ?>
            <div style="margin-left: 10px; font-size: 16px;">
                <span style="background: #28a745; color: white; padding: 6px 10px; border-radius: 4px; font-size: 14px;">✅ สามารถเข้าร่วมได้</span>
            </div>
        <?php
        } else { ?>
        <div style="margin-left: 10px; font-size: 16px;">
            <span style="background: #ffc107; color: black; padding: 6px 10px; border-radius: 4px; font-size: 14px;">⏳ รอการอนุมัติเพื่อรับ OTP</span>
        </div>
        <?php
        }
    ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>