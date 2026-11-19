<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseModel.php';

/**
 * Class Lecturer
 *
 * Merepresentasikan entitas `lecturers` (Dosen) yang memiliki relasi
 * Many-to-One ke tabel `departments` dan One-to-Many ke tabel `courses`.
 */
class Lecturer extends BaseModel
{
    /** @var string Nama tabel dosen */
    protected string $table = 'lecturers';

    /**
     * Mengambil seluruh data dosen beserta informasi departemennya (LEFT JOIN).
     *
     * @return array Daftar seluruh dosen.
     */
    public function getAll(): array
    {
        $sql = "SELECT l.*,
                       d.department_code,
                       d.department_name
                FROM {$this->table} l
                LEFT JOIN departments d ON l.department_id = d.id
                ORDER BY l.id ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mengambil satu data dosen berdasarkan ID.
     *
     * @param int $id Primary key dosen.
     * @return array|null Data dosen jika ditemukan, atau null jika tidak ada.
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
     * Menambahkan record dosen baru ke database.
     *
     * @param array $data Array asosiatif berisi name, nidn, email, phone, join_date, department_id.
     * @return bool True jika berhasil disimpan.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (name, nidn, email, phone, join_date, department_id)
                VALUES (:name, :nidn, :email, :phone, :join_date, :department_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name'          => $data['name'],
            ':nidn'          => $data['nidn'],
            ':email'         => $data['email'],
            ':phone'         => $data['phone'],
            ':join_date'     => $data['join_date'],
            ':department_id' => $data['department_id'] ?: null,
        ]);
    }

    /**
     * Memperbarui data dosen berdasarkan ID.
     *
     * @param int   $id   Primary key dosen.
     * @param array $data Data baru dosen.
     * @return bool True jika berhasil diperbarui.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET name = :name,
                    nidn = :nidn,
                    email = :email,
                    phone = :phone,
                    join_date = :join_date,
                    department_id = :department_id
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name'          => $data['name'],
            ':nidn'          => $data['nidn'],
            ':email'         => $data['email'],
            ':phone'         => $data['phone'],
            ':join_date'     => $data['join_date'],
            ':department_id' => $data['department_id'] ?: null,
            ':id'            => $id,
        ]);
    }

    /**
     * Menghapus data dosen berdasarkan ID.
     *
     * @param int $id Primary key dosen.
     * @return bool True jika berhasil dihapus.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
