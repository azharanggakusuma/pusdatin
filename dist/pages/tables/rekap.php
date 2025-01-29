<?php
// Sertakan file koneksi dan sesi
include_once('../../config/conn.php');
include "../../config/session.php";

// Autoload dependencies (PhpSpreadsheet, Mpdf, dll)
require __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Mpdf\Mpdf;

// Ambil parameter jenis ekspor, kode desa, kecamatan, dan filter tahun dari URL
$type = $_GET['type'] ?? null;
$kode_desa = $_GET['kode_desa'] ?? null;
$kode_kecamatan = $_GET['kode_kecamatan'] ?? null;
$filter_tahun = $_GET['filter_tahun'] ?? null;

/**
 * 1. Definisikan kolom dari kedua query
 */

// Kolom dari query utama
$allColumns_query = [
    'tahun',
    'kode_desa',
    'nama_desa',
    'kecamatan',
    'sk_pembentukan',
    'alamat_balai',
    'batas_utara',
    'kec_utara',
    'batas_selatan',
    'kec_selatan',
    'batas_timur',
    'kec_timur',
    'batas_barat',
    'kec_barat',
    'jarak_ke_ibukota_kecamatan',
    'jarak_ke_ibukota_kabupaten',
    'status_idm',
    'alamat_website',
    'alamat_email',
    'alamat_facebook',
    'alamat_twitter',
    'alamat_youtube',
    'status_pemerintahan',
    'penetapan_batas_desa',
    'no_surat_batas_desa',
    'ketersediaan_peta_desa',
    'no_surat_peta_desa',
    'jumlah_dusun',
    'jumlah_rw',
    'jumlah_rt',
    'luas_wilayah_desa',
    'topografi_terluas_wilayah_desa',
    'keberadaan_kantor',
    'status_kantor',
    'kondisi_kantor',
    'lokasi_kantor',
    'koordinat_lintang',
    'koordinat_bujur',
    'jumlah_surat_kematian',
    'jumlah_penduduk_laki',
    'jumlah_penduduk_perempuan',
    'jumlah_kepala_keluarga',
    'pmi_bekerja',
    'agen_pengerahan_pmi',
    'layanan_rekomendasi_pmi',
    'keberadaan_wna',
    'jumlah_pln',
    'jumlah_non_pln',
    'jumlah_bukan_pengguna_listrik',
    'penggunaan_lampu_tenaga_surya',
    'lampu_tenaga_surya',
    'penerangan_jalan_utama',
    'sumber_penerangan',
    'tps',
    'tps3r',
    'bank_sampah',
    'sutet_status',
    'keberadaan_pemukiman',
    'jumlah_pemukiman',
    'keberadaan_sungai',
    'nama_sungai_1',
    'nama_sungai_2',
    'nama_sungai_3',
    'nama_sungai_4',
    'keberadaan_danau',
    'nama_danau_1',
    'nama_danau_2',
    'nama_danau_3',
    'nama_danau_4',
    'keberadaan_pemukiman_bantaran',
    'jumlah_pemukiman_bantaran',
    'jumlah_embung',
    'lokasi_mata_air',
    'keberadaan_kumuh',
    'jumlah_kumuh',
    'keberadaan_galian',
    'jumlah_prasarana',
    'jumlah_rumah',
    'tanah_longsor',
    'banjir',
    'banjir_bandang',
    'gempa_bumi',
    'tsunami',
    'gelombang_pasang',
    'angin_puyuh',
    'gunung_meletus',
    'kebakaran_hutan',
    'kekeringan',
    'abrasi',
    'peringatan_dini',
    'peringatan_tsunami',
    'perlengkapan_keselamatan',
    'rambu_evakuasi',
    'infrastruktur',
    'keberadaan_tbm',
    'keberadaan_bidan',
    'keberadaan_dukun_bayi',
    'muntaber_diare',
    'demam_berdarah',
    'campak',
    'malaria',
    'flu_burung_sars',
    'hepatitis_e',
    'difteri',
    'corona_covid19',
    'lainnya_name',
    'lainnya_status',
    'jumlah_masjid',
    'jumlah_pura',
    'jumlah_musala',
    'jumlah_wihara',
    'jumlah_gereja_kristen',
    'jumlah_kelenteng',
    'jumlah_gereja_katolik',
    'jumlah_balai_basarah',
    'jumlah_kapel',
    'lainnya',
    'jumlah_lainnya',
    'jumlah_tuna_netra',
    'jumlah_tuna_rungu',
    'jumlah_tuna_wicara',
    'jumlah_tuna_rungu_wicara',
    'jumlah_tuna_daksa',
    'jumlah_tuna_grahita',
    'jumlah_tuna_laras',
    'jumlah_tuna_eks_kusta',
    'jumlah_tuna_ganda',
    'status_ruang_publik',
    'ruang_terbuka_hijau',
    'ruang_terbuka_non_hijau',
    'sepak_bola',
    'bola_voli',
    'bulu_tangkis',
    'bola_basket',
    'tenis_lapangan',
    'tenis_meja',
    'futsal',
    'renang',
    'bela_diri',
    'bilyard',
    'fitness',
    'lainnya_nama_olahraga',
    'lainnya_kondisi_olahraga',
    'lalu_lintas',
    'jenis_permukaan_jalan',
    'jalan_darat_bisa_dilalui',
    'keberadaan_angkutan_umum',
    'operasional_angkutan_umum',
    'jam_operasi_angkutan_umum',
    'keberadaan_internet',
    'jumlah_bts',
    'jumlah_operator_telekomunikasi',
    'sinyal_telepon',
    'sinyal_internet',
    'kondisi_komputer',
    'fasilitas_internet',
    'kantor_pos',
    'layanan_pos_keliling',
    'ekspedisi_swasta',
    'keberadaan',
    'jumlah_sentra',
    'produk_utama',
    'keberadaan',
    'makanan_unggulan',
    'non_makanan_unggulan',
    'keberadaan_minyak_tanah',
    'keberadaan_lpg',
    'bank_pemerintah',
    'bank_swasta',
    'bank_bpr',
    'jarak_bank_terdekat',
    'koperasi_kud',
    'koperasi_kopinkra',
    'koperasi_ksp',
    'koperasi_lainnya',
    'toko_kud',
    'toko_bumdesa',
    'toko_lainnya',
    'bmt_jumlah',
    'bmt_jarak',
    'bmt_kemudahan',
    'atm_jumlah',
    'atm_jarak',
    'atm_kemudahan',
    'agen_bank_jumlah',
    'agen_bank_jarak',
    'agen_bank_kemudahan',
    'valas_jumlah',
    'valas_jarak',
    'valas_kemudahan',
    'pegadaian_jumlah',
    'pegadaian_jarak',
    'pegadaian_kemudahan',
    'agen_tiket_jumlah',
    'agen_tiket_jarak',
    'agen_tiket_kemudahan',
    'bengkel_jumlah',
    'bengkel_jarak',
    'bengkel_kemudahan',
    'salon_jumlah',
    'salon_jarak',
    'salon_kemudahan',
    'kelompok_pertokoan_jumlah',
    'kelompok_pertokoan_kemudahan',
    'pasar_permanen_jumlah',
    'pasar_permanen_kemudahan',
    'pasar_semi_permanen_jumlah',
    'pasar_semi_permanen_kemudahan',
    'pasar_tanpa_bangunan_jumlah',
    'pasar_tanpa_bangunan_kemudahan',
    'minimarket_jumlah',
    'minimarket_kemudahan',
    'restoran_jumlah',
    'restoran_kemudahan',
    'warung_makan_jumlah',
    'warung_makan_kemudahan',
    'toko_kelontong_jumlah',
    'toko_kelontong_kemudahan',
    'hotel_jumlah',
    'hotel_kemudahan',
    'penginapan_jumlah',
    'penginapan_kemudahan',
    'kejadian_perkelahian_massal',
    'pembangunan_pos_keamanan',
    'pembentukan_regu_keamanan',
    'penambahan_anggota_hansip',
    'pelaporan_tamu_menginap',
    'pengaktifan_sistem_keamanan',
    'jumlah_anggota_linmas',
    'keberadaan_pos_polisi'
];

// Kolom dari query baru
$allColumns_query_baru = [
    'tanah_bengkok',
    'tanah_titi_sara',
    'kebun_desa',
    'sawah_desa',
    'keberadaan_sistem_informasi_desa',
    'keberadaan_sistem_keuangan_desa',
    'jumlah_unit_usaha_bumdes',
    'tanah_kas_desa_ulayat',
    'tambatan_perahu',
    'pasar_desa',
    'bangunan_milik_desa',
    'hutan_milik_desa',
    'mata_air_milik_desa',
    'tempat_wisata_pemandian_umum',
    'aset_lainnya_milik_desa',
    'ketersediaan_rpjmdes',
    'tahun_awal_rpjmdes',
    'tahun_akhir_rpjmdes',
    'ketersediaan_rkpdes',
    'jumlah_peraturan_yang_dimiliki_desa',
    'jumlah_peraturan_kepala_desa',
    'keberadaan_kerjasama_antar_desa',
    'keberadaan_kerjasama_desa_dengan_pihak_ketiga',
    'keberadaan_pendamping_lokal_desa',
    'keberadaan_kader_pembangunan_manusia',
    'pembinaan_kpm_dari_pemkab_kota',
    'pendapatan_asli_desa',
    'dana_desa',
    'bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah',
    'alokasi_dana_desa',
    'bantuan_keuangan_dari_apbd_provinsi',
    'bantuan_keuangan_dari_apbd',
    'hibah_dan_sumbangan_dari_pihak_ketiga',
    'lain_lain_pendapatan_desa_yang_sah',
    'bidang_penyelenggaraan_pemerintahan_desa',
    'bidang_pelaksanaan_pembangunan_desa',
    'bidang_pembinaan_kemasyarakatan',
    'bidang_pemberdayaan_masyarakat',
    'bidang_tak_terduga',
    'status_keaktifan',
    'status_badan_hukum',
    'jumlah_paket_pengadaan_barang_dan_jasa',
    'penerima_pkh',
    'penerima_blt_dana_desa',
    'penerima_bpnt',
    'penerima_pbi_jk',
    'jumlah_sktm',

    'nama_kepala_desa',
    'umur',
    'jenis_kelamin',
    'pendidikan_terakhir',
    'tahun_mulai_menjabat',

    'skd_laki',
    'skd_perempuan',
    'kaur_laki',
    'kaur_perempuan',
    'kkk_laki',
    'kkk_perempuan',
    'pk_laki',
    'pk_perempuan',
    'staf_laki',
    'staf_perempuan',
    'total_laki',
    'total_perempuan',

    'tidak_sekolah_laki',
    'tidak_sekolah_perempuan',
    'tidak_tamat_sd_laki',
    'tidak_tamat_sd_perempuan',
    'tamat_sd_laki',
    'tamat_sd_perempuan',
    'smp_laki',
    'smp_perempuan',
    'smu_laki',
    'smu_perempuan',
    'd3_laki',
    'd3_perempuan',
    's1_laki',
    's1_perempuan',
    's2_laki',
    's2_perempuan',
    's3_laki',
    's3_perempuan',
    'total_laki',
    'total_perempuan',

    'keberadaan_bpd',
    'jumlah_laki',
    'jumlah_perempuan',
    'jumlah_kegiatan',

    'jumlah_tim_penggerak_pkk',
    'jumlah_kader_pkk',
    'jumlah_kelompok_pkk',
    'jumlah_kelompok_dasa_wisma',

    'jumlah_karang_taruna',
    'jumlah_posyandu',
    'jumlah_anggota_laki',
    'jumlah_anggota_perempuan'
];

/**
 * 2. Grouping kolom untuk multi-header, termasuk kolom dari kedua query
 */
$groupedColumns = [
    'Data Desa' => [
        'tahun'                            => 'Periode Tahun',
        'kode_desa'                        => 'Kode Desa',
        'nama_desa'                        => 'Nama Desa',
        'kecamatan'                        => 'Kecamatan',
    ],

    'Keterangan Tempat' => [
        'sk_pembentukan'                   => 'Sk Pembentukan/Pengesahan Desa/Kelurahan',
        'alamat_balai'                     => 'Alamat Balai Desa/Kantor Kelurahan',
    ],

    'Keterangan Umum Desa Kelurahan' => [
        'batas_utara'                      => 'Batas Utara',
        'kec_utara'                        => 'Kec Utara',
        'batas_selatan'                    => 'Batas Selatan',
        'kec_selatan'                      => 'Kec Selatan',
        'batas_timur'                      => 'Batas Timur',
        'kec_timur'                        => 'Kec Timur',
        'batas_barat'                      => 'Batas Barat',
        'kec_barat'                        => 'Kec Barat',
        'jarak_ke_ibukota_kecamatan'       => 'Jarak ke Ibu Kota Kecamatan (km)',
        'jarak_ke_ibukota_kabupaten'       => 'Jarak ke Ibu Kota Kabupaten (km)',
        'status_idm'                       => 'Status Desa Membangun',
        'alamat_website'                   => 'Alamat Website Desa',
        'alamat_email'                     => 'Alamat Email Desa',
        'alamat_facebook'                  => 'Alamat Facebook Desa',
        'alamat_twitter'                   => 'Alamat Twitter Desa',
        'alamat_youtube'                   => 'Alamat YouTube Desa',
        'status_pemerintahan'              => 'Status Pemerintahan',
        'penetapan_batas_desa'             => 'Penetapan Batas Desa',
        'no_surat_batas_desa'              => 'No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa',
        'ketersediaan_peta_desa'           => 'Ketersediaan Peta Desa',
        'no_surat_peta_desa'               => 'No SK/Perbup/Perda tentang Peta Desa',
        'jumlah_dusun'                     => 'Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis',
        'jumlah_rw'                        => 'Banyaknya RW',
        'jumlah_rt'                        => 'Banyaknya RT',
        'luas_wilayah_desa'                => 'Luas Wilayah Desa',
        'topografi_terluas_wilayah_desa'   => 'Topografi Terluas Wilayah Desa',
        'keberadaan_kantor'                => 'Keberadaan kantor kepala desa/lurah',
        'status_kantor'                    => 'Status Kantor Kepala Desa/Lurah',
        'kondisi_kantor'                   => 'Kondisi Kantor Kepala Desa/Balai Desa',
        'lokasi_kantor'                    => 'Lokasi Kantor Kepala Desa/Lurah',
        'koordinat_lintang'                => 'Koordinat Lintang (Latitude)',
        'koordinat_bujur'                  => 'Koordinat Bujur (Longitude)',
    ],

    'Kependudukan dan Ketenagakerjaan' => [
        'jumlah_surat_kematian'            => 'Jumlah Surat Kematian Yang Dikeluarkan',
        'jumlah_penduduk_laki'             => 'Jumlah Penduduk Laki-Laki',
        'jumlah_penduduk_perempuan'        => 'Jumlah Penduduk Perempuan',
        'jumlah_kepala_keluarga'           => 'Jumlah Kepala Keluarga',
        'pmi_bekerja'                      => 'Keberadaan Warga Desa/Kelurahan yang Sedang Bekerja sebagai PMI (Pekerja Migran Indonesia)/TKI di Luar Negeri',
        'agen_pengerahan_pmi'              => 'Keberadaan Agen (Seseorang/Sekelompok Orang/Perusahaan) Pengerahan Pekerja Migran Indonesia/TKI ke Luar Negeri di Desa/Kelurahan',
        'layanan_rekomendasi_pmi'          => 'Layanan Rekomendasi/Surat Keterangan Bagi Warga Desa/Kelurahan yang Akan Bekerja Sebagai Pekerja Migran Indonesia/TKI di Luar Negeri',
        'keberadaan_wna'                   => 'Keberadaan Warga Negara Asing (WNA) di Desa/Kelurahan',
    ],

    'Perumahan dan Lingkungan Hidup' => [
        'jumlah_pln'                       => 'Jumlah Keluarga Pengguna Listrik PLN (Perusahaan Listrik Negara)',
        'jumlah_non_pln'                   => 'Jumlah Keluarga Pengguna Listrik Non-PLN',
        'jumlah_bukan_pengguna_listrik'    => 'Jumlah Keluraga Bukan Pengguna Listrik',
        'penggunaan_lampu_tenaga_surya'    => 'Keluarga yang Menggunakan Lampu Tenaga Surya',
        'lampu_tenaga_surya'               => 'Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga Surya',
        'penerangan_jalan_utama'           => 'Penerangan di Jalan Utama Desa/Kelurahan',
        'sumber_penerangan'                => 'Sumber Penerangan di Jalan Utama Desa/Kelurahan',
        'tps'                              => 'Keberadaan Tempat Pembuangan Sampah Sementara (TPS)',
        'tps3r'                            => 'Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)',
        'bank_sampah'                      => 'Keberadaan Bank Sampah di Desa/Kelurahan',
        'sutet_status'                     => 'Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra tinggi (SUTET) / Saluran Udara Tegangan Tinggi (SUUT) / Saluran Udara Tegangan Tinggi Arus Searah (SUTTAS)',
        'keberadaan_pemukiman'             => 'Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS',
        'jumlah_pemukiman'                 => 'Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS',
        'keberadaan_sungai'                => 'Keberadaan Sungai Yang Melintasi',
        'nama_sungai_1'                    => 'Nama Sungai Yang Melintasi ke 1',
        'nama_sungai_2'                    => 'Nama Sungai Yang Melintasi ke 2',
        'nama_sungai_3'                    => 'Nama Sungai Yang Melintasi ke 3',
        'nama_sungai_4'                    => 'Nama Sungai Yang Melintasi ke 4',
        'keberadaan_danau'                 => 'Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa',
        'nama_danau_1'                     => 'Nama danau/waduk/situ yang berada di wilayah desa ke 1',
        'nama_danau_2'                     => 'Nama danau/waduk/situ yang berada di wilayah desa ke 2',
        'nama_danau_3'                     => 'Nama danau/waduk/situ yang berada di wilayah desa ke 3',
        'nama_danau_4'                     => 'Nama danau/waduk/situ yang berada di wilayah desa ke 4',
        'keberadaan_pemukiman'             => 'Keberadaan Pemukiman Di Bantaran Sungai',
        'jumlah_pemukiman'                 => 'Jumlah Pemukiman Di Bantaran Sungai',
        'jumlah_embung'                    => 'Jumlah Embung',
        'lokasi_mata_air'                  => 'Lokasi Mata Air',
        'keberadaan_kumuh'                 => 'Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan Padat Dan Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan',
        'jumlah_kumuh'                     => 'Jumlah Pemukiman Kumuh',
        'keberadaan_galian'                => 'Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali, Pasir, Kapur, Kaolin, Pasir Kuarsa, Tanah Liat, Dll.)',
        'jumlah_prasarana'                 => 'Jumlah Sarana Prasarana Kebersihan',
        'jumlah_rumah'                     => 'Jumlah Rumah Tidak Layak Huni',
    ],

    'Bencana Alam dan Mitigasi Bencana Alam' => [
        'tanah_longsor'                    => 'Tanah Longsor',
        'banjir'                           => 'Banjir',
        'banjir_bandang'                   => 'Banjir Bandang',
        'gempa_bumi'                       => 'Gempa Bumi',
        'tsunami'                          => 'Tsunami',
        'gelombang_pasang'                 => 'Gelombang Pasang',
        'angin_puyuh'                      => 'Angin Puyuh',
        'gunung_meletus'                   => 'Gunung Meletus',
        'kebakaran_hutan'                  => 'Kebakaran Hutan',
        'kekeringan'                       => 'Kekeringan',
        'abrasi'                           => 'Abrasi',
        'peringatan_dini'                  => 'Sistem Peringatan Dini Bencana Alam',
        'peringatan_tsunami'               => 'Sistem Peringatan Dini Khusus Tsunami',
        'perlengkapan_keselamatan'         => 'Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)',
        'rambu_evakuasi'                   => 'Rambu-Rambu dan Jalur Evakuasi Bencana',
        'infrastruktur'                    => 'Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul, Parit, Drainase, Waduk, Pantai, dll.)',
    ],

    'Pendidikan dan Kesehatan' => [
        'keberadaan_tbm'                   => 'Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa',
        'keberadaan_bidan'                 => 'Keberadaan Bidan Desa yang menetap di Desa/Kelurahan',
        'keberadaan_dukun_bayi'            => 'Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan',
        'muntaber_diare'                   => 'Muntaber/diare',
        'demam_berdarah'                   => 'Demam Berdarah',
        'campak'                           => 'Campak',
        'malaria'                          => 'Malaria',
        'flu_burung_sars'                  => 'Flu Burung/SARS',
        'hepatitis_e'                      => 'Hepatitis E',
        'difteri'                          => 'Difteri',
        'corona_covid19'                   => 'Corona/COVID-19',
        'lainnya_name'                     => 'Lainnya',
        'lainnya_status'                   => 'Lainnya (Status)',
    ],

    'Sosial Budaya' => [
        'jumlah_masjid'                   => 'Jumlah Masjid',
        'jumlah_pura'                     => 'Jumlah Pura',
        'jumlah_musal'                    => 'Jumlah Surau/Langgar/Musala',
        'jumlah_wihara'                   => 'Jumlah Wihara',
        'jumlah_gereja_kristen'           => 'Jumlah Gereja Kristen',
        'jumlah_kelenteng'                => 'Jumlah Kelenteng',
        'jumlah_gereja_katolik'           => 'Jumlah Gereja Katolik',
        'jumlah_balai_basarah'            => 'Jumlah Balai Basarah',
        'jumlah_kape'                     => 'Jumlah Kapel',
        'lainnya'                         => 'Tempat Ibadah Lainnya',
        'jumlah_lainnya'                  => 'Jumlah Lainnya',
        'jumlah_tuna_netra'               => 'Jumlah tuna netra (buta)',
        'jumlah_tuna_rungu'               => 'Jumlah tuna rungu (tuli)',
        'jumlah_tuna_wicara'              => 'Jumlah tuna wicara (bisu)',
        'jumlah_tuna_rungu_wicara'        => 'Jumlah tuna rungu-wicara (tuli-bisu)',
        'jumlah_tuna_daksa'               => 'Jumlah tuna daksa (disabilitas tubuh)',
        'jumlah_tuna_grahita'             => 'Jumlah tuna grahita (keterbelakangan mental)',
        'jumlah_tuna_laras'               => 'Jumlah tuna laras (eks-sakit jiwa)',
        'jumlah_tuna_eks_kusta'           => 'Jumlah tuna eks-sakit kusta',
        'jumlah_tuna_ganda'               => 'Jumlah tuna ganda (fisik-mental)',
        'status_ruang_publik'             => 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)',
        'ruang_terbuka_hijau'             => 'Ruang Terbuka Hijau (RTH)',
        'ruang_terbuka_non_hijau'         => 'Ruang Terbuka Non Hijau (RTNH)',
    ],

    'Olahraga' => [
        'sepak_bola'                      => 'Sepak bola',
        'bola_voli'                       => 'Bola voli',
        'bulu_tangkis'                    => 'Bulu tangkis',
        'bola_basket'                     => 'Bola basket',
        'tenis_lapangan'                  => 'Tenis lapangan',
        'tenis_meja'                      => 'Tenis meja',
        'futsal'                          => 'Futsal',
        'renang'                          => 'Renang',
        'bela_diri'                       => 'Bela diri (pencak silat, karate, dll.)',
        'bilyard'                         => 'Bilyard',
        'fitness'                         => 'Fitness, aerobik, dll.',
        'lainnya_nama_olahraga'           => 'Fasilitas Lainnya',
        'lainnya_kondisi_olahraga'        => 'Kondisi Fasilitas lainnya',
    ],

    'Angkutan Komunikasi dan Informasi' => [
        'lalu_lintas'                     => 'Lalu lintas dari/ke desa/kelurahan melalui',
        'jenis_permukaan_jalan'           => 'Jenis permukaan jalan darat antar desa/kelurahan yang terluas',
        'jalan_darat_bisa_dilalui'        => 'Jalan darat antar desa/kelurahan dapat dilalui kendaraan bermotor roda 4 atau lebih',
        'keberadaan_angkutan_umum'        => 'Keberadaan angkutan umum',
        'operasional_angkutan_umum'       => 'Operasional angkutan umum yang utama',
        'jam_operasi_angkutan_umum'       => 'Jam operasi angkutan umum yang utama',
        'keberadaan_internet'             => 'Keberadaan internet untuk warnet, game online, dan fasilitas lainnya di desa/kelurahan',
        'jumlah_bts'                      => 'Jumlah menara telepon seluler atau Base Transceiver Station (BTS)',
        'jumlah_operator_telekomunikasi'  => 'Jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa',
        'sinyal_telepon'                  => 'Sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
        'sinyal_internet'                 => 'Sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
        'kondisi_komputer'                => 'Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah',
        'fasilitas_internet'              => 'Fasilitas internet di kantor kepala desa/lurah',
        'kantor_pos'                      => 'Kantor pos/pos pembantu/rumah pos',
        'layanan_pos_keliling'            => 'Layanan pos keliling',
        'ekspedisi_swasta'                => 'Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta',
    ],

    'Ekonomi' => [
        'keberadaan_sentra_industri'      => 'Keberadaan Sentra Industri Unggulan Desa',
        'jumlah_sentra'                   => 'Sentra Industri',
        'produk_utama'                    => 'Produk pada sentra industri yang mempunyai muatan usaha terbanyak',
        'keberadaan_produk_unggulan'      => 'Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)',
        'makanan_unggulan'                => 'Produk barang unggulan/utama desa/kelurahan (makanan)',
        'non_makanan_unggulan'            => 'Produk barang unggulan/utama desa/kelurahan (non makanan)',
        'keberadaan_minyak_tanah'         => 'Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)',
        'keberadaan_lpg'                  => 'Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)',
        'bank_pemerintah'                 => 'Jumlah Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)',
        'bank_swasta'                     => 'Jumlah Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)',
        'bank_bpr'                        => 'Jumlah Bank Perkreditan Rakyat (BPR)',
        'jarak_bank_terdekat'             => 'Jika tidak ada bank, perkiraan jarak ke bank terdekat',
        'koperasi_kud'                    => 'Jumlah Koperasi Unit Desa (KUD)',
        'koperasi_kopinkra'               => 'Jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro',
        'koperasi_ksp'                    => 'Jumlah Koperasi Simpan Pinjam (KSP/Kospin)',
        'koperasi_lainnya'                => 'Jumlah Koperasi lainnya',
        'toko_kud'                        => 'Keberadaan Toko Milik KUD',
        'toko_bumdesa'                    => 'Keberadaan Toko Milik BUM Desa',
        'toko_lainnya'                    => 'Keberadaan Toko Selain milik KUD/BUM Desa',
        'bmt_jumlah'                      => 'Jumlah Sarana Baitul Maal Wa Tamwil (BMT)',
        'bmt_jarak'                       => 'Jarak Baitul Maal Wa Tamwil (BMT)',
        'bmt_kemudahan'                   => 'Kemudahan untuk Mencapai Baitul Maal Wa Tamwil (BMT)',
        'atm_jumlah'                      => 'Jumlah Sarana Anjungan Tunai Mandiri (ATM)',
        'atm_jarak'                       => 'Jarak Anjungan Tunai Mandiri (ATM)',
        'atm_kemudahan'                   => 'Kemudahan untuk Mencapai Anjungan Tunai Mandiri (ATM)',
        'agen_bank_jumlah'                => 'Jumlah Sarana Agen Bank',
        'agen_bank_jarak'                 => 'Jarak Agen Bank',
        'agen_bank_kemudahan'             => 'Kemudahan untuk Mencapai Agen Bank',
        'valas_jumlah'                    => 'Jumlah Sarana Pedagang Valuta Asing',
        'valas_jarak'                     => 'Jarak Pedagang Valuta Asing',
        'valas_kemudahan'                 => 'Kemudahan untuk Mencapai Pedagang Valuta Asing',
        'pegadaian_jumlah'                => 'Jumlah Sarana Pergadaian',
        'pegadaian_jarak'                 => 'Jarak Pergadaian',
        'pegadaian_kemudahan'             => 'Kemudahan untuk Mencapai Pergadaian',
        'agen_tiket_jumlah'               => 'Jumlah Sarana Agen Tiket/Travel/Biro Perjalanan',
        'agen_tiket_jarak'                => 'Jarak Agen Tiket/Travel/Biro Perjalanan',
        'agen_tiket_kemudahan'            => 'Kemudahan untuk Mencapai Agen Tiket/Travel/Biro Perjalanan',
        'bengkel_jumlah'                  => 'Jumlah Sarana Bengkel Mobil/Motor',
        'bengkel_jarak'                   => 'Jarak Bengkel Mobil/Motor',
        'bengkel_kemudahan'               => 'Kemudahan untuk Mencapai Bengkel Mobil/Motor',
        'salon_jumlah'                    => 'Jumlah Sarana Salon Kecantikan',
        'salon_jarak'                     => 'Jarak Salon Kecantikan',
        'salon_kemudahan'                 => 'Kemudahan untuk Mencapai Salon Kecantikan',
        'kelompok_pertokoan_jumlah'       => 'Jumlah Sarana Kelompok pertokoan',
        'kelompok_pertokoan_kemudahan'    => 'Kemudahan untuk Mencapai Kelompok pertokoan',
        'pasar_permanen_jumlah'           => 'Jumlah Sarana Pasar dengan bangunan permanen',
        'pasar_permanen_kemudahan'        => 'Kemudahan untuk Mencapai Pasar dengan bangunan permanen',
        'pasar_semi_permanen_jumlah'      => 'Jumlah Sarana Pasar dengan bangunan semi permanen',
        'pasar_semi_permanen_kemudahan'   => 'Kemudahan untuk Mencapai Pasar dengan bangunan semi permanen',
        'pasar_tanpa_bangunan_jumlah'     => 'Jumlah Sarana Pasar tanpa bangunan',
        'pasar_tanpa_bangunan_kemudahan'  => 'Kemudahan untuk Mencapai Pasar tanpa bangunan',
        'minimarket_jumlah'               => 'Jumlah Sarana Minimarket/swalayan/supermarket',
        'minimarket_kemudahan'            => 'Kemudahan untuk Mencapai Minimarket/swalayan/supermarket',
        'restoran_jumlah'                 => 'Jumlah Sarana Restoran/rumah makan',
        'restoran_kemudahan'              => 'Kemudahan untuk Mencapai Restoran/rumah makan',
        'warung_makan_jumlah'             => 'Jumlah Sarana Warung/kedai makanan minuman',
        'warung_makan_kemudahan'          => 'Kemudahan untuk Mencapai Warung/kedai makanan minuman',
        'toko_kelontong_jumlah'           => 'Jumlah Sarana Toko/warung kelontong',
        'toko_kelontong_kemudahan'        => 'Kemudahan untuk Mencapai Toko/warung kelontong',
        'hotel_jumlah'                    => 'Jumlah Sarana Hotel',
        'hotel_kemudahan'                 => 'Kemudahan untuk Mencapai Hotel',
        'penginapan_jumlah'               => 'Jumlah Sarana Penginapan (hostel/motel/losmen/wisma)',
        'penginapan_kemudahan'            => 'Kemudahan untuk Mencapai Penginapan (hostel/motel/losmen/wisma)',
    ],

    'Keamanan' => [
        'kejadian_perkelahian_massal'     => 'Kejadian Perkelahian Massal di Desa/Kelurahan Selama Setahun Terakhir',
        'pembangunan_pos_keamanan'        => 'Pembangunan/pemeliharaan pos keamanan lingkungan',
        'pembentukan_regu_keamanan'       => 'Pembentukan/pengaturan regu keamanan',
        'penambahan_anggota_hansip'       => 'Penambahan jumlah anggota hansip/linmas',
        'pelaporan_tamu_menginap'         => 'Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan',
        'pengaktifan_sistem_keamanan'     => 'Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga',
        'jumlah_anggota_linmas'           => 'Jumlah anggota linmas/hansip di desa/kelurahan',
        'keberadaan_pos_polisi'           => 'Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan',
    ],

    'Keuangan dan Aset Desa' => [
        'tanah_bengkok'                   => 'Tanah Bengkok',
        'tanah_titi_sara'                 => 'Tanah Titi Sara',
        'kebun_desa'                      => 'Kebun Desa',
        'sawah_desa'                      => 'Sawah Desa',
        'keberadaan_sistem_informasi_desa'  => 'Keberadaan Sistem Informasi Desa',
        'keberadaan_sistem_keuangan_desa'   => 'Keberadaan Sistem Keuangan Desa',
        'jumlah_unit_usaha_bumdes'           => 'Jumlah Unit Usaha BUMDes',
        'tanah_kas_desa_ulayat'              => 'Tanah Kas Desa Ulayat',
        'tambatan_perahu'                    => 'Tambatan Perahu',
        'pasar_desa'                         => 'Pasar Desa',
        'bangunan_milik_desa'                => 'Bangunan Milik Desa',
        'hutan_milik_desa'                   => 'Hutan Milik Desa',
        'mata_air_milik_desa'                => 'Mata Air Milik Desa',
        'tempat_wisata_pemandian_umum'       => 'Tempat Wisata Pemandian Umum',
        'aset_lainnya_milik_desa'            => 'Aset Lainnya Milik Desa',
        'ketersediaan_rpjmdes'                => 'Ketersediaan RPJMDES',
        'tahun_awal_rpjmdes'                  => 'Tahun Awal RPJMDES',
        'tahun_akhir_rpjmdes'                 => 'Tahun Akhir RPJMDES',
        'ketersediaan_rkpdes'                 => 'Ketersediaan RKPDes',
        'jumlah_peraturan_yang_dimiliki_desa' => 'Jumlah Peraturan yang Dimiliki Desa',
        'jumlah_peraturan_kepala_desa'        => 'Jumlah Peraturan Kepala Desa',
        'keberadaan_kerjasama_antar_desa'              => 'Keberadaan Kerjasama Antar Desa',
        'keberadaan_kerjasama_desa_dengan_pihak_ketiga' => 'Keberadaan Kerjasama Desa dengan Pihak Ketiga',
        // Tambahan
        'keberadaan_pendamping_lokal_desa' => 'Keberadaan Pendamping Lokal Desa',
        'keberadaan_kader_pembangunan_manusia' => 'Keberadaan Kader Pembangunan Manusia',
        'pembinaan_kpm_dari_pemkab_kota'      => 'Pembinaan KPM dari Pemkab/Kota',
        'pendapatan_asli_desa'                      => 'Pendapatan Asli Desa',
        'dana_desa'                                  => 'Dana Desa',
        'bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah' => 'Bagian dari Hasil Pajak Daerah dan Retribusi Daerah',
        'alokasi_dana_desa'                          => 'Alokasi Dana Desa',
        'bantuan_keuangan_dari_apbd_provinsi'        => 'Bantuan Keuangan dari APBD Provinsi',
        'bantuan_keuangan_dari_apbd'                 => 'Bantuan Keuangan dari APBD',
        'hibah_dan_sumbangan_dari_pihak_ketiga'      => 'Hibah dan Sumbangan dari Pihak Ketiga',
        'lain_lain_pendapatan_desa_yang_sah'         => 'Lain-lain Pendapatan Desa yang Sah',
        'bidang_penyelenggaraan_pemerintahan_desa'  => 'Bidang Penyelenggaraan Pemerintahan Desa',
        'bidang_pelaksanaan_pembangunan_desa'       => 'Bidang Pelaksanaan Pembangunan Desa',
        'bidang_pembinaan_kemasyarakatan'           => 'Bidang Pembinaan Kemasyarakatan',
        'bidang_pemberdayaan_masyarakat'            => 'Bidang Pemberdayaan Masyarakat',
        'bidang_tak_terduga'                        => 'Bidang Tak Terduga',
        'status_keaktifan'   => 'Status Keaktifan BUMDes',
        'status_badan_hukum' => 'Status Badan Hukum BUMDes',
        'jumlah_paket_pengadaan_barang_dan_jasa' => 'Jumlah Paket Pengadaan Barang dan Jasa',
    ],

    'Perlindungan Sosial, Pembangunan, dan Pemberdayaan Masyarakat' => [
        'penerima_pkh'             => 'Penerima PKH',
        'penerima_blt_dana_desa'   => 'Penerima BLT Dana Desa',
        'penerima_bpnt'            => 'Penerima BPNT',
        'penerima_pbi_jk'          => 'Penerima PBI/JK',
        'jumlah_sktm' => 'Jumlah SKTM',
    ],

    'Aparatur Pemerintahan Desa' => [
        'nama_kepala_desa'       => 'Nama Kepala Desa',
        'umur'                   => 'Umur Kepala Desa',
        'jenis_kelamin'          => 'Jenis Kelamin Kepala Desa',
        'pendidikan_terakhir'    => 'Pendidikan Terakhir Kepala Desa',
        'tahun_mulai_menjabat'   => 'Tahun Mulai Menjabat Kepala Desa',
        'skd_laki'           => 'SKD (Laki-laki)',
        'skd_perempuan'     => 'SKD (Perempuan)',
        'kaur_laki'         => 'KAUR (Laki-laki)',
        'kaur_perempuan'    => 'KAUR (Perempuan)',
        'kkk_laki'          => 'KKK (Laki-laki)',
        'kkk_perempuan'     => 'KKK (Perempuan)',
        'pk_laki'           => 'PK (Laki-laki)',
        'pk_perempuan'      => 'PK (Perempuan)',
        'staf_laki'         => 'Staf (Laki-laki)',
        'staf_perempuan'    => 'Staf (Perempuan)',
        'total_laki'        => 'Total Perangkat Desa (Laki-laki)',
        'total_perempuan'   => 'Total Perangkat Desa (Perempuan)',
        'tidak_sekolah_laki'       => 'Tidak Sekolah (Laki-laki)',
        'tidak_sekolah_perempuan'  => 'Tidak Sekolah (Perempuan)',
        'tidak_tamat_sd_laki'      => 'Tidak Tamat SD (Laki-laki)',
        'tidak_tamat_sd_perempuan' => 'Tidak Tamat SD (Perempuan)',
        'tamat_sd_laki'            => 'Tamat SD (Laki-laki)',
        'tamat_sd_perempuan'       => 'Tamat SD (Perempuan)',
        'smp_laki'                 => 'SMP (Laki-laki)',
        'smp_perempuan'            => 'SMP (Perempuan)',
        'smu_laki'                 => 'SMU (Laki-laki)',
        'smu_perempuan'            => 'SMU (Perempuan)',
        'd3_laki'                  => 'D3 (Laki-laki)',
        'd3_perempuan'             => 'D3 (Perempuan)',
        's1_laki'                  => 'S1 (Laki-laki)',
        's1_perempuan'             => 'S1 (Perempuan)',
        's2_laki'                  => 'S2 (Laki-laki)',
        's2_perempuan'             => 'S2 (Perempuan)',
        's3_laki'                  => 'S3 (Laki-laki)',
        's3_perempuan'             => 'S3 (Perempuan)',
        'total_laki'               => 'Total Pendidikan Perangkat Desa (Laki-laki)',
        'total_perempuan'          => 'Total Pendidikan Perangkat Desa (Perempuan)',
        'keberadaan_bpd'         => 'Keberadaan BPD',
        'jumlah_laki'            => 'Jumlah Anggota BPD (Laki-laki)',
        'jumlah_perempuan'       => 'Jumlah Anggota BPD (Perempuan)',
        'jumlah_kegiatan'        => 'Jumlah Kegiatan BPD',
    ],

    'Lembaga Kemasyarakatan di Desa Kelurahan' => [
        'jumlah_tim_penggerak_pkk'     => 'Jumlah Tim Penggerak PKK',
        'jumlah_kader_pkk'             => 'Jumlah Kader PKK',
        'jumlah_kelompok_pkk'          => 'Jumlah Kelompok PKK',
        'jumlah_kelompok_dasa_wisma'   => 'Jumlah Kelompok Dasa/Wisma PKK',
        'jumlah_karang_taruna' => 'Jumlah Karang Taruna',
        'jumlah_posyandu' => 'Jumlah Posyandu',
        'jumlah_anggota_laki'       => 'Jumlah Anggota Laki-laki LPMD',
        'jumlah_anggota_perempuan'  => 'Jumlah Anggota Perempuan LPMD',
    ],
];

/**
 * 3. Definisikan kedua query: $query (utama) dan $query_baru (tambahan)
 */

// ==================== Query Utama ($query) ====================
$query = "
SELECT DISTINCT 
    /* Ambil tahun dari user_progress (alias: 'tahun') */
    filtered_user_progress.tahun AS tahun,

    tb_enumerator.kode_desa,
    tb_enumerator.nama_desa,
    tb_enumerator.kecamatan,

    /* SK pembentukan */
    tb_sk_pembentukan.sk_pembentukan,

    /* Balai desa */
    tb_balai_desa.alamat_balai,

    /* Batas desa */
    tb_batas_desa.batas_utara,
    tb_batas_desa.kec_utara,
    tb_batas_desa.batas_selatan,
    tb_batas_desa.kec_selatan,
    tb_batas_desa.batas_timur,
    tb_batas_desa.kec_timur,
    tb_batas_desa.batas_barat,
    tb_batas_desa.kec_barat,

    /* Jarak kantor */
    tb_jarak_kantor_desa.jarak_ke_ibukota_kecamatan,
    tb_jarak_kantor_desa.jarak_ke_ibukota_kabupaten,

    /* IDM Status */
    tb_idm_status.status_idm,

    /* Website medsos */
    tb_website_medsos.alamat_website,
    tb_website_medsos.alamat_email,
    tb_website_medsos.alamat_facebook,
    tb_website_medsos.alamat_twitter,
    tb_website_medsos.alamat_youtube,

    /* Status pemerintahan */
    tb_status_pemerintahan.status_pemerintahan,

    /* Ketersediaan penetapan peta desa */
    tb_ketersediaan_penetapan_peta_desa.penetapan_batas_desa,
    tb_ketersediaan_penetapan_peta_desa.no_surat_batas_desa,
    tb_ketersediaan_penetapan_peta_desa.ketersediaan_peta_desa,
    tb_ketersediaan_penetapan_peta_desa.no_surat_peta_desa,

    /* Banyaknya dusun */
    tb_banyaknya_dusun_rt_rw.jumlah_dusun,
    tb_banyaknya_dusun_rt_rw.jumlah_rw,
    tb_banyaknya_dusun_rt_rw.jumlah_rt,

    /* Luas wilayah */
    tb_luas_wilayah_desa.luas_wilayah_desa,

    /* Topografi */
    tb_topografi_terluas_wilayah_desa.topografi_terluas_wilayah_desa,

    /* Kepemilikan kantor */
    tb_kepemilikan_kantor.keberadaan_kantor,
    tb_kepemilikan_kantor.status_kantor,
    tb_kepemilikan_kantor.kondisi_kantor,
    tb_kepemilikan_kantor.lokasi_kantor,

    /* Koordinat */
    tb_titik_koordinat_kantor_desa.koordinat_lintang,
    tb_titik_koordinat_kantor_desa.koordinat_bujur,

    /* Kematian */
    tb_kematian.jumlah_surat_kematian,

    /* Penduduk & Keluarga */
    tb_penduduk_dan_keluarga.jumlah_penduduk_laki,
    tb_penduduk_dan_keluarga.jumlah_penduduk_perempuan,
    tb_penduduk_dan_keluarga.jumlah_kepala_keluarga,

    /* Ketenagakerjaan */
    tb_ketenagakerjaan.pmi_bekerja,
    tb_ketenagakerjaan.agen_pengerahan_pmi,
    tb_ketenagakerjaan.layanan_rekomendasi_pmi,
    tb_ketenagakerjaan.keberadaan_wna,

    /* Pengguna listrik */
    tb_pengguna_listrik_lampu_surya.jumlah_pln,
    tb_pengguna_listrik_lampu_surya.jumlah_non_pln,
    tb_pengguna_listrik_lampu_surya.jumlah_bukan_pengguna_listrik,
    tb_pengguna_listrik_lampu_surya.penggunaan_lampu_tenaga_surya,

    /* Penerangan jalan */
    tb_penerangan_jalan.lampu_tenaga_surya,
    tb_penerangan_jalan.penerangan_jalan_utama,
    tb_penerangan_jalan.sumber_penerangan,

    /* Pengelolaan sampah */
    tb_pengelolaan_sampah.tps,
    tb_pengelolaan_sampah.tps3r,
    tb_pengelolaan_sampah.bank_sampah,

    /* SUTET */
    tb_sutet.sutet_status,
    tb_sutet.keberadaan_pemukiman,
    tb_sutet.jumlah_pemukiman,

    /* Sungai */
    tb_keberadaan_sungai.keberadaan_sungai,
    tb_keberadaan_sungai.nama_sungai_1,
    tb_keberadaan_sungai.nama_sungai_2,
    tb_keberadaan_sungai.nama_sungai_3,
    tb_keberadaan_sungai.nama_sungai_4,

    /* Danau */
    tb_keberadaan_danau.keberadaan_danau,
    tb_keberadaan_danau.nama_danau_1,
    tb_keberadaan_danau.nama_danau_2,
    tb_keberadaan_danau.nama_danau_3,
    tb_keberadaan_danau.nama_danau_4,

    /* Pemukiman bantaran */
    tb_keberadaan_pemukiman_bantaran.keberadaan_pemukiman,
    tb_keberadaan_pemukiman_bantaran.jumlah_pemukiman,

    /* Embung / mata air */
    tb_embung_mata_air.jumlah_embung,
    tb_embung_mata_air.lokasi_mata_air,

    /* Kumuh */
    tb_permukiman_kumuh.keberadaan_kumuh,
    tb_permukiman_kumuh.jumlah_kumuh,

    /* Galian */
    tb_lokasi_penggalian.keberadaan_galian,

    /* Prasarana kebersihan */
    tb_prasarana_kebersihan.jumlah_prasarana,

    /* Rumah tidak layak */
    tb_rumah_tidak_layak_huni.jumlah_rumah,

    /* Bencana alam */
    tb_bencana_alam.tanah_longsor,
    tb_bencana_alam.banjir,
    tb_bencana_alam.banjir_bandang,
    tb_bencana_alam.gempa_bumi,
    tb_bencana_alam.tsunami,
    tb_bencana_alam.gelombang_pasang,
    tb_bencana_alam.angin_puyuh,
    tb_bencana_alam.gunung_meletus,
    tb_bencana_alam.kebakaran_hutan,
    tb_bencana_alam.kekeringan,
    tb_bencana_alam.abrasi,

    /* Peringatan bencana */
    tb_peringatan_bencana.peringatan_dini,
    tb_peringatan_bencana.peringatan_tsunami,
    tb_peringatan_bencana.perlengkapan_keselamatan,
    tb_peringatan_bencana.rambu_evakuasi,
    tb_peringatan_bencana.infrastruktur,

    /* Taman bacaan */
    tb_taman_bacaan.keberadaan_tbm,

    /* Bidan / dukun bayi */
    tb_keberadaan_bidan.keberadaan_bidan,
    tb_keberadaan_dukun_bayi.keberadaan_dukun_bayi,

    /* KLB wabah */
    tb_klb_wabah.muntaber_diare,
    tb_klb_wabah.demam_berdarah,
    tb_klb_wabah.campak,
    tb_klb_wabah.malaria,
    tb_klb_wabah.flu_burung_sars,
    tb_klb_wabah.hepatitis_e,
    tb_klb_wabah.difteri,
    tb_klb_wabah.corona_covid19,
    tb_klb_wabah.lainnya_name,
    tb_klb_wabah.lainnya_status,

    /* Tempat Ibadah */
    tb_tempat_ibadah.jumlah_masjid,
    tb_tempat_ibadah.jumlah_pura,
    tb_tempat_ibadah.jumlah_musala,
    tb_tempat_ibadah.jumlah_wihara,	
    tb_tempat_ibadah.jumlah_gereja_kristen,	
    tb_tempat_ibadah.jumlah_kelenteng,	
    tb_tempat_ibadah.jumlah_gereja_katolik,	
    tb_tempat_ibadah.jumlah_balai_basarah,	
    tb_tempat_ibadah.jumlah_kapel,	
    tb_tempat_ibadah.lainnya,
    tb_tempat_ibadah.jumlah_lainnya,	

    /* Disabilitas */
    tb_disabilitas.jumlah_tuna_netra,
    tb_disabilitas.jumlah_tuna_rungu,
    tb_disabilitas.jumlah_tuna_wicara,
    tb_disabilitas.jumlah_tuna_rungu_wicara,
    tb_disabilitas.jumlah_tuna_daksa,
    tb_disabilitas.jumlah_tuna_grahita,
    tb_disabilitas.jumlah_tuna_laras,
    tb_disabilitas.jumlah_tuna_eks_kusta,
    tb_disabilitas.jumlah_tuna_ganda,

    /* Ruang publik */
    tb_ruang_publik.status_ruang_publik,
    tb_ruang_publik.ruang_terbuka_hijau,
    tb_ruang_publik.ruang_terbuka_non_hijau,

    /* Fasilitas olahraga */
    tb_fasilitas_olahraga.sepak_bola,
    tb_fasilitas_olahraga.bola_voli,
    tb_fasilitas_olahraga.bulu_tangkis,
    tb_fasilitas_olahraga.bola_basket,
    tb_fasilitas_olahraga.tenis_lapangan,
    tb_fasilitas_olahraga.tenis_meja,
    tb_fasilitas_olahraga.futsal,
    tb_fasilitas_olahraga.renang,
    tb_fasilitas_olahraga.bela_diri,
    tb_fasilitas_olahraga.bilyard,
    tb_fasilitas_olahraga.fitness,
    tb_fasilitas_olahraga.lainnya_nama,
    tb_fasilitas_olahraga.lainnya_kondisi,

    /* Prasarana Transportasi */
    tb_prasarana_transportasi.lalu_lintas,
    tb_prasarana_transportasi.jenis_permukaan_jalan,
    tb_prasarana_transportasi.jalan_darat_bisa_dilalui,
    tb_prasarana_transportasi.keberadaan_angkutan_umum,
    tb_prasarana_transportasi.operasional_angkutan_umum,
    tb_prasarana_transportasi.jam_operasi_angkutan_umum,

    /* Internet Transportasi */
    tb_internet_transportasi.keberadaan_internet,

    /* Menara Telepon */
    tb_menara_telepon.jumlah_bts,
    tb_menara_telepon.jumlah_operator_telekomunikasi,
    tb_menara_telepon.sinyal_telepon,
    tb_menara_telepon.sinyal_internet,

    /* Ketersediaan Internet */
    tb_ketersediaan_internet.kondisi_komputer,
    tb_ketersediaan_internet.fasilitas_internet,

    /* Kantor Pos */
    tb_keberadaan_kantor_pos.kantor_pos,
    tb_keberadaan_kantor_pos.layanan_pos_keliling,
    tb_keberadaan_kantor_pos.ekspedisi_swasta,

    /* Sentra Industri */
    tb_sentra_industri.keberadaan,
    tb_sentra_industri.jumlah_sentra,
    tb_sentra_industri.produk_utama,

    /* Produk Unggulan */
    tb_produk_unggulan.keberadaan,
    tb_produk_unggulan.makanan_unggulan,
    tb_produk_unggulan.non_makanan_unggulan,

    /* Pangkalan Minyak */
    tb_pangkalan_minyak.keberadaan_minyak_tanah,
    tb_pangkalan_minyak.keberadaan_lpg,

    /* Bank Operasi */
    tb_bank_operasi.bank_pemerintah,
    tb_bank_operasi.bank_swasta,
    tb_bank_operasi.bank_bpr,
    tb_bank_operasi.jarak_bank_terdekat,

    /* Koperasi */
    tb_koperasi.koperasi_kud,
    tb_koperasi.koperasi_kopinkra,
    tb_koperasi.koperasi_ksp,
    tb_koperasi.koperasi_lainnya,
    tb_koperasi.toko_kud,
    tb_koperasi.toko_bumdesa,
    tb_koperasi.toko_lainnya,

    /* Sarana Ekonomi */
    tb_sarana_ekonomi.bmt_jumlah,
    tb_sarana_ekonomi.bmt_jarak,
    tb_sarana_ekonomi.bmt_kemudahan,
    tb_sarana_ekonomi.atm_jumlah,
    tb_sarana_ekonomi.atm_jarak,
    tb_sarana_ekonomi.atm_kemudahan,
    tb_sarana_ekonomi.agen_bank_jumlah,
    tb_sarana_ekonomi.agen_bank_jarak,
    tb_sarana_ekonomi.agen_bank_kemudahan,
    tb_sarana_ekonomi.valas_jumlah,
    tb_sarana_ekonomi.valas_jarak,
    tb_sarana_ekonomi.valas_kemudahan,
    tb_sarana_ekonomi.pegadaian_jumlah,
    tb_sarana_ekonomi.pegadaian_jarak,
    tb_sarana_ekonomi.pegadaian_kemudahan,
    tb_sarana_ekonomi.agen_tiket_jumlah,
    tb_sarana_ekonomi.agen_tiket_jarak,
    tb_sarana_ekonomi.agen_tiket_kemudahan,
    tb_sarana_ekonomi.bengkel_jumlah,
    tb_sarana_ekonomi.bengkel_jarak,
    tb_sarana_ekonomi.bengkel_kemudahan,
    tb_sarana_ekonomi.salon_jumlah,
    tb_sarana_ekonomi.salon_jarak,
    tb_sarana_ekonomi.salon_kemudahan,

    /* Sarana Prasarana */
    tb_sarana_prasarana.kelompok_pertokoan_jumlah,
    tb_sarana_prasarana.kelompok_pertokoan_kemudahan,
    tb_sarana_prasarana.pasar_permanen_jumlah,
    tb_sarana_prasarana.pasar_permanen_kemudahan,
    tb_sarana_prasarana.pasar_semi_permanen_jumlah,
    tb_sarana_prasarana.pasar_semi_permanen_kemudahan,
    tb_sarana_prasarana.pasar_tanpa_bangunan_jumlah,
    tb_sarana_prasarana.pasar_tanpa_bangunan_kemudahan,
    tb_sarana_prasarana.minimarket_jumlah,
    tb_sarana_prasarana.minimarket_kemudahan,
    tb_sarana_prasarana.restoran_jumlah,
    tb_sarana_prasarana.restoran_kemudahan,
    tb_sarana_prasarana.warung_makan_jumlah,
    tb_sarana_prasarana.warung_makan_kemudahan,
    tb_sarana_prasarana.toko_kelontong_jumlah,
    tb_sarana_prasarana.toko_kelontong_kemudahan,
    tb_sarana_prasarana.hotel_jumlah,
    tb_sarana_prasarana.hotel_kemudahan,
    tb_sarana_prasarana.penginapan_jumlah,
    tb_sarana_prasarana.penginapan_kemudahan,

    /* Perkelahian Massal */
    tb_perkelahian_massal.kejadian AS kejadian_perkelahian_massal,

    /* Keamanan Lingkungan */
    tb_keamanan_lingkungan.pembangunan_pos_keamanan,
    tb_keamanan_lingkungan.pembentukan_regu_keamanan,
    tb_keamanan_lingkungan.penambahan_anggota_hansip,
    tb_keamanan_lingkungan.pelaporan_tamu_menginap,
    tb_keamanan_lingkungan.pengaktifan_sistem_keamanan,

    /* Linmas */
    tb_linmas_poskamling.jumlah_anggota_linmas,

    /* Pos Polisi */
    tb_keberadaan_pos_polisi.keberadaan_pos_polisi
FROM
    tb_enumerator

/* JOIN user_progress sebagai sumber TAHUN */
LEFT JOIN (
    SELECT DISTINCT desa_id, tahun
    FROM user_progress
) AS filtered_user_progress
    ON filtered_user_progress.desa_id = tb_enumerator.id_desa

/* SK Pembentukan */
LEFT JOIN tb_sk_pembentukan
    ON tb_sk_pembentukan.desa_id = tb_enumerator.id_desa
   AND tb_sk_pembentukan.tahun   = filtered_user_progress.tahun

/* Balai Desa */
LEFT JOIN tb_balai_desa
    ON tb_balai_desa.desa_id = tb_enumerator.id_desa
   AND tb_balai_desa.tahun   = filtered_user_progress.tahun

/* Batas Desa */
LEFT JOIN tb_batas_desa
    ON tb_batas_desa.desa_id = tb_enumerator.id_desa
   AND tb_batas_desa.tahun   = filtered_user_progress.tahun

/* Jarak Kantor Desa */
LEFT JOIN tb_jarak_kantor_desa
    ON tb_jarak_kantor_desa.desa_id = tb_enumerator.id_desa
   AND tb_jarak_kantor_desa.tahun   = filtered_user_progress.tahun

/* IDM Status */
LEFT JOIN tb_idm_status
    ON tb_idm_status.desa_id = tb_enumerator.id_desa
   AND tb_idm_status.tahun   = filtered_user_progress.tahun

/* Website Medsos */
LEFT JOIN tb_website_medsos
    ON tb_website_medsos.desa_id = tb_enumerator.id_desa
   AND tb_website_medsos.tahun   = filtered_user_progress.tahun

/* Status Pemerintahan */
LEFT JOIN tb_status_pemerintahan
    ON tb_status_pemerintahan.desa_id = tb_enumerator.id_desa
   AND tb_status_pemerintahan.tahun   = filtered_user_progress.tahun

/* Ketersediaan Penetapan Peta Desa */
LEFT JOIN tb_ketersediaan_penetapan_peta_desa
    ON tb_ketersediaan_penetapan_peta_desa.desa_id = tb_enumerator.id_desa
   AND tb_ketersediaan_penetapan_peta_desa.tahun   = filtered_user_progress.tahun

/* Banyaknya Dusun/RW/RT */
LEFT JOIN tb_banyaknya_dusun_rt_rw
    ON tb_banyaknya_dusun_rt_rw.desa_id = tb_enumerator.id_desa
   AND tb_banyaknya_dusun_rt_rw.tahun   = filtered_user_progress.tahun

/* Luas Wilayah */
LEFT JOIN tb_luas_wilayah_desa
    ON tb_luas_wilayah_desa.desa_id = tb_enumerator.id_desa
   AND tb_luas_wilayah_desa.tahun   = filtered_user_progress.tahun

/* Topografi */
LEFT JOIN tb_topografi_terluas_wilayah_desa
    ON tb_topografi_terluas_wilayah_desa.desa_id = tb_enumerator.id_desa
   AND tb_topografi_terluas_wilayah_desa.tahun   = filtered_user_progress.tahun

/* Kepemilikan Kantor */
LEFT JOIN tb_kepemilikan_kantor
    ON tb_kepemilikan_kantor.desa_id = tb_enumerator.id_desa
   AND tb_kepemilikan_kantor.tahun   = filtered_user_progress.tahun

/* Titik Koordinat */
LEFT JOIN tb_titik_koordinat_kantor_desa
    ON tb_titik_koordinat_kantor_desa.desa_id = tb_enumerator.id_desa
   AND tb_titik_koordinat_kantor_desa.tahun   = filtered_user_progress.tahun

/* Kematian */
LEFT JOIN tb_kematian
    ON tb_kematian.desa_id = tb_enumerator.id_desa
   AND tb_kematian.tahun   = filtered_user_progress.tahun

/* Penduduk & Keluarga */
LEFT JOIN tb_penduduk_dan_keluarga
    ON tb_penduduk_dan_keluarga.desa_id = tb_enumerator.id_desa
   AND tb_penduduk_dan_keluarga.tahun   = filtered_user_progress.tahun

/* Ketenagakerjaan */
LEFT JOIN tb_ketenagakerjaan
    ON tb_ketenagakerjaan.desa_id = tb_enumerator.id_desa
   AND tb_ketenagakerjaan.tahun   = filtered_user_progress.tahun

/* Pengguna Listrik & Lampu Surya */
LEFT JOIN tb_pengguna_listrik_lampu_surya
    ON tb_pengguna_listrik_lampu_surya.desa_id = tb_enumerator.id_desa
   AND tb_pengguna_listrik_lampu_surya.tahun   = filtered_user_progress.tahun

/* Penerangan Jalan */
LEFT JOIN tb_penerangan_jalan
    ON tb_penerangan_jalan.desa_id = tb_enumerator.id_desa
   AND tb_penerangan_jalan.tahun   = filtered_user_progress.tahun

/* Pengelolaan Sampah */
LEFT JOIN tb_pengelolaan_sampah
    ON tb_pengelolaan_sampah.desa_id = tb_enumerator.id_desa
   AND tb_pengelolaan_sampah.tahun   = filtered_user_progress.tahun

/* SUTET */
LEFT JOIN tb_sutet
    ON tb_sutet.desa_id = tb_enumerator.id_desa
   AND tb_sutet.tahun   = filtered_user_progress.tahun

/* Keberadaan Sungai */
LEFT JOIN tb_keberadaan_sungai
    ON tb_keberadaan_sungai.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_sungai.tahun   = filtered_user_progress.tahun

/* Keberadaan Danau */
LEFT JOIN tb_keberadaan_danau
    ON tb_keberadaan_danau.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_danau.tahun   = filtered_user_progress.tahun

/* Pemukiman Bantaran Sungai */
LEFT JOIN tb_keberadaan_pemukiman_bantaran
    ON tb_keberadaan_pemukiman_bantaran.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_pemukiman_bantaran.tahun   = filtered_user_progress.tahun

/* Embung & Mata Air */
LEFT JOIN tb_embung_mata_air
    ON tb_embung_mata_air.desa_id = tb_enumerator.id_desa
   AND tb_embung_mata_air.tahun   = filtered_user_progress.tahun

/* Permukiman Kumuh */
LEFT JOIN tb_permukiman_kumuh
    ON tb_permukiman_kumuh.desa_id = tb_enumerator.id_desa
   AND tb_permukiman_kumuh.tahun   = filtered_user_progress.tahun

/* Lokasi Penggalian */
LEFT JOIN tb_lokasi_penggalian
    ON tb_lokasi_penggalian.desa_id = tb_enumerator.id_desa
   AND tb_lokasi_penggalian.tahun   = filtered_user_progress.tahun

/* Prasarana Kebersihan */
LEFT JOIN tb_prasarana_kebersihan
    ON tb_prasarana_kebersihan.desa_id = tb_enumerator.id_desa
   AND tb_prasarana_kebersihan.tahun   = filtered_user_progress.tahun

/* Rumah Tidak Layak Huni */
LEFT JOIN tb_rumah_tidak_layak_huni
    ON tb_rumah_tidak_layak_huni.desa_id = tb_enumerator.id_desa
   AND tb_rumah_tidak_layak_huni.tahun   = filtered_user_progress.tahun

/* Bencana Alam */
LEFT JOIN tb_bencana_alam
    ON tb_bencana_alam.desa_id = tb_enumerator.id_desa
   AND tb_bencana_alam.tahun   = filtered_user_progress.tahun

/* Peringatan Bencana */
LEFT JOIN tb_peringatan_bencana
    ON tb_peringatan_bencana.desa_id = tb_enumerator.id_desa
   AND tb_peringatan_bencana.tahun   = filtered_user_progress.tahun

/* Taman Bacaan */
LEFT JOIN tb_taman_bacaan
    ON tb_taman_bacaan.desa_id = tb_enumerator.id_desa
   AND tb_taman_bacaan.tahun   = filtered_user_progress.tahun

/* Bidan */
LEFT JOIN tb_keberadaan_bidan
    ON tb_keberadaan_bidan.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_bidan.tahun   = filtered_user_progress.tahun

/* Dukun Bayi */
LEFT JOIN tb_keberadaan_dukun_bayi
    ON tb_keberadaan_dukun_bayi.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_dukun_bayi.tahun   = filtered_user_progress.tahun

/* KLB Wabah */
LEFT JOIN tb_klb_wabah
    ON tb_klb_wabah.desa_id = tb_enumerator.id_desa
   AND tb_klb_wabah.tahun   = filtered_user_progress.tahun

/* Tempat Ibadah */
LEFT JOIN tb_tempat_ibadah
    ON tb_tempat_ibadah.desa_id = tb_enumerator.id_desa
   AND tb_tempat_ibadah.tahun   = filtered_user_progress.tahun

/* Disabilitas */
LEFT JOIN tb_disabilitas
    ON tb_disabilitas.desa_id = tb_enumerator.id_desa
   AND tb_disabilitas.tahun   = filtered_user_progress.tahun

/* Ruang Publik */
LEFT JOIN tb_ruang_publik
    ON tb_ruang_publik.desa_id = tb_enumerator.id_desa
   AND tb_ruang_publik.tahun   = filtered_user_progress.tahun

/* Fasilitas Olahraga */
LEFT JOIN tb_fasilitas_olahraga
    ON tb_fasilitas_olahraga.desa_id = tb_enumerator.id_desa
   AND tb_fasilitas_olahraga.tahun   = filtered_user_progress.tahun

/* Prasarana Transportasi */
LEFT JOIN tb_prasarana_transportasi
    ON tb_prasarana_transportasi.desa_id = tb_enumerator.id_desa
   AND tb_prasarana_transportasi.tahun   = filtered_user_progress.tahun

/* Internet Transportasi */
LEFT JOIN tb_internet_transportasi
    ON tb_internet_transportasi.desa_id = tb_enumerator.id_desa
   AND tb_internet_transportasi.tahun   = filtered_user_progress.tahun

/* Menara Telepon */
LEFT JOIN tb_menara_telepon
    ON tb_menara_telepon.desa_id = tb_enumerator.id_desa
   AND tb_menara_telepon.tahun   = filtered_user_progress.tahun

/* Ketersediaan Internet */
LEFT JOIN tb_ketersediaan_internet
    ON tb_ketersediaan_internet.desa_id = tb_enumerator.id_desa
   AND tb_ketersediaan_internet.tahun   = filtered_user_progress.tahun

/* Kantor Pos */
LEFT JOIN tb_keberadaan_kantor_pos
    ON tb_keberadaan_kantor_pos.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_kantor_pos.tahun   = filtered_user_progress.tahun

/* Sentra Industri */
LEFT JOIN tb_sentra_industri
    ON tb_sentra_industri.desa_id = tb_enumerator.id_desa
   AND tb_sentra_industri.tahun   = filtered_user_progress.tahun

/* Produk Unggulan */
LEFT JOIN tb_produk_unggulan
    ON tb_produk_unggulan.desa_id = tb_enumerator.id_desa
   AND tb_produk_unggulan.tahun   = filtered_user_progress.tahun

/* Pangkalan Minyak */
LEFT JOIN tb_pangkalan_minyak
    ON tb_pangkalan_minyak.desa_id = tb_enumerator.id_desa
   AND tb_pangkalan_minyak.tahun   = filtered_user_progress.tahun

/* Bank Operasi */
LEFT JOIN tb_bank_operasi
    ON tb_bank_operasi.desa_id = tb_enumerator.id_desa
   AND tb_bank_operasi.tahun   = filtered_user_progress.tahun

/* Koperasi */
LEFT JOIN tb_koperasi
    ON tb_koperasi.desa_id = tb_enumerator.id_desa
   AND tb_koperasi.tahun   = filtered_user_progress.tahun

/* Sarana Ekonomi */
LEFT JOIN tb_sarana_ekonomi
    ON tb_sarana_ekonomi.desa_id = tb_enumerator.id_desa
   AND tb_sarana_ekonomi.tahun   = filtered_user_progress.tahun

/* Sarana Prasarana */
LEFT JOIN tb_sarana_prasarana
    ON tb_sarana_prasarana.desa_id = tb_enumerator.id_desa
   AND tb_sarana_prasarana.tahun   = filtered_user_progress.tahun

/* Perkelahian Massal */
LEFT JOIN tb_perkelahian_massal
    ON tb_perkelahian_massal.desa_id = tb_enumerator.id_desa
   AND tb_perkelahian_massal.tahun   = filtered_user_progress.tahun

/* Keamanan Lingkungan */
LEFT JOIN tb_keamanan_lingkungan
    ON tb_keamanan_lingkungan.desa_id = tb_enumerator.id_desa
   AND tb_keamanan_lingkungan.tahun   = filtered_user_progress.tahun

/* Linmas & Poskamling */
LEFT JOIN tb_linmas_poskamling
    ON tb_linmas_poskamling.desa_id = tb_enumerator.id_desa
   AND tb_linmas_poskamling.tahun   = filtered_user_progress.tahun

/* Pos Polisi */
LEFT JOIN tb_keberadaan_pos_polisi
    ON tb_keberadaan_pos_polisi.desa_id = tb_enumerator.id_desa
   AND tb_keberadaan_pos_polisi.tahun   = filtered_user_progress.tahun
";

// ==================== Query Baru ($query_baru) ====================
$query_baru = "
SELECT DISTINCT 
    /* Ambil tahun dari user_progress (alias: 'tahun') */
    filtered_user_progress.tahun AS tahun,

    tb_enumerator.kode_desa,

    tb_tanah_kas_desa.tanah_bengkok,
    tb_tanah_kas_desa.tanah_titi_sara,
    tb_tanah_kas_desa.kebun_desa,
    tb_tanah_kas_desa.sawah_desa,

    tb_pemanfaatan_sistem.keberadaan_sistem_informasi_desa,
    tb_pemanfaatan_sistem.keberadaan_sistem_keuangan_desa,

    tb_badan_usaha_aset_desa.jumlah_unit_usaha_bumdes,
    tb_badan_usaha_aset_desa.tanah_kas_desa_ulayat,
    tb_badan_usaha_aset_desa.tambatan_perahu,
    tb_badan_usaha_aset_desa.pasar_desa,
    tb_badan_usaha_aset_desa.bangunan_milik_desa,
    tb_badan_usaha_aset_desa.hutan_milik_desa,
    tb_badan_usaha_aset_desa.mata_air_milik_desa,
    tb_badan_usaha_aset_desa.tempat_wisata_pemandian_umum,
    tb_badan_usaha_aset_desa.aset_lainnya_milik_desa,

    tb_ketersediaan_rpjmdes_rkpdes.ketersediaan_rpjmdes,
    tb_ketersediaan_rpjmdes_rkpdes.tahun_awal_rpjmdes,
    tb_ketersediaan_rpjmdes_rkpdes.tahun_akhir_rpjmdes,
    tb_ketersediaan_rpjmdes_rkpdes.ketersediaan_rkpdes,

    tb_peraturan_desa.jumlah_peraturan_yang_dimiliki_desa,
    tb_peraturan_desa.jumlah_peraturan_kepala_desa,

    tb_kerjasama_desa.keberadaan_kerjasama_antar_desa,
    tb_kerjasama_desa.keberadaan_kerjasama_desa_dengan_pihak_ketiga,

    tb_pendamping_lokal_desa.keberadaan_pendamping_lokal_desa,

    tb_kader_pembangunan_manusia.keberadaan_kader_pembangunan_manusia,
    tb_kader_pembangunan_manusia.pembinaan_kpm_dari_pemkab_kota,

    tb_realisasi_anggaran_desa.pendapatan_asli_desa,
    tb_realisasi_anggaran_desa.dana_desa,
    tb_realisasi_anggaran_desa.bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah,
    tb_realisasi_anggaran_desa.alokasi_dana_desa,
    tb_realisasi_anggaran_desa.bantuan_keuangan_dari_apbd_provinsi,
    tb_realisasi_anggaran_desa.bantuan_keuangan_dari_apbd,
    tb_realisasi_anggaran_desa.hibah_dan_sumbangan_dari_pihak_ketiga,
    tb_realisasi_anggaran_desa.lain_lain_pendapatan_desa_yang_sah,

    tb_realisasi_anggaran_belanja_desa.bidang_penyelenggaraan_pemerintahan_desa,
    tb_realisasi_anggaran_belanja_desa.bidang_pelaksanaan_pembangunan_desa,
    tb_realisasi_anggaran_belanja_desa.bidang_pembinaan_kemasyarakatan,
    tb_realisasi_anggaran_belanja_desa.bidang_pemberdayaan_masyarakat,
    tb_realisasi_anggaran_belanja_desa.bidang_tak_terduga,

    tb_bumdes.status_keaktifan,
    tb_bumdes.status_badan_hukum,

    tb_pengadaan_barang_jasa.jumlah_paket_pengadaan_barang_dan_jasa,

    tb_penerima_bantuan_sosial.penerima_pkh,
    tb_penerima_bantuan_sosial.penerima_blt_dana_desa,
    tb_penerima_bantuan_sosial.penerima_bpnt,
    tb_penerima_bantuan_sosial.penerima_pbi_jk,
    tb_sktm.jumlah_sktm,

    tb_kepala_desa.nama_kepala_desa,
    tb_kepala_desa.umur,
    tb_kepala_desa.jenis_kelamin,
    tb_kepala_desa.pendidikan_terakhir,
    tb_kepala_desa.tahun_mulai_menjabat,

    tb_perangkat_desa.skd_laki,
    tb_perangkat_desa.skd_perempuan,
    tb_perangkat_desa.kaur_laki,
    tb_perangkat_desa.kaur_perempuan,
    tb_perangkat_desa.kkk_laki,
    tb_perangkat_desa.kkk_perempuan,
    tb_perangkat_desa.pk_laki,
    tb_perangkat_desa.pk_perempuan,
    tb_perangkat_desa.staf_laki,
    tb_perangkat_desa.staf_perempuan,
    tb_perangkat_desa.total_laki,
    tb_perangkat_desa.total_perempuan,

    tb_perangkat_desa_pendidikan.tidak_sekolah_laki,
    tb_perangkat_desa_pendidikan.tidak_sekolah_perempuan,
    tb_perangkat_desa_pendidikan.tidak_tamat_sd_laki,
    tb_perangkat_desa_pendidikan.tidak_tamat_sd_perempuan,
    tb_perangkat_desa_pendidikan.tamat_sd_laki,
    tb_perangkat_desa_pendidikan.tamat_sd_perempuan,
    tb_perangkat_desa_pendidikan.smp_laki,
    tb_perangkat_desa_pendidikan.smp_perempuan,
    tb_perangkat_desa_pendidikan.smu_laki,
    tb_perangkat_desa_pendidikan.smu_perempuan,
    tb_perangkat_desa_pendidikan.d3_laki,
    tb_perangkat_desa_pendidikan.d3_perempuan,
    tb_perangkat_desa_pendidikan.s1_laki,
    tb_perangkat_desa_pendidikan.s1_perempuan,
    tb_perangkat_desa_pendidikan.s2_laki,
    tb_perangkat_desa_pendidikan.s2_perempuan,
    tb_perangkat_desa_pendidikan.s3_laki,
    tb_perangkat_desa_pendidikan.s3_perempuan,
    tb_perangkat_desa_pendidikan.total_laki,
    tb_perangkat_desa_pendidikan.total_perempuan,

    tb_badan_permusyawaratan_desa.keberadaan_bpd,
    tb_badan_permusyawaratan_desa.jumlah_laki,
    tb_badan_permusyawaratan_desa.jumlah_perempuan,
    tb_badan_permusyawaratan_desa.jumlah_kegiatan,

    tb_data_pkk.jumlah_tim_penggerak_pkk,
    tb_data_pkk.jumlah_kader_pkk,
    tb_data_pkk.jumlah_kelompok_pkk,
    tb_data_pkk.jumlah_kelompok_dasa_wisma,

    tb_karang_taruna.jumlah_karang_taruna,
    tb_posyandu.jumlah_posyandu,
    tb_lpmd.jumlah_anggota_laki,
    tb_lpmd.jumlah_anggota_perempuan

FROM
    tb_enumerator

/* JOIN user_progress sebagai sumber TAHUN */
LEFT JOIN (
    SELECT DISTINCT desa_id, tahun
    FROM user_progress
) AS filtered_user_progress
    ON filtered_user_progress.desa_id = tb_enumerator.id_desa

/* Tanah Kas Desa */
LEFT JOIN tb_tanah_kas_desa
    ON tb_tanah_kas_desa.desa_id = tb_enumerator.id_desa
   AND tb_tanah_kas_desa.tahun   = filtered_user_progress.tahun

/* Pemanfaatan Sistem */
LEFT JOIN tb_pemanfaatan_sistem
    ON tb_pemanfaatan_sistem.desa_id = tb_enumerator.id_desa
   AND tb_pemanfaatan_sistem.tahun   = filtered_user_progress.tahun

/* Badan Usaha dan Aset Desa */
LEFT JOIN tb_badan_usaha_aset_desa
    ON tb_badan_usaha_aset_desa.desa_id = tb_enumerator.id_desa
   AND tb_badan_usaha_aset_desa.tahun   = filtered_user_progress.tahun

/* Ketersediaan RPJMDES/RKPDes */
LEFT JOIN tb_ketersediaan_rpjmdes_rkpdes
    ON tb_ketersediaan_rpjmdes_rkpdes.desa_id = tb_enumerator.id_desa
   AND tb_ketersediaan_rpjmdes_rkpdes.tahun   = filtered_user_progress.tahun

/* Peraturan Desa */
LEFT JOIN tb_peraturan_desa
    ON tb_peraturan_desa.desa_id = tb_enumerator.id_desa
   AND tb_peraturan_desa.tahun   = filtered_user_progress.tahun

/* Kerjasama Desa */
LEFT JOIN tb_kerjasama_desa
    ON tb_kerjasama_desa.desa_id = tb_enumerator.id_desa
   AND tb_kerjasama_desa.tahun   = filtered_user_progress.tahun

/* Pendamping Lokal Desa */
LEFT JOIN tb_pendamping_lokal_desa
    ON tb_pendamping_lokal_desa.desa_id = tb_enumerator.id_desa
   AND tb_pendamping_lokal_desa.tahun   = filtered_user_progress.tahun

/* Kader Pembangunan Manusia */
LEFT JOIN tb_kader_pembangunan_manusia
    ON tb_kader_pembangunan_manusia.desa_id = tb_enumerator.id_desa
   AND tb_kader_pembangunan_manusia.tahun   = filtered_user_progress.tahun

/* Realisasi Anggaran Desa */
LEFT JOIN tb_realisasi_anggaran_desa
    ON tb_realisasi_anggaran_desa.desa_id = tb_enumerator.id_desa
   AND tb_realisasi_anggaran_desa.tahun   = filtered_user_progress.tahun

/* Realisasi Anggaran Belanja Desa */
LEFT JOIN tb_realisasi_anggaran_belanja_desa
    ON tb_realisasi_anggaran_belanja_desa.desa_id = tb_enumerator.id_desa
   AND tb_realisasi_anggaran_belanja_desa.tahun   = filtered_user_progress.tahun

/* BUMDes */
LEFT JOIN tb_bumdes
    ON tb_bumdes.desa_id = tb_enumerator.id_desa
   AND tb_bumdes.tahun   = filtered_user_progress.tahun

/* Pengadaan Barang dan Jasa */
LEFT JOIN tb_pengadaan_barang_jasa
    ON tb_pengadaan_barang_jasa.desa_id = tb_enumerator.id_desa
   AND tb_pengadaan_barang_jasa.tahun   = filtered_user_progress.tahun

/* Penerima Bantuan Sosial */
LEFT JOIN tb_penerima_bantuan_sosial
    ON tb_penerima_bantuan_sosial.desa_id = tb_enumerator.id_desa
   AND tb_penerima_bantuan_sosial.tahun   = filtered_user_progress.tahun

/* SKTM */
LEFT JOIN tb_sktm
    ON tb_sktm.desa_id = tb_enumerator.id_desa
   AND tb_sktm.tahun   = filtered_user_progress.tahun

/* Kepala Desa */
LEFT JOIN tb_kepala_desa
    ON tb_kepala_desa.desa_id = tb_enumerator.id_desa
   AND tb_kepala_desa.tahun   = filtered_user_progress.tahun

/* Perangkat Desa */
LEFT JOIN tb_perangkat_desa
    ON tb_perangkat_desa.desa_id = tb_enumerator.id_desa
   AND tb_perangkat_desa.tahun   = filtered_user_progress.tahun

/* Pendidikan Perangkat Desa */
LEFT JOIN tb_perangkat_desa_pendidikan
    ON tb_perangkat_desa_pendidikan.desa_id = tb_enumerator.id_desa
   AND tb_perangkat_desa_pendidikan.tahun   = filtered_user_progress.tahun

/* Badan Permusyawaratan Desa */
LEFT JOIN tb_badan_permusyawaratan_desa
    ON tb_badan_permusyawaratan_desa.desa_id = tb_enumerator.id_desa
   AND tb_badan_permusyawaratan_desa.tahun   = filtered_user_progress.tahun

/* Data PKK */
LEFT JOIN tb_data_pkk
    ON tb_data_pkk.desa_id = tb_enumerator.id_desa
   AND tb_data_pkk.tahun   = filtered_user_progress.tahun

/* Karang Taruna */
LEFT JOIN tb_karang_taruna
    ON tb_karang_taruna.desa_id = tb_enumerator.id_desa
   AND tb_karang_taruna.tahun   = filtered_user_progress.tahun

/* Posyandu */
LEFT JOIN tb_posyandu
    ON tb_posyandu.desa_id = tb_enumerator.id_desa
   AND tb_posyandu.tahun   = filtered_user_progress.tahun

/* LPMD */
LEFT JOIN tb_lpmd
    ON tb_lpmd.desa_id = tb_enumerator.id_desa
   AND tb_lpmd.tahun   = filtered_user_progress.tahun

";

// ==================== Tambahkan Filter (WHERE) ====================
$where = [];
$params = [];
$types = '';

// Jika ada filter kecamatan
if (!empty($kode_kecamatan)) {
    $where[] = "tb_enumerator.kecamatan = ?";
    $params[] = $kode_kecamatan;
    $types .= 's';
}

// Jika ada filter desa
if (!empty($kode_desa)) {
    $where[] = "tb_enumerator.kode_desa = ?";
    $params[] = $kode_desa;
    $types .= 's';
}

// Jika ada filter tahun
if (!empty($filter_tahun)) {
    $where[] = "filtered_user_progress.tahun = ?";
    $params[] = $filter_tahun;
    $types .= 'i';
}

// Tambahkan syarat agar 'tahun' tidak NULL
$where[] = "filtered_user_progress.tahun IS NOT NULL";

// Buat kondisi WHERE
$whereClause = "";
if ($where) {
    $whereClause = " WHERE " . implode(" AND ", $where);
}

// Tambahkan WHERE ke kedua query
$query .= $whereClause;
$query_baru .= $whereClause;

// ==================== Eksekusi Kedua Query ====================

// Eksekusi query utama ($query)
$stmt1 = mysqli_prepare($conn, $query);
if (!$stmt1) {
    die("Gagal menyiapkan pernyataan SQL untuk query1: " . mysqli_error($conn));
}
if ($params) {
    mysqli_stmt_bind_param($stmt1, $types, ...$params);
}
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);

if (!$result1) {
    die("Gagal mengeksekusi query1: " . mysqli_error($conn));
}

// Eksekusi query baru ($query_baru)
$stmt2 = mysqli_prepare($conn, $query_baru);
if (!$stmt2) {
    die("Gagal menyiapkan pernyataan SQL untuk query_baru: " . mysqli_error($conn));
}
if ($params) {
    mysqli_stmt_bind_param($stmt2, $types, ...$params);
}
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

if (!$result2) {
    die("Gagal mengeksekusi query_baru: " . mysqli_error($conn));
}

// ==================== Menggabungkan Data dari Kedua Query ====================

// Fetch data dari query1
$data1 = [];
while ($row = mysqli_fetch_assoc($result1)) {
    $kode = $row['kode_desa'];
    $data1[$kode][$row['tahun']] = $row;
}

// Fetch data dari query_baru dan merge dengan data1
while ($row = mysqli_fetch_assoc($result2)) {
    $kode = $row['kode_desa'];
    $tahun = $row['tahun'];
    if (isset($data1[$kode][$tahun])) {
        // Merge data dari query_baru ke data1
        foreach ($allColumns_query_baru as $col) {
            $data1[$kode][$tahun][$col] = $row[$col];
        }
    } else {
        // Jika kombinasi kode_desa dan tahun tidak ada di data1, tambahkan sebagai data baru
        $data1[$kode][$tahun] = $row;
    }
}

// Cek jika tidak ada data setelah penggabungan
if (empty($data1)) {
    die("Tidak ada data yang ditemukan dengan filter yang diberikan.");
}

// Atur $allData sebagai array gabungan
$allData = [];
foreach ($data1 as $desa => $tahunData) {
    foreach ($tahunData as $tahun => $data) {
        $allData[] = $data;
    }
}

/**
 * 4. Definisikan Fungsi untuk Membersihkan Nama Sheet
 */
function sanitizeSheetName($name, $maxLength = 31)
{
    // Hilangkan karakter ilegal
    $illegalChars = ['\\', '/', '?', '*', '[', ']', ':'];
    $name = str_replace($illegalChars, '', $name);

    // Truncate nama jika diperlukan
    if (strlen($name) > $maxLength) {
        $name = substr($name, 0, $maxLength);
    }

    return $name;
}

/**
 * 5. Export ke EXCEL atau PDF
 */

// ================= Export Excel (Multi-Sheet dengan Daftar Data Berisi Link) =================
if ($type === 'excel') {
    try {
        // Inisialisasi Spreadsheet
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Hapus sheet default

        /**
         * 6a. Membuat Sheet Indeks ("Daftar Data")
         */
        $daftarSheet = $spreadsheet->createSheet();
        $daftarSheet->setTitle('Daftar Data');

        // Header untuk Daftar Data
        $daftarSheet->setCellValue('A1', 'No');
        $daftarSheet->setCellValue('B1', 'Nama Data');

        // Definisi Style untuk Header Daftar Data
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Rata kiri
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        // Terapkan style header
        $daftarSheet->getStyle("A1:B1")->applyFromArray($headerStyle);

        // Array untuk menyimpan nama sheet yang sudah ada untuk memastikan unik
        $existingSheetNames = ['Daftar Data'];

        // Mapping grupName ke uniqueSheetName
        $sheetNameMap = [];

        // Isi Daftar Data dengan nama grup dan hyperlink
        $rowNum = 2;
        $no = 1;
        foreach ($groupedColumns as $groupName => $colsInGroup) {
            // Sanitasi nama sheet dan pastikan panjang <=31
            $sanitizedGroupSheetName = sanitizeSheetName($groupName, 31);

            // Pastikan nama sheet unik
            $uniqueSheetName = $sanitizedGroupSheetName;
            $counter = 1;
            while (in_array($uniqueSheetName, $existingSheetNames)) {
                // Tambahkan nomor di akhir nama sheet untuk memastikan unik
                $suffix = " ($counter)";
                // Pastikan total panjang nama sheet tidak melebihi 31 karakter
                $trimLength = 31 - strlen($suffix);
                $uniqueSheetName = substr($sanitizedGroupSheetName, 0, $trimLength) . $suffix;
                $counter++;
            }

            // Simpan mapping grupName ke uniqueSheetName
            $sheetNameMap[$groupName] = $uniqueSheetName;

            // Tambahkan nama sheet yang unik ke array existingSheetNames
            $existingSheetNames[] = $uniqueSheetName;

            // Tulis nomor
            $daftarSheet->setCellValue('A' . $rowNum, $no);

            // Tulis nama sheet dengan hyperlink
            $daftarSheet->setCellValue('B' . $rowNum, $groupName);
            // Buat hyperlink ke sheet tersebut
            $daftarSheet->getCell('B' . $rowNum)->getHyperlink()->setUrl("sheet://'" . $uniqueSheetName . "'!A1");
            // Tambahkan style untuk link
            $daftarSheet->getStyle('B' . $rowNum)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
            $daftarSheet->getStyle('B' . $rowNum)->getFont()->setUnderline(true);
            // Atur alignment rata kiri
            $daftarSheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $rowNum++;
            $no++;
        }

        // Terapkan style tabel (borders dan alignment rata kiri)
        $lastRowDaftar = $rowNum - 1;
        $daftarSheet->getStyle("A1:B{$lastRowDaftar}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Rata kiri
                'vertical'   => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Auto-width kolom
        foreach (range('A', 'B') as $columnID) {
            $daftarSheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        /**
         * 6b. Membuat Sheet-Group
         */
        foreach ($groupedColumns as $groupName => $colsInGroup) {
            // Buat sheet baru untuk grup
            $uniqueSheetName = $sheetNameMap[$groupName];
            $groupSheet = $spreadsheet->createSheet();
            $groupSheet->setTitle(substr($uniqueSheetName, 0, 31)); // Judul sheet (max 31 karakter)

            // Tulis header (baris 1)
            $currentCol = 1;
            foreach ($colsInGroup as $dbCol => $headerText) {
                $colLetter = Coordinate::stringFromColumnIndex($currentCol);
                $groupSheet->setCellValue($colLetter . '1', $headerText);
                $currentCol++;
            }

            // Definisi Style untuk Header
            $groupHeaderStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D3D3D3']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ];

            // Terapkan style header
            $lastColLetter = Coordinate::stringFromColumnIndex($currentCol - 1);
            $groupSheet->getStyle("A1:{$lastColLetter}1")->applyFromArray($groupHeaderStyle);

            // Isi data mulai dari baris 2
            $rowNumber = 2;
            foreach ($allData as $rowArr) {
                $colIdx = 1;
                foreach ($colsInGroup as $dbCol => $headerText) {
                    // Ambil nilai dari data gabungan
                    $value = isset($rowArr[$dbCol]) ? $rowArr[$dbCol] : '-';
                    $colLetter = Coordinate::stringFromColumnIndex($colIdx);
                    $groupSheet->setCellValue($colLetter . $rowNumber, $value);
                    $colIdx++;
                }
                $rowNumber++;
            }

            // Terapkan style tabel (borders dan alignment center)
            $lastRow = $rowNumber - 1;
            $groupSheet->getStyle("A1:{$lastColLetter}{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER
                ]
            ]);

            // Auto-width kolom
            for ($i = 1; $i <= count($colsInGroup); $i++) {
                $colLetter = Coordinate::stringFromColumnIndex($i);
                $groupSheet->getColumnDimension($colLetter)->setAutoSize(true);
            }
        }

        /**
         * 6c. Atur Sheet Indeks sebagai Sheet Aktif
         */
        // Pastikan "Daftar Data" adalah sheet pertama (index 0)
        $spreadsheet->setActiveSheetIndexByName('Daftar Data');

        /**
         * 6d. Output ke Browser
         */
        if (ob_get_level()) ob_end_clean(); // Bersihkan output buffer
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="rekap_data_pusdatin.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } catch (Exception $e) {
        die("Error exporting Excel: " . $e->getMessage());
    }
}

// ============== Export PDF (mPDF) ==============
if ($type === 'pdf') {
    try {
        // Inisialisasi mPDF dengan setting A4 Landscape dan margin yang sesuai
        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // Mulai membangun HTML untuk laporan
        $html = '
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 10pt;
                    color: #333333;
                }
                h1 {
                    text-align: center;
                    font-size: 18pt;
                    margin-bottom: 30px;
                }
                h2 {
                    font-size: 14pt;
                    color: #555555;
                    margin-top: 40px;
                    margin-bottom: 15px;
                    border-bottom: 1px solid #dddddd;
                    padding-bottom: 5px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #dddddd;
                    padding: 10px;
                    vertical-align: top;
                }
                th {
                    background-color: #f2f2f2;
                    text-align: center;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .section {
                    page-break-inside: avoid;
                }
                /* Responsive adjustments */
                @media print {
                    table {
                        page-break-inside: auto;
                    }
                    tr {
                        page-break-inside: avoid;
                        page-break-after: auto;
                    }
                    thead {
                        display: table-header-group;
                    }
                    tfoot {
                        display: table-footer-group;
                    }
                }
            </style>
            <h1>Rekap Data Pusdatin</h1>
        ';

        /**
         * 7. Menambahkan Data ke HTML untuk PDF
         */
        foreach ($groupedColumns as $groupName => $colsInGroup) {
            $html .= '<div class="section">';
            $html .= '<h2>' . htmlspecialchars($groupName) . '</h2>';
            $html .= '<table>';
            $html .= '<thead><tr>';

            // Header tabel
            foreach ($colsInGroup as $dbCol => $colHeader) {
                $html .= '<th>' . htmlspecialchars($colHeader) . '</th>';
            }
            $html .= '</tr></thead>';
            $html .= '<tbody>';

            // Isi data
            foreach ($allData as $rowArr) {
                $html .= '<tr>';
                foreach ($colsInGroup as $dbCol => $colHeader) {
                    $cellData = isset($rowArr[$dbCol]) ? htmlspecialchars($rowArr[$dbCol]) : '-';
                    // Tentukan apakah kolom tersebut berisi teks panjang
                    $isTextColumn = in_array($dbCol, [
                        'nama_desa',
                        'alamat_balai',
                        'alamat_website',
                        'alamat_email',
                        'alamat_facebook',
                        'alamat_twitter',
                        'alamat_youtube',
                        'status_pemerintahan',
                        'perlengkapan_keselamatan',
                        'lainnya_name',
                        'lainnya_status',
                        'makanan_unggulan',
                        'non_makanan_unggulan',
                        'lainnya_nama_olahraga',
                        'lainnya_kondisi_olahraga'
                    ]) || in_array($dbCol, [
                        // Tambahan kolom dari $query_baru
                        'tanah_bengkok',
                        'tanah_titi_sara',
                        'kebun_desa',
                        'sawah_desa',
                        'keberadaan_sistem_informasi_desa',
                        'keberadaan_sistem_keuangan_desa',
                        'jumlah_unit_usaha_bumdes',
                        'tanah_kas_desa_ulayat',
                        'tambatan_perahu',
                        'pasar_desa',
                        'bangunan_milik_desa',
                        'hutan_milik_desa',
                        'mata_air_milik_desa',
                        'tempat_wisata_pemandian_umum',
                        'aset_lainnya_milik_desa',
                        'ketersediaan_rpjmdes',
                        'tahun_awal_rpjmdes',
                        'tahun_akhir_rpjmdes',
                        'ketersediaan_rkpdes',
                        'jumlah_peraturan_yang_dimiliki_desa',
                        'jumlah_peraturan_kepala_desa',
                        'keberadaan_kerjasama_antar_desa',
                        'keberadaan_kerjasama_desa_dengan_pihak_ketiga',
                        'keberadaan_pendamping_lokal_desa',
                        'keberadaan_kader_pembangunan_manusia',
                        'pembinaan_kpm_dari_pemkab_kota',
                        'pendapatan_asli_desa',
                        'dana_desa',
                        'bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah',
                        'alokasi_dana_desa',
                        'bantuan_keuangan_dari_apbd_provinsi',
                        'bantuan_keuangan_dari_apbd',
                        'hibah_dan_sumbangan_dari_pihak_ketiga',
                        'lain_lain_pendapatan_desa_yang_sah',
                        'bidang_penyelenggaraan_pemerintahan_desa',
                        'bidang_pelaksanaan_pembangunan_desa',
                        'bidang_pembinaan_kemasyarakatan',
                        'bidang_pemberdayaan_masyarakat',
                        'bidang_tak_terduga',
                        'status_keaktifan',
                        'status_badan_hukum',
                        'jumlah_paket_pengadaan_barang_dan_jasa'
                    ]);
                    $textAlign = $isTextColumn ? 'left' : 'center';
                    $html .= '<td style="text-align:' . $textAlign . '; word-wrap: break-word;">' . $cellData . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</tbody></table>';
            $html .= '</div>';
        }

        // Tambahkan footer tanpa border dengan format "Generated on [Tanggal] Page X of Y"
        $mpdf->SetHTMLFooter('
            <div style="width: 100%; font-family: Arial, sans-serif; font-size: 9pt;">
                <span style="float: right;">Page {PAGENO} of {nbpg}</span> &nbsp;
                <span style="float: left;">(Generated on {DATE j-m-Y})</span>
            </div>
            <div style="clear: both;"></div>
        ');

        // Generate PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output('rekap_data_pusdatin.pdf', 'D');
        exit;
    } catch (Exception $e) {
        die("Error exporting PDF: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Rekap Data</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | General Form Elements">
    <meta name="author" content="ColorlibHQ">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->

        <?php include('../../components/navbar.php'); ?>

        <?php include('../../components/sidebar.php'); ?>
        <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Data Report</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Report
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->

            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Report</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#filterModal">
                                    <i class="fas fa-filter"></i>&nbsp; Filter
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#previewModal">
                                    <i class="fas fa-table"></i> &nbsp; Preview
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#exportModal">
                                    <i class="fas fa-download"></i>&nbsp; Export
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0" style="overflow-x: auto;">
                            <?php
                            $headers = [
                                '#',
                                'Periode Tahun',
                                'Kode Desa',
                                'Nama Desa',
                                'Kecamatan',
                                'Sk Pembentukan/Pengesahan Desa/Kelurahan',
                                'Alamat Balai Desa/Kantor Kelurahan',
                                'Batas Utara',
                                'Kec Utara',
                                'Batas Selatan',
                                'Kec Selatan',
                                'Batas Timur',
                                'Kec Timur',
                                'Batas Barat',
                                'Kec Barat',
                                'Jarak ke Ibu Kota Kecamatan (km)',
                                'Jarak ke Ibu Kota Kabupaten (km)',
                                'Status Desa Membangun',
                                'Alamat Website Desa',
                                'Alamat Email Desa',
                                'Alamat Facebook Desa',
                                'Alamat Twitter Desa',
                                'Alamat YouTube Desa',
                                'Status Pemerintahan',
                                'Penetapan Batas Desa',
                                'No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa',
                                'Ketersediaan Peta Desa',
                                'No SK/Perbup/Perda tentang Peta Desa',
                                'Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis',
                                'Banyaknya RW',
                                'Banyaknya RT',
                                'Luas Wilayah Desa',
                                'Topografi Terluas Wilayah Desa',
                                'Keberadaan kantor kepala desa/lurah',
                                'Status Kantor Kepala Desa/Lurah',
                                'Kondisi Kantor Kepala Desa/Balai Desa',
                                'Lokasi Kantor Kepala Desa/Lurah',
                                'Koordinat Lintang (Latitude)',
                                'Koordinat Bujur (Longitude)',
                                'Jumlah Surat Kematian Yang Dikeluarkan',
                                'Jumlah Penduduk Laki-Laki',
                                'Jumlah Penduduk Perempuan',
                                'Jumlah Kepala Keluarga',
                                'Keberadaan Warga Desa/Kelurahan yang Sedang Bekerja sebagai PMI (Pekerja Migran Indonesia)/TKI di Luar Negeri',
                                'Keberadaan Agen (Seseorang/Sekelompok Orang/Perusahaan) Pengerahan Pekerja Migran Indonesia/TKI ke Luar Negeri di Desa/Kelurahan',
                                'Layanan Rekomendasi/Surat Keterangan Bagi Warga Desa/Kelurahan yang Akan Bekerja Sebagai Pekerja Migran Indonesia/TKI di Luar Negeri',
                                'Keberadaan Warga Negara Asing (WNA) di Desa/Kelurahan',
                                'Jumlah Keluarga Pengguna Listrik PLN (Perusahaan Listrik Negara)',
                                'Jumlah Keluarga Pengguna Listrik Non-PLN',
                                'Jumlah Keluraga Bukan Pengguna Listrik',
                                'Keluarga yang Menggunakan Lampu Tenaga Surya',
                                'Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga Surya',
                                'Penerangan di Jalan Utama Desa/Kelurahan',
                                'Sumber Penerangan di Jalan Utama Desa/Kelurahan',
                                'Keberadaan Tempat Pembuangan Sampah Sementara (TPS)',
                                'Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)',
                                'Keberadaan Bank Sampah di Desa/Kelurahan',
                                'Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra tinggi (SUTET) / Saluran Udara Tegangan Tinggi (SUUT) / Saluran Udara Tegangan Tinggi Arus Searah (SUTTAS)',
                                'Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS',
                                'Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS',
                                'Keberadaan Sungai Yang Melintasi',
                                'Nama Sungai Yang Melintasi ke 1',
                                'Nama Sungai Yang Melintasi ke 2',
                                'Nama Sungai Yang Melintasi ke 3',
                                'Nama Sungai Yang Melintasi ke 4',
                                'Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa',
                                'Nama danau/waduk/situ yang berada di wilayah desa ke 1',
                                'Nama danau/waduk/situ yang berada di wilayah desa ke 2',
                                'Nama danau/waduk/situ yang berada di wilayah desa ke 3',
                                'Nama danau/waduk/situ yang berada di wilayah desa ke 4',
                                'Keberadaan Pemukiman Di Bantaran Sungai',
                                'Jumlah Pemukiman Di Bantaran Sungai',
                                'Jumlah Embung',
                                'Lokasi Mata Air',
                                'Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan Padat Dan Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan',
                                'Jumlah Pemukiman Kumuh',
                                'Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali, Pasir, Kapur, Kaolin, Pasir Kuarsa, Tanah Liat, Dll.)',
                                'Jumlah Sarana Prasarana Kebersihan',
                                'Jumlah Rumah Tidak Layak Huni',
                                'Tanah Longsor',
                                'Banjir',
                                'Banjir Bandang',
                                'Gempa Bumi',
                                'Tsunami',
                                'Gelombang Pasang',
                                'Angin Puyuh',
                                'Gunung Meletus',
                                'Kebakaran Hutan',
                                'Kekeringan',
                                'Abrasi',
                                'Sistem Peringatan Dini Bencana Alam',
                                'Sistem Peringatan Dini Khusus Tsunami',
                                'Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)',
                                'Rambu-Rambu dan Jalur Evakuasi Bencana',
                                'Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul, Parit, Drainase, Waduk, Pantai, dll.)',
                                'Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa',
                                'Keberadaan Bidan Desa yang menetap di Desa/Kelurahan',
                                'Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan',
                                'Muntaber/diare',
                                'Demam Berdarah',
                                'Campak',
                                'Malaria',
                                'Flu Burung/SARS',
                                'Hepatitis E',
                                'Difteri',
                                'Corona/COVID-19',
                                'Lainnya',
                                'Lainnya (Status)',
                                'Jumlah Masjid',
                                'Jumlah Pura',
                                'Jumlah Surau/Langgar/Musala',
                                'Jumlah Wihara',
                                'Jumlah Gereja Kristen',
                                'Jumlah Kelenteng',
                                'Jumlah Gereja Katolik',
                                'Jumlah Balai Basarah',
                                'Jumlah Kapel',
                                'Tempat Ibadah Lainnya',
                                'Jumlah Lainnya',
                                'Jumlah tuna netra (buta)',
                                'Jumlah tuna rungu (tuli)',
                                'Jumlah tuna wicara (bisu)',
                                'Jumlah tuna rungu-wicara (tuli-bisu)',
                                'Jumlah tuna daksa (disabilitas tubuh)',
                                'Jumlah tuna grahita (keterbelakangan mental)',
                                'Jumlah tuna laras (eks-sakit jiwa)',
                                'Jumlah tuna eks-sakit kusta',
                                'Jumlah tuna ganda (fisik-mental)',
                                'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)',
                                'Ruang Terbuka Hijau (RTH)',
                                'Ruang Terbuka Non Hijau (RTNH)',
                                'Sepak bola',
                                'Bola voli',
                                'Bulu tangkis',
                                'Bola basket',
                                'Tenis lapangan',
                                'Tenis meja',
                                'Futsal',
                                'Renang',
                                'Bela diri (pencak silat, karate, dll.)',
                                'Bilyard',
                                'Fitness, aerobik, dll.',
                                'Fasilitas Lainnya',
                                'Kondisi Fasilitas lainnya',
                                'Lalu lintas dari/ke desa/kelurahan melalui',
                                'Jenis permukaan jalan darat antar desa/kelurahan yang terluas',
                                'Jalan darat antar desa/kelurahan dapat dilalui kendaraan bermotor roda 4 atau lebih',
                                'Keberadaan angkutan umum',
                                'Operasional angkutan umum yang utama',
                                'Jam operasi angkutan umum yang utama',
                                'Keberadaan internet untuk warnet, game online, dan fasilitas lainnya di desa/kelurahan',
                                'Jumlah menara telepon seluler atau Base Transceiver Station (BTS)',
                                'Jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa',
                                'Sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
                                'Sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
                                'Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah',
                                'Fasilitas internet di kantor kepala desa/lurah',
                                'Kantor pos/pos pembantu/rumah pos',
                                'Layanan pos keliling',
                                'Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta',
                                'Keberadaan Sentra Industri Unggulan Desa',
                                'Sentra Industri',
                                'Produk pada sentra industri yang mempunyai muatan usaha terbanyak',
                                'Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)',
                                'Produk barang unggulan/utama desa/kelurahan (makanan)',
                                'Produk barang unggulan/utama desa/kelurahan (non makanan)',
                                'Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)',
                                'Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)',
                                'Jumlah Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)',
                                'Jumlah Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)',
                                'Jumlah Bank Perkreditan Rakyat (BPR)',
                                'Jika tidak ada bank, perkiraan jarak ke bank terdekat',
                                'Jumlah Koperasi Unit Desa (KUD)',
                                'Jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro',
                                'Jumlah Koperasi Simpan Pinjam (KSP/Kospin)',
                                'Jumlah Koperasi lainnya',
                                'Keberadaan Toko Milik KUD',
                                'Keberadaan Toko Milik BUM Desa',
                                'Keberadaan Toko Selain milik KUD/BUM Desa',
                                'Jumlah Sarana Baitul Maal Wa Tamwil (BMT)',
                                'Jarak Baitul Maal Wa Tamwil (BMT)',
                                'Kemudahan untuk Mencapai Baitul Maal Wa Tamwil (BMT)',
                                'Jumlah Sarana Anjungan Tunai Mandiri (ATM)',
                                'Jarak Anjungan Tunai Mandiri (ATM)',
                                'Kemudahan untuk Mencapai Anjungan Tunai Mandiri (ATM)',
                                'Jumlah Sarana Agen Bank',
                                'Jarak Agen Bank',
                                'Kemudahan untuk Mencapai Agen Bank',
                                'Jumlah Sarana Pedagang Valuta Asing',
                                'Jarak Pedagang Valuta Asing',
                                'Kemudahan untuk Mencapai Pedagang Valuta Asing',
                                'Jumlah Sarana Pergadaian',
                                'Jarak Pergadaian',
                                'Kemudahan untuk Mencapai Pergadaian',
                                'Jumlah Sarana Agen Tiket/Travel/Biro Perjalanan',
                                'Jarak Agen Tiket/Travel/Biro Perjalanan',
                                'Kemudahan untuk Mencapai Agen Tiket/Travel/Biro Perjalanan',
                                'Jumlah Sarana Bengkel Mobil/Motor',
                                'Jarak Bengkel Mobil/Motor',
                                'Kemudahan untuk Mencapai Bengkel Mobil/Motor',
                                'Jumlah Sarana Salon Kecantikan',
                                'Jarak Salon Kecantikan',
                                'Kemudahan untuk Mencapai Salon Kecantikan',
                                'Jumlah Sarana Kelompok pertokoan',
                                'Kemudahan untuk Mencapai Kelompok pertokoan',
                                'Jumlah Sarana Pasar dengan bangunan permanen',
                                'Kemudahan untuk Mencapai Pasar dengan bangunan permanen',
                                'Jumlah Sarana Pasar dengan bangunan semi permanen',
                                'Kemudahan untuk Mencapai Pasar dengan bangunan semi permanen',
                                'Jumlah Sarana Pasar tanpa bangunan',
                                'Kemudahan untuk Mencapai Pasar tanpa bangunan',
                                'Jumlah Sarana Minimarket/swalayan/supermarket',
                                'Kemudahan untuk Mencapai Minimarket/swalayan/supermarket',
                                'Jumlah Sarana Restoran/rumah makan',
                                'Kemudahan untuk Mencapai Restoran/rumah makan',
                                'Jumlah Sarana Warung/kedai makanan minuman',
                                'Kemudahan untuk Mencapai Warung/kedai makanan minuman',
                                'Jumlah Sarana Toko/warung kelontong',
                                'Kemudahan untuk Mencapai Toko/warung kelontong',
                                'Jumlah Sarana Hotel',
                                'Kemudahan untuk Mencapai Hotel',
                                'Jumlah Sarana Penginapan (hostel/motel/losmen/wisma)',
                                'Kemudahan untuk Mencapai Penginapan (hostel/motel/losmen/wisma)',
                                'Kejadian Perkelahian Massal di Desa/Kelurahan Selama Setahun Terakhir',
                                'Pembangunan/pemeliharaan pos keamanan lingkungan',
                                'Pembentukan/pengaturan regu keamanan',
                                'Penambahan jumlah anggota hansip/linmas',
                                'Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan',
                                'Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga',
                                'Jumlah anggota linmas/hansip di desa/kelurahan',
                                'Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan'
                            ];
                            ?>
                            <table class="table table-striped" style="table-layout: auto; width: 100%;">
                                <thead>
                                    <tr style="white-space: nowrap;">
                                        <?php foreach ($headers as $header): ?>
                                            <th><?php echo htmlspecialchars($header); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Filter data berdasarkan tahun
                                    $filter_tahun = isset($_GET['filter_tahun']) ? intval($_GET['filter_tahun']) : null;

                                    // Query untuk mengambil data desa
                                    $query = "
                                            SELECT 
                                        filtered_progress.tahun,
                                        tb_enumerator.kode_desa,
                                        tb_enumerator.nama_desa,
                                        tb_enumerator.kecamatan,
                                        tb_sk_pembentukan.sk_pembentukan,
                                        tb_balai_desa.alamat_balai,
                                        tb_batas_desa.batas_utara,
                                        tb_batas_desa.kec_utara,
                                        tb_batas_desa.batas_selatan,
                                        tb_batas_desa.kec_selatan,
                                        tb_batas_desa.batas_timur,
                                        tb_batas_desa.kec_timur,
                                        tb_batas_desa.batas_barat,
                                        tb_batas_desa.kec_barat,
                                        tb_jarak_kantor_desa.jarak_ke_ibukota_kecamatan,
                                        tb_jarak_kantor_desa.jarak_ke_ibukota_kabupaten,
                                        tb_idm_status.status_idm,
                                        tb_website_medsos.alamat_website,
                                        tb_website_medsos.alamat_email,
                                        tb_website_medsos.alamat_facebook,
                                        tb_website_medsos.alamat_twitter,
                                        tb_website_medsos.alamat_youtube,
                                        tb_status_pemerintahan.status_pemerintahan,
                                        tb_ketersediaan_penetapan_peta_desa.penetapan_batas_desa,
                                        tb_ketersediaan_penetapan_peta_desa.no_surat_batas_desa,
                                        tb_ketersediaan_penetapan_peta_desa.ketersediaan_peta_desa,
                                        tb_ketersediaan_penetapan_peta_desa.no_surat_peta_desa,
                                        tb_banyaknya_dusun_rt_rw.jumlah_dusun,
                                        tb_banyaknya_dusun_rt_rw.jumlah_rw,
                                        tb_banyaknya_dusun_rt_rw.jumlah_rt,
                                        tb_luas_wilayah_desa.luas_wilayah_desa,
                                        tb_topografi_terluas_wilayah_desa.topografi_terluas_wilayah_desa,
                                        tb_kepemilikan_kantor.keberadaan_kantor,
                                        tb_kepemilikan_kantor.status_kantor,
                                        tb_kepemilikan_kantor.kondisi_kantor,
                                        tb_kepemilikan_kantor.lokasi_kantor,
                                        tb_titik_koordinat_kantor_desa.koordinat_lintang,
                                        tb_titik_koordinat_kantor_desa.koordinat_bujur,
                                        tb_kematian.jumlah_surat_kematian,
                                        tb_penduduk_dan_keluarga.jumlah_penduduk_laki,
                                        tb_penduduk_dan_keluarga.jumlah_penduduk_perempuan,
                                        tb_penduduk_dan_keluarga.jumlah_kepala_keluarga,
                                        tb_ketenagakerjaan.pmi_bekerja,
                                        tb_ketenagakerjaan.agen_pengerahan_pmi,
                                        tb_ketenagakerjaan.layanan_rekomendasi_pmi,
                                        tb_ketenagakerjaan.keberadaan_wna,
                                        tb_pengguna_listrik_lampu_surya.jumlah_pln,
                                        tb_pengguna_listrik_lampu_surya.jumlah_non_pln,
                                        tb_pengguna_listrik_lampu_surya.jumlah_bukan_pengguna_listrik,
                                        tb_pengguna_listrik_lampu_surya.penggunaan_lampu_tenaga_surya,
                                        tb_penerangan_jalan.lampu_tenaga_surya,
                                        tb_penerangan_jalan.penerangan_jalan_utama,
                                        tb_penerangan_jalan.sumber_penerangan,
                                        tb_pengelolaan_sampah.tps,
                                        tb_pengelolaan_sampah.tps3r,
                                        tb_pengelolaan_sampah.bank_sampah,
                                        tb_sutet.sutet_status,
                                        tb_sutet.keberadaan_pemukiman AS keberadaan_pemukiman_sutet,
                                        tb_sutet.jumlah_pemukiman AS jumlah_pemukiman_sutet,
                                        tb_keberadaan_sungai.keberadaan_sungai,
                                        tb_keberadaan_sungai.nama_sungai_1,
                                        tb_keberadaan_sungai.nama_sungai_2,
                                        tb_keberadaan_sungai.nama_sungai_3,
                                        tb_keberadaan_sungai.nama_sungai_4,
                                        tb_keberadaan_danau.keberadaan_danau,
                                        tb_keberadaan_danau.nama_danau_1,
                                        tb_keberadaan_danau.nama_danau_2,
                                        tb_keberadaan_danau.nama_danau_3,
                                        tb_keberadaan_danau.nama_danau_4,
                                        tb_keberadaan_pemukiman_bantaran.keberadaan_pemukiman AS keberadaan_pemukiman_bantaran,
                                        tb_keberadaan_pemukiman_bantaran.jumlah_pemukiman AS jumlah_pemukiman_bantaran,
                                        tb_embung_mata_air.jumlah_embung,
                                        tb_embung_mata_air.lokasi_mata_air,
                                        tb_permukiman_kumuh.keberadaan_kumuh,
                                        tb_permukiman_kumuh.jumlah_kumuh,
                                        tb_lokasi_penggalian.keberadaan_galian,
                                        tb_prasarana_kebersihan.jumlah_prasarana,
                                        tb_rumah_tidak_layak_huni.jumlah_rumah,
                                        tb_bencana_alam.tanah_longsor,
                                        tb_bencana_alam.banjir,
                                        tb_bencana_alam.banjir_bandang,
                                        tb_bencana_alam.gempa_bumi,
                                        tb_bencana_alam.tsunami,
                                        tb_bencana_alam.gelombang_pasang,
                                        tb_bencana_alam.angin_puyuh,
                                        tb_bencana_alam.gunung_meletus,
                                        tb_bencana_alam.kebakaran_hutan,
                                        tb_bencana_alam.kekeringan,
                                        tb_bencana_alam.abrasi,
                                        tb_peringatan_bencana.peringatan_dini,
                                        tb_peringatan_bencana.peringatan_tsunami,
                                        tb_peringatan_bencana.perlengkapan_keselamatan,
                                        tb_peringatan_bencana.rambu_evakuasi,
                                        tb_peringatan_bencana.infrastruktur,
                                        tb_taman_bacaan.keberadaan_tbm,
                                        tb_keberadaan_bidan.keberadaan_bidan,
                                        tb_keberadaan_dukun_bayi.keberadaan_dukun_bayi,
                                        tb_klb_wabah.muntaber_diare,
                                        tb_klb_wabah.demam_berdarah,
                                        tb_klb_wabah.campak,
                                        tb_klb_wabah.malaria,
                                        tb_klb_wabah.flu_burung_sars,
                                        tb_klb_wabah.hepatitis_e,
                                        tb_klb_wabah.difteri,
                                        tb_klb_wabah.corona_covid19,
                                        tb_klb_wabah.lainnya_name,
                                        tb_klb_wabah.lainnya_status,
                                        tb_tempat_ibadah.jumlah_masjid,
                                        tb_tempat_ibadah.jumlah_pura,
                                        tb_tempat_ibadah.jumlah_musala,
                                        tb_tempat_ibadah.jumlah_wihara,	
                                        tb_tempat_ibadah.jumlah_gereja_kristen,	
                                        tb_tempat_ibadah.jumlah_kelenteng,	
                                        tb_tempat_ibadah.jumlah_gereja_katolik,	
                                        tb_tempat_ibadah.jumlah_balai_basarah,	
                                        tb_tempat_ibadah.jumlah_kapel,	
                                        tb_tempat_ibadah.lainnya,
                                        tb_tempat_ibadah.jumlah_lainnya,
                                        tb_disabilitas.jumlah_tuna_netra,
                                        tb_disabilitas.jumlah_tuna_rungu,
                                        tb_disabilitas.jumlah_tuna_wicara,
                                        tb_disabilitas.jumlah_tuna_rungu_wicara,
                                        tb_disabilitas.jumlah_tuna_daksa,
                                        tb_disabilitas.jumlah_tuna_grahita,
                                        tb_disabilitas.jumlah_tuna_laras,
                                        tb_disabilitas.jumlah_tuna_eks_kusta,
                                        tb_disabilitas.jumlah_tuna_ganda,
                                        tb_ruang_publik.status_ruang_publik,
                                        tb_ruang_publik.ruang_terbuka_hijau,
                                        tb_ruang_publik.ruang_terbuka_non_hijau,
                                        tb_fasilitas_olahraga.sepak_bola,
                                        tb_fasilitas_olahraga.bola_voli,
                                        tb_fasilitas_olahraga.bulu_tangkis,
                                        tb_fasilitas_olahraga.bola_basket,
                                        tb_fasilitas_olahraga.tenis_lapangan,
                                        tb_fasilitas_olahraga.tenis_meja,
                                        tb_fasilitas_olahraga.futsal,
                                        tb_fasilitas_olahraga.renang,
                                        tb_fasilitas_olahraga.bela_diri,
                                        tb_fasilitas_olahraga.bilyard,
                                        tb_fasilitas_olahraga.fitness,
                                        tb_fasilitas_olahraga.lainnya_nama,
                                        tb_fasilitas_olahraga.lainnya_kondisi,
                                        tb_prasarana_transportasi.lalu_lintas,
                                        tb_prasarana_transportasi.jenis_permukaan_jalan,
                                        tb_prasarana_transportasi.jalan_darat_bisa_dilalui,
                                        tb_prasarana_transportasi.keberadaan_angkutan_umum,
                                        tb_prasarana_transportasi.operasional_angkutan_umum,
                                        tb_prasarana_transportasi.jam_operasi_angkutan_umum,
                                        tb_internet_transportasi.keberadaan_internet,
                                        tb_menara_telepon.jumlah_bts,
                                        tb_menara_telepon.jumlah_operator_telekomunikasi,
                                        tb_menara_telepon.sinyal_telepon,
                                        tb_menara_telepon.sinyal_internet,
                                        tb_ketersediaan_internet.kondisi_komputer,
                                        tb_ketersediaan_internet.fasilitas_internet,
                                        tb_keberadaan_kantor_pos.kantor_pos,
                                        tb_keberadaan_kantor_pos.layanan_pos_keliling,
                                        tb_keberadaan_kantor_pos.ekspedisi_swasta,
                                        tb_sentra_industri.keberadaan,
                                        tb_sentra_industri.jumlah_sentra,
                                        tb_sentra_industri.produk_utama,
                                        tb_produk_unggulan.keberadaan,
                                        tb_produk_unggulan.makanan_unggulan,
                                        tb_produk_unggulan.non_makanan_unggulan,
                                        tb_pangkalan_minyak.keberadaan_minyak_tanah,
                                        tb_pangkalan_minyak.keberadaan_lpg,
                                        tb_bank_operasi.bank_pemerintah,
                                        tb_bank_operasi.bank_swasta,
                                        tb_bank_operasi.bank_bpr,
                                        tb_bank_operasi.jarak_bank_terdekat,
                                        tb_koperasi.koperasi_kud,
                                        tb_koperasi.koperasi_kopinkra,
                                        tb_koperasi.koperasi_ksp,
                                        tb_koperasi.koperasi_lainnya,
                                        tb_koperasi.toko_kud,
                                        tb_koperasi.toko_bumdesa,
                                        tb_koperasi.toko_lainnya,
                                        tb_sarana_ekonomi.bmt_jumlah,
                                        tb_sarana_ekonomi.bmt_jarak,
                                        tb_sarana_ekonomi.bmt_kemudahan,
                                        tb_sarana_ekonomi.atm_jumlah,
                                        tb_sarana_ekonomi.atm_jarak,
                                        tb_sarana_ekonomi.atm_kemudahan,
                                        tb_sarana_ekonomi.agen_bank_jumlah,
                                        tb_sarana_ekonomi.agen_bank_jarak,
                                        tb_sarana_ekonomi.agen_bank_kemudahan,
                                        tb_sarana_ekonomi.valas_jumlah,
                                        tb_sarana_ekonomi.valas_jarak,
                                        tb_sarana_ekonomi.valas_kemudahan,
                                        tb_sarana_ekonomi.pegadaian_jumlah,
                                        tb_sarana_ekonomi.pegadaian_jarak,
                                        tb_sarana_ekonomi.pegadaian_kemudahan,
                                        tb_sarana_ekonomi.agen_tiket_jumlah,
                                        tb_sarana_ekonomi.agen_tiket_jarak,
                                        tb_sarana_ekonomi.agen_tiket_kemudahan,
                                        tb_sarana_ekonomi.bengkel_jumlah,
                                        tb_sarana_ekonomi.bengkel_jarak,
                                        tb_sarana_ekonomi.bengkel_kemudahan,
                                        tb_sarana_ekonomi.salon_jumlah,
                                        tb_sarana_ekonomi.salon_jarak,
                                        tb_sarana_ekonomi.salon_kemudahan,
                                        tb_sarana_prasarana.kelompok_pertokoan_jumlah,
                                        tb_sarana_prasarana.kelompok_pertokoan_kemudahan,
                                        tb_sarana_prasarana.pasar_permanen_jumlah,
                                        tb_sarana_prasarana.pasar_permanen_kemudahan,
                                        tb_sarana_prasarana.pasar_semi_permanen_jumlah,
                                        tb_sarana_prasarana.pasar_semi_permanen_kemudahan,
                                        tb_sarana_prasarana.pasar_tanpa_bangunan_jumlah,
                                        tb_sarana_prasarana.pasar_tanpa_bangunan_kemudahan,
                                        tb_sarana_prasarana.minimarket_jumlah,
                                        tb_sarana_prasarana.minimarket_kemudahan,
                                        tb_sarana_prasarana.restoran_jumlah,
                                        tb_sarana_prasarana.restoran_kemudahan,
                                        tb_sarana_prasarana.warung_makan_jumlah,
                                        tb_sarana_prasarana.warung_makan_kemudahan,
                                        tb_sarana_prasarana.toko_kelontong_jumlah,
                                        tb_sarana_prasarana.toko_kelontong_kemudahan,
                                        tb_sarana_prasarana.hotel_jumlah,
                                        tb_sarana_prasarana.hotel_kemudahan,
                                        tb_sarana_prasarana.penginapan_jumlah,
                                        tb_sarana_prasarana.penginapan_kemudahan,
                                        tb_perkelahian_massal.kejadian,
                                        tb_keamanan_lingkungan.pembangunan_pos_keamanan,
                                        tb_keamanan_lingkungan.pembentukan_regu_keamanan,
                                        tb_keamanan_lingkungan.penambahan_anggota_hansip,
                                        tb_keamanan_lingkungan.pelaporan_tamu_menginap,
                                        tb_keamanan_lingkungan.pengaktifan_sistem_keamanan,
                                        tb_linmas_poskamling.jumlah_anggota_linmas,
                                        tb_keberadaan_pos_polisi.keberadaan_pos_polisi
                                    FROM
                                        (
                                            SELECT 
                                                desa_id,
                                                tahun,
                                                MIN(id) AS min_id
                                            FROM
                                                user_progress
                                            WHERE
                                                tahun IS NOT NULL
                                            GROUP BY desa_id, tahun
                                        ) AS filtered_progress
                                    LEFT JOIN
                                        tb_enumerator ON filtered_progress.desa_id = tb_enumerator.id_desa
                                    LEFT JOIN
                                        tb_sk_pembentukan ON filtered_progress.desa_id = tb_sk_pembentukan.desa_id
                                        AND filtered_progress.tahun = tb_sk_pembentukan.tahun
                                    LEFT JOIN
                                        tb_balai_desa ON filtered_progress.desa_id = tb_balai_desa.desa_id
                                        AND filtered_progress.tahun = tb_balai_desa.tahun
                                    LEFT JOIN
                                        tb_batas_desa ON filtered_progress.desa_id = tb_batas_desa.desa_id
                                        AND filtered_progress.tahun = tb_batas_desa.tahun
                                    LEFT JOIN
                                        tb_jarak_kantor_desa ON filtered_progress.desa_id = tb_jarak_kantor_desa.desa_id
                                        AND filtered_progress.tahun = tb_jarak_kantor_desa.tahun
                                    LEFT JOIN
                                        tb_idm_status ON filtered_progress.desa_id = tb_idm_status.desa_id
                                        AND filtered_progress.tahun = tb_idm_status.tahun
                                    LEFT JOIN
                                        tb_website_medsos ON filtered_progress.desa_id = tb_website_medsos.desa_id
                                        AND filtered_progress.tahun = tb_website_medsos.tahun
                                    LEFT JOIN
                                        tb_status_pemerintahan ON filtered_progress.desa_id = tb_status_pemerintahan.desa_id
                                        AND filtered_progress.tahun = tb_status_pemerintahan.tahun
                                    LEFT JOIN
                                        tb_ketersediaan_penetapan_peta_desa ON filtered_progress.desa_id = tb_ketersediaan_penetapan_peta_desa.desa_id
                                        AND filtered_progress.tahun = tb_ketersediaan_penetapan_peta_desa.tahun
                                    LEFT JOIN
                                        tb_banyaknya_dusun_rt_rw ON filtered_progress.desa_id = tb_banyaknya_dusun_rt_rw.desa_id
                                        AND filtered_progress.tahun = tb_banyaknya_dusun_rt_rw.tahun
                                    LEFT JOIN
                                        tb_luas_wilayah_desa ON filtered_progress.desa_id = tb_luas_wilayah_desa.desa_id
                                        AND filtered_progress.tahun = tb_luas_wilayah_desa.tahun
                                    LEFT JOIN
                                        tb_topografi_terluas_wilayah_desa ON filtered_progress.desa_id = tb_topografi_terluas_wilayah_desa.desa_id
                                        AND filtered_progress.tahun = tb_topografi_terluas_wilayah_desa.tahun
                                    LEFT JOIN
                                        tb_kepemilikan_kantor ON filtered_progress.desa_id = tb_kepemilikan_kantor.desa_id
                                        AND filtered_progress.tahun = tb_kepemilikan_kantor.tahun
                                    LEFT JOIN
                                        tb_titik_koordinat_kantor_desa ON filtered_progress.desa_id = tb_titik_koordinat_kantor_desa.desa_id
                                        AND filtered_progress.tahun = tb_titik_koordinat_kantor_desa.tahun
                                    LEFT JOIN
                                        tb_kematian ON filtered_progress.desa_id = tb_kematian.desa_id
                                        AND filtered_progress.tahun = tb_kematian.tahun
                                    LEFT JOIN
                                        tb_penduduk_dan_keluarga ON filtered_progress.desa_id = tb_penduduk_dan_keluarga.desa_id
                                        AND filtered_progress.tahun = tb_penduduk_dan_keluarga.tahun
                                    LEFT JOIN
                                        tb_ketenagakerjaan ON filtered_progress.desa_id = tb_ketenagakerjaan.desa_id
                                        AND filtered_progress.tahun = tb_ketenagakerjaan.tahun
                                    LEFT JOIN
                                        tb_pengguna_listrik_lampu_surya ON filtered_progress.desa_id = tb_pengguna_listrik_lampu_surya.desa_id
                                        AND filtered_progress.tahun = tb_pengguna_listrik_lampu_surya.tahun
                                    LEFT JOIN
                                        tb_penerangan_jalan ON filtered_progress.desa_id = tb_penerangan_jalan.desa_id
                                        AND filtered_progress.tahun = tb_penerangan_jalan.tahun
                                    LEFT JOIN
                                        tb_pengelolaan_sampah ON filtered_progress.desa_id = tb_pengelolaan_sampah.desa_id
                                        AND filtered_progress.tahun = tb_pengelolaan_sampah.tahun
                                    LEFT JOIN
                                        tb_sutet ON filtered_progress.desa_id = tb_sutet.desa_id
                                        AND filtered_progress.tahun = tb_sutet.tahun
                                    LEFT JOIN
                                        tb_keberadaan_sungai ON filtered_progress.desa_id = tb_keberadaan_sungai.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_sungai.tahun
                                    LEFT JOIN
                                        tb_keberadaan_danau ON filtered_progress.desa_id = tb_keberadaan_danau.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_danau.tahun
                                    LEFT JOIN
                                        tb_keberadaan_pemukiman_bantaran ON filtered_progress.desa_id = tb_keberadaan_pemukiman_bantaran.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_pemukiman_bantaran.tahun
                                    LEFT JOIN
                                        tb_embung_mata_air ON filtered_progress.desa_id = tb_embung_mata_air.desa_id
                                        AND filtered_progress.tahun = tb_embung_mata_air.tahun
                                    LEFT JOIN
                                        tb_permukiman_kumuh ON filtered_progress.desa_id = tb_permukiman_kumuh.desa_id
                                        AND filtered_progress.tahun = tb_permukiman_kumuh.tahun
                                    LEFT JOIN
                                        tb_lokasi_penggalian ON filtered_progress.desa_id = tb_lokasi_penggalian.desa_id
                                        AND filtered_progress.tahun = tb_lokasi_penggalian.tahun
                                    LEFT JOIN
                                        tb_prasarana_kebersihan ON filtered_progress.desa_id = tb_prasarana_kebersihan.desa_id
                                        AND filtered_progress.tahun = tb_prasarana_kebersihan.tahun
                                    LEFT JOIN
                                        tb_rumah_tidak_layak_huni ON filtered_progress.desa_id = tb_rumah_tidak_layak_huni.desa_id
                                        AND filtered_progress.tahun = tb_rumah_tidak_layak_huni.tahun
                                    LEFT JOIN
                                        tb_bencana_alam ON filtered_progress.desa_id = tb_bencana_alam.desa_id
                                        AND filtered_progress.tahun = tb_bencana_alam.tahun
                                    LEFT JOIN
                                        tb_peringatan_bencana ON filtered_progress.desa_id = tb_peringatan_bencana.desa_id
                                        AND filtered_progress.tahun = tb_peringatan_bencana.tahun
                                    LEFT JOIN
                                        tb_taman_bacaan ON filtered_progress.desa_id = tb_taman_bacaan.desa_id
                                        AND filtered_progress.tahun = tb_taman_bacaan.tahun
                                    LEFT JOIN
                                        tb_keberadaan_bidan ON filtered_progress.desa_id = tb_keberadaan_bidan.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_bidan.tahun
                                    LEFT JOIN
                                        tb_keberadaan_dukun_bayi ON filtered_progress.desa_id = tb_keberadaan_dukun_bayi.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_dukun_bayi.tahun
                                    LEFT JOIN
                                        tb_klb_wabah ON filtered_progress.desa_id = tb_klb_wabah.desa_id
                                        AND filtered_progress.tahun = tb_klb_wabah.tahun
                                    LEFT JOIN
                                        tb_tempat_ibadah ON filtered_progress.desa_id = tb_tempat_ibadah.desa_id
                                        AND filtered_progress.tahun = tb_tempat_ibadah.tahun
                                    LEFT JOIN
                                        tb_disabilitas ON filtered_progress.desa_id = tb_disabilitas.desa_id
                                        AND filtered_progress.tahun = tb_disabilitas.tahun
                                    LEFT JOIN
                                        tb_ruang_publik ON filtered_progress.desa_id = tb_ruang_publik.desa_id
                                        AND filtered_progress.tahun = tb_ruang_publik.tahun
                                    LEFT JOIN
                                        tb_fasilitas_olahraga ON filtered_progress.desa_id = tb_fasilitas_olahraga.desa_id
                                        AND filtered_progress.tahun = tb_fasilitas_olahraga.tahun
                                    LEFT JOIN
                                        tb_prasarana_transportasi ON filtered_progress.desa_id = tb_prasarana_transportasi.desa_id
                                        AND filtered_progress.tahun = tb_prasarana_transportasi.tahun
                                    LEFT JOIN
                                        tb_internet_transportasi ON filtered_progress.desa_id = tb_internet_transportasi.desa_id
                                        AND filtered_progress.tahun = tb_internet_transportasi.tahun
                                    LEFT JOIN
                                        tb_menara_telepon ON filtered_progress.desa_id = tb_menara_telepon.desa_id
                                        AND filtered_progress.tahun = tb_menara_telepon.tahun
                                    LEFT JOIN
                                        tb_ketersediaan_internet ON filtered_progress.desa_id = tb_ketersediaan_internet.desa_id
                                        AND filtered_progress.tahun = tb_ketersediaan_internet.tahun
                                    LEFT JOIN
                                        tb_keberadaan_kantor_pos ON filtered_progress.desa_id = tb_keberadaan_kantor_pos.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_kantor_pos.tahun
                                    LEFT JOIN
                                        tb_sentra_industri ON filtered_progress.desa_id = tb_sentra_industri.desa_id
                                        AND filtered_progress.tahun = tb_sentra_industri.tahun
                                    LEFT JOIN
                                        tb_produk_unggulan ON filtered_progress.desa_id = tb_produk_unggulan.desa_id
                                        AND filtered_progress.tahun = tb_produk_unggulan.tahun
                                    LEFT JOIN
                                        tb_pangkalan_minyak ON filtered_progress.desa_id = tb_pangkalan_minyak.desa_id
                                        AND filtered_progress.tahun = tb_pangkalan_minyak.tahun
                                    LEFT JOIN
                                        tb_bank_operasi ON filtered_progress.desa_id = tb_bank_operasi.desa_id
                                        AND filtered_progress.tahun = tb_bank_operasi.tahun
                                    LEFT JOIN
                                        tb_koperasi ON filtered_progress.desa_id = tb_koperasi.desa_id
                                        AND filtered_progress.tahun = tb_koperasi.tahun
                                    LEFT JOIN
                                        tb_sarana_ekonomi ON filtered_progress.desa_id = tb_sarana_ekonomi.desa_id
                                        AND filtered_progress.tahun = tb_sarana_ekonomi.tahun
                                    LEFT JOIN
                                        tb_sarana_prasarana ON filtered_progress.desa_id = tb_sarana_prasarana.desa_id
                                        AND filtered_progress.tahun = tb_sarana_prasarana.tahun
                                    LEFT JOIN
                                        tb_perkelahian_massal ON filtered_progress.desa_id = tb_perkelahian_massal.desa_id
                                        AND filtered_progress.tahun = tb_perkelahian_massal.tahun
                                    LEFT JOIN
                                        tb_keamanan_lingkungan ON filtered_progress.desa_id = tb_keamanan_lingkungan.desa_id
                                        AND filtered_progress.tahun = tb_keamanan_lingkungan.tahun
                                    LEFT JOIN
                                        tb_linmas_poskamling ON filtered_progress.desa_id = tb_linmas_poskamling.desa_id
                                        AND filtered_progress.tahun = tb_linmas_poskamling.tahun
                                    LEFT JOIN
                                        tb_keberadaan_pos_polisi ON filtered_progress.desa_id = tb_keberadaan_pos_polisi.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_pos_polisi.tahun

                                            ";

                                    // Tambahkan filter jika tahun dipilih
                                    if ($filter_tahun) {
                                        $query .= " WHERE filtered_progress.tahun = $filter_tahun ";
                                    }

                                    // Eksekusi query
                                    $result = mysqli_query($conn, $query) or die("Error: " . mysqli_error($conn));

                                    $no = 1;
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tahun'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kode_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kecamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sk_pembentukan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_balai'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_utara'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_utara'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_selatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_selatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_timur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_timur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_barat'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_barat'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jarak_ke_ibukota_kecamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jarak_ke_ibukota_kabupaten'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_idm'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_website'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_email'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_facebook'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_twitter'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_youtube'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_pemerintahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penetapan_batas_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['no_surat_batas_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ketersediaan_peta_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['no_surat_peta_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_dusun'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rw'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rt'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['luas_wilayah_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['topografi_terluas_wilayah_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kondisi_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lokasi_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koordinat_lintang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koordinat_bujur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_surat_kematian'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_penduduk_laki'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_penduduk_perempuan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_kepala_keluarga'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pmi_bekerja'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_pengerahan_pmi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['layanan_rekomendasi_pmi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_wna'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pln'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_non_pln'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_bukan_pengguna_listrik'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penggunaan_lampu_tenaga_surya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lampu_tenaga_surya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penerangan_jalan_utama'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sumber_penerangan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tps'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tps3r'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bank_sampah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sutet_status'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_pemukiman_sutet'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pemukiman_sutet'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_sungai'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_1'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_2'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_3'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_4'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_danau'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_1'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_2'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_3'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_4'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_pemukiman_bantaran'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pemukiman_bantaran'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_embung'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lokasi_mata_air'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_kumuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_kumuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_galian'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_prasarana'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rumah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tanah_longsor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['banjir'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['banjir_bandang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gempa_bumi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tsunami'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gelombang_pasang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['angin_puyuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gunung_meletus'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kebakaran_hutan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kekeringan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['abrasi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['peringatan_dini'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['peringatan_tsunami'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['perlengkapan_keselamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['rambu_evakuasi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['infrastruktur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_tbm'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_bidan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_dukun_bayi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['muntaber_diare'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['demam_berdarah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['campak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['malaria'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['flu_burung_sars'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['hepatitis_e'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['difteri'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['corona_covid19'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lainnya_name'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lainnya_status'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_masjid'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_masjid
                                            echo "<td>" . htmlspecialchars($row['jumlah_pura'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_pura
                                            echo "<td>" . htmlspecialchars($row['jumlah_musala'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_musala
                                            echo "<td>" . htmlspecialchars($row['jumlah_wihara'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_wihara
                                            echo "<td>" . htmlspecialchars($row['jumlah_gereja_kristen'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_gereja_kristen
                                            echo "<td>" . htmlspecialchars($row['jumlah_kelenteng'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_kelenteng
                                            echo "<td>" . htmlspecialchars($row['jumlah_gereja_katolik'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_gereja_katolik
                                            echo "<td>" . htmlspecialchars($row['jumlah_balai_basarah'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_balai_basarah
                                            echo "<td>" . htmlspecialchars($row['jumlah_kapel'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_kapel
                                            echo "<td>" . htmlspecialchars($row['lainnya'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.lainnya
                                            echo "<td>" . htmlspecialchars($row['jumlah_lainnya'] ?? "Belum Mengisi") . "</td>"; // tb_tempat_ibadah.jumlah_lainnya
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_netra'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_netra
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_rungu'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_rungu
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_wicara'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_wicara
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_rungu_wicara'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_rungu_wicara
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_daksa'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_daksa
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_grahita'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_grahita
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_laras'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_laras
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_eks_kusta'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_eks_kusta
                                            echo "<td>" . htmlspecialchars($row['jumlah_tuna_ganda'] ?? "Belum Mengisi") . "</td>"; // tb_disabilitas.jumlah_tuna_ganda
                                            echo "<td>" . htmlspecialchars($row['status_ruang_publik'] ?? "Belum Mengisi") . "</td>"; // tb_ruang_publik.status_ruang_publik
                                            echo "<td>" . htmlspecialchars($row['ruang_terbuka_hijau'] ?? "Belum Mengisi") . "</td>"; // tb_ruang_publik.ruang_terbuka_hijau
                                            echo "<td>" . htmlspecialchars($row['ruang_terbuka_non_hijau'] ?? "Belum Mengisi") . "</td>"; // tb_ruang_publik.ruang_terbuka_non_hijau
                                            echo "<td>" . htmlspecialchars($row['sepak_bola'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.sepak_bola
                                            echo "<td>" . htmlspecialchars($row['bola_voli'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.bola_voli
                                            echo "<td>" . htmlspecialchars($row['bulu_tangkis'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.bulu_tangkis
                                            echo "<td>" . htmlspecialchars($row['bola_basket'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.bola_basket
                                            echo "<td>" . htmlspecialchars($row['tenis_lapangan'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.tenis_lapangan
                                            echo "<td>" . htmlspecialchars($row['tenis_meja'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.tenis_meja
                                            echo "<td>" . htmlspecialchars($row['futsal'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.futsal
                                            echo "<td>" . htmlspecialchars($row['renang'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.renang
                                            echo "<td>" . htmlspecialchars($row['bela_diri'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.bela_diri
                                            echo "<td>" . htmlspecialchars($row['bilyard'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.bilyard
                                            echo "<td>" . htmlspecialchars($row['fitness'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.fitness
                                            echo "<td>" . htmlspecialchars($row['lainnya_nama'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.lainnya_nama
                                            echo "<td>" . htmlspecialchars($row['lainnya_kondisi'] ?? "Belum Mengisi") . "</td>"; // tb_fasilitas_olahraga.lainnya_kondisi
                                            echo "<td>" . htmlspecialchars($row['lalu_lintas'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.lalu_lintas
                                            echo "<td>" . htmlspecialchars($row['jenis_permukaan_jalan'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.jenis_permukaan_jalan
                                            echo "<td>" . htmlspecialchars($row['jalan_darat_bisa_dilalui'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.jalan_darat_bisa_dilalui
                                            echo "<td>" . htmlspecialchars($row['keberadaan_angkutan_umum'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.keberadaan_angkutan_umum
                                            echo "<td>" . htmlspecialchars($row['operasional_angkutan_umum'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.operasional_angkutan_umum
                                            echo "<td>" . htmlspecialchars($row['jam_operasi_angkutan_umum'] ?? "Belum Mengisi") . "</td>"; // tb_prasarana_transportasi.jam_operasi_angkutan_umum
                                            echo "<td>" . htmlspecialchars($row['keberadaan_internet'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_bts'] ?? "Belum Mengisi") . "</td>"; // tb_menara_telepon.jumlah_bts
                                            echo "<td>" . htmlspecialchars($row['jumlah_operator_telekomunikasi'] ?? "Belum Mengisi") . "</td>"; // tb_menara_telepon.jumlah_operator_telekomunikasi
                                            echo "<td>" . htmlspecialchars($row['sinyal_telepon'] ?? "Belum Mengisi") . "</td>"; // tb_menara_telepon.sinyal_telepon
                                            echo "<td>" . htmlspecialchars($row['sinyal_internet'] ?? "Belum Mengisi") . "</td>"; // tb_menara_telepon.sinyal_internet
                                            echo "<td>" . htmlspecialchars($row['kondisi_komputer'] ?? "Belum Mengisi") . "</td>"; // tb_ketersediaan_internet.kondisi_komputer
                                            echo "<td>" . htmlspecialchars($row['fasilitas_internet'] ?? "Belum Mengisi") . "</td>"; // tb_ketersediaan_internet.fasilitas_internet
                                            echo "<td>" . htmlspecialchars($row['kantor_pos'] ?? "Belum Mengisi") . "</td>"; // tb_keberadaan_kantor_pos.kantor_pos
                                            echo "<td>" . htmlspecialchars($row['layanan_pos_keliling'] ?? "Belum Mengisi") . "</td>"; // tb_keberadaan_kantor_pos.layanan_pos_keliling
                                            echo "<td>" . htmlspecialchars($row['ekspedisi_swasta'] ?? "Belum Mengisi") . "</td>"; // tb_keberadaan_kantor_pos.ekspedisi_swasta
                                            echo "<td>" . htmlspecialchars($row['keberadaan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_sentra'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['produk_utama'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['makanan_unggulan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['non_makanan_unggulan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_minyak_tanah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_lpg'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bank_pemerintah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bank_swasta'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bank_bpr'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jarak_bank_terdekat'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koperasi_kud'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koperasi_kopinkra'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koperasi_ksp'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koperasi_lainnya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['toko_kud'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['toko_bumdesa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['toko_lainnya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bmt_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bmt_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bmt_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['atm_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['atm_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['atm_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_bank_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_bank_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_bank_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['valas_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['valas_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['valas_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pegadaian_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pegadaian_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pegadaian_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_tiket_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_tiket_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_tiket_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bengkel_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bengkel_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bengkel_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['salon_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['salon_jarak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['salon_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kelompok_pertokoan_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kelompok_pertokoan_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_permanen_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_permanen_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_semi_permanen_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_semi_permanen_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_tanpa_bangunan_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pasar_tanpa_bangunan_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['minimarket_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['minimarket_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['restoran_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['restoran_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['warung_makan_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['warung_makan_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['toko_kelontong_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['toko_kelontong_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['hotel_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['hotel_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penginapan_jumlah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penginapan_kemudahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kejadian'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pembangunan_pos_keamanan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pembentukan_regu_keamanan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penambahan_anggota_hansip'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pelaporan_tamu_menginap'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pengaktifan_sistem_keamanan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_anggota_linmas'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_pos_polisi'] ?? "Belum Mengisi") . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div> <!--end::Container-->

                <!-- Modal Filter Tahun -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">Filter Berdasarkan Tahun</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="filter_tahun">Pilih Tahun</label>
                                    <select name="filter_tahun" id="filter_tahun" class="form-control form-select mt-2">
                                        <option value="" selected disabled>Pilih Tahun</option>
                                        <?php
                                        // Ambil tahun unik dari tabel user_progress
                                        $query_tahun = "SELECT DISTINCT YEAR(created_at) AS tahun FROM user_progress ORDER BY tahun DESC";
                                        $result_tahun = mysqli_query($conn, $query_tahun) or die("Error: " . mysqli_error($conn));

                                        if ($result_tahun) {
                                            while ($row_tahun = mysqli_fetch_assoc($result_tahun)) {
                                                $selected = (isset($_GET['filter_tahun']) && $_GET['filter_tahun'] == $row_tahun['tahun']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row_tahun['tahun']) . "' $selected>" . htmlspecialchars($row_tahun['tahun']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>-->
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> &nbsp;
                                        Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- SweetAlert CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

                <!-- SweetAlert JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <!-- Modal Export -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="exportForm" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportModalLabel">Pilih Jenis Export</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Filter Kecamatan -->
                                    <label for="kode_kecamatan">Pilih Kecamatan</label>
                                    <select name="kode_kecamatan" id="kode_kecamatan" class="form-control form-select mt-2 mb-3" onchange="loadDesa(this.value)">
                                        <option value="">Semua Kecamatan</option>
                                        <?php
                                        $kecamatanResult = mysqli_query($conn, "SELECT DISTINCT kecamatan FROM tb_enumerator ORDER BY kecamatan ASC");
                                        while ($kecamatan = mysqli_fetch_assoc($kecamatanResult)) {
                                            echo "<option value='{$kecamatan['kecamatan']}'>{$kecamatan['kecamatan']}</option>";
                                        }
                                        ?>
                                    </select>

                                    <!-- Filter Desa -->
                                    <label for="kode_desa">Pilih Desa</label>
                                    <select name="kode_desa" id="kode_desa" class="form-control form-select mt-2 mb-3">
                                        <option value="">Semua Desa</option>
                                        <!-- Desa akan dimuat dinamis berdasarkan pilihan kecamatan -->
                                    </select>

                                    <!-- Filter Tahun -->
                                    <label for="filter_tahun">Pilih Tahun</label>
                                    <select name="filter_tahun" id="filter_tahun" class="form-control form-select mt-2">
                                        <option value="">Semua Tahun</option>
                                        <?php
                                        $tahunResult = mysqli_query($conn, "SELECT DISTINCT tahun FROM tb_sk_pembentukan ORDER BY tahun DESC");
                                        while ($tahun = mysqli_fetch_assoc($tahunResult)) {
                                            echo "<option value='{$tahun['tahun']}'>{$tahun['tahun']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <!-- Tombol Ekspor Excel -->
                                    <button type="button" id="exportExcelBtn" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> &nbsp; Export Excel
                                    </button>
                                    <!-- Tombol Ekspor PDF -->
                                    <button type="button" id="exportPdfBtn" class="btn btn-danger">
                                        <i class="fas fa-file-pdf"></i> &nbsp; Export PDF
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    // Function to load Desa based on Kecamatan
                    function loadDesa(kecamatan) {
                        const desaSelect = document.getElementById('kode_desa');
                        desaSelect.innerHTML = '<option value="">Memuat...</option>'; // Indikasi loading

                        fetch(`get_desa.php?kecamatan=${encodeURIComponent(kecamatan)}`)
                            .then(response => response.json())
                            .then(data => {
                                desaSelect.innerHTML = '<option value="">Semua Desa</option>';
                                data.forEach(desa => {
                                    desaSelect.innerHTML += `<option value="${desa.kode_desa}">${desa.nama_desa}</option>`;
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                desaSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
                            });
                    }

                    // Function to initiate download via iframe
                    function initiateDownload(url) {
                        // Create a hidden iframe
                        const iframe = document.createElement('iframe');
                        iframe.style.display = 'none';
                        iframe.src = url;
                        document.body.appendChild(iframe);
                    }

                    // Function to handle export (common for both Excel and PDF)
                    function handleExport(type) {
                        const form = document.getElementById('exportForm');
                        const formData = new FormData(form);
                        formData.append('type', type);

                        // Construct the query string
                        const queryString = new URLSearchParams(formData).toString();
                        const downloadUrl = form.action + '?' + queryString;

                        // Show SweetAlert2 with a progress bar
                        Swal.fire({
                            title: 'Tunggu Sebentar...',
                            html: `
                                <p>Data sedang diproses untuk diekspor.</p>
                                <div style="margin-top: 20px;">
                                    <progress id="exportProgress" value="0" max="100" style="width: 100%; height: 20px;"></progress>
                                    <p id="progressText" style="text-align: center; margin-top: 10px;">0%</p>
                                </div>
                            `,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                const progress = Swal.getHtmlContainer().querySelector('#exportProgress');
                                const progressText = Swal.getHtmlContainer().querySelector('#progressText');
                                let progressValue = 0;

                                // Simulate progress
                                const progressInterval = setInterval(() => {
                                    progressValue += Math.floor(Math.random() * 10) + 5; // Increment between 5-14%
                                    if (progressValue >= 100) {
                                        progressValue = 100;
                                        clearInterval(progressInterval);
                                        progress.value = progressValue;
                                        progressText.textContent = `${progressValue}%`;

                                        // Initiate download
                                        initiateDownload(downloadUrl);

                                        // Show success message
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Selesai Diproses',
                                            text: 'Data akan segera diunduh.',
                                            showConfirmButton: false,
                                            timer: 2000,
                                            timerProgressBar: true
                                        });
                                    } else {
                                        progress.value = progressValue;
                                        progressText.textContent = `${progressValue}%`;
                                    }
                                }, 500); // Update every 0.5 seconds
                            }
                        });
                    }

                    document.getElementById('exportExcelBtn').addEventListener('click', function() {
                        handleExport('excel');
                    });

                    document.getElementById('exportPdfBtn').addEventListener('click', function() {
                        handleExport('pdf');
                    });
                </script>

                <?php
                // Define Columns and Headers
                $columns = [
                    'tahun',
                    'kode_desa',
                    'nama_desa',
                    'kecamatan',
                    'sk_pembentukan',
                    'alamat_balai',
                    'batas_utara',
                    'kec_utara',
                    'batas_selatan',
                    'kec_selatan',
                    'batas_timur',
                    'kec_timur',
                    'batas_barat',
                    'kec_barat',
                    'jarak_ke_ibukota_kecamatan',
                    'jarak_ke_ibukota_kabupaten',
                    'status_idm',
                    'alamat_website',
                    'alamat_email',
                    'alamat_facebook',
                    'alamat_twitter',
                    'alamat_youtube',
                    'status_pemerintahan',
                    'penetapan_batas_desa',
                    'no_surat_batas_desa',
                    'ketersediaan_peta_desa',
                    'no_surat_peta_desa',
                    'jumlah_dusun',
                    'jumlah_rw',
                    'jumlah_rt',
                    'luas_wilayah_desa',
                    'topografi_terluas_wilayah_desa',
                    'keberadaan_kantor',
                    'status_kantor',
                    'kondisi_kantor',
                    'lokasi_kantor',
                    'koordinat_lintang',
                    'koordinat_bujur',
                    'jumlah_surat_kematian',
                    'jumlah_penduduk_laki',
                    'jumlah_penduduk_perempuan',
                    'jumlah_kepala_keluarga',
                    'pmi_bekerja',
                    'agen_pengerahan_pmi',
                    'layanan_rekomendasi_pmi',
                    'keberadaan_wna',
                    'jumlah_pln',
                    'jumlah_non_pln',
                    'jumlah_bukan_pengguna_listrik',
                    'penggunaan_lampu_tenaga_surya',
                    'lampu_tenaga_surya',
                    'penerangan_jalan_utama',
                    'sumber_penerangan',
                    'tps',
                    'tps3r',
                    'bank_sampah',
                    'sutet_status',
                    'keberadaan_pemukiman',
                    'jumlah_pemukiman',
                    'keberadaan_sungai',
                    'nama_sungai_1',
                    'nama_sungai_2',
                    'nama_sungai_3',
                    'nama_sungai_4',
                    'keberadaan_danau',
                    'nama_danau_1',
                    'nama_danau_2',
                    'nama_danau_3',
                    'nama_danau_4',
                    'keberadaan_pemukiman_bantaran',
                    'jumlah_pemukiman_bantaran',
                    'jumlah_embung',
                    'lokasi_mata_air',
                    'keberadaan_kumuh',
                    'jumlah_kumuh',
                    'keberadaan_galian',
                    'jumlah_prasarana',
                    'jumlah_rumah',
                    'tanah_longsor',
                    'banjir',
                    'banjir_bandang',
                    'gempa_bumi',
                    'tsunami',
                    'gelombang_pasang',
                    'angin_puyuh',
                    'gunung_meletus',
                    'kebakaran_hutan',
                    'kekeringan',
                    'abrasi',
                    'peringatan_dini',
                    'peringatan_tsunami',
                    'perlengkapan_keselamatan',
                    'rambu_evakuasi',
                    'infrastruktur',
                    'keberadaan_tbm',
                    'keberadaan_bidan',
                    'keberadaan_dukun_bayi',
                    'muntaber_diare',
                    'demam_berdarah',
                    'campak',
                    'malaria',
                    'flu_burung_sars',
                    'hepatitis_e',
                    'difteri',
                    'corona_covid19',
                    'lainnya_name',
                    'lainnya_status',
                    'jumlah_tuna_netra',
                    'jumlah_tuna_rungu',
                    'jumlah_tuna_wicara',
                    'jumlah_tuna_rungu_wicara',
                    'jumlah_tuna_daksa',
                    'jumlah_tuna_grahita',
                    'jumlah_tuna_laras',
                    'jumlah_tuna_eks_kusta',
                    'jumlah_tuna_ganda',
                    'status_ruang_publik',
                    'ruang_terbuka_hijau',
                    'ruang_terbuka_non_hijau',
                    'sepak_bola',
                    'bola_voli',
                    'bulu_tangkis',
                    'bola_basket',
                    'tenis_lapangan',
                    'tenis_meja',
                    'futsal',
                    'renang',
                    'bela_diri',
                    'bilyard',
                    'fitness',
                    'lainnya_nama_olahraga',
                    'lainnya_kondisi_olahraga',
                    'lalu_lintas',
                    'jenis_permukaan_jalan',
                    'jalan_darat_bisa_dilalui',
                    'keberadaan_angkutan_umum',
                    'operasional_angkutan_umum',
                    'jam_operasi_angkutan_umum',
                    'keberadaan_internet',
                    'jumlah_bts',
                    'jumlah_operator_telekomunikasi',
                    'sinyal_telepon',
                    'sinyal_internet',
                    'kondisi_komputer',
                    'fasilitas_internet',
                    'kantor_pos',
                    'layanan_pos_keliling',
                    'ekspedisi_swasta',
                    'keberadaan_sentra_industri',
                    'jumlah_sentra',
                    'produk_utama',
                    'keberadaan_produk_unggulan',
                    'makanan_unggulan',
                    'non_makanan_unggulan',
                    'keberadaan_minyak_tanah',
                    'keberadaan_lpg',
                    'bank_pemerintah',
                    'bank_swasta',
                    'bank_bpr',
                    'jarak_bank_terdekat',
                    'koperasi_kud',
                    'koperasi_kopinkra',
                    'koperasi_ksp',
                    'koperasi_lainnya',
                    'toko_kud',
                    'toko_bumdesa',
                    'toko_lainnya',
                    'bmt_jumlah',
                    'bmt_jarak',
                    'bmt_kemudahan',
                    'atm_jumlah',
                    'atm_jarak',
                    'atm_kemudahan',
                    'agen_bank_jumlah',
                    'agen_bank_jarak',
                    'agen_bank_kemudahan',
                    'valas_jumlah',
                    'valas_jarak',
                    'valas_kemudahan',
                    'pegadaian_jumlah',
                    'pegadaian_jarak',
                    'pegadaian_kemudahan',
                    'agen_tiket_jumlah',
                    'agen_tiket_jarak',
                    'agen_tiket_kemudahan',
                    'bengkel_jumlah',
                    'bengkel_jarak',
                    'bengkel_kemudahan',
                    'salon_jumlah',
                    'salon_jarak',
                    'salon_kemudahan',
                    'kelompok_pertokoan_jumlah',
                    'kelompok_pertokoan_kemudahan',
                    'pasar_permanen_jumlah',
                    'pasar_permanen_kemudahan',
                    'pasar_semi_permanen_jumlah',
                    'pasar_semi_permanen_kemudahan',
                    'pasar_tanpa_bangunan_jumlah',
                    'pasar_tanpa_bangunan_kemudahan',
                    'minimarket_jumlah',
                    'minimarket_kemudahan',
                    'restoran_jumlah',
                    'restoran_kemudahan',
                    'warung_makan_jumlah',
                    'warung_makan_kemudahan',
                    'toko_kelontong_jumlah',
                    'toko_kelontong_kemudahan',
                    'hotel_jumlah',
                    'hotel_kemudahan',
                    'penginapan_jumlah',
                    'penginapan_kemudahan',
                    'kejadian_perkelahian_massal',
                    'pembangunan_pos_keamanan',
                    'pembentukan_regu_keamanan',
                    'penambahan_anggota_hansip',
                    'pelaporan_tamu_menginap',
                    'pengaktifan_sistem_keamanan',
                    'jumlah_anggota_linmas',
                    'keberadaan_pos_polisi'
                ];

                $headers = [
                    'Periode Tahun',
                    'Kode Desa',
                    'Nama Desa',
                    'Kecamatan',
                    'Sk Pembentukan/Pengesahan Desa/Kelurahan',
                    'Alamat Balai Desa/Kantor Kelurahan',
                    'Batas Utara',
                    'Kec Utara',
                    'Batas Selatan',
                    'Kec Selatan',
                    'Batas Timur',
                    'Kec Timur',
                    'Batas Barat',
                    'Kec Barat',
                    'Jarak ke Ibu Kota Kecamatan (km)',
                    'Jarak ke Ibu Kota Kabupaten (km)',
                    'Status Desa Membangun',
                    'Alamat Website Desa',
                    'Alamat Email Desa',
                    'Alamat Facebook Desa',
                    'Alamat Twitter Desa',
                    'Alamat YouTube Desa',
                    'Status Pemerintahan',
                    'Penetapan Batas Desa',
                    'No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa',
                    'Ketersediaan Peta Desa',
                    'No SK/Perbup/Perda tentang Peta Desa',
                    'Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis',
                    'Banyaknya RW',
                    'Banyaknya RT',
                    'Luas Wilayah Desa',
                    'Topografi Terluas Wilayah Desa',
                    'Keberadaan kantor kepala desa/lurah',
                    'Status Kantor Kepala Desa/Lurah',
                    'Kondisi Kantor Kepala Desa/Balai Desa',
                    'Lokasi Kantor Kepala Desa/Lurah',
                    'Koordinat Lintang (Latitude)',
                    'Koordinat Bujur (Longitude)',
                    'Jumlah Surat Kematian Yang Dikeluarkan',
                    'Jumlah Penduduk Laki-Laki',
                    'Jumlah Penduduk Perempuan',
                    'Jumlah Kepala Keluarga',
                    'Keberadaan Warga Desa/Kelurahan yang Sedang Bekerja sebagai PMI (Pekerja Migran Indonesia)/TKI di Luar Negeri',
                    'Keberadaan Agen (Seseorang/Sekelompok Orang/Perusahaan) Pengerahan Pekerja Migran Indonesia/TKI ke Luar Negeri di Desa/Kelurahan',
                    'Layanan Rekomendasi/Surat Keterangan Bagi Warga Desa/Kelurahan yang Akan Bekerja Sebagai Pekerja Migran Indonesia/TKI di Luar Negeri',
                    'Keberadaan Warga Negara Asing (WNA) di Desa/Kelurahan',
                    'Jumlah Keluarga Pengguna Listrik PLN (Perusahaan Listrik Negara)',
                    'Jumlah Keluarga Pengguna Listrik Non-PLN',
                    'Jumlah Keluraga Bukan Pengguna Listrik',
                    'Keluarga yang Menggunakan Lampu Tenaga Surya',
                    'Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga Surya',
                    'Penerangan di Jalan Utama Desa/Kelurahan',
                    'Sumber Penerangan di Jalan Utama Desa/Kelurahan',
                    'Keberadaan Tempat Pembuangan Sampah Sementara (TPS)',
                    'Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)',
                    'Keberadaan Bank Sampah di Desa/Kelurahan',
                    'Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra tinggi (SUTET) / Saluran Udara Tegangan Tinggi (SUUT) / Saluran Udara Tegangan Tinggi Arus Searah (SUTTAS)',
                    'Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS',
                    'Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS',
                    'Keberadaan Sungai Yang Melintasi',
                    'Nama Sungai Yang Melintasi ke 1',
                    'Nama Sungai Yang Melintasi ke 2',
                    'Nama Sungai Yang Melintasi ke 3',
                    'Nama Sungai Yang Melintasi ke 4',
                    'Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa',
                    'Nama danau/waduk/situ yang berada di wilayah desa ke 1',
                    'Nama danau/waduk/situ yang berada di wilayah desa ke 2',
                    'Nama danau/waduk/situ yang berada di wilayah desa ke 3',
                    'Nama danau/waduk/situ yang berada di wilayah desa ke 4',
                    'Keberadaan Pemukiman Di Bantaran Sungai',
                    'Jumlah Pemukiman Di Bantaran Sungai',
                    'Jumlah Embung',
                    'Lokasi Mata Air',
                    'Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan Padat Dan Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan',
                    'Jumlah Pemukiman Kumuh',
                    'Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali, Pasir, Kapur, Kaolin, Pasir Kuarsa, Tanah Liat, Dll.)',
                    'Jumlah Sarana Prasarana Kebersihan',
                    'Jumlah Rumah Tidak Layak Huni',
                    'Tanah Longsor',
                    'Banjir',
                    'Banjir Bandang',
                    'Gempa Bumi',
                    'Tsunami',
                    'Gelombang Pasang',
                    'Angin Puyuh',
                    'Gunung Meletus',
                    'Kebakaran Hutan',
                    'Kekeringan',
                    'Abrasi',
                    'Sistem Peringatan Dini Bencana Alam',
                    'Sistem Peringatan Dini Khusus Tsunami',
                    'Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)',
                    'Rambu-Rambu dan Jalur Evakuasi Bencana',
                    'Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul, Parit, Drainase, Waduk, Pantai, dll.)',
                    'Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa',
                    'Keberadaan Bidan Desa yang menetap di Desa/Kelurahan',
                    'Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan',
                    'Muntaber/diare',
                    'Demam Berdarah',
                    'Campak',
                    'Malaria',
                    'Flu Burung/SARS',
                    'Hepatitis E',
                    'Difteri',
                    'Corona/COVID-19',
                    'Lainnya',
                    'Lainnya (Status)',
                    'Jumlah Masjid',
                    'Jumlah Pura',
                    'Jumlah Surau/Langgar/Musala',
                    'Jumlah Wihara',
                    'Jumlah Gereja Kristen',
                    'Jumlah Kelenteng',
                    'Jumlah Gereja Katolik',
                    'Jumlah Balai Basarah',
                    'Jumlah Kapel',
                    'Tempat Ibadah Lainnya',
                    'Jumlah Lainnya',
                    'Jumlah tuna netra (buta)',
                    'Jumlah tuna rungu (tuli)',
                    'Jumlah tuna wicara (bisu)',
                    'Jumlah tuna rungu-wicara (tuli-bisu)',
                    'Jumlah tuna daksa (disabilitas tubuh)',
                    'Jumlah tuna grahita (keterbelakangan mental)',
                    'Jumlah tuna laras (eks-sakit jiwa)',
                    'Jumlah tuna eks-sakit kusta',
                    'Jumlah tuna ganda (fisik-mental)',
                    'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)',
                    'Ruang Terbuka Hijau (RTH)',
                    'Ruang Terbuka Non Hijau (RTNH)',
                    'Sepak bola',
                    'Bola voli',
                    'Bulu tangkis',
                    'Bola basket',
                    'Tenis lapangan',
                    'Tenis meja',
                    'Futsal',
                    'Renang',
                    'Bela diri (pencak silat, karate, dll.)',
                    'Bilyard',
                    'Fitness, aerobik, dll.',
                    'Fasilitas Lainnya',
                    'Kondisi Fasilitas lainnya',
                    'Lalu lintas dari/ke desa/kelurahan melalui',
                    'Jenis permukaan jalan darat antar desa/kelurahan yang terluas',
                    'Jalan darat antar desa/kelurahan dapat dilalui kendaraan bermotor roda 4 atau lebih',
                    'Keberadaan angkutan umum',
                    'Operasional angkutan umum yang utama',
                    'Jam operasi angkutan umum yang utama',
                    'Keberadaan internet untuk warnet, game online, dan fasilitas lainnya di desa/kelurahan',
                    'Jumlah menara telepon seluler atau Base Transceiver Station (BTS)',
                    'Jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa',
                    'Sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
                    'Sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan',
                    'Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah',
                    'Fasilitas internet di kantor kepala desa/lurah',
                    'Kantor pos/pos pembantu/rumah pos',
                    'Layanan pos keliling',
                    'Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta',
                    'Keberadaan Sentra Industri Unggulan Desa',
                    'Sentra Industri',
                    'Produk pada sentra industri yang mempunyai muatan usaha terbanyak',
                    'Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)',
                    'Produk barang unggulan/utama desa/kelurahan (makanan)',
                    'Produk barang unggulan/utama desa/kelurahan (non makanan)',
                    'Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)',
                    'Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)',
                    'Jumlah Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)',
                    'Jumlah Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)',
                    'Jumlah Bank Perkreditan Rakyat (BPR)',
                    'Jika tidak ada bank, perkiraan jarak ke bank terdekat',
                    'Jumlah Koperasi Unit Desa (KUD)',
                    'Jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro',
                    'Jumlah Koperasi Simpan Pinjam (KSP/Kospin)',
                    'Jumlah Koperasi lainnya',
                    'Keberadaan Toko Milik KUD',
                    'Keberadaan Toko Milik BUM Desa',
                    'Keberadaan Toko Selain milik KUD/BUM Desa',
                    'Jumlah Sarana Baitul Maal Wa Tamwil (BMT)',
                    'Jarak Baitul Maal Wa Tamwil (BMT)',
                    'Kemudahan untuk Mencapai Baitul Maal Wa Tamwil (BMT)',
                    'Jumlah Sarana Anjungan Tunai Mandiri (ATM)',
                    'Jarak Anjungan Tunai Mandiri (ATM)',
                    'Kemudahan untuk Mencapai Anjungan Tunai Mandiri (ATM)',
                    'Jumlah Sarana Agen Bank',
                    'Jarak Agen Bank',
                    'Kemudahan untuk Mencapai Agen Bank',
                    'Jumlah Sarana Pedagang Valuta Asing',
                    'Jarak Pedagang Valuta Asing',
                    'Kemudahan untuk Mencapai Pedagang Valuta Asing',
                    'Jumlah Sarana Pergadaian',
                    'Jarak Pergadaian',
                    'Kemudahan untuk Mencapai Pergadaian',
                    'Jumlah Sarana Agen Tiket/Travel/Biro Perjalanan',
                    'Jarak Agen Tiket/Travel/Biro Perjalanan',
                    'Kemudahan untuk Mencapai Agen Tiket/Travel/Biro Perjalanan',
                    'Jumlah Sarana Bengkel Mobil/Motor',
                    'Jarak Bengkel Mobil/Motor',
                    'Kemudahan untuk Mencapai Bengkel Mobil/Motor',
                    'Jumlah Sarana Salon Kecantikan',
                    'Jarak Salon Kecantikan',
                    'Kemudahan untuk Mencapai Salon Kecantikan',
                    'Jumlah Sarana Kelompok pertokoan',
                    'Kemudahan untuk Mencapai Kelompok pertokoan',
                    'Jumlah Sarana Pasar dengan bangunan permanen',
                    'Kemudahan untuk Mencapai Pasar dengan bangunan permanen',
                    'Jumlah Sarana Pasar dengan bangunan semi permanen',
                    'Kemudahan untuk Mencapai Pasar dengan bangunan semi permanen',
                    'Jumlah Sarana Pasar tanpa bangunan',
                    'Kemudahan untuk Mencapai Pasar tanpa bangunan',
                    'Jumlah Sarana Minimarket/swalayan/supermarket',
                    'Kemudahan untuk Mencapai Minimarket/swalayan/supermarket',
                    'Jumlah Sarana Restoran/rumah makan',
                    'Kemudahan untuk Mencapai Restoran/rumah makan',
                    'Jumlah Sarana Warung/kedai makanan minuman',
                    'Kemudahan untuk Mencapai Warung/kedai makanan minuman',
                    'Jumlah Sarana Toko/warung kelontong',
                    'Kemudahan untuk Mencapai Toko/warung kelontong',
                    'Jumlah Sarana Hotel',
                    'Kemudahan untuk Mencapai Hotel',
                    'Jumlah Sarana Penginapan (hostel/motel/losmen/wisma)',
                    'Kemudahan untuk Mencapai Penginapan (hostel/motel/losmen/wisma)',
                    'Kejadian Perkelahian Massal di Desa/Kelurahan Selama Setahun Terakhir',
                    'Pembangunan/pemeliharaan pos keamanan lingkungan',
                    'Pembentukan/pengaturan regu keamanan',
                    'Penambahan jumlah anggota hansip/linmas',
                    'Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan',
                    'Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga',
                    'Jumlah anggota linmas/hansip di desa/kelurahan',
                    'Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan'
                ];

                // Execute the Query
                $result = mysqli_query($conn, $query);

                // Check for query execution errors
                if (!$result) {
                    die("Query Error: " . mysqli_error($conn));
                }

                // Determine if Data was Found
                $data_found = mysqli_num_rows($result) > 0;
                ?>

                <!-- Modal Preview -->
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen"> <!-- Full-Screen Modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel">Preview Data</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> <!-- Bootstrap 5 close button -->
                            </div>
                            <div class="modal-body" style="overflow-x: auto; overflow-y: auto;"> <!-- Enable both horizontal and vertical scrolling -->
                                <?php if ($data_found): ?>
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <?php foreach ($headers as $header): ?>
                                                    <th class="text-center"><?php echo htmlspecialchars($header); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <?php foreach ($columns as $column): ?>
                                                        <td>
                                                            <?php
                                                            // Display the data or a dash if empty
                                                            echo isset($row[$column]) && !empty($row[$column]) ? htmlspecialchars($row[$column]) : '-';
                                                            ?>
                                                        </td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>Data tidak ditemukan.</p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <!-- Bootstrap 5 close button -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap JS and dependencies (Popper.js) -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-z7Hsjp8CQ0pcZ9XUpk8+0I9Ebm8BlDR+NHpT7xVmbZewC6BjijU/du//k6aWsv0C" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-J6qa484yGJC9g6YtfVFrFkGmPzCI8R86OfXbfe0CkHhfXPyUxUlP/kGhG3Ed3eYc" crossorigin="anonymous"></script>

                <!-- Optional: jQuery and DataTables JS for enhanced table features -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

                <script>
                    $(document).ready(function() {
                        // Initialize DataTables for enhanced table features
                        $('#dataTable').DataTable({
                            "scrollX": true, // Enable horizontal scrolling
                            "paging": true, // Enable pagination
                            "pageLength": 25, // Set default page length
                            "lengthMenu": [
                                [25, 50, 100, -1],
                                [25, 50, 100, "All"]
                            ], // Page length options
                            "order": [] // Disable initial sorting
                        });
                    });
                </script>
                <style>
                    /* Optional: Customize table cell padding */
                    table th,
                    table td {
                        padding: 8px;
                        white-space: nowrap;
                        /* Prevent text from wrapping */
                    }
                </style>

            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->

        <?php include("../../components/footer.php"); ?>
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->

    <!-- Tambahkan library Select2 dan tema Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../../dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
</body><!--end::Body-->

</html>