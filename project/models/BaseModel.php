<?php

declare(strict_types=1);

/**
 * Abstract Class BaseModel
 *
 * Kelas dasar untuk seluruh Model yang menyediakan akses terpusat ke objek
 * koneksi PDO serta definisi nama tabel utama masing-masing entitas.
 */
abstract class BaseModel
{
    /** @var PDO Instance koneksi PDO yang diinjeksikan melalui konstruktor */
    protected PDO $db;

    /** @var string Nama tabel pada database */
    protected string $table;

    /**
     * Konstruktor BaseModel.
     *
     * @param PDO $db Instance koneksi database PDO.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}
