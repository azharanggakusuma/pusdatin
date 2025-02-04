-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2025 at 07:56 AM
-- Server version: 10.6.20-MariaDB
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pusdatin`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `url`, `status`) VALUES
(1, 'Data Desa', 'pages/forms/data_desa.php', 1),
(44, 'Keterangan Tempat', 'pages/forms/keterangan_tempat.php', 1),
(45, 'Keterangan Umum Desa Kelurahan', 'pages/forms/keterangan_umum_desa_kelurahan.php', 1),
(46, 'Kependudukan dan Ketenagakerjaan', 'pages/forms/kependudukan_dan_ketenagakerjaan.php', 1),
(47, 'Perumahan dan Lingkungan Hidup', 'pages/forms/perumahan_dan_lingkungan_hidup.php', 1),
(48, 'Bencana Alam dan Mitigasi Bencana Alam', 'pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php', 1),
(49, 'Pendidikan dan Kesehatan', 'pages/forms/pendidikan_dan_kesehatan.php', 1),
(50, 'Sosial Budaya', 'pages/forms/sosial_budaya.php', 1),
(51, 'Olahraga', 'pages/forms/olahraga.php', 1),
(52, 'Angkutan, Komunikasi, dan Informasi', 'pages/forms/angkutan,_komunikasi,_dan_informasi.php', 1),
(53, 'Ekonomi', 'pages/forms/ekonomi.php', 1),
(54, 'Keamanan', 'pages/forms/keamanan.php', 1),
(55, 'Keuangan dan Aset Desa', 'pages/forms/keuangan_dan_aset_desa.php', 1),
(56, 'Perlindungan Sosial, Pembangunan, dan Pemberdayaan Masyarakat', 'pages/forms/perlindungan_sosial,_pembangunan,_dan_pemberdayaan_masyarakat.php', 1),
(57, 'Aparatur Pemerintahan Desa', 'pages/forms/aparatur_pemerintahan_desa.php', 1),
(58, 'Lembaga Kemasyarakatan di Desa Kelurahan', 'pages/forms/lembaga_kemasyarakatan_di_desa_kelurahan.php', 1),
(62, 'Data Lokasi Geospasial', 'pages/forms/data_lokasi_geospasial.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `visit_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengunjung`
--

-- --------------------------------------------------------

--
-- Table structure for table `tahun`
--

CREATE TABLE `tahun` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun`
--

INSERT INTO `tahun` (`id`, `year`) VALUES
(1, '2024'),
(2, '2025'),

-- --------------------------------------------------------

--
-- Table structure for table `tb_apotek`
--

CREATE TABLE `tb_apotek` (
  `id` int(11) NOT NULL,
  `nama_apotek` varchar(255) NOT NULL,
  `alamat_apotek` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_badan_permusyawaratan_desa`
--

CREATE TABLE `tb_badan_permusyawaratan_desa` (
  `id` int(11) NOT NULL,
  `keberadaan_bpd` enum('Ada','Tidak Ada') NOT NULL,
  `jumlah_laki` int(11) DEFAULT NULL,
  `jumlah_perempuan` int(11) DEFAULT NULL,
  `jumlah_kegiatan` int(11) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_badan_usaha_aset_desa`
--

CREATE TABLE `tb_badan_usaha_aset_desa` (
  `id` int(11) NOT NULL,
  `jumlah_unit_usaha_bumdes` int(11) NOT NULL,
  `tanah_kas_desa_ulayat` varchar(50) NOT NULL,
  `tambatan_perahu` varchar(50) NOT NULL,
  `pasar_desa` varchar(50) NOT NULL,
  `bangunan_milik_desa` varchar(50) NOT NULL,
  `hutan_milik_desa` varchar(50) NOT NULL,
  `mata_air_milik_desa` varchar(50) NOT NULL,
  `tempat_wisata_pemandian_umum` varchar(50) NOT NULL,
  `aset_lainnya_milik_desa` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_balai_desa`
--

CREATE TABLE `tb_balai_desa` (
  `id` int(11) NOT NULL,
  `alamat_balai` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bank_operasi`
--

CREATE TABLE `tb_bank_operasi` (
  `id` int(11) NOT NULL,
  `bank_pemerintah` int(11) DEFAULT 0,
  `bank_swasta` int(11) DEFAULT 0,
  `bank_bpr` int(11) DEFAULT 0,
  `jarak_bank_terdekat` float DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_banyaknya_dusun_rt_rw`
--

CREATE TABLE `tb_banyaknya_dusun_rt_rw` (
  `id` int(11) NOT NULL,
  `jumlah_dusun` int(11) NOT NULL DEFAULT 0,
  `jumlah_rw` int(11) NOT NULL DEFAULT 0,
  `jumlah_rt` int(11) NOT NULL DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_batas_desa`
--

CREATE TABLE `tb_batas_desa` (
  `id` int(11) NOT NULL,
  `batas_utara` varchar(255) NOT NULL,
  `kec_utara` varchar(255) NOT NULL,
  `batas_selatan` varchar(255) NOT NULL,
  `kec_selatan` varchar(255) NOT NULL,
  `batas_timur` varchar(255) NOT NULL,
  `kec_timur` varchar(255) NOT NULL,
  `batas_barat` varchar(255) NOT NULL,
  `kec_barat` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bencana_alam`
--

CREATE TABLE `tb_bencana_alam` (
  `id_bencana_alam` int(11) NOT NULL,
  `tanah_longsor` varchar(10) NOT NULL,
  `banjir` varchar(10) NOT NULL,
  `banjir_bandang` varchar(10) NOT NULL,
  `gempa_bumi` varchar(10) NOT NULL,
  `tsunami` varchar(10) NOT NULL,
  `gelombang_pasang` varchar(10) NOT NULL,
  `angin_puyuh` varchar(10) NOT NULL,
  `gunung_meletus` varchar(10) NOT NULL,
  `kebakaran_hutan` varchar(10) NOT NULL,
  `kekeringan` varchar(10) NOT NULL,
  `abrasi` varchar(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bumdes`
--

CREATE TABLE `tb_bumdes` (
  `id` int(11) NOT NULL,
  `status_keaktifan` enum('Aktif','Tidak Aktif') NOT NULL,
  `status_badan_hukum` enum('Sudah Memiliki Badan Hukum','Belum Memiliki Badan') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_daftar_posyandu`
--

CREATE TABLE `tb_daftar_posyandu` (
  `id` int(11) NOT NULL,
  `nama_posyandu` varchar(255) NOT NULL,
  `alamat_posyandu` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_data_pkk`
--

CREATE TABLE `tb_data_pkk` (
  `id` int(11) NOT NULL,
  `jumlah_tim_penggerak_pkk` int(11) DEFAULT 0,
  `jumlah_kader_pkk` int(11) DEFAULT 0,
  `jumlah_kelompok_pkk` int(11) DEFAULT 0,
  `jumlah_kelompok_dasa_wisma` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_disabilitas`
--

CREATE TABLE `tb_disabilitas` (
  `id` int(11) NOT NULL,
  `jumlah_tuna_netra` int(11) NOT NULL,
  `jumlah_tuna_rungu` int(11) NOT NULL,
  `jumlah_tuna_wicara` int(11) NOT NULL,
  `jumlah_tuna_rungu_wicara` int(11) NOT NULL,
  `jumlah_tuna_daksa` int(11) NOT NULL,
  `jumlah_tuna_grahita` int(11) NOT NULL,
  `jumlah_tuna_laras` int(11) NOT NULL,
  `jumlah_tuna_eks_kusta` int(11) NOT NULL,
  `jumlah_tuna_ganda` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_embung_mata_air`
--

CREATE TABLE `tb_embung_mata_air` (
  `id` int(11) NOT NULL,
  `jumlah_embung` int(11) NOT NULL,
  `lokasi_mata_air` enum('Ada, Dikelola','Ada, Tidak Dikelola','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_enumerator`
--

CREATE TABLE `tb_enumerator` (
  `id_desa` int(11) NOT NULL,
  `kode_desa` varchar(100) NOT NULL,
  `nama_desa` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_fasilitas_olahraga`
--

CREATE TABLE `tb_fasilitas_olahraga` (
  `id` int(11) NOT NULL,
  `sepak_bola` varchar(50) NOT NULL,
  `bola_voli` varchar(50) NOT NULL,
  `bulu_tangkis` varchar(50) NOT NULL,
  `bola_basket` varchar(50) NOT NULL,
  `tenis_lapangan` varchar(50) NOT NULL,
  `tenis_meja` varchar(50) NOT NULL,
  `futsal` varchar(50) NOT NULL,
  `renang` varchar(50) NOT NULL,
  `bela_diri` varchar(50) NOT NULL,
  `bilyard` varchar(50) NOT NULL,
  `fitness` varchar(50) NOT NULL,
  `lainnya_nama` varchar(100) DEFAULT NULL,
  `lainnya_kondisi` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_idm_status`
--

CREATE TABLE `tb_idm_status` (
  `id` int(11) NOT NULL,
  `status_idm` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_internet_transportasi`
--

CREATE TABLE `tb_internet_transportasi` (
  `id` int(11) NOT NULL,
  `keberadaan_internet` enum('Ada','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jarak_kantor_desa`
--

CREATE TABLE `tb_jarak_kantor_desa` (
  `id` int(11) NOT NULL,
  `jarak_ke_ibukota_kecamatan` decimal(6,2) NOT NULL,
  `jarak_ke_ibukota_kabupaten` decimal(6,2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kader_pembangunan_manusia`
--

CREATE TABLE `tb_kader_pembangunan_manusia` (
  `id` int(11) NOT NULL,
  `keberadaan_kader_pembangunan_manusia` varchar(50) NOT NULL,
  `pembinaan_kpm_dari_pemkab_kota` varchar(50) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_karang_taruna`
--

CREATE TABLE `tb_karang_taruna` (
  `id` int(11) NOT NULL,
  `jumlah_karang_taruna` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keamanan_lingkungan`
--

CREATE TABLE `tb_keamanan_lingkungan` (
  `id` int(11) NOT NULL,
  `pembangunan_pos_keamanan` varchar(50) NOT NULL,
  `pembentukan_regu_keamanan` varchar(50) NOT NULL,
  `penambahan_anggota_hansip` varchar(50) NOT NULL,
  `pelaporan_tamu_menginap` varchar(50) NOT NULL,
  `pengaktifan_sistem_keamanan` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_bidan`
--

CREATE TABLE `tb_keberadaan_bidan` (
  `id` int(11) NOT NULL,
  `keberadaan_bidan` varchar(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_danau`
--

CREATE TABLE `tb_keberadaan_danau` (
  `id` int(11) NOT NULL,
  `keberadaan_danau` enum('Ada','Tidak Ada') NOT NULL,
  `nama_danau_1` varchar(255) DEFAULT NULL,
  `nama_danau_2` varchar(255) DEFAULT NULL,
  `nama_danau_3` varchar(255) DEFAULT NULL,
  `nama_danau_4` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_dukun_bayi`
--

CREATE TABLE `tb_keberadaan_dukun_bayi` (
  `id` int(11) NOT NULL,
  `keberadaan_dukun_bayi` varchar(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_kantor_pos`
--

CREATE TABLE `tb_keberadaan_kantor_pos` (
  `id` int(11) NOT NULL,
  `kantor_pos` enum('Beroperasi','Jarang beroperasi','Tidak beroperasi','Tidak ada') NOT NULL,
  `layanan_pos_keliling` enum('Ada','Tidak ada') NOT NULL,
  `ekspedisi_swasta` enum('Beroperasi','Jarang beroperasi','Tidak beroperasi','Tidak ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_pemukiman_bantaran`
--

CREATE TABLE `tb_keberadaan_pemukiman_bantaran` (
  `id` int(11) NOT NULL,
  `keberadaan_pemukiman` enum('Ada','Tidak Ada') NOT NULL,
  `jumlah_pemukiman` int(11) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_pos_polisi`
--

CREATE TABLE `tb_keberadaan_pos_polisi` (
  `id` int(11) NOT NULL,
  `keberadaan_pos_polisi` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keberadaan_sungai`
--

CREATE TABLE `tb_keberadaan_sungai` (
  `id` int(11) NOT NULL,
  `keberadaan_sungai` enum('Ada','Tidak Ada') NOT NULL,
  `nama_sungai_1` varchar(255) DEFAULT NULL,
  `nama_sungai_2` varchar(255) DEFAULT NULL,
  `nama_sungai_3` varchar(255) DEFAULT NULL,
  `nama_sungai_4` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kematian`
--

CREATE TABLE `tb_kematian` (
  `id` int(11) NOT NULL,
  `jumlah_surat_kematian` int(11) NOT NULL DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kepala_desa`
--

CREATE TABLE `tb_kepala_desa` (
  `id` int(11) NOT NULL,
  `nama_kepala_desa` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL,
  `jenis_kelamin` enum('LAKI-LAKI','PEREMPUAN') NOT NULL,
  `pendidikan_terakhir` enum('Tidak pernah sekolah','Tidak tamat SD/Sederajat','Tamat SD/Sederajat','SMP/Sederajat','SMU/Sederajat','Akademi/DIII','Diploma IV/S1','S2','S3') NOT NULL,
  `tahun_mulai_menjabat` year(4) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kepemilikan_kantor`
--

CREATE TABLE `tb_kepemilikan_kantor` (
  `id` int(11) NOT NULL,
  `keberadaan_kantor` enum('ADA','TIDAK ADA') NOT NULL,
  `status_kantor` enum('ASET DESA','BUKAN ASET DESA') NOT NULL,
  `kondisi_kantor` enum('ADA, LAYAK','ADA, TIDAK LAYAK','TIDAK ADA') NOT NULL,
  `lokasi_kantor` enum('Di dalam wilayah desa/kelurahan','Di Luar Wilayah Desa/Kelurahan') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kerjasama_desa`
--

CREATE TABLE `tb_kerjasama_desa` (
  `id` int(11) NOT NULL,
  `keberadaan_kerjasama_antar_desa` varchar(50) NOT NULL,
  `keberadaan_kerjasama_desa_dengan_pihak_ketiga` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ketenagakerjaan`
--

CREATE TABLE `tb_ketenagakerjaan` (
  `id` int(11) NOT NULL,
  `pmi_bekerja` enum('Ada','Tidak Ada') NOT NULL,
  `agen_pengerahan_pmi` enum('Ada','Tidak Ada') NOT NULL,
  `layanan_rekomendasi_pmi` enum('Ada','Tidak Ada') NOT NULL,
  `keberadaan_wna` enum('Ada','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ketersediaan_batas_peta`
--

CREATE TABLE `tb_ketersediaan_batas_peta` (
  `id` int(11) NOT NULL,
  `penetapan_batas_desa` varchar(50) NOT NULL,
  `no_surat_batas_desa` varchar(255) DEFAULT NULL,
  `ketersediaan_peta_desa` varchar(50) NOT NULL,
  `no_surat_peta_desa` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ketersediaan_internet`
--

CREATE TABLE `tb_ketersediaan_internet` (
  `id` int(11) NOT NULL,
  `kondisi_komputer` enum('Digunakan','Jarang digunakan','Tidak digunakan','Tidak ada') NOT NULL,
  `fasilitas_internet` enum('Berfungsi','Jarang berfungsi','Tidak berfungsi','Tidak ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ketersediaan_penetapan_peta_desa`
--

CREATE TABLE `tb_ketersediaan_penetapan_peta_desa` (
  `id` int(11) NOT NULL,
  `penetapan_batas_desa` enum('SUDAH ADA','BELUM ADA') NOT NULL,
  `no_surat_batas_desa` varchar(255) DEFAULT NULL,
  `ketersediaan_peta_desa` enum('ADA','TIDAK ADA') NOT NULL,
  `no_surat_peta_desa` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ketersediaan_rpjmdes_rkpdes`
--

CREATE TABLE `tb_ketersediaan_rpjmdes_rkpdes` (
  `id` int(11) NOT NULL,
  `ketersediaan_rpjmdes` varchar(50) NOT NULL,
  `tahun_awal_rpjmdes` int(11) DEFAULT NULL,
  `tahun_akhir_rpjmdes` int(11) DEFAULT NULL,
  `ketersediaan_rkpdes` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_klb_wabah`
--

CREATE TABLE `tb_klb_wabah` (
  `id_klb` int(11) NOT NULL,
  `muntaber_diare` varchar(10) NOT NULL,
  `demam_berdarah` varchar(10) NOT NULL,
  `campak` varchar(10) NOT NULL,
  `malaria` varchar(10) NOT NULL,
  `flu_burung_sars` varchar(10) NOT NULL,
  `hepatitis_e` varchar(10) NOT NULL,
  `difteri` varchar(10) NOT NULL,
  `corona_covid19` varchar(10) NOT NULL,
  `lainnya_name` varchar(255) DEFAULT NULL,
  `lainnya_status` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_koperasi`
--

CREATE TABLE `tb_koperasi` (
  `id` int(11) NOT NULL,
  `koperasi_kud` int(11) DEFAULT 0,
  `koperasi_kopinkra` int(11) DEFAULT 0,
  `koperasi_ksp` int(11) DEFAULT 0,
  `koperasi_lainnya` int(11) DEFAULT 0,
  `toko_kud` enum('Ada','Tidak Ada') DEFAULT NULL,
  `toko_bumdesa` enum('Ada','Tidak Ada') DEFAULT NULL,
  `toko_lainnya` enum('Ada','Tidak Ada') DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_linmas_poskamling`
--

CREATE TABLE `tb_linmas_poskamling` (
  `id` int(11) NOT NULL,
  `jumlah_anggota_linmas` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_lokasi_penggalian`
--

CREATE TABLE `tb_lokasi_penggalian` (
  `id` int(11) NOT NULL,
  `keberadaan_galian` enum('Ada','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_lpmd`
--

CREATE TABLE `tb_lpmd` (
  `id` int(11) NOT NULL,
  `jumlah_anggota_laki` int(11) DEFAULT 0,
  `jumlah_anggota_perempuan` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_luas_wilayah_desa`
--

CREATE TABLE `tb_luas_wilayah_desa` (
  `id` int(11) NOT NULL,
  `luas_wilayah_desa` decimal(10,2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_menara_telepon`
--

CREATE TABLE `tb_menara_telepon` (
  `id` int(11) NOT NULL,
  `jumlah_bts` int(11) NOT NULL,
  `jumlah_operator_telekomunikasi` int(11) NOT NULL,
  `sinyal_telepon` enum('Sinyal sangat kuat','Sinyal kuat','Sinyal lemah','Tidak ada sinyal') NOT NULL,
  `sinyal_internet` enum('5G/4G/LTE','3G/H+/EVDO','2.5G/EG/GPRS','Tidak ada sinyal internet') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pangkalan_minyak`
--

CREATE TABLE `tb_pangkalan_minyak` (
  `id` int(11) NOT NULL,
  `keberadaan_minyak_tanah` enum('Ada','Tidak Ada') NOT NULL,
  `keberadaan_lpg` enum('Ada','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemanfaatan_sistem`
--

CREATE TABLE `tb_pemanfaatan_sistem` (
  `id` int(11) NOT NULL,
  `keberadaan_sistem_informasi_desa` varchar(50) NOT NULL,
  `keberadaan_sistem_keuangan_desa` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendamping_lokal_desa`
--

CREATE TABLE `tb_pendamping_lokal_desa` (
  `id` int(11) NOT NULL,
  `keberadaan_pendamping_lokal_desa` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_penduduk_dan_keluarga`
--

CREATE TABLE `tb_penduduk_dan_keluarga` (
  `id` int(11) NOT NULL,
  `jumlah_penduduk_laki` int(11) NOT NULL DEFAULT 0,
  `jumlah_penduduk_perempuan` int(11) NOT NULL DEFAULT 0,
  `jumlah_kepala_keluarga` int(11) NOT NULL DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_penerangan_jalan`
--

CREATE TABLE `tb_penerangan_jalan` (
  `id` int(11) NOT NULL,
  `lampu_tenaga_surya` enum('Ada','Tidak Ada') NOT NULL,
  `penerangan_jalan_utama` enum('Ada, Sebagian Besar','Ada, Sebagian Kecil','Tidak Ada') NOT NULL,
  `sumber_penerangan` enum('Listrik Diusahakan Oleh Pemerintah','Listrik Diusahakan Oleh Non Pemerintah','Non Listrik') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_penerima_bantuan_sosial`
--

CREATE TABLE `tb_penerima_bantuan_sosial` (
  `id` int(11) NOT NULL,
  `penerima_pkh` int(11) NOT NULL,
  `penerima_blt_dana_desa` int(11) NOT NULL,
  `penerima_bpnt` int(11) NOT NULL,
  `penerima_pbi_jk` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengadaan_barang_jasa`
--

CREATE TABLE `tb_pengadaan_barang_jasa` (
  `id` int(11) NOT NULL,
  `jumlah_paket_pengadaan_barang_dan_jasa` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengelolaan_sampah`
--

CREATE TABLE `tb_pengelolaan_sampah` (
  `id` int(11) NOT NULL,
  `tps` enum('Ada, Digunakan','Ada, Tidak Digunakan','Tidak Ada') NOT NULL,
  `tps3r` enum('Ada, Digunakan','Ada, Tidak Digunakan','Tidak Ada') NOT NULL,
  `bank_sampah` enum('Ada','Tidak Ada','Non Listrik') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna_listrik_lampu_surya`
--

CREATE TABLE `tb_pengguna_listrik_lampu_surya` (
  `id` int(11) NOT NULL,
  `jumlah_pln` int(11) NOT NULL,
  `jumlah_non_pln` int(11) NOT NULL,
  `jumlah_bukan_pengguna_listrik` int(11) NOT NULL,
  `penggunaan_lampu_tenaga_surya` enum('Ada, Sebagian Besar','Ada, Sebagian Kecil','Tidak Ada') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_perangkat_desa`
--

CREATE TABLE `tb_perangkat_desa` (
  `id` int(11) NOT NULL,
  `skd_laki` int(11) DEFAULT 0,
  `skd_perempuan` int(11) DEFAULT 0,
  `kaur_laki` int(11) DEFAULT 0,
  `kaur_perempuan` int(11) DEFAULT 0,
  `kkk_laki` int(11) DEFAULT 0,
  `kkk_perempuan` int(11) DEFAULT 0,
  `pk_laki` int(11) DEFAULT 0,
  `pk_perempuan` int(11) DEFAULT 0,
  `staf_laki` int(11) DEFAULT 0,
  `staf_perempuan` int(11) DEFAULT 0,
  `total_laki` int(11) DEFAULT 0,
  `total_perempuan` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_perangkat_desa_pendidikan`
--

CREATE TABLE `tb_perangkat_desa_pendidikan` (
  `id` int(11) NOT NULL,
  `tidak_sekolah_laki` int(11) DEFAULT 0,
  `tidak_sekolah_perempuan` int(11) DEFAULT 0,
  `tidak_tamat_sd_laki` int(11) DEFAULT 0,
  `tidak_tamat_sd_perempuan` int(11) DEFAULT 0,
  `tamat_sd_laki` int(11) DEFAULT 0,
  `tamat_sd_perempuan` int(11) DEFAULT 0,
  `smp_laki` int(11) DEFAULT 0,
  `smp_perempuan` int(11) DEFAULT 0,
  `smu_laki` int(11) DEFAULT 0,
  `smu_perempuan` int(11) DEFAULT 0,
  `d3_laki` int(11) DEFAULT 0,
  `d3_perempuan` int(11) DEFAULT 0,
  `s1_laki` int(11) DEFAULT 0,
  `s1_perempuan` int(11) DEFAULT 0,
  `s2_laki` int(11) DEFAULT 0,
  `s2_perempuan` int(11) DEFAULT 0,
  `s3_laki` int(11) DEFAULT 0,
  `s3_perempuan` int(11) DEFAULT 0,
  `total_laki` int(11) DEFAULT 0,
  `total_perempuan` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_peraturan_desa`
--

CREATE TABLE `tb_peraturan_desa` (
  `id` int(11) NOT NULL,
  `jumlah_peraturan_yang_dimiliki_desa` int(11) NOT NULL,
  `jumlah_peraturan_kepala_desa` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_peringatan_bencana`
--

CREATE TABLE `tb_peringatan_bencana` (
  `id_peringatan` int(11) NOT NULL,
  `peringatan_dini` varchar(20) NOT NULL,
  `peringatan_tsunami` varchar(30) NOT NULL,
  `perlengkapan_keselamatan` varchar(20) NOT NULL,
  `rambu_evakuasi` varchar(20) NOT NULL,
  `infrastruktur` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_perkelahian_massal`
--

CREATE TABLE `tb_perkelahian_massal` (
  `id` int(11) NOT NULL,
  `kejadian` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_permukiman_kumuh`
--

CREATE TABLE `tb_permukiman_kumuh` (
  `id` int(11) NOT NULL,
  `keberadaan_kumuh` enum('Ada','Tidak Ada') NOT NULL,
  `jumlah_kumuh` int(11) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_poliklinik`
--

CREATE TABLE `tb_poliklinik` (
  `id` int(11) NOT NULL,
  `nama_poliklinik` varchar(255) NOT NULL,
  `alamat_poliklinik` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_polindes`
--

CREATE TABLE `tb_polindes` (
  `id` int(11) NOT NULL,
  `nama_polindes` varchar(255) NOT NULL,
  `alamat_polindes` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pondok_pesantren`
--

CREATE TABLE `tb_pondok_pesantren` (
  `id` int(11) NOT NULL,
  `nama_pesantren` varchar(255) NOT NULL,
  `alamat_pesantren` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_poskesdes`
--

CREATE TABLE `tb_poskesdes` (
  `id` int(11) NOT NULL,
  `nama_poskesdes` varchar(255) NOT NULL,
  `alamat_poskesdes` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_posyandu`
--

CREATE TABLE `tb_posyandu` (
  `id` int(11) NOT NULL,
  `jumlah_posyandu` int(11) DEFAULT 0,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_potensi_wisata`
--

CREATE TABLE `tb_potensi_wisata` (
  `id` int(11) NOT NULL,
  `nama_potensi_wisata` varchar(255) NOT NULL,
  `jenis_wisata` varchar(50) NOT NULL,
  `titik_koordinat_lintang` varchar(50) NOT NULL,
  `titik_koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_praktek_bidan`
--

CREATE TABLE `tb_praktek_bidan` (
  `id` int(11) NOT NULL,
  `nama_praktek_bidan` varchar(255) NOT NULL,
  `alamat_praktek_bidan` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_praktek_dokter`
--

CREATE TABLE `tb_praktek_dokter` (
  `id` int(11) NOT NULL,
  `nama_praktek_dokter` varchar(255) NOT NULL,
  `alamat_praktek_dokter` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_prasarana_kebersihan`
--

CREATE TABLE `tb_prasarana_kebersihan` (
  `id` int(11) NOT NULL,
  `jumlah_prasarana` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_prasarana_transportasi`
--

CREATE TABLE `tb_prasarana_transportasi` (
  `id` int(11) NOT NULL,
  `lalu_lintas` enum('Aspal/Beton','Diperkeras (kerikil, batu, dll.)','Tanah','Lainnya') NOT NULL,
  `jenis_permukaan_jalan` enum('Sepanjang tahun','Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)','Selama musim kemarau','Tidak dapat dilalui sepanjang tahun') NOT NULL,
  `jalan_darat_bisa_dilalui` enum('Sepanjang tahun','Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)','Selama musim kemarau','Tidak dapat dilalui sepanjang tahun') NOT NULL,
  `keberadaan_angkutan_umum` enum('Ada, dengan trayek tetap','Ada, tanpa trayek tetap','Tidak ada angkutan umum') NOT NULL,
  `operasional_angkutan_umum` enum('Setiap hari','Tidak setiap hari') NOT NULL,
  `jam_operasi_angkutan_umum` enum('Siang dan malam hari','Hanya siang/malam hari') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk_unggulan`
--

CREATE TABLE `tb_produk_unggulan` (
  `id` int(11) NOT NULL,
  `keberadaan` enum('Ada','Tidak Ada') NOT NULL,
  `makanan_unggulan` varchar(255) DEFAULT NULL,
  `non_makanan_unggulan` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_puskesmas`
--

CREATE TABLE `tb_puskesmas` (
  `id` int(11) NOT NULL,
  `nama_puskesmas` varchar(255) NOT NULL,
  `alamat_puskesmas` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pustu`
--

CREATE TABLE `tb_pustu` (
  `id` int(11) NOT NULL,
  `nama_pustu` varchar(255) NOT NULL,
  `alamat_pustu` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_realisasi_anggaran_belanja_desa`
--

CREATE TABLE `tb_realisasi_anggaran_belanja_desa` (
  `id` int(11) NOT NULL,
  `bidang_penyelenggaraan_pemerintahan_desa` decimal(15,2) NOT NULL,
  `bidang_pelaksanaan_pembangunan_desa` decimal(15,2) NOT NULL,
  `bidang_pembinaan_kemasyarakatan` decimal(15,2) NOT NULL,
  `bidang_pemberdayaan_masyarakat` decimal(15,2) NOT NULL,
  `bidang_tak_terduga` decimal(15,2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_realisasi_anggaran_desa`
--

CREATE TABLE `tb_realisasi_anggaran_desa` (
  `id` int(11) NOT NULL,
  `pendapatan_asli_desa` decimal(15,2) NOT NULL,
  `dana_desa` decimal(15,2) NOT NULL,
  `bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah` decimal(15,2) NOT NULL,
  `alokasi_dana_desa` decimal(15,2) NOT NULL,
  `bantuan_keuangan_dari_apbd_provinsi` decimal(15,2) NOT NULL,
  `bantuan_keuangan_dari_apbd` decimal(15,2) NOT NULL,
  `hibah_dan_sumbangan_dari_pihak_ketiga` decimal(15,2) NOT NULL,
  `lain_lain_pendapatan_desa_yang_sah` decimal(15,2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruang_publik`
--

CREATE TABLE `tb_ruang_publik` (
  `id` int(11) NOT NULL,
  `status_ruang_publik` varchar(255) NOT NULL,
  `ruang_terbuka_hijau` varchar(50) DEFAULT NULL,
  `ruang_terbuka_non_hijau` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rumah_sakit`
--

CREATE TABLE `tb_rumah_sakit` (
  `id` int(11) NOT NULL,
  `nama_rumah_sakit` varchar(255) NOT NULL,
  `alamat_rumah_sakit` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rumah_tidak_layak_huni`
--

CREATE TABLE `tb_rumah_tidak_layak_huni` (
  `id` int(11) NOT NULL,
  `jumlah_rumah` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sarana_ekonomi`
--

CREATE TABLE `tb_sarana_ekonomi` (
  `id` int(11) NOT NULL,
  `bmt_jumlah` int(11) DEFAULT 0,
  `bmt_jarak` float DEFAULT NULL,
  `bmt_kemudahan` varchar(50) DEFAULT NULL,
  `atm_jumlah` int(11) DEFAULT 0,
  `atm_jarak` float DEFAULT NULL,
  `atm_kemudahan` varchar(50) DEFAULT NULL,
  `agen_bank_jumlah` int(11) DEFAULT 0,
  `agen_bank_jarak` float DEFAULT NULL,
  `agen_bank_kemudahan` varchar(50) DEFAULT NULL,
  `valas_jumlah` int(11) DEFAULT 0,
  `valas_jarak` float DEFAULT NULL,
  `valas_kemudahan` varchar(50) DEFAULT NULL,
  `pegadaian_jumlah` int(11) DEFAULT 0,
  `pegadaian_jarak` float DEFAULT NULL,
  `pegadaian_kemudahan` varchar(50) DEFAULT NULL,
  `agen_tiket_jumlah` int(11) DEFAULT 0,
  `agen_tiket_jarak` float DEFAULT NULL,
  `agen_tiket_kemudahan` varchar(50) DEFAULT NULL,
  `bengkel_jumlah` int(11) DEFAULT 0,
  `bengkel_jarak` float DEFAULT NULL,
  `bengkel_kemudahan` varchar(50) DEFAULT NULL,
  `salon_jumlah` int(11) DEFAULT 0,
  `salon_jarak` float DEFAULT NULL,
  `salon_kemudahan` varchar(50) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sarana_prasarana`
--

CREATE TABLE `tb_sarana_prasarana` (
  `id` int(11) NOT NULL,
  `kelompok_pertokoan_jumlah` int(11) DEFAULT 0,
  `kelompok_pertokoan_kemudahan` varchar(50) DEFAULT NULL,
  `pasar_permanen_jumlah` int(11) DEFAULT 0,
  `pasar_permanen_kemudahan` varchar(50) DEFAULT NULL,
  `pasar_semi_permanen_jumlah` int(11) DEFAULT 0,
  `pasar_semi_permanen_kemudahan` varchar(50) DEFAULT NULL,
  `pasar_tanpa_bangunan_jumlah` int(11) DEFAULT 0,
  `pasar_tanpa_bangunan_kemudahan` varchar(50) DEFAULT NULL,
  `minimarket_jumlah` int(11) DEFAULT 0,
  `minimarket_kemudahan` varchar(50) DEFAULT NULL,
  `restoran_jumlah` int(11) DEFAULT 0,
  `restoran_kemudahan` varchar(50) DEFAULT NULL,
  `warung_makan_jumlah` int(11) DEFAULT 0,
  `warung_makan_kemudahan` varchar(50) DEFAULT NULL,
  `toko_kelontong_jumlah` int(11) DEFAULT 0,
  `toko_kelontong_kemudahan` varchar(50) DEFAULT NULL,
  `hotel_jumlah` int(11) DEFAULT 0,
  `hotel_kemudahan` varchar(50) DEFAULT NULL,
  `penginapan_jumlah` int(11) DEFAULT 0,
  `penginapan_kemudahan` varchar(50) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sekolah`
--

CREATE TABLE `tb_sekolah` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `jenjang_pendidikan` varchar(100) NOT NULL,
  `status_sekolah` varchar(50) NOT NULL,
  `alamat_sekolah` text NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `koordinat_lintang` varchar(50) NOT NULL,
  `koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sentra_industri`
--

CREATE TABLE `tb_sentra_industri` (
  `id` int(11) NOT NULL,
  `keberadaan` enum('Ada','Tidak Ada') NOT NULL,
  `jumlah_sentra` int(11) DEFAULT NULL,
  `produk_utama` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sktm`
--

CREATE TABLE `tb_sktm` (
  `id` int(11) NOT NULL,
  `jumlah_sktm` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sk_pembentukan`
--

CREATE TABLE `tb_sk_pembentukan` (
  `id` int(11) NOT NULL,
  `sk_pembentukan` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_status_pemerintahan`
--

CREATE TABLE `tb_status_pemerintahan` (
  `id` int(11) NOT NULL,
  `status_pemerintahan` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sutet`
--

CREATE TABLE `tb_sutet` (
  `id` int(11) NOT NULL,
  `sutet_status` varchar(255) NOT NULL,
  `keberadaan_pemukiman` varchar(255) NOT NULL,
  `jumlah_pemukiman` int(11) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_taman_bacaan`
--

CREATE TABLE `tb_taman_bacaan` (
  `id` int(11) NOT NULL,
  `keberadaan_tbm` varchar(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tanah_kas_desa`
--

CREATE TABLE `tb_tanah_kas_desa` (
  `id` int(11) NOT NULL,
  `tanah_bengkok` decimal(10,2) NOT NULL,
  `tanah_titi_sara` decimal(10,2) NOT NULL,
  `kebun_desa` decimal(10,2) NOT NULL,
  `sawah_desa` decimal(10,2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tempat_ibadah`
--

CREATE TABLE `tb_tempat_ibadah` (
  `id` int(11) NOT NULL,
  `jumlah_masjid` int(11) DEFAULT 0,
  `jumlah_pura` int(11) DEFAULT 0,
  `jumlah_musala` int(11) DEFAULT 0,
  `jumlah_wihara` int(11) DEFAULT 0,
  `jumlah_gereja_kristen` int(11) DEFAULT 0,
  `jumlah_kelenteng` int(11) DEFAULT 0,
  `jumlah_gereja_katolik` int(11) DEFAULT 0,
  `jumlah_balai_basarah` int(11) DEFAULT 0,
  `jumlah_kapel` int(11) DEFAULT 0,
  `lainnya` varchar(255) DEFAULT NULL,
  `jumlah_lainnya` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tempat_peribadatan`
--

CREATE TABLE `tb_tempat_peribadatan` (
  `id` int(11) NOT NULL,
  `jenis_tempat_peribadatan` varchar(50) NOT NULL,
  `nama_tempat_peribadatan` varchar(255) NOT NULL,
  `titik_koordinat_lintang` varchar(50) NOT NULL,
  `titik_koordinat_bujur` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_titik_koordinat_kantor_desa`
--

CREATE TABLE `tb_titik_koordinat_kantor_desa` (
  `id` int(11) NOT NULL,
  `koordinat_lintang` decimal(10,6) NOT NULL,
  `koordinat_bujur` decimal(10,6) NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_topografi_terluas_wilayah_desa`
--

CREATE TABLE `tb_topografi_terluas_wilayah_desa` (
  `id` int(11) NOT NULL,
  `topografi_terluas_wilayah_desa` enum('LERENG/PUNCAK','LEMBAH','DATARAN','PESISIR PANTAI') NOT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_website_medsos`
--

CREATE TABLE `tb_website_medsos` (
  `id` int(11) NOT NULL,
  `alamat_website` varchar(255) DEFAULT NULL,
  `alamat_email` varchar(255) DEFAULT NULL,
  `alamat_facebook` varchar(255) DEFAULT NULL,
  `alamat_twitter` varchar(255) DEFAULT NULL,
  `alamat_youtube` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin'),
(26, 'Adidharma', 'adidharma', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(27, 'Ambit', 'ambit', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(28, 'Ambulu', 'ambulu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(29, 'Arjawinangun', 'arjawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(30, 'Asem', 'asem', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(31, 'Astana', 'astana', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(32, 'Astanajapura', 'astanajapura', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(33, 'Astanalanggar', 'astanalanggar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(34, 'Astana Mukti', 'astana_mukti', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(35, 'Astapada', 'astapada', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(36, 'Babadan', 'babadan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(37, 'Babakan', 'babakan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(38, 'Babakan Sumber', 'babakan_sumber', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(39, 'Babakan Ciwaringin', 'babakan_ciwaringin', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(40, 'Babakan Gebang', 'babakan_gebang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(41, 'Babakan Losari', 'babakan_losari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(42, 'Babakan Losari Lor', 'babakan_losari_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(43, 'Bakung Kidul', 'bakung_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(44, 'Bakung Lor', 'bakung_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(45, 'Balad', 'balad', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(46, 'Balerante', 'balerante', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(47, 'Bandengan', 'bandengan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(48, 'Bangodua', 'bangodua', 'f520f394f12445eeaacdd6707ed12ea5c39bfac2', 'user'),
(49, 'Banjarwangunan', 'banjarwangunan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(50, 'Barisan', 'barisan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(51, 'Battembat', 'battembat', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(52, 'Bayalangu Kidul', 'bayalangu_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(53, 'Bayalangu Lor', 'bayalangu _lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(54, 'Beber', 'beber', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(55, 'Beberan', 'beberan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(56, 'Belawa', 'belawa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(57, 'Bendungan', 'bendungan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(58, 'Beringin', 'beringin', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(59, 'Blender', 'blender', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(60, 'Bobos', 'bobos', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(61, 'Bode Lor', 'bode_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(62, 'Bodesari', 'bodesari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(63, 'Bojong Kulon', 'bojong_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(64, 'Bojong Lor', 'bojong_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(65, 'Bojong Wetan', 'bojong_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(66, 'Bojonggebang', 'bojonggebang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(67, 'Bojongnegara', 'bojongnegara', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(68, 'Bringin', 'bringin', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(69, 'Budur', 'budur', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(70, 'Bulak', 'bulak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(71, 'Bunder', 'bunder', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(72, 'Bungko', 'bungko', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(73, 'Bungko Lor', 'bungko_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(74, 'Buntet', 'buntet', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(75, 'Buyut', 'buyut', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(76, 'Cangkoak', 'cangkoak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(77, 'Cankring', 'cankring', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(78, 'Cangkuang', 'cangkuang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(79, 'Cempaka Talun', 'cempaka_talun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(80, 'Cempaka Plumbon', 'cempaka_plumbon', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(81, 'Cengkuang', 'cengkuang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(82, 'Ciawi', 'ciawi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(83, 'Ciawiasih', 'ciawiasih', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(84, 'Ciawigajah', 'ciawigajah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(85, 'Ciawijapura', 'ciawijapura', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(86, 'Cibogo', 'cibogo', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(87, 'Cigobang', 'cigobang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(88, 'Cigobang Wangi', 'cigobang_wangi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(89, 'Cikalahang', 'cikalahang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(90, 'Cikancas', 'cikancas', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(91, 'Cikeduk', 'cikeduk', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(92, 'Cikeusal', 'cikeusal', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(93, 'Cikulak', 'cikulak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(94, 'Cikulak Kidul', 'cikulak_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(95, 'Ciledug Kulon', 'ciledug_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(96, 'Ciledug Lor', 'ciledug_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(97, 'Ciledug Tengah', 'ciledug_tengah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(98, 'Ciledug Wetan', 'ciledug_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(99, 'Cilengkrang', 'cilengkrang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(100, 'Cilengkrang Girang', 'cilengkrang_girang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(101, 'Cilukrak', 'cilukrak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(102, 'Cipanas', 'cipanas', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(103, 'Ciperna', 'ciperna', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(104, 'Cipeujeuh Kulon', 'cipeujeuh_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(105, 'Cipeujeuh Wetan', 'cipeujeuh_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(106, 'Cipinang', 'cipinang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(107, 'Cirebon Girang', 'cirebon_girang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(108, 'Cisaat Waled', 'cisaat_waled', '728348f63167a287d2509edf88d74dbf79c44480', 'user'),
(109, 'Cisaat Dukupuntang', 'cisaat_dukupuntang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(110, 'Citemu', 'citemu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(111, 'Ciuyah', 'ciuyah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(112, 'Ciwaringin', 'ciwaringin', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(113, 'Cupang', 'cupang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(114, 'Curug', 'curug', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(115, 'Curug Wetan', 'curug_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(116, 'Damarguna', 'damarguna', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(117, 'Danamulya', 'danamulya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(118, 'Danawinangun', 'danawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(119, 'Dawuan', 'dawuan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(120, 'Depok', 'depok', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(121, 'Dompyong Kulon', 'dompyong_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(122, 'Dompyong Wetan', 'dompyong_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(123, 'Dukuh', 'dukuh', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(124, 'Dukuhwidara', 'dukuhwidara', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(125, 'Dukupuntang', 'dukupuntang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(126, 'Durajaya', 'durajaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(127, 'Ender', 'ender', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(128, 'Gagasari', 'gagasari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(129, 'Galagamba', 'galagamba', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(130, 'Gamel', 'gamel', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(131, 'Gebang', 'gebang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(132, 'Gebang Ilir', 'gebang_ilir', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(133, 'Gebang Kulon', 'gebang_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(134, 'Gebang Mekar', 'gebang_mekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(135, 'Gebang Udik', 'gebang_udik', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(136, 'Gegesik Kidul', 'gegesik_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(137, 'Gegesik Kulon', 'gegesik_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(138, 'Gegesik Lor', 'gegesik_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(139, 'Gegesik Wetan', 'gegesik_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(140, 'Gegunung', 'gegunung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(141, 'Gembongan', 'gembongan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(142, 'Gembongan Mekar', 'gembongan_mekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(143, 'Gempol', 'gempol', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(144, 'Gesik', 'gesik', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(145, 'Getasan', 'getasan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(146, 'Getrakmoyan', 'getrakmoyan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(147, 'Geyongan', 'geyongan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(148, 'Gintung Kidul', 'gintung_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(149, 'Gintung Lor', 'gintung_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(150, 'Gintung Tengah', 'gintung_tengah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(151, 'Gintungranjeng', 'gintungranjeng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(152, 'Girinata', 'girinata', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(153, 'Gombang', 'gombang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(154, 'Greged', 'greged', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(155, 'Grogol  Gunungjati', 'grogol_gunungjati', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(156, 'Grogol  Kapetakan', 'grogol_kapetakan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(157, 'Gujeg', 'gujeg', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(158, 'Gumulung Lebak', 'gumulung_lebak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(159, 'Gumulung Tonggoh', 'gumulung_tonggoh', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(160, 'Gunungsari', 'gunungsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(161, 'Guwa Kidul', 'guwa_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(162, 'Guwa Lor', 'guwa_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(163, 'Halimpu', 'halimpu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(164, 'Hulubanteng', 'hulubanteng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(165, 'Hulubanteng Lor', 'hulubanteng_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(166, 'Jadimulya', 'jadimulya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(167, 'Jagapura Kidul', 'jagapura_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(168, 'Jagapura Kulon', 'jagapura_kulon', '938a6ca01ed777209245c493a4ab7bbc272756fa', 'user'),
(169, 'Jagapura Lor', 'jagapura_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(170, 'Jagapura Wetan', 'jagapura_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(171, 'Jamblang', 'jamblang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(172, 'Japura Kidul', 'japura_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(173, 'Japura Lor', 'japura_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(174, 'Japura Bakti', 'japura_bakti', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(175, 'Jatianom', 'jatianom', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(176, 'Jatimerta', 'jatimerta', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(177, 'Jatipancur', 'jatipancur', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(178, 'Jatipiring', 'jatipiring', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(179, 'Jatipura', 'jatipura', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(180, 'Jatirenggang', 'jatirenggang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(181, 'Jatiseeng', 'jatiseeng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(182, 'Jatiseeng Kidul', 'jatiseeng_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(183, 'Jemaras Kidul', 'jemaras_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(184, 'Jemaras Lor', 'jemaras_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(185, 'Jungjang', 'jungjang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(186, 'Jungjang Wetan', 'jungjang_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(187, 'Kalianyar', 'kalianyar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(188, 'Kalibaru', 'kalibaru', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(189, 'Kalibuntu', 'kalibuntu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(190, 'Kalideres', 'kalideres', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(191, 'Kaligawe', 'kaligawe', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(192, 'Kaligawe Wetan', 'kaligawe_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(193, 'Kalikoa', 'kalikoa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(194, 'Kalimoro', 'kalimoro', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(195, 'Kalimeang', 'kalimeang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(196, 'Kalimekar', 'kalimekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(197, 'Kalimukti', 'kalimukti', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(198, 'Kalipasung', 'kalipasung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(199, 'Kalirahayu', 'kalirahayu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(200, 'Kalisapu', 'kalisapu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(201, 'Kalisari', 'kalisari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(202, 'Kalitengah', 'kalitengah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(203, 'Kaliwadas', 'kaliwadas', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(204, 'Kaliwedi Kidul', 'kaliwedi_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(205, 'Kaliwedi Lor', 'kaliwedi_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(206, 'Kaliwulu', 'kaliwulu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(207, 'Kamarang', 'kamarang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(208, 'Kamarang Lebak', 'kamarang_lebak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(209, 'Kanci', 'kanci', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(210, 'Kanci Kulon', 'kanci_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(211, 'Kapetakan', 'kapetakan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(212, 'Karanganyar Karangwareng', 'karanganyar_karangwareng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(213, 'Karanganyar Panguragan', 'karanganyar_panguragan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(214, 'Karangasem Karangwareng', 'karangasem_karangwareng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(215, 'Karangasem Plumbon', 'karangasem_plumbon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(216, 'Karangkendal', 'karangkendal', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(217, 'Karangmalang', 'karangmalang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(218, 'Karangamangu', 'karangamangu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(219, 'Karangmekar', 'karangmekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(220, 'Karangmulya', 'karangmulya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(221, 'Karangreja', 'karangreja', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(222, 'Karangsambung', 'karangsambung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(223, 'Karangsari Waled', 'karangsari_waled', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(224, 'Karangsari Weru', 'karangsari_weru', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(225, 'Karangsembung', 'karangsembung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(226, 'Karangsuwung', 'karangsuwung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(227, 'Karangtengah', 'karangtengah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(228, 'Karangwangi Karangwareng', 'karangwangi_karangwareng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(229, 'Karangwangi Depok', 'karangwangi_depok', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(230, 'Karangwareng', 'karangwareng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(231, 'Karangwangun', 'karangwangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(232, 'Karangwuni', 'karangwuni', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(233, 'Kasugengan Kidul', 'kasugengan_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(234, 'Kasugengan Lor', 'kasugengan_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(235, 'Kebarepan', 'kebarepan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(236, 'Kebonturi', 'kebonturi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(237, 'Kecomberan', 'kecomberan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(238, 'Kedawung', 'kedawung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(239, 'Kedongdong', 'kedongdong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(240, 'Kedongdong Kidul', 'kedongdong_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(241, 'Keduanan', 'keduanan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(242, 'Kedungbunder', 'kedungbunder', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(243, 'Kedungdalem', 'kedungdalem', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(244, 'Kedungdawa', 'kedungdawa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(245, 'Kedungjaya', 'kedungjaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(246, 'Kedungsana', 'kedungsana', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(247, 'Kejiwan', 'kejiwan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(248, 'Kejuden', 'kejuden', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(249, 'Kemantren', 'kemantren', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(250, 'Kemlakagede', 'kemlakagede', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(251, 'Kempek', 'kempek', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(252, 'Kenanga', 'kenanga', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(253, 'Kendal', 'kendal', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(254, 'Kepongpongan', 'kepongpongan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(255, 'Kepuh', 'kepuh', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(256, 'Kepunduan', 'kepunduan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(257, 'Kerandon', 'kerandon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(258, 'Keraton', 'keraton', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(259, 'Kertasari', 'kertasari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(260, 'Kertasura', 'kertasura', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(261, 'Kertawangun', 'kertawangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(262, 'Kertawinangun', 'kertawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(263, 'Klangenan', 'klangenan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(264, 'Klayan', 'klayan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(265, 'Kondangsari', 'kondangsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(266, 'Kreyo', 'kreyo', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(267, 'Kroya', 'kroya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(268, 'Kubang', 'kubang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(269, 'Kubangdeleg', 'kubangdeleg', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(270, 'Kubangkarang', 'kubangkarang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(271, 'Kudukeras', 'kudukeras', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(272, 'Kudumulya', 'kudumulya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(273, 'Lebakmekar', 'lebakmekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(274, 'Lemahabang', 'lemahabang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(275, 'Lemahabang Kulon', 'lemahabang_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(276, 'Lemahtamba', 'lemahtamba', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(277, 'Leuweunggajah', 'leuweunggajah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(278, 'Leuwidingding', 'leuwidingding', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(279, 'Losari Kidul', 'losari_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(280, 'Losari Lor', 'losari_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(281, 'Lungbenda', 'lungbenda', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(282, 'Lurah', 'lurah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(283, 'Luwung', 'luwung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(284, 'Luwung Kencana', 'luwung_kencana', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(285, 'Mandala', 'mandala', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(286, 'Marikangen', 'marikangen', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(287, 'Matangaji', 'matangaji', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(288, 'Mayung', 'mayung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(289, 'Megucilik', 'megucilik', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(290, 'Megugede', 'megugede', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(291, 'Mekarsari', 'mekarsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(292, 'Melakasari', 'melakasari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(293, 'Mertapada Kulon', 'mertapada_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(294, 'Mertapada Wetan', 'mertapada_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(295, 'Mertasinga', 'mertasinga', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(296, 'Muara', 'muara', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(297, 'Mulyasari', 'mulyasari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(298, 'Mundumesigit', 'mundumesigit', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(299, 'Mundupesisir', 'mundupesisir', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(300, 'Munjul', 'munjul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(301, 'Nanggela', 'nanggela', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(302, 'Orimalang', 'orimalang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(303, 'Pabedilan Kaler', 'pabedilan_kaler', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(304, 'Pabedilan Kidul', 'pabedilan_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(305, 'Pabedilan Kulon', 'pabedilan_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(306, 'Pabedilan Wetan', 'pabedilan_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(307, 'Pabuaran Kidul', 'pabuaran_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(308, 'Pabuaran Lor', 'pabuaran_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(309, 'Pabuaran Wetan', 'pabuaran_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(310, 'Pakusamben', 'pakusamben', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(311, 'Palimanan Barat', 'palimanan_barat', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(312, 'Palimanan Timur', 'palimanan_timur', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(313, 'Palir', 'palir', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(314, 'Pamengkang', 'pamengkang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(315, 'Pamijahan', 'pamijahan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(316, 'Penambangan', 'penambangan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(317, 'Panembahan', 'panembahan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(318, 'Pangenan', 'pangenan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(319, 'Panggangsari', 'panggangsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(320, 'Pangkalan', 'pangkalan', '6df73cc169278dd6daab5fe7d6cacb1fed537131', 'user'),
(321, 'Pangurangan', 'pangurangan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(322, 'Pangurangan Kulon', 'pangurangan_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(323, 'Pangurangan Lor', 'pangurangan_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(324, 'Pangurangan Wetan', 'pangurangan_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(325, 'Panongan Sedong', 'panongan_sedong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(326, 'Panongan Palimanan', 'panongan_palimanan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(327, 'Panongan Lor', 'panongan_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(328, 'Panunggul', 'panunggul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(329, 'Pasalakan', 'pasalakan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(330, 'Pasaleman', 'pasaleman', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(331, 'Pasanggrahan', 'pasanggrahan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(332, 'Pasawahan', 'pasawahan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(333, 'Pasindangan', 'pasindangan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(334, 'Pasuruan', 'pasuruan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(335, 'Patapan', 'patapan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(336, 'Pegagan', 'pegagan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(337, 'Pegagan Kidul', 'pegagan_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(338, 'Pegaan Lor', 'pegaan_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(339, 'Pejambon', 'pejambon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(340, 'Pakantingan', 'pakantingan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(341, 'Pelayangan', 'pelayangan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(342, 'Pengarengan', 'pengarengan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(343, 'Penpen', 'penpen', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(344, 'Perbutulan', 'perbutulan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(345, 'Picungpugur', 'picungpugur', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(346, 'Pilangsari', 'pilangsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(347, 'Plumbon', 'plumbon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(348, 'Prajawinangun Kulon', 'prajawinangun_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(349, 'Prajawinangun Wetan', 'prajawinangun_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(350, 'Purbawinangun', 'purbawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(351, 'Purwawinangun', 'purwawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(352, 'Putat', 'putat', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(353, 'Rawagatel', 'rawagatel', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(354, 'Rawaurip', 'rawaurip', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(355, 'Sambeng', 'sambeng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(356, 'Sampih', 'sampih', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(357, 'Sampiran', 'sampiran', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(358, 'Sarabau', 'sarabau', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(359, 'Sarajaya', 'sarajaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(360, 'Sarwadadi', 'sarwadadi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(361, 'Sedong Kidul', 'sedong_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(362, 'Sedong Lor', 'sedong_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(363, 'Semplo', 'semplo', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(364, 'Sendang', 'sendang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(365, 'Sende', 'sende', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(366, 'Serang', 'serang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(367, 'Serang Kulon', 'serang_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(368, 'Serang Wetan', 'serang_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(369, 'Setu Kulon', 'setu_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(370, 'Setu Wetan', 'setu_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(371, 'Setupatok', 'setupatok', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(372, 'Seuseupan', 'seuseupan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(373, 'Sibubut', 'sibubut', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(374, 'Sidamulya', 'sidamulya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(375, 'Sidaresmi', 'sidaresmi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(376, 'Sidawangi', 'sidawangi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(377, 'Sigong', 'sigong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(378, 'Silih Asih', 'silih_asih', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(379, 'Sinar Rancang', 'sinar_rancang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(380, 'Sindang Kempeng', 'sindang_kempeng', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(381, 'Sindanghayu', 'sindanghayu', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(382, 'Sindangjawa', 'sindangjawa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(383, 'Sindangkasih', 'sindangkasih', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(384, 'Sindanglaut', 'sindanglaut', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(385, 'Sindangmekar', 'sindangmekar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(386, 'Sirnabaya', 'sirnabaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(387, 'Sitiwinangun', 'sitiwinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(388, 'Slangit', 'slangit', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(389, 'Slendra', 'slendra', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(390, 'Suci', 'suci', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(391, 'Sukadana', 'sukadana', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(392, 'Sumber', 'sumber', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(393, 'Sumber Kidul', 'sumber_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(394, 'Sumber Lor', 'sumber_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(395, 'Sumurkondang', 'sumurkondang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(396, 'Surakarta', 'surakarta', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(397, 'Suranenggala', 'suranenggala', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(398, 'Suranenggala Kidul', 'suranenggala_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(399, 'Suranenggala Kulon', 'suranenggala_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(400, 'Suranenggala Lor', 'suranenggala_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(401, 'Susukan', 'susukan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(402, 'Susukan Agung', 'susukan_agung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(403, 'Susukan Lebak', 'susukan_lebak', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(404, 'Susukan Tonggoh', 'susukan_tonggoh', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(405, 'Sutawinangun', 'sutawinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(406, 'Tambelang', 'tambelang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(407, 'Tangkil', 'tangkil', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(408, 'Tanjunganom', 'tanjunganom', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(409, 'Tawangsari', 'tawangsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(410, 'Tegalgubug', 'tegalgubug', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(411, 'Tegal Gubug Lor', 'tegal_gubug_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(412, 'Tegalkarang', 'tegalkarang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(413, 'Tegalsari', 'tegalsari', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(414, 'Tegalwangi', 'tegalwangi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(415, 'Tenjomaya', 'tenjomaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(416, 'Tersana', 'tersana', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(417, 'Tonjong', 'tonjong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(418, 'Trusmi Kulon', 'trusmi_kulon', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(419, 'Trusmi Wetan', 'trusmi_wetan', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(420, 'Tuk', 'tuk', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(421, 'Tuk Karangsuwung', 'tuk_karangsuwung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(422, 'Tukmudal', 'tukmudal', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(423, 'Ujunggebang', 'ujunggebang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(424, 'Ujungsemi', 'ujungsemi', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(425, 'Walahar', 'walahar', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(426, 'Waled Asem', 'waled_asem', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(427, 'Waled Desa', 'waled_desa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(428, 'Waled Kota', 'waled_kota', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(429, 'Wanakaya', 'wanakaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(430, 'Wanasaba Kidul', 'wanasaba_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(431, 'Wanasaba Lor', 'wanasaba_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(432, 'Wanayasa', 'wanayasa', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(433, 'Wangkelang', 'wangkelang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(434, 'Wangunharja', 'wangunharja', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(435, 'Wargabinangun', 'wargabinangun', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(436, 'Waruduwur', 'waruduwur', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(437, 'Warugede', 'warugede', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(438, 'Warujaya', 'warujaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(439, 'Warukawung', 'warukawung', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(440, 'Waruroyom', 'waruroyom', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(441, 'Watubelah', 'watubelah', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(442, 'weru_kidul', 'weru_kidul', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(443, 'Weru Lor', 'weru_lor', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(444, 'Wilulang', 'wilulang', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(445, 'Winduhaji', 'winduhaji', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(446, 'Windujaya', 'windujaya', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(447, 'Winong', 'winong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(448, 'Wiyong', 'wiyong', '7c222fb2927d828af22f592134e8932480637c0d', 'user'),
(449, 'Wotgali', 'wotgali', '7c222fb2927d828af22f592134e8932480637c0d', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `desa_id` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_apotek`
--
ALTER TABLE `tb_apotek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_badan_permusyawaratan_desa`
--
ALTER TABLE `tb_badan_permusyawaratan_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_badan_usaha_aset_desa`
--
ALTER TABLE `tb_badan_usaha_aset_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_balai_desa`
--
ALTER TABLE `tb_balai_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_bank_operasi`
--
ALTER TABLE `tb_bank_operasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_banyaknya_dusun_rt_rw`
--
ALTER TABLE `tb_banyaknya_dusun_rt_rw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_batas_desa`
--
ALTER TABLE `tb_batas_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_bencana_alam`
--
ALTER TABLE `tb_bencana_alam`
  ADD PRIMARY KEY (`id_bencana_alam`),
  ADD KEY `fk_bencana_alam_user_id` (`user_id`),
  ADD KEY `fk_bencana_alam_desa_id` (`desa_id`);

--
-- Indexes for table `tb_bumdes`
--
ALTER TABLE `tb_bumdes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_daftar_posyandu`
--
ALTER TABLE `tb_daftar_posyandu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_data_pkk`
--
ALTER TABLE `tb_data_pkk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_disabilitas`
--
ALTER TABLE `tb_disabilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `desa_id` (`desa_id`);

--
-- Indexes for table `tb_embung_mata_air`
--
ALTER TABLE `tb_embung_mata_air`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_enumerator`
--
ALTER TABLE `tb_enumerator`
  ADD PRIMARY KEY (`id_desa`),
  ADD UNIQUE KEY `idx_desa_id_unique` (`id_desa`),
  ADD KEY `fk_tb_desa_user_id` (`user_id`);

--
-- Indexes for table `tb_fasilitas_olahraga`
--
ALTER TABLE `tb_fasilitas_olahraga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_idm_status`
--
ALTER TABLE `tb_idm_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_internet_transportasi`
--
ALTER TABLE `tb_internet_transportasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_jarak_kantor_desa`
--
ALTER TABLE `tb_jarak_kantor_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_kader_pembangunan_manusia`
--
ALTER TABLE `tb_kader_pembangunan_manusia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_karang_taruna`
--
ALTER TABLE `tb_karang_taruna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keamanan_lingkungan`
--
ALTER TABLE `tb_keamanan_lingkungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_bidan`
--
ALTER TABLE `tb_keberadaan_bidan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keberadaan_bidan_user_id` (`user_id`),
  ADD KEY `fk_keberadaan_bidan_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_danau`
--
ALTER TABLE `tb_keberadaan_danau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_dukun_bayi`
--
ALTER TABLE `tb_keberadaan_dukun_bayi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dukun_bayi_user_id` (`user_id`),
  ADD KEY `fk_dukun_bayi_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_kantor_pos`
--
ALTER TABLE `tb_keberadaan_kantor_pos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_pemukiman_bantaran`
--
ALTER TABLE `tb_keberadaan_pemukiman_bantaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_pos_polisi`
--
ALTER TABLE `tb_keberadaan_pos_polisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_keberadaan_sungai`
--
ALTER TABLE `tb_keberadaan_sungai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_kematian`
--
ALTER TABLE `tb_kematian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_kepala_desa`
--
ALTER TABLE `tb_kepala_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_kepemilikan_kantor`
--
ALTER TABLE `tb_kepemilikan_kantor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_kerjasama_desa`
--
ALTER TABLE `tb_kerjasama_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ketenagakerjaan`
--
ALTER TABLE `tb_ketenagakerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ketersediaan_batas_peta`
--
ALTER TABLE `tb_ketersediaan_batas_peta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ketersediaan_internet`
--
ALTER TABLE `tb_ketersediaan_internet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ketersediaan_penetapan_peta_desa`
--
ALTER TABLE `tb_ketersediaan_penetapan_peta_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ketersediaan_rpjmdes_rkpdes`
--
ALTER TABLE `tb_ketersediaan_rpjmdes_rkpdes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_klb_wabah`
--
ALTER TABLE `tb_klb_wabah`
  ADD PRIMARY KEY (`id_klb`),
  ADD KEY `fk_klb_user_id` (`user_id`),
  ADD KEY `fk_klb_desa_id` (`desa_id`);

--
-- Indexes for table `tb_koperasi`
--
ALTER TABLE `tb_koperasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_linmas_poskamling`
--
ALTER TABLE `tb_linmas_poskamling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_lokasi_penggalian`
--
ALTER TABLE `tb_lokasi_penggalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_lpmd`
--
ALTER TABLE `tb_lpmd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_luas_wilayah_desa`
--
ALTER TABLE `tb_luas_wilayah_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_menara_telepon`
--
ALTER TABLE `tb_menara_telepon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pangkalan_minyak`
--
ALTER TABLE `tb_pangkalan_minyak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pemanfaatan_sistem`
--
ALTER TABLE `tb_pemanfaatan_sistem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pendamping_lokal_desa`
--
ALTER TABLE `tb_pendamping_lokal_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_penduduk_dan_keluarga`
--
ALTER TABLE `tb_penduduk_dan_keluarga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_penerangan_jalan`
--
ALTER TABLE `tb_penerangan_jalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_penerima_bantuan_sosial`
--
ALTER TABLE `tb_penerima_bantuan_sosial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pengadaan_barang_jasa`
--
ALTER TABLE `tb_pengadaan_barang_jasa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pengelolaan_sampah`
--
ALTER TABLE `tb_pengelolaan_sampah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pengguna_listrik_lampu_surya`
--
ALTER TABLE `tb_pengguna_listrik_lampu_surya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_perangkat_desa`
--
ALTER TABLE `tb_perangkat_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_perangkat_desa_pendidikan`
--
ALTER TABLE `tb_perangkat_desa_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_peraturan_desa`
--
ALTER TABLE `tb_peraturan_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_peringatan_bencana`
--
ALTER TABLE `tb_peringatan_bencana`
  ADD PRIMARY KEY (`id_peringatan`),
  ADD KEY `fk_peringatan_user_id` (`user_id`),
  ADD KEY `fk_peringatan_desa_id` (`desa_id`);

--
-- Indexes for table `tb_perkelahian_massal`
--
ALTER TABLE `tb_perkelahian_massal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_permukiman_kumuh`
--
ALTER TABLE `tb_permukiman_kumuh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_poliklinik`
--
ALTER TABLE `tb_poliklinik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_polindes`
--
ALTER TABLE `tb_polindes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pondok_pesantren`
--
ALTER TABLE `tb_pondok_pesantren`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_poskesdes`
--
ALTER TABLE `tb_poskesdes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_posyandu`
--
ALTER TABLE `tb_posyandu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_potensi_wisata`
--
ALTER TABLE `tb_potensi_wisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_praktek_bidan`
--
ALTER TABLE `tb_praktek_bidan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_praktek_dokter`
--
ALTER TABLE `tb_praktek_dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_prasarana_kebersihan`
--
ALTER TABLE `tb_prasarana_kebersihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_prasarana_transportasi`
--
ALTER TABLE `tb_prasarana_transportasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_produk_unggulan`
--
ALTER TABLE `tb_produk_unggulan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_puskesmas`
--
ALTER TABLE `tb_puskesmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_pustu`
--
ALTER TABLE `tb_pustu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_realisasi_anggaran_belanja_desa`
--
ALTER TABLE `tb_realisasi_anggaran_belanja_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_realisasi_anggaran_desa`
--
ALTER TABLE `tb_realisasi_anggaran_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_ruang_publik`
--
ALTER TABLE `tb_ruang_publik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `desa_id` (`desa_id`);

--
-- Indexes for table `tb_rumah_sakit`
--
ALTER TABLE `tb_rumah_sakit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_rumah_tidak_layak_huni`
--
ALTER TABLE `tb_rumah_tidak_layak_huni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sarana_ekonomi`
--
ALTER TABLE `tb_sarana_ekonomi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sarana_prasarana`
--
ALTER TABLE `tb_sarana_prasarana`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sekolah`
--
ALTER TABLE `tb_sekolah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sentra_industri`
--
ALTER TABLE `tb_sentra_industri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sktm`
--
ALTER TABLE `tb_sktm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sk_pembentukan`
--
ALTER TABLE `tb_sk_pembentukan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_status_pemerintahan`
--
ALTER TABLE `tb_status_pemerintahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_sutet`
--
ALTER TABLE `tb_sutet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_taman_bacaan`
--
ALTER TABLE `tb_taman_bacaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbm_user_id` (`user_id`),
  ADD KEY `fk_tbm_desa_id` (`desa_id`);

--
-- Indexes for table `tb_tanah_kas_desa`
--
ALTER TABLE `tb_tanah_kas_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_tempat_ibadah`
--
ALTER TABLE `tb_tempat_ibadah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tempat_ibadah_user_id` (`user_id`),
  ADD KEY `fk_tempat_ibadah_desa_id` (`desa_id`);

--
-- Indexes for table `tb_tempat_peribadatan`
--
ALTER TABLE `tb_tempat_peribadatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_titik_koordinat_kantor_desa`
--
ALTER TABLE `tb_titik_koordinat_kantor_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_topografi_terluas_wilayah_desa`
--
ALTER TABLE `tb_topografi_terluas_wilayah_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `tb_website_medsos`
--
ALTER TABLE `tb_website_medsos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_desa_id` (`desa_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_desa_id_new` (`desa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8974;

--
-- AUTO_INCREMENT for table `tahun`
--
ALTER TABLE `tahun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_apotek`
--
ALTER TABLE `tb_apotek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_badan_permusyawaratan_desa`
--
ALTER TABLE `tb_badan_permusyawaratan_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_badan_usaha_aset_desa`
--
ALTER TABLE `tb_badan_usaha_aset_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_balai_desa`
--
ALTER TABLE `tb_balai_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_bank_operasi`
--
ALTER TABLE `tb_bank_operasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_banyaknya_dusun_rt_rw`
--
ALTER TABLE `tb_banyaknya_dusun_rt_rw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_batas_desa`
--
ALTER TABLE `tb_batas_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_bencana_alam`
--
ALTER TABLE `tb_bencana_alam`
  MODIFY `id_bencana_alam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_bumdes`
--
ALTER TABLE `tb_bumdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_daftar_posyandu`
--
ALTER TABLE `tb_daftar_posyandu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_data_pkk`
--
ALTER TABLE `tb_data_pkk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_disabilitas`
--
ALTER TABLE `tb_disabilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_embung_mata_air`
--
ALTER TABLE `tb_embung_mata_air`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_enumerator`
--
ALTER TABLE `tb_enumerator`
  MODIFY `id_desa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_fasilitas_olahraga`
--
ALTER TABLE `tb_fasilitas_olahraga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_idm_status`
--
ALTER TABLE `tb_idm_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_internet_transportasi`
--
ALTER TABLE `tb_internet_transportasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jarak_kantor_desa`
--
ALTER TABLE `tb_jarak_kantor_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_kader_pembangunan_manusia`
--
ALTER TABLE `tb_kader_pembangunan_manusia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_karang_taruna`
--
ALTER TABLE `tb_karang_taruna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keamanan_lingkungan`
--
ALTER TABLE `tb_keamanan_lingkungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keberadaan_bidan`
--
ALTER TABLE `tb_keberadaan_bidan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_keberadaan_danau`
--
ALTER TABLE `tb_keberadaan_danau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keberadaan_dukun_bayi`
--
ALTER TABLE `tb_keberadaan_dukun_bayi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_keberadaan_kantor_pos`
--
ALTER TABLE `tb_keberadaan_kantor_pos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keberadaan_pemukiman_bantaran`
--
ALTER TABLE `tb_keberadaan_pemukiman_bantaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keberadaan_pos_polisi`
--
ALTER TABLE `tb_keberadaan_pos_polisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keberadaan_sungai`
--
ALTER TABLE `tb_keberadaan_sungai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kematian`
--
ALTER TABLE `tb_kematian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kepala_desa`
--
ALTER TABLE `tb_kepala_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kepemilikan_kantor`
--
ALTER TABLE `tb_kepemilikan_kantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kerjasama_desa`
--
ALTER TABLE `tb_kerjasama_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_ketenagakerjaan`
--
ALTER TABLE `tb_ketenagakerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_ketersediaan_batas_peta`
--
ALTER TABLE `tb_ketersediaan_batas_peta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_ketersediaan_internet`
--
ALTER TABLE `tb_ketersediaan_internet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_ketersediaan_penetapan_peta_desa`
--
ALTER TABLE `tb_ketersediaan_penetapan_peta_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_ketersediaan_rpjmdes_rkpdes`
--
ALTER TABLE `tb_ketersediaan_rpjmdes_rkpdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_klb_wabah`
--
ALTER TABLE `tb_klb_wabah`
  MODIFY `id_klb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_koperasi`
--
ALTER TABLE `tb_koperasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_linmas_poskamling`
--
ALTER TABLE `tb_linmas_poskamling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_lokasi_penggalian`
--
ALTER TABLE `tb_lokasi_penggalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_lpmd`
--
ALTER TABLE `tb_lpmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_luas_wilayah_desa`
--
ALTER TABLE `tb_luas_wilayah_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_menara_telepon`
--
ALTER TABLE `tb_menara_telepon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pangkalan_minyak`
--
ALTER TABLE `tb_pangkalan_minyak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pemanfaatan_sistem`
--
ALTER TABLE `tb_pemanfaatan_sistem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pendamping_lokal_desa`
--
ALTER TABLE `tb_pendamping_lokal_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_penduduk_dan_keluarga`
--
ALTER TABLE `tb_penduduk_dan_keluarga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_penerangan_jalan`
--
ALTER TABLE `tb_penerangan_jalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_penerima_bantuan_sosial`
--
ALTER TABLE `tb_penerima_bantuan_sosial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pengadaan_barang_jasa`
--
ALTER TABLE `tb_pengadaan_barang_jasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pengelolaan_sampah`
--
ALTER TABLE `tb_pengelolaan_sampah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pengguna_listrik_lampu_surya`
--
ALTER TABLE `tb_pengguna_listrik_lampu_surya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_perangkat_desa`
--
ALTER TABLE `tb_perangkat_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_perangkat_desa_pendidikan`
--
ALTER TABLE `tb_perangkat_desa_pendidikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_peraturan_desa`
--
ALTER TABLE `tb_peraturan_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_peringatan_bencana`
--
ALTER TABLE `tb_peringatan_bencana`
  MODIFY `id_peringatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_perkelahian_massal`
--
ALTER TABLE `tb_perkelahian_massal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_permukiman_kumuh`
--
ALTER TABLE `tb_permukiman_kumuh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_poliklinik`
--
ALTER TABLE `tb_poliklinik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_polindes`
--
ALTER TABLE `tb_polindes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pondok_pesantren`
--
ALTER TABLE `tb_pondok_pesantren`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_poskesdes`
--
ALTER TABLE `tb_poskesdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_posyandu`
--
ALTER TABLE `tb_posyandu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_potensi_wisata`
--
ALTER TABLE `tb_potensi_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_praktek_bidan`
--
ALTER TABLE `tb_praktek_bidan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_praktek_dokter`
--
ALTER TABLE `tb_praktek_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_prasarana_kebersihan`
--
ALTER TABLE `tb_prasarana_kebersihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_prasarana_transportasi`
--
ALTER TABLE `tb_prasarana_transportasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_produk_unggulan`
--
ALTER TABLE `tb_produk_unggulan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_puskesmas`
--
ALTER TABLE `tb_puskesmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pustu`
--
ALTER TABLE `tb_pustu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_realisasi_anggaran_belanja_desa`
--
ALTER TABLE `tb_realisasi_anggaran_belanja_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_realisasi_anggaran_desa`
--
ALTER TABLE `tb_realisasi_anggaran_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_ruang_publik`
--
ALTER TABLE `tb_ruang_publik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_rumah_sakit`
--
ALTER TABLE `tb_rumah_sakit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_rumah_tidak_layak_huni`
--
ALTER TABLE `tb_rumah_tidak_layak_huni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_sarana_ekonomi`
--
ALTER TABLE `tb_sarana_ekonomi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_sarana_prasarana`
--
ALTER TABLE `tb_sarana_prasarana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_sekolah`
--
ALTER TABLE `tb_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_sentra_industri`
--
ALTER TABLE `tb_sentra_industri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_sktm`
--
ALTER TABLE `tb_sktm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_sk_pembentukan`
--
ALTER TABLE `tb_sk_pembentukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_status_pemerintahan`
--
ALTER TABLE `tb_status_pemerintahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_sutet`
--
ALTER TABLE `tb_sutet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_taman_bacaan`
--
ALTER TABLE `tb_taman_bacaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_tanah_kas_desa`
--
ALTER TABLE `tb_tanah_kas_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_tempat_ibadah`
--
ALTER TABLE `tb_tempat_ibadah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_tempat_peribadatan`
--
ALTER TABLE `tb_tempat_peribadatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_titik_koordinat_kantor_desa`
--
ALTER TABLE `tb_titik_koordinat_kantor_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_topografi_terluas_wilayah_desa`
--
ALTER TABLE `tb_topografi_terluas_wilayah_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_website_medsos`
--
ALTER TABLE `tb_website_medsos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_apotek`
--
ALTER TABLE `tb_apotek`
  ADD CONSTRAINT `fk_tb_apotek_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_apotek_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_badan_permusyawaratan_desa`
--
ALTER TABLE `tb_badan_permusyawaratan_desa`
  ADD CONSTRAINT `fk_tb_badan_permusyawaratan_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_badan_permusyawaratan_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_badan_usaha_aset_desa`
--
ALTER TABLE `tb_badan_usaha_aset_desa`
  ADD CONSTRAINT `fk_tb_badan_usaha_aset_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_badan_usaha_aset_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_balai_desa`
--
ALTER TABLE `tb_balai_desa`
  ADD CONSTRAINT `fk_tb_balai_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_balai_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_bank_operasi`
--
ALTER TABLE `tb_bank_operasi`
  ADD CONSTRAINT `fk_tb_bank_operasi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_bank_operasi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_banyaknya_dusun_rt_rw`
--
ALTER TABLE `tb_banyaknya_dusun_rt_rw`
  ADD CONSTRAINT `fk_tb_banyaknya_dusun_rt_rw_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_banyaknya_dusun_rt_rw_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_batas_desa`
--
ALTER TABLE `tb_batas_desa`
  ADD CONSTRAINT `fk_tb_batas_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_batas_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_bencana_alam`
--
ALTER TABLE `tb_bencana_alam`
  ADD CONSTRAINT `fk_tb_bencana_alam_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_bencana_alam_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_bumdes`
--
ALTER TABLE `tb_bumdes`
  ADD CONSTRAINT `fk_tb_bumdes_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_bumdes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_daftar_posyandu`
--
ALTER TABLE `tb_daftar_posyandu`
  ADD CONSTRAINT `fk_tb_daftar_posyandu_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_daftar_posyandu_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_data_pkk`
--
ALTER TABLE `tb_data_pkk`
  ADD CONSTRAINT `fk_tb_data_pkk_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_data_pkk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_disabilitas`
--
ALTER TABLE `tb_disabilitas`
  ADD CONSTRAINT `tb_disabilitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tb_disabilitas_ibfk_2` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE;

--
-- Constraints for table `tb_embung_mata_air`
--
ALTER TABLE `tb_embung_mata_air`
  ADD CONSTRAINT `fk_tb_embung_mata_air_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_embung_mata_air_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_enumerator`
--
ALTER TABLE `tb_enumerator`
  ADD CONSTRAINT `fk_tb_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_fasilitas_olahraga`
--
ALTER TABLE `tb_fasilitas_olahraga`
  ADD CONSTRAINT `fk_tb_fasilitas_olahraga_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_fasilitas_olahraga_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_idm_status`
--
ALTER TABLE `tb_idm_status`
  ADD CONSTRAINT `fk_tb_idm_status_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_idm_status_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_internet_transportasi`
--
ALTER TABLE `tb_internet_transportasi`
  ADD CONSTRAINT `fk_tb_internet_transportasi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_internet_transportasi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_jarak_kantor_desa`
--
ALTER TABLE `tb_jarak_kantor_desa`
  ADD CONSTRAINT `fk_tb_jarak_kantor_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_jarak_kantor_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_kader_pembangunan_manusia`
--
ALTER TABLE `tb_kader_pembangunan_manusia`
  ADD CONSTRAINT `fk_tb_kader_pembangunan_manusia_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_kader_pembangunan_manusia_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_karang_taruna`
--
ALTER TABLE `tb_karang_taruna`
  ADD CONSTRAINT `fk_tb_karang_taruna_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_karang_taruna_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keamanan_lingkungan`
--
ALTER TABLE `tb_keamanan_lingkungan`
  ADD CONSTRAINT `fk_tb_keamanan_lingkungan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keamanan_lingkungan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_bidan`
--
ALTER TABLE `tb_keberadaan_bidan`
  ADD CONSTRAINT `fk_tb_keberadaan_bidan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_bidan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_danau`
--
ALTER TABLE `tb_keberadaan_danau`
  ADD CONSTRAINT `fk_tb_keberadaan_danau_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_danau_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_dukun_bayi`
--
ALTER TABLE `tb_keberadaan_dukun_bayi`
  ADD CONSTRAINT `fk_tb_keberadaan_dukun_bayi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_dukun_bayi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_kantor_pos`
--
ALTER TABLE `tb_keberadaan_kantor_pos`
  ADD CONSTRAINT `fk_tb_keberadaan_kantor_pos_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_kantor_pos_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_pemukiman_bantaran`
--
ALTER TABLE `tb_keberadaan_pemukiman_bantaran`
  ADD CONSTRAINT `fk_tb_keberadaan_pemukiman_bantaran_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_pemukiman_bantaran_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_pos_polisi`
--
ALTER TABLE `tb_keberadaan_pos_polisi`
  ADD CONSTRAINT `fk_tb_keberadaan_pos_polisi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_pos_polisi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_keberadaan_sungai`
--
ALTER TABLE `tb_keberadaan_sungai`
  ADD CONSTRAINT `fk_tb_keberadaan_sungai_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_keberadaan_sungai_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_kematian`
--
ALTER TABLE `tb_kematian`
  ADD CONSTRAINT `fk_tb_kematian_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_kematian_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_kepala_desa`
--
ALTER TABLE `tb_kepala_desa`
  ADD CONSTRAINT `fk_tb_kepala_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_kepala_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_kepemilikan_kantor`
--
ALTER TABLE `tb_kepemilikan_kantor`
  ADD CONSTRAINT `fk_tb_kepemilikan_kantor_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_kepemilikan_kantor_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_kerjasama_desa`
--
ALTER TABLE `tb_kerjasama_desa`
  ADD CONSTRAINT `fk_tb_kerjasama_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_kerjasama_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ketenagakerjaan`
--
ALTER TABLE `tb_ketenagakerjaan`
  ADD CONSTRAINT `fk_tb_ketenagakerjaan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_ketenagakerjaan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ketersediaan_batas_peta`
--
ALTER TABLE `tb_ketersediaan_batas_peta`
  ADD CONSTRAINT `fk_tb_ketersediaan_batas_peta_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_ketersediaan_batas_peta_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ketersediaan_internet`
--
ALTER TABLE `tb_ketersediaan_internet`
  ADD CONSTRAINT `fk_tb_ketersediaan_internet_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_ketersediaan_internet_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ketersediaan_penetapan_peta_desa`
--
ALTER TABLE `tb_ketersediaan_penetapan_peta_desa`
  ADD CONSTRAINT `fk_tb_ketersediaan_penetapan_peta_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_ketersediaan_penetapan_peta_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ketersediaan_rpjmdes_rkpdes`
--
ALTER TABLE `tb_ketersediaan_rpjmdes_rkpdes`
  ADD CONSTRAINT `fk_tb_ketersediaan_rpjmdes_rkpdes_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_ketersediaan_rpjmdes_rkpdes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_klb_wabah`
--
ALTER TABLE `tb_klb_wabah`
  ADD CONSTRAINT `fk_tb_klb_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_klb_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_koperasi`
--
ALTER TABLE `tb_koperasi`
  ADD CONSTRAINT `fk_tb_koperasi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_koperasi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_linmas_poskamling`
--
ALTER TABLE `tb_linmas_poskamling`
  ADD CONSTRAINT `fk_tb_linmas_poskamling_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_linmas_poskamling_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_lokasi_penggalian`
--
ALTER TABLE `tb_lokasi_penggalian`
  ADD CONSTRAINT `fk_tb_lokasi_penggalian_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_lokasi_penggalian_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_lpmd`
--
ALTER TABLE `tb_lpmd`
  ADD CONSTRAINT `fk_tb_lpmd_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_lpmd_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_luas_wilayah_desa`
--
ALTER TABLE `tb_luas_wilayah_desa`
  ADD CONSTRAINT `fk_tb_luas_wilayah_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_luas_wilayah_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_menara_telepon`
--
ALTER TABLE `tb_menara_telepon`
  ADD CONSTRAINT `fk_tb_menara_telepon_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_menara_telepon_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pangkalan_minyak`
--
ALTER TABLE `tb_pangkalan_minyak`
  ADD CONSTRAINT `fk_tb_pangkalan_minyak_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pangkalan_minyak_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pemanfaatan_sistem`
--
ALTER TABLE `tb_pemanfaatan_sistem`
  ADD CONSTRAINT `fk_tb_pemanfaatan_sistem_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pemanfaatan_sistem_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pendamping_lokal_desa`
--
ALTER TABLE `tb_pendamping_lokal_desa`
  ADD CONSTRAINT `fk_tb_pendamping_lokal_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pendamping_lokal_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_penduduk_dan_keluarga`
--
ALTER TABLE `tb_penduduk_dan_keluarga`
  ADD CONSTRAINT `fk_tb_penduduk_dan_keluarga_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_penduduk_dan_keluarga_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_penerangan_jalan`
--
ALTER TABLE `tb_penerangan_jalan`
  ADD CONSTRAINT `fk_tb_penerangan_jalan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_penerangan_jalan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_penerima_bantuan_sosial`
--
ALTER TABLE `tb_penerima_bantuan_sosial`
  ADD CONSTRAINT `fk_tb_penerima_bantuan_sosial_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_penerima_bantuan_sosial_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pengadaan_barang_jasa`
--
ALTER TABLE `tb_pengadaan_barang_jasa`
  ADD CONSTRAINT `fk_tb_pengadaan_barang_jasa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pengadaan_barang_jasa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pengelolaan_sampah`
--
ALTER TABLE `tb_pengelolaan_sampah`
  ADD CONSTRAINT `fk_tb_pengelolaan_sampah_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pengelolaan_sampah_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pengguna_listrik_lampu_surya`
--
ALTER TABLE `tb_pengguna_listrik_lampu_surya`
  ADD CONSTRAINT `fk_tb_pengguna_listrik_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pengguna_listrik_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_perangkat_desa`
--
ALTER TABLE `tb_perangkat_desa`
  ADD CONSTRAINT `fk_tb_perangkat_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_perangkat_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_perangkat_desa_pendidikan`
--
ALTER TABLE `tb_perangkat_desa_pendidikan`
  ADD CONSTRAINT `fk_tb_perangkat_desa_pendidikan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_perangkat_desa_pendidikan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_peraturan_desa`
--
ALTER TABLE `tb_peraturan_desa`
  ADD CONSTRAINT `fk_tb_peraturan_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_peraturan_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_peringatan_bencana`
--
ALTER TABLE `tb_peringatan_bencana`
  ADD CONSTRAINT `fk_tb_peringatan_bencana_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_peringatan_bencana_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_perkelahian_massal`
--
ALTER TABLE `tb_perkelahian_massal`
  ADD CONSTRAINT `fk_tb_perkelahian_massal_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_perkelahian_massal_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_permukiman_kumuh`
--
ALTER TABLE `tb_permukiman_kumuh`
  ADD CONSTRAINT `fk_tb_permukiman_kumuh_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_permukiman_kumuh_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_poliklinik`
--
ALTER TABLE `tb_poliklinik`
  ADD CONSTRAINT `fk_tb_poliklinik_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_poliklinik_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_polindes`
--
ALTER TABLE `tb_polindes`
  ADD CONSTRAINT `fk_tb_polindes_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_polindes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pondok_pesantren`
--
ALTER TABLE `tb_pondok_pesantren`
  ADD CONSTRAINT `fk_tb_pesantren_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pesantren_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_poskesdes`
--
ALTER TABLE `tb_poskesdes`
  ADD CONSTRAINT `fk_tb_poskesdes_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_poskesdes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_posyandu`
--
ALTER TABLE `tb_posyandu`
  ADD CONSTRAINT `fk_tb_posyandu_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_posyandu_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_potensi_wisata`
--
ALTER TABLE `tb_potensi_wisata`
  ADD CONSTRAINT `fk_tb_potensi_wisata_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_potensi_wisata_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_praktek_bidan`
--
ALTER TABLE `tb_praktek_bidan`
  ADD CONSTRAINT `fk_tb_praktek_bidan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_praktek_bidan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_praktek_dokter`
--
ALTER TABLE `tb_praktek_dokter`
  ADD CONSTRAINT `fk_tb_praktek_dokter_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_praktek_dokter_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_prasarana_kebersihan`
--
ALTER TABLE `tb_prasarana_kebersihan`
  ADD CONSTRAINT `fk_tb_prasarana_kebersihan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_prasarana_kebersihan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_prasarana_transportasi`
--
ALTER TABLE `tb_prasarana_transportasi`
  ADD CONSTRAINT `fk_tb_prasarana_transportasi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_prasarana_transportasi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_produk_unggulan`
--
ALTER TABLE `tb_produk_unggulan`
  ADD CONSTRAINT `fk_tb_produk_unggulan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_produk_unggulan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_puskesmas`
--
ALTER TABLE `tb_puskesmas`
  ADD CONSTRAINT `fk_tb_puskesmas_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_puskesmas_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pustu`
--
ALTER TABLE `tb_pustu`
  ADD CONSTRAINT `fk_tb_pustu_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_pustu_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_realisasi_anggaran_belanja_desa`
--
ALTER TABLE `tb_realisasi_anggaran_belanja_desa`
  ADD CONSTRAINT `fk_tb_realisasi_anggaran_belanja_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_realisasi_anggaran_belanja_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_realisasi_anggaran_desa`
--
ALTER TABLE `tb_realisasi_anggaran_desa`
  ADD CONSTRAINT `fk_tb_realisasi_anggaran_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_realisasi_anggaran_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_ruang_publik`
--
ALTER TABLE `tb_ruang_publik`
  ADD CONSTRAINT `tb_ruang_publik_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tb_ruang_publik_ibfk_2` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE;

--
-- Constraints for table `tb_rumah_sakit`
--
ALTER TABLE `tb_rumah_sakit`
  ADD CONSTRAINT `fk_tb_rumah_sakit_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_rumah_sakit_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_rumah_tidak_layak_huni`
--
ALTER TABLE `tb_rumah_tidak_layak_huni`
  ADD CONSTRAINT `fk_tb_rumah_tidak_layak_huni_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_rumah_tidak_layak_huni_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sarana_ekonomi`
--
ALTER TABLE `tb_sarana_ekonomi`
  ADD CONSTRAINT `fk_tb_sarana_ekonomi_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sarana_ekonomi_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sarana_prasarana`
--
ALTER TABLE `tb_sarana_prasarana`
  ADD CONSTRAINT `fk_tb_sarana_prasarana_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sarana_prasarana_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sekolah`
--
ALTER TABLE `tb_sekolah`
  ADD CONSTRAINT `fk_tb_sekolah_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sekolah_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sentra_industri`
--
ALTER TABLE `tb_sentra_industri`
  ADD CONSTRAINT `fk_tb_sentra_industri_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sentra_industri_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sktm`
--
ALTER TABLE `tb_sktm`
  ADD CONSTRAINT `fk_tb_sktm_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sktm_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sk_pembentukan`
--
ALTER TABLE `tb_sk_pembentukan`
  ADD CONSTRAINT `fk_tb_sk_pembentukan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sk_pembentukan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_status_pemerintahan`
--
ALTER TABLE `tb_status_pemerintahan`
  ADD CONSTRAINT `fk_tb_status_pemerintahan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_status_pemerintahan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_sutet`
--
ALTER TABLE `tb_sutet`
  ADD CONSTRAINT `fk_tb_sutet_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_sutet_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_taman_bacaan`
--
ALTER TABLE `tb_taman_bacaan`
  ADD CONSTRAINT `fk_tb_taman_bacaan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_taman_bacaan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_tanah_kas_desa`
--
ALTER TABLE `tb_tanah_kas_desa`
  ADD CONSTRAINT `fk_tb_tanah_kas_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_tanah_kas_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_tempat_ibadah`
--
ALTER TABLE `tb_tempat_ibadah`
  ADD CONSTRAINT `fk_tb_tempat_ibadah_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_tempat_ibadah_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_tempat_peribadatan`
--
ALTER TABLE `tb_tempat_peribadatan`
  ADD CONSTRAINT `fk_tb_tempat_peribadatan_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_tempat_peribadatan_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_titik_koordinat_kantor_desa`
--
ALTER TABLE `tb_titik_koordinat_kantor_desa`
  ADD CONSTRAINT `fk_tb_titik_koordinat_kantor_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_titik_koordinat_kantor_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_topografi_terluas_wilayah_desa`
--
ALTER TABLE `tb_topografi_terluas_wilayah_desa`
  ADD CONSTRAINT `fk_tb_topografi_terluas_wilayah_desa_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_topografi_terluas_wilayah_desa_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_website_medsos`
--
ALTER TABLE `tb_website_medsos`
  ADD CONSTRAINT `fk_tb_website_medsos_desa_id` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tb_website_medsos_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `fk_desa_id_new` FOREIGN KEY (`desa_id`) REFERENCES `tb_enumerator` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
