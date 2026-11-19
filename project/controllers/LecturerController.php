<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Lecturer.php';
require_once __DIR__ . '/../models/Department.php';

/**
 * Class LecturerController
 *
 * Mengatur alur permintaan (request) dan tanggapan (response) untuk
 * manajemen data Dosen (lecturers).
 */
class LecturerController extends BaseController
{
    /** @var Lecturer Model data dosen */
    private Lecturer $lecturerModel;

    /** @var Department Model data departemen untuk dropdown relasi */
    private Department $departmentModel;

    /**
     * Konstruktor LecturerController.
     *
     * @param PDO $db Instance koneksi database PDO.
     */
    public function __construct(PDO $db)
    {
        $this->lecturerModel   = new Lecturer($db);
        $this->departmentModel = new Department($db);
    }

    /**
     * Menampilkan halaman daftar seluruh dosen.
     *
     * @return void
     */
    public function index(): void
    {
        $lecturers = $this->lecturerModel->getAll();

        $this->render('lecturers/index', [
            'pageTitle'  => 'Lecturers Management',
            'activeMenu' => 'lecturers',
            'lecturers'  => $lecturers,
        ]);
    }

    /**
     * Menampilkan formulir tambah dosen baru.
     *
     * @return void
     */
    public function create(): void
    {
        $departments = $this->departmentModel->getAll();

        $this->render('lecturers/create', [
            'pageTitle'   => 'Create Lecturer',
            'activeMenu'  => 'lecturers',
            'departments' => $departments,
        ]);
    }

    /**
     * Memproses penyimpanan data dosen baru dari formulir POST.
     *
     * @return void
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('lecturers', 'index');
        }

        $data = [
            'name'          => $this->sanitize($_POST['name'] ?? ''),
            'nidn'          => $this->sanitize($_POST['nidn'] ?? ''),
            'email'         => $this->sanitize($_POST['email'] ?? ''),
            'phone'         => $this->sanitize($_POST['phone'] ?? ''),
            'join_date'     => $this->sanitize($_POST['join_date'] ?? ''),
            'department_id' => !empty($_POST['department_id']) ? (int) $_POST['department_id'] : null,
        ];

        // Validasi kelengkapan atribut wajib
        if ($data['name'] === '' || $data['nidn'] === '' || $data['email'] === '' || $data['phone'] === '' || $data['join_date'] === '') {
            $this->setFlash('danger', 'Semua kolom wajib diisi.');
            $this->redirect('lecturers', 'create');
        }

        try {
            $this->lecturerModel->create($data);
            $this->setFlash('success', 'Data dosen berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal menambahkan data dosen. Pastikan NIDN dan Email belum terdaftar.');
        }

        $this->redirect('lecturers', 'index');
    }

    /**
     * Menampilkan formulir pengubahan data dosen berdasarkan ID.
     *
     * @return void
     */
    public function edit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $lecturer = $this->lecturerModel->getById($id);

        if (!$lecturer) {
            $this->setFlash('warning', 'Data dosen tidak ditemukan.');
            $this->redirect('lecturers', 'index');
        }

        $departments = $this->departmentModel->getAll();

        $this->render('lecturers/edit', [
            'pageTitle'   => 'Update Lecturer',
            'activeMenu'  => 'lecturers',
            'lecturer'    => $lecturer,
            'departments' => $departments,
        ]);
    }

    /**
     * Memproses pembaruan data dosen dari formulir POST.
     *
     * @return void
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('lecturers', 'index');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $data = [
            'name'          => $this->sanitize($_POST['name'] ?? ''),
            'nidn'          => $this->sanitize($_POST['nidn'] ?? ''),
            'email'         => $this->sanitize($_POST['email'] ?? ''),
            'phone'         => $this->sanitize($_POST['phone'] ?? ''),
            'join_date'     => $this->sanitize($_POST['join_date'] ?? ''),
            'department_id' => !empty($_POST['department_id']) ? (int) $_POST['department_id'] : null,
        ];

        if ($id <= 0 || $data['name'] === '' || $data['nidn'] === '' || $data['email'] === '') {
            $this->setFlash('danger', 'Data dosen tidak valid.');
            $this->redirect('lecturers', 'index');
        }

        try {
            $this->lecturerModel->update($id, $data);
            $this->setFlash('success', 'Data dosen berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal memperbarui data dosen. Periksa duplikasi NIDN atau Email.');
        }

        $this->redirect('lecturers', 'index');
    }

    /**
     * Menghapus data dosen berdasarkan ID yang dikirim melalui parameter GET.
     *
     * @return void
     */
    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id > 0) {
            try {
                $this->lecturerModel->delete($id);
                $this->setFlash('success', 'Data dosen berhasil dihapus.');
            } catch (PDOException $e) {
                $this->setFlash('danger', 'Gagal menghapus data dosen karena masih terikat relasi.');
            }
        }

        $this->redirect('lecturers', 'index');
    }
}
