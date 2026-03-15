<?php 
include __DIR__ . '/header.php'; 
$act = $data['activity']; 
$activity_id = $_GET['id'] ?? $act['AID'] ?? 0;
?>

<main class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">✏️ แก้ไขกิจกรรม</h2>
        
        <form action="/edit_activity?id=<?= $activity_id ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?= $activity_id ?>">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อกิจกรรม <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($act['Title'] ?? '') ?>" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">รายละเอียด <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm text-gray-800"><?= htmlspecialchars($act['Description'] ?? '') ?></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">จำนวนรับสมัคร (คน)</label>
                    <input type="number" name="participant_limit" min="1" value="<?= (int)($act['Max_Participants'] ?? 0) ?>" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">วันที่เริ่ม</label>
                    <input type="date" name="start_date" value="<?= date('Y-m-d', strtotime($act['StartDate'] ?? 'now')) ?>" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">วันที่สิ้นสุด</label>
                    <input type="date" name="end_date" value="<?= date('Y-m-d', strtotime($act['EndDate'] ?? 'now')) ?>" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>
            
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🖼️ รูปภาพปัจจุบัน</h3>
                <?php if (!empty($data['images'])): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                        <?php foreach ($data['images'] as $img): ?>
                            <div class="bg-white border border-gray-200 rounded-lg p-2 text-center shadow-sm">
                                <img src="<?= htmlspecialchars($img) ?>" class="w-full h-24 object-cover rounded-md mb-2">
                                <label class="flex items-center justify-center gap-1 text-xs cursor-pointer text-red-600 font-medium">
                                    <input type="checkbox" name="delete_images[]" value="<?= htmlspecialchars($img) ?>" class="accent-red-600">
                                    <span>ลบรูปนี้</span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-pink-50 text-pink-700 p-4 rounded-lg text-sm border border-pink-100 text-center">ยังไม่มีรูปภาพในกิจกรรมนี้</div>
                <?php endif; ?>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">📸 อัปโหลดรูปภาพใหม่เพิ่ม</h3>
                <input type="file" name="images[]" accept="image/*" multiple 
                       class="w-full bg-white border border-gray-200 rounded-lg p-2 text-sm text-gray-500 cursor-pointer">
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="/activity_detail?id=<?= $activity_id ?>" 
                   class="px-6 py-3 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    ยกเลิก
                </a>
                <button type="submit" 
                        class="px-10 py-3 text-sm font-bold text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-lg transition-all">
                    บันทึกการแก้ไข
                </button>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>