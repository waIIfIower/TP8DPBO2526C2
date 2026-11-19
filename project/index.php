<?php

declare(strict_types=1);

/**
 * Front Controller / Entry Point Utama Aplikasi
 *
 * Seluruh permintaan HTTP masuk melalui file ini menggunakan parameter query:
 * - `page`   : Menentukan entitas/controller tujuan (`lecturers`, `departments`, `courses`).
 * - `action` : Menentukan metode aksi pada controller (`index`, `create`, `store`, `edit`, `update`, `delete`).
 */

session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/LecturerController.php';
require_once __DIR__ . '/controllers/DepartmentController.php';
require_once __DIR__ . '/controllers/CourseController.php';

// Inisialisasi koneksi database PDO
$database = new Database();
$db       = $database->getConnection();

// Membaca parameter rute dengan nilai default ke daftar dosen
$page   = $_GET['page'] ?? 'lecturers';
$action = $_GET['action'] ?? 'index';

// Pemetaan parameter `page` ke Controller yang sesuai
switch ($page) {
    case 'departments':
        $controller = new DepartmentController($db);
        break;

    case 'courses':
        $controller = new CourseController($db);
        break;

    case 'lecturers':
    default:
        $controller = new LecturerController($db);
        break;
}

// Daftar aksi CRUD yang diizinkan untuk dipanggil secara dinamis
$allowedActions = ['index', 'create', 'store', 'edit', 'update', 'delete'];

if (in_array($action, $allowedActions, true) && method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
