<?php
session_destroy(); // ล้างความจำระบบ
header("Location: /"); // กลับหน้าแรก
exit;