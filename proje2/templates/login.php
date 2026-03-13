<html>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <?php include __DIR__ . '/header.php'; ?>

    <main class="flex flex-1 items-center justify-center">
        <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
            
            <h2 class="text-2xl font-bold text-center mb-6">เข้าสู่ระบบ</h2>

            <form action="login" method="post" class="space-y-4">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        อีเมลผู้ใช้
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        required
                        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        รหัสผ่าน
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
                >
                    เข้าสู่ระบบ
                </button>

            </form>
        </div>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>

</body>


</html>