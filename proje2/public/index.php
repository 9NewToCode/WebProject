<?php

declare(strict_types=1);
session_start();

// กำหนดค่าคงที่สำหรับไดเรกทอรีต่างๆ ในโปรเจค
const INCLUDES_DIR = __DIR__ . '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASES_DIR = __DIR__ . '/../databases';

// รวมไฟล์ที่จำเป็น เข้ามาใช้งานใน index.php
require_once INCLUDES_DIR . '/router.php';
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/database.php';

//ล้าง URL ก่อนที่จะส่งไปให้ระบบค้นหาหน้าเว็บ
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
dispatch($uri, $_SERVER['REQUEST_METHOD']);