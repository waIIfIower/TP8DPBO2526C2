<?php

declare(strict_types=1);

/**
 * Class Database
 *
 * Bertanggung jawab mengelola koneksi ke server basis data MySQL menggunakan
 * ekstensi PDO (PHP Data Objects) dengan penanganan pengecualian yang aman.
 */
class Database
{
    /** @var string Nama host server database */
    private string $host = 'localhost';

    /** @var string Nama database sesuai konfigurasi proyek */
    private string $dbName = 'tp_mvc25';

    /** @var string Username kredensial database */
    private string $username = 'root';

    /** @var string Password kredensial database */
    private string $password = '';

    /** @var string Set karakter koneksi database */
    private string $charset = 'utf8mb4';

    /** @var PDO|null Instance koneksi PDO aktif */
    private ?PDO $connection = null;

    /**
     * Membuat dan mengembalikan instance koneksi PDO.
     *
     * @return PDO Objek koneksi PDO yang siap digunakan oleh Model.
     */
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

            $options = [
                // Melempar PDOException setiap kali terjadi kesalahan SQL
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Mengembalikan hasil query dalam bentuk array asosiatif secara default
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Menonaktifkan emulasi prepared statement demi keamanan SQL Injection
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $exception) {
                die('Koneksi database gagal: ' . htmlspecialchars($exception->getMessage()));
            }
        }

        return $this->connection;
    }
}
