<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lecturer.php';

/**
 * Class CourseController
 *
 * Mengatur alur permintaan (request) dan tanggapan (response) untuk
 * manajemen CRUD tabel baru `courses` (Mata Kuliah).
 */
class CourseController extends BaseController
{
    /** @var Course Model data mata kuliah */
    private Course $courseModel;

    /** @var Lecturer Model data dosen untuk dropdown dosen pengampu */
    private Lecturer $lecturerModel;

    /**
     * Konstruktor CourseController.
     *
     * @param PDO $db Instance koneksi database PDO.
     */
    public function __construct(PDO $db)
    {
        $this->courseModel   = new Course($db);
        $this->lecturerModel = new Lecturer($db);
    }

    /**
     * Menampilkan daftar seluruh mata kuliah.
     *
     * @return void
     */
    public function index(): void
    {
        $courses = $this->courseModel->getAll();

        $this->render('courses/index', [
            'pageTitle'  => 'Courses Management',
            'activeMenu' => 'courses',
            'courses'    => $courses,
        ]);
    }

    /**
     * Menampilkan formulir tambah mata kuliah baru.
     *
     * @return void
     */
    public function create(): void
    {
        $lecturers = $this->lecturerModel->getAll();

        $this->render('courses/create', [
            'pageTitle'  => 'Create Course',
            'activeMenu' => 'courses',
            'lecturers'  => $lecturers,
        ]);
    }

    /**
     * Memproses penyimpanan data mata kuliah baru.
     *
     * @return void
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('courses', 'index');
        }

        $data = [
            'course_code' => strtoupper($this->sanitize($_POST['course_code'] ?? '')),
            'course_name' => $this->sanitize($_POST['course_name'] ?? ''),
            'credits'     => (int) ($_POST['credits'] ?? 0),
            'semester'    => (int) ($_POST['semester'] ?? 0),
            'lecturer_id' => (int) ($_POST['lecturer_id'] ?? 0),
        ];

        if ($data['course_code'] === '' || $data['course_name'] === '' || $data['credits'] <= 0 || $data['semester'] <= 0 || $data['lecturer_id'] <= 0) {
            $this->setFlash('danger', 'Semua kolom mata kuliah wajib diisi dengan benar, termasuk memilih dosen pengampu.');
            $this->redirect('courses', 'create');
        }

        try {
            $this->courseModel->create($data);
            $this->setFlash('success', 'Data mata kuliah berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal menambahkan mata kuliah. Kode mata kuliah sudah terdaftar atau dosen tidak valid.');
        }

        $this->redirect('courses', 'index');
    }

    /**
     * Menampilkan formulir ubah mata kuliah berdasarkan ID.
     *
     * @return void
     */
    public function edit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $course = $this->courseModel->getById($id);

        if (!$course) {
            $this->setFlash('warning', 'Data mata kuliah tidak ditemukan.');
            $this->redirect('courses', 'index');
        }

        $lecturers = $this->lecturerModel->getAll();

        $this->render('courses/edit', [
            'pageTitle'  => 'Update Course',
            'activeMenu' => 'courses',
            'course'     => $course,
            'lecturers'  => $lecturers,
        ]);
    }

    /**
     * Memproses pembaruan data mata kuliah.
     *
     * @return void
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('courses', 'index');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $data = [
            'course_code' => strtoupper($this->sanitize($_POST['course_code'] ?? '')),
            'course_name' => $this->sanitize($_POST['course_name'] ?? ''),
            'credits'     => (int) ($_POST['credits'] ?? 0),
            'semester'    => (int) ($_POST['semester'] ?? 0),
            'lecturer_id' => (int) ($_POST['lecturer_id'] ?? 0),
        ];

        if ($id <= 0 || $data['course_code'] === '' || $data['course_name'] === '' || $data['lecturer_id'] <= 0) {
            $this->setFlash('danger', 'Data mata kuliah tidak valid.');
            $this->redirect('courses', 'index');
        }

        try {
            $this->courseModel->update($id, $data);
            $this->setFlash('success', 'Data mata kuliah berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->setFlash('danger', 'Gagal memperbarui mata kuliah. Periksa duplikasi kode mata kuliah.');
        }

        $this->redirect('courses', 'index');
    }

    /**
     * Menghapus data mata kuliah berdasarkan ID.
     *
     * @return void
     */
    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id > 0) {
            try {
                $this->courseModel->delete($id);
                $this->setFlash('success', 'Data mata kuliah berhasil dihapus.');
            } catch (PDOException $e) {
                $this->setFlash('danger', 'Gagal menghapus data mata kuliah.');
            }
        }

        $this->redirect('courses', 'index');
    }
}
