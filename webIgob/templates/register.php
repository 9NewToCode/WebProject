<?php include __DIR__ . '/header.php'; ?>

<main class="flex justify-center mt-10">
    <div class="w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">สมัครสมาชิก</h2>

        <form method="POST" action="register" class="bg-white shadow-lg rounded-xl p-8 space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">ชื่อ</label>
                <input type="text" name="name" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">เพศ</label>
                <select name="gender" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="male">ชาย</option>
                    <option value="female">หญิง</option>
                    <option value="other">อื่นๆ</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">วันเกิด</label>
                <input type="date" name="birthdate" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">อาชีพ</label>
                <input type="text" name="occupation" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">จังหวัด</label>
                <input type="text" name="province" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
                <input type="password" name="password" required
                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                สมัครสมาชิก
            </button>

        </form>

    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>