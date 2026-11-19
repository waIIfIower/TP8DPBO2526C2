<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Department.php';

/**
 * Class DepartmentController
 *
 * Mengatur alur permintaan (request) dan tanggapan (response) untuk
 * manajemen CRUD tabel baru `departments` (Program Studi / Departemen).
 */
class DepartmentController extends BaseController
{
    /** @var Department Model data departemen */
    private Department $departmentModel;

    /**
     * Konstruktor DepartmentController.
     *
     * @param PDO $db Instance koneksi database PDO.
     */
    public function __construct(PDO $db)
    {
        $this->departmentModel = new Department($db);
    }

    /**
     * Menampilkan halaman daftar seluruh departemen.
     *
     * @return void
     */
    public function index(): void
    {
        $departments = $this->departmentModel->getAll();

        $this->render('departments/index', [
            'pageTitle'   => 'Departments Management',
            'activeMenu'  => 'departments',
            'departments' => $departments,
        ]);
    }

    /**
     * Menampilkan formulir tambah departemen baru.
     *
     * @return void
     */
    public function create(): void
    {
        $this->render('departments/create', [
            'pageTitle'  => 'Create Department',
            'activeMenu' => 'departments',
        ]);
    }

    /**
     * Memproses penyimpanan data departemen baru.
     *
     * @return void
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('departments', 'index');
        }

        $data = [
            'department_code' => strtoupper($this->sanitize($_POST['department_code'] ?? '')),
            'department_name' => $this->sanitize($_POST['department_name'] ?? ''),
            'faculty'         => $this->sanitize($_POST['faculty'] ?? ''),
            'office_location' => $this->sanitize($_POST['office_location'] ?? ''),
        ];

        if ($data['department_code'] === '' || $data['department_name'] === '' || $data['faculty'] === '' || $data['office_location'] === '') {
            $this->setFlash('danger', 'Semua kolom departemen wajib diisi.');
            $this->redirect('departments', 'create');
        }

        try {
            $this->departmentModel->create($data);
            $this->setFlash('success', 'Data departemen berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal menambahkan departemen. Kode departemen sudah digunakan.');
        }

        $this->redirect('departments', 'index');
    }

    /**
     * Menampilkan formulir ubah departemen berdasarkan ID.
     *
     * @return void
     */
    public function edit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $department = $this->departmentModel->getById($id);

        if (!$department) {
            $this->setFlash('warning', 'Data departemen tidak ditemukan.');
            $this->redirect('departments', 'index');
        }

        $this->render('departments/edit', [
            'pageTitle'  => 'Update Department',
            'activeMenu' => 'departments',
            'department' => $department,
        ]);
    }

    /**
     * Memproses pembaruan data departemen.
     *
     * @return void
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('departments', 'index');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $data = [
            'department_code' => strtoupper($this->sanitize($_POST['department_code'] ?? '')),
            'department_name' => $this->sanitize($_POST['department_name'] ?? ''),
            'faculty'         => $this->sanitize($_POST['faculty'] ?? ''),
            'office_location' => $this->sanitize($_POST['office_location'] ?? ''),
        ];

        if ($id <= 0 || $data['department_code'] === '' || $data['department_name'] === '') {
            $this->setFlash('danger', 'Data departemen tidak valid.');
            $this->redirect('departments', 'index');
        }

        try {
            $this->departmentModel->update($id, $data);
            $this->setFlash('success', 'Data departemen berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal memperbarui departemen. Periksa duplikasi kode departemen.');
        }

        $this->redirect('departments', 'index');
    }

    /**
     * Menghapus data departemen berdasarkan ID.
     *
     * @return void
     */
    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id > 0) {
            try {
                $this->departmentModel->delete($id);
                $this->setFlash('success', 'Data departemen berhasil dihapus.');
            } catch (PDOException $e) {
                $this->setFlash('danger', 'Gagal menghapus data departemen.');
            }
        }

        $this->redirect('departments', 'index');
    }
}
