<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseModel.php';

/**
 * Class Course
 *
 * Merepresentasikan entitas `courses` (Mata Kuliah) yang berelasi
 * Many-to-One ke tabel `lecturers` sebagai dosen pengampu.
 */
class Course extends BaseModel
{
    /** @var string Nama tabel mata kuliah */
    protected string $table = 'courses';

    /**
     * Mengambil seluruh data mata kuliah beserta nama dosen pengampu dan departemennya.
     *
     * @return array Daftar seluruh mata kuliah.
     */
    public function getAll(): array
    {
        $sql = "SELECT c.*,
                       l.name AS lecturer_name,
                       l.nidn AS lecturer_nidn,
                       d.department_name
                FROM {$this->table} c
                INNER JOIN lecturers l ON c.lecturer_id = l.id
                LEFT JOIN departments d ON l.department_id = d.id
                ORDER BY c.semester ASC, c.course_code ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mengambil satu data mata kuliah berdasarkan ID.
     *
     * @param int $id Primary key mata kuliah.
     * @return array|null Data mata kuliah jika ditemukan, atau null jika tidak ada.
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Menyimpan data mata kuliah baru ke database.
     *
     * @param array $data Array asosiatif berisi course_code, course_name, credits, semester, lecturer_id.
     * @return bool True jika berhasil disimpan.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (course_code, course_name, credits, semester, lecturer_id)
                VALUES (:course_code, :course_name, :credits, :semester, :lecturer_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':course_code' => $data['course_code'],
            ':course_name' => $data['course_name'],
            ':credits'     => (int) $data['credits'],
            ':semester'    => (int) $data['semester'],
            ':lecturer_id' => (int) $data['lecturer_id'],
        ]);
    }

    /**
     * Memperbarui data mata kuliah berdasarkan ID.
     *
     * @param int   $id   Primary key mata kuliah.
     * @param array $data Data baru mata kuliah.
     * @return bool True jika berhasil diperbarui.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET course_code = :course_code,
                    course_name = :course_name,
                    credits = :credits,
                    semester = :semester,
                    lecturer_id = :lecturer_id
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':course_code' => $data['course_code'],
            ':course_name' => $data['course_name'],
            ':credits'     => (int) $data['credits'],
            ':semester'    => (int) $data['semester'],
            ':lecturer_id' => (int) $data['lecturer_id'],
            ':id'          => $id,
        ]);
    }

    /**
     * Menghapus data mata kuliah berdasarkan ID.
     *
     * @param int $id Primary key mata kuliah.
     * @return bool True jika berhasil dihapus.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
