-- ============================================================================
-- File Database: tp_mvc25.sql
-- Deskripsi    : Skema database relasional untuk sistem akademik berbasis MVC
-- Tabel        : departments, lecturers, courses
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `tp_mvc25`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `tp_mvc25`;

-- Menonaktifkan pengecekan foreign key sementara saat proses reset tabel
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `lecturers`;
DROP TABLE IF EXISTS `departments`;

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------------------------------------------------------
-- 1. Tabel `departments` (Tabel Baru 1 - Master Program Studi / Departemen)
-- ----------------------------------------------------------------------------
CREATE TABLE `departments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `department_code` VARCHAR(15) NOT NULL,
  `department_name` VARCHAR(100) NOT NULL,
  `faculty` VARCHAR(100) NOT NULL,
  `office_location` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_department_code` (`department_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 2. Tabel `lecturers` (Tabel Awal dengan Penambahan Atribut & Relasi FK)
--    Atribut awal  : id, name, nidn, phone, join_date
--    Atribut baru  : email, department_id (FK -> departments.id)
-- ----------------------------------------------------------------------------
CREATE TABLE `lecturers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `nidn` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `join_date` DATE NOT NULL,
  `department_id` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lecturer_nidn` (`nidn`),
  UNIQUE KEY `uq_lecturer_email` (`email`),
  KEY `idx_lecturers_department_id` (`department_id`),
  CONSTRAINT `fk_lecturers_department`
    FOREIGN KEY (`department_id`)
    REFERENCES `departments` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. Tabel `courses` (Tabel Baru 2 - Mata Kuliah yang Diampu Dosen)
--    Relasi FK     : lecturer_id (FK -> lecturers.id)
-- ----------------------------------------------------------------------------
CREATE TABLE `courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_code` VARCHAR(15) NOT NULL,
  `course_name` VARCHAR(120) NOT NULL,
  `credits` TINYINT UNSIGNED NOT NULL,
  `semester` TINYINT UNSIGNED NOT NULL,
  `lecturer_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_course_code` (`course_code`),
  KEY `idx_courses_lecturer_id` (`lecturer_id`),
  CONSTRAINT `fk_courses_lecturer`
    FOREIGN KEY (`lecturer_id`)
    REFERENCES `lecturers` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Data Awal (Seed Data) untuk Pengujian Aplikasi
-- ============================================================================

INSERT INTO `departments` (`id`, `department_code`, `department_name`, `faculty`, `office_location`) VALUES
(1, 'ILKOM', 'Ilmu Komputer', 'FPMIPA', 'Gedung FPMIPA C Lt. 2'),
(2, 'PEND-IK', 'Pendidikan Ilmu Komputer', 'FPMIPA', 'Gedung FPMIPA C Lt. 3'),
(3, 'RPL', 'Rekayasa Perangkat Lunak', 'FPMIPA', 'Gedung JICA Lt. 4');

INSERT INTO `lecturers` (`id`, `name`, `nidn`, `email`, `phone`, `join_date`, `department_id`) VALUES
(1, 'Dr. Budi Santoso, M.T.', '0012048501', 'budi.santoso@kampus.ac.id', '081234567801', '2018-09-01', 1),
(2, 'Rina Wulandari, S.Kom., M.Cs.', '0023089002', 'rina.wulandari@kampus.ac.id', '081234567802', '2020-02-15', 1),
(3, 'Ahmad Fauzi, M.Kom.', '0015068803', 'ahmad.fauzi@kampus.ac.id', '081234567803', '2019-08-10', 2),
(4, 'Siti Nurhaliza, Ph.D.', '0004118704', 'siti.nurhaliza@kampus.ac.id', '081234567804', '2017-01-20', 3);

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `credits`, `semester`, `lecturer_id`) VALUES
(1, 'IK201', 'Desain dan Pemrograman Berorientasi Objek', 3, 3, 1),
(2, 'IK205', 'Struktur Data dan Algoritma', 4, 3, 2),
(3, 'IK302', 'Kecerdasan Buatan', 3, 5, 1),
(4, 'PI204', 'Basis Data Relasional', 3, 3, 3),
(5, 'RP301', 'Arsitektur Perangkat Lunak', 3, 5, 4);
