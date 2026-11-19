<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseModel.php';

/**
 * Class Department
 *
 * Merepresentasikan entitas `departments` (Program Studi / Departemen)
 * serta menangani seluruh operasi CRUD ke basis data.
 */
class Department extends BaseModel
{
    /** @var string Nama tabel departemen */
    protected string $table = 'departments';

    /**
     * Mengambil seluruh data departemen beserta jumlah dosen yang tergabung.
     *
     * @return array Daftar seluruh departemen.
     */
    public function getAll(): array
    {
        $sql = "SELECT d.*, COUNT(l.id) AS total_lecturers
                FROM {$this->table} d
                LEFT JOIN lecturers l ON d.id = l.department_id
                GROUP BY d.id
                ORDER BY d.id ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Mengambil satu data departemen berdasarkan ID.
     *
     * @param int $id Primary key departemen.
     * @return array|null Data departemen jika ditemukan, atau null jika tidak ada.
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
     * Menyimpan data departemen baru ke database.
     *
     * @param array $data Array asosiatif berisi department_code, department_name, faculty, office_location.
     * @return bool True jika berhasil disimpan.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (department_code, department_name, faculty, office_location)
                VALUES (:department_code, :department_name, :faculty, :office_location)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':department_code' => $data['department_code'],
            ':department_name' => $data['department_name'],
            ':faculty'         => $data['faculty'],
            ':office_location' => $data['office_location'],
        ]);
    }

    /**
     * Memperbarui data departemen berdasarkan ID.
     *
     * @param int   $id   Primary key departemen.
     * @param array $data Data baru departemen.
     * @return bool True jika berhasil diperbarui.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET department_code = :department_code,
                    department_name = :department_name,
                    faculty = :faculty,
                    office_location = :office_location
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':department_code' => $data['department_code'],
            ':department_name' => $data['department_name'],
            ':faculty'         => $data['faculty'],
            ':office_location' => $data['office_location'],
            ':id'              => $id,
        ]);
    }

    /**
     * Menghapus data departemen berdasarkan ID.
     *
     * @param int $id Primary key departemen.
     * @return bool True jika berhasil dihapus.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
