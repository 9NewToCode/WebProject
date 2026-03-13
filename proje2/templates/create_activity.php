<?php include __DIR__ . '/header.php'; ?>


<main class="flex justify-center mt-10">
    
    <div class="w-full max-w-lg">
        <a href="/"
class="fixed top-4 left-4 inline-block px-4 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition shadow">
    🏠 กลับหน้าหลัก
</a>

        <h2 class="text-2xl font-bold text-center mb-6">สร้างกิจกรรมใหม่</h2>

        <form action="/create_activity" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-lg rounded-xl p-8 space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">ชื่อกิจกรรม</label>
                <input type="text" name="title" required
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">รายละเอียด</label>
                <textarea name="description" rows="5" required
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">จำนวนที่รับสมัคร (คน)</label>
                <input type="number" name="participant_limit" min="1" required
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">วันที่เริ่มกิจกรรม</label>
                <input type="date" name="start_date" required
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">วันที่สิ้นสุดกิจกรรม</label>
                <input type="date" name="end_date" required
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    อัปโหลดรูปภาพกิจกรรม (เลือกได้หลายรูป)
                </label>
                <input type="file" name="images[]" accept="image/*" multiple required
                class="mt-1 w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 
                file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            </div>

            <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                บันทึกกิจกรรม
            </button>

        </form>

    </div>
    
</main>

<?php include __DIR__ . '/footer.php'; ?>