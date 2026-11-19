<?php

declare(strict_types=1);

/**
 * Abstract Class BaseController
 *
 * Kelas dasar untuk seluruh Controller yang menyediakan utilitas rendering View,
 * pengalihan halaman (redirect), sanitasi input dasar, dan pesan kilat (flash message).
 */
abstract class BaseController
{
    /**
     * Merender file View beserta layout header dan footer.
     *
     * @param string $viewPath Path relatif view di dalam folder `views/` (tanpa ekstensi `.php`).
     * @param array  $data     Data asosiatif yang akan diekstrak menjadi variabel di dalam View.
     * @return void
     */
    protected function render(string $viewPath, array $data = []): void
    {
        // Mengekstrak array data agar dapat diakses langsung sebagai variabel di View
        extract($data);

        $fullViewFile = __DIR__ . '/../views/' . $viewPath . '.php';
        if (!file_exists($fullViewFile)) {
            die('View tidak ditemukan: ' . htmlspecialchars($viewPath));
        }

        require __DIR__ . '/../views/layouts/header.php';
        require $fullViewFile;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Mengalihkan browser pengguna ke rute controller dan aksi tertentu.
     *
     * @param string $page   Nama entitas/halaman (lecturers, departments, courses).
     * @param string $action Nama aksi (index, create, edit, dll.).
     * @return void
     */
    protected function redirect(string $page, string $action = 'index'): void
    {
        header("Location: index.php?page={$page}&action={$action}");
        exit;
    }

    /**
     * Menyimpan notifikasi sementara (flash message) ke dalam session.
     *
     * @param string $type    Tipe alert Bootstrap (success, danger, warning, info).
     * @param string $message Isi pesan notifikasi.
     * @return void
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    /**
     * Membersihkan spasi berlebih di awal dan akhir string input.
     *
     * @param string|null $value Nilai mentah dari form.
     * @return string Nilai yang sudah dirapikan.
     */
    protected function sanitize(?string $value): string
    {
        return trim((string) $value);
    }
}
