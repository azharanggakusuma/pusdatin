<?php
// Sertakan file koneksi dan sesi
include_once('../../config/conn.php');
include "../../config/session.php";

// Autoload dependencies melalui Composer
require __DIR__ . '/../../../vendor/autoload.php';

// Gunakan namespace yang diperlukan
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

// Definisikan nama kolom asli dari database tanpa prefiks tabel
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

// Definisikan nama kolom yang akan ditampilkan di Excel dan PDF
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

// Query
$query = "
    SELECT DISTINCT 
        tb_sk_pembentukan.tahun,
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
        tb_sutet.keberadaan_pemukiman,
        tb_sutet.jumlah_pemukiman,
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
        tb_keberadaan_pemukiman_bantaran.keberadaan_pemukiman,
        tb_keberadaan_pemukiman_bantaran.jumlah_pemukiman,
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
        tb_enumerator
    LEFT JOIN
        tb_sk_pembentukan
        ON tb_enumerator.id_desa = tb_sk_pembentukan.desa_id
    LEFT JOIN
        (
            SELECT DISTINCT desa_id, tahun 
            FROM user_progress
        ) AS filtered_user_progress
        ON tb_enumerator.id_desa = filtered_user_progress.desa_id
        AND tb_sk_pembentukan.tahun = filtered_user_progress.tahun
    LEFT JOIN tb_balai_desa
        ON tb_enumerator.id_desa = tb_balai_desa.desa_id
    LEFT JOIN tb_batas_desa
        ON tb_enumerator.id_desa = tb_batas_desa.desa_id
    LEFT JOIN tb_jarak_kantor_desa
        ON tb_enumerator.id_desa = tb_jarak_kantor_desa.desa_id
    LEFT JOIN tb_idm_status
        ON tb_enumerator.id_desa = tb_idm_status.desa_id
    LEFT JOIN tb_website_medsos
        ON tb_enumerator.id_desa = tb_website_medsos.desa_id
    LEFT JOIN tb_status_pemerintahan
        ON tb_enumerator.id_desa = tb_status_pemerintahan.desa_id
    LEFT JOIN tb_ketersediaan_penetapan_peta_desa
        ON tb_enumerator.id_desa = tb_ketersediaan_penetapan_peta_desa.desa_id
    LEFT JOIN tb_banyaknya_dusun_rt_rw
        ON tb_enumerator.id_desa = tb_banyaknya_dusun_rt_rw.desa_id
    LEFT JOIN tb_luas_wilayah_desa
        ON tb_enumerator.id_desa = tb_luas_wilayah_desa.desa_id
    LEFT JOIN tb_topografi_terluas_wilayah_desa
        ON tb_enumerator.id_desa = tb_topografi_terluas_wilayah_desa.desa_id
    LEFT JOIN tb_kepemilikan_kantor
        ON tb_enumerator.id_desa = tb_kepemilikan_kantor.desa_id
    LEFT JOIN tb_titik_koordinat_kantor_desa
        ON tb_enumerator.id_desa = tb_titik_koordinat_kantor_desa.desa_id
    LEFT JOIN tb_kematian
        ON tb_enumerator.id_desa = tb_kematian.desa_id
    LEFT JOIN tb_penduduk_dan_keluarga
        ON tb_enumerator.id_desa = tb_penduduk_dan_keluarga.desa_id
    LEFT JOIN tb_ketenagakerjaan
        ON tb_enumerator.id_desa = tb_ketenagakerjaan.desa_id
    LEFT JOIN tb_pengguna_listrik_lampu_surya
        ON tb_enumerator.id_desa = tb_pengguna_listrik_lampu_surya.desa_id
    LEFT JOIN tb_penerangan_jalan
        ON tb_enumerator.id_desa = tb_penerangan_jalan.desa_id
    LEFT JOIN tb_pengelolaan_sampah
        ON tb_enumerator.id_desa = tb_pengelolaan_sampah.desa_id
    LEFT JOIN tb_sutet
        ON tb_enumerator.id_desa = tb_sutet.desa_id
    LEFT JOIN tb_keberadaan_sungai
        ON tb_enumerator.id_desa = tb_keberadaan_sungai.desa_id
    LEFT JOIN tb_keberadaan_danau
        ON tb_enumerator.id_desa = tb_keberadaan_danau.desa_id
    LEFT JOIN tb_keberadaan_pemukiman_bantaran
        ON tb_enumerator.id_desa = tb_keberadaan_pemukiman_bantaran.desa_id
    LEFT JOIN tb_embung_mata_air
        ON tb_enumerator.id_desa = tb_embung_mata_air.desa_id
    LEFT JOIN tb_permukiman_kumuh
        ON tb_enumerator.id_desa = tb_permukiman_kumuh.desa_id
    LEFT JOIN tb_lokasi_penggalian
        ON tb_enumerator.id_desa = tb_lokasi_penggalian.desa_id
    LEFT JOIN tb_prasarana_kebersihan
        ON tb_enumerator.id_desa = tb_prasarana_kebersihan.desa_id
    LEFT JOIN tb_rumah_tidak_layak_huni
        ON tb_enumerator.id_desa = tb_rumah_tidak_layak_huni.desa_id
    LEFT JOIN tb_bencana_alam
        ON tb_enumerator.id_desa = tb_bencana_alam.desa_id
    LEFT JOIN tb_peringatan_bencana
        ON tb_enumerator.id_desa = tb_peringatan_bencana.desa_id
    LEFT JOIN tb_taman_bacaan
        ON tb_enumerator.id_desa = tb_taman_bacaan.desa_id
    LEFT JOIN tb_keberadaan_bidan
        ON tb_enumerator.id_desa = tb_keberadaan_bidan.desa_id
    LEFT JOIN tb_keberadaan_dukun_bayi
        ON tb_enumerator.id_desa = tb_keberadaan_dukun_bayi.desa_id
    LEFT JOIN tb_klb_wabah
        ON tb_enumerator.id_desa = tb_klb_wabah.desa_id
    LEFT JOIN tb_disabilitas
        ON tb_enumerator.id_desa = tb_disabilitas.desa_id
    LEFT JOIN tb_ruang_publik
        ON tb_enumerator.id_desa = tb_ruang_publik.desa_id
    LEFT JOIN tb_fasilitas_olahraga
        ON tb_enumerator.id_desa = tb_fasilitas_olahraga.desa_id
    LEFT JOIN tb_prasarana_transportasi
        ON tb_enumerator.id_desa = tb_prasarana_transportasi.desa_id
    LEFT JOIN tb_internet_transportasi
        ON tb_enumerator.id_desa = tb_internet_transportasi.desa_id
    LEFT JOIN tb_menara_telepon
        ON tb_enumerator.id_desa = tb_menara_telepon.desa_id
    LEFT JOIN tb_ketersediaan_internet
        ON tb_enumerator.id_desa = tb_ketersediaan_internet.desa_id
    LEFT JOIN tb_keberadaan_kantor_pos
        ON tb_enumerator.id_desa = tb_keberadaan_kantor_pos.desa_id
    LEFT JOIN tb_sentra_industri
        ON tb_enumerator.id_desa = tb_sentra_industri.desa_id
    LEFT JOIN tb_produk_unggulan
        ON tb_enumerator.id_desa = tb_produk_unggulan.desa_id
    LEFT JOIN tb_pangkalan_minyak
        ON tb_enumerator.id_desa = tb_pangkalan_minyak.desa_id
    LEFT JOIN tb_bank_operasi
        ON tb_enumerator.id_desa = tb_bank_operasi.desa_id
    LEFT JOIN tb_koperasi
        ON tb_enumerator.id_desa = tb_koperasi.desa_id
    LEFT JOIN tb_sarana_ekonomi
        ON tb_enumerator.id_desa = tb_sarana_ekonomi.desa_id
    LEFT JOIN tb_sarana_prasarana
        ON tb_enumerator.id_desa = tb_sarana_prasarana.desa_id
    LEFT JOIN tb_perkelahian_massal
        ON tb_enumerator.id_desa = tb_perkelahian_massal.desa_id
    LEFT JOIN tb_keamanan_lingkungan
        ON tb_enumerator.id_desa = tb_keamanan_lingkungan.desa_id
    LEFT JOIN tb_linmas_poskamling
        ON tb_enumerator.id_desa = tb_linmas_poskamling.desa_id
    LEFT JOIN tb_keberadaan_pos_polisi
        ON tb_enumerator.id_desa = tb_keberadaan_pos_polisi.desa_id
";

// Tambahkan filter berdasarkan input pengguna dengan prepared statements
$where = [];
$params = [];
$types = '';

if (!empty($kode_kecamatan)) {
    $where[] = "tb_enumerator.kecamatan = ?";
    $params[] = $kode_kecamatan;
    $types .= 's';
}
if (!empty($kode_desa)) {
    $where[] = "tb_enumerator.kode_desa = ?";
    $params[] = $kode_desa;
    $types .= 's';
}
if (!empty($filter_tahun)) {
    $where[] = "tb_sk_pembentukan.tahun = ?";
    $params[] = $filter_tahun;
    $types .= 'i'; // Misalnya tahun adalah integer
}

if (!empty($where)) {
    $query .= " WHERE " . implode(' AND ', $where);
}

// Prepare statement untuk keamanan (Prepared Statements)
$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Failed to prepare the SQL statement: " . mysqli_error($conn));
}

// Bind parameters jika ada
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Eksekusi query
mysqli_stmt_execute($stmt);

// Dapatkan hasil
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Cek apakah ada data
if (mysqli_num_rows($result) == 0) {
    die("Tidak ada data yang ditemukan dengan filter yang diberikan.");
}

// Fungsi untuk ekspor Excel
if ($type === 'excel') {
    try {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tetapkan nama kolom ke baris header Excel secara manual
        $columnIndex = 1; // Kolom A
        foreach ($headers as $header) {
            $columnLetter = Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnIndex++;
        }

        // Style untuk header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        $lastColumn = Coordinate::stringFromColumnIndex(count($headers));
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);

        // Data dari database
        $rowNumber = 2;
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($columns as $index => $column) {
                $columnLetter = Coordinate::stringFromColumnIndex($index + 1);
                // Handle NULL values
                $value = isset($row[$column]) ? $row[$column] : '';
                $sheet->setCellValue($columnLetter . $rowNumber, $value);
            }
            $rowNumber++;
        }

        // Style untuk semua tabel
        $tableStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $lastColumn . ($rowNumber - 1))->applyFromArray($tableStyle);

        // Auto-size columns
        for ($i = 1; $i <= count($headers); $i++) {
            $columnLetter = Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }

        // Membersihkan buffer output
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Kirim file Excel ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="rekap_data_pusdatin.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } catch (Exception $e) {
        die("Error exporting Excel: " . $e->getMessage());
    }
}

// Reset pointer hasil query untuk ekspor PDF
mysqli_data_seek($result, 0);

// Fungsi untuk ekspor PDF
if ($type === 'pdf') {
    try {
        // Karena banyak kolom, gunakan ukuran kertas lebih besar atau orientasi landscape
        $mpdf = new Mpdf(['format' => 'A3-L']); // A3 dengan orientasi landscape

        // Mulai membangun HTML
        $html = '<h1 style="text-align: center;">Rekap Data</h1>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 8px;">';
        $html .= '<thead><tr style="background-color: #d3d3d3; text-align: center;">';

        // Header tabel secara manual
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        // Data dari database
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>';
            foreach ($columns as $column) {
                // Handle NULL values
                $cellData = isset($row[$column]) ? htmlspecialchars($row[$column]) : '';
                $html .= '<td>' . $cellData . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
                                    data-target="#exportModal">
                                    <i class="fas fa-download"></i>&nbsp; Export
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#previewModal">
                                    <i class="fas fa-table"></i> &nbsp; Preview
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0" style="overflow-x: auto;">
                            <table class="table table-striped" style="table-layout: auto; width: 100%;">
                                <thead>
                                    <tr style="white-space: nowrap;">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">Periode Tahun</th>
                                        <th rowspan="2">Kode Desa</th>
                                        <th rowspan="2">Nama Desa</th>
                                        <th rowspan="2">Kecamatan</th>
                                        <th rowspan="2">Sk Pembentukan/Pengesahan Desa/Kelurahan</th>
                                        <th rowspan="2">Alamat Balai Desa/Kantor Kelurahan</th>
                                        <th colspan="2">Batas Utara</th>
                                        <th colspan="2">Batas Selatan</th>
                                        <th colspan="2">Batas Timur</th>
                                        <th colspan="2">Batas Barat</th>
                                        <th rowspan="2">Jarak ke Ibu Kota Kecamatan (km)</th>
                                        <th rowspan="2">Jarak ke Ibu Kota Kabupaten (km)</th>
                                        <th rowspan="2">Status Desa Membangun</th>
                                        <th rowspan="2">Alamat Website Desa</th>
                                        <th rowspan="2">Alamat Email Desa</th>
                                        <th rowspan="2">Alamat Facebook Desa</th>
                                        <th rowspan="2">Alamat Twitter Desa</th>
                                        <th rowspan="2">Alamat YouTube Desa</th>
                                        <th rowspan="2">Status Pemerintahan</th>
                                        <th rowspan="2">Penetapan Batas Desa</th>
                                        <th rowspan="2">No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa</th>
                                        <th rowspan="2">Ketersediaan Peta Desa</th>
                                        <th rowspan="2">No SK/Perbup/Perda tentang Peta Desa</th>
                                        <th rowspan="2">Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis</th>
                                        <th rowspan="2">Banyaknya RW</th>
                                        <th rowspan="2">Banyaknya RT</th>
                                        <th rowspan="2">Luas Wilayah Desa</th>
                                        <th rowspan="2">Topografi Terluas Wilayah Desa</th>
                                        <th rowspan="2">Keberadaan kantor kepala desa/lurah</th>
                                        <th rowspan="2">Status Kantor Kepala Desa/Lurah</th>
                                        <th rowspan="2">Kondisi Kantor Kepala Desa/Balai Desa</th>
                                        <th rowspan="2">Lokasi Kantor Kepala Desa/Lurah</th>
                                        <th rowspan="2">Koordinat Lintang (Latitude)</th>
                                        <th rowspan="2">Koordinat Bujur (Longitude)</th>
                                        <th rowspan="2">Jumlah Surat Kematian Yang Dikeluarkan</th>
                                        <th rowspan="2">Jumlah Penduduk Laki-Laki</th>
                                        <th rowspan="2">Jumlah Penduduk Perempuan</th>
                                        <th rowspan="2">Jumlah Kepala Keluarga</th>
                                        <th rowspan="2">Keberadaan Warga Desa/Kelurahan yang Sedang Bekerja sebagai PMI
                                            (Pekerja Migran Indonesia)/TKI di Luar Negeri</th>
                                        <th rowspan="2">Keberadaan Agen (Seseorang/Sekelompok Orang/Perusahaan)
                                            Pengerahan Pekerja Migran Indonesia/TKI ke Luar Negeri di Desa/Kelurahan
                                        </th>
                                        <th rowspan="2">Layanan Rekomendasi/Surat Keterangan Bagi Warga Desa/Kelurahan
                                            yang Akan Bekerja Sebagai Pekerja Migran Indonesia/TKI di Luar Negeri</th>
                                        <th rowspan="2">Keberadaan Warga Negara Asing (WNA) di Desa/Kelurahan</th>
                                        <th rowspan="2">Jumlah Keluarga Pengguna Listrik PLN (Perusahaan Listrik Negara)
                                        </th>
                                        <th rowspan="2">Jumlah Keluarga Pengguna Listrik Non-PLN</th>
                                        <th rowspan="2">Jumlah Keluraga Bukan Pengguna Listrik
                                        </th>
                                        <th rowspan="2">Keluarga yang Menggunakan Lampu Tenaga Surya
                                        </th>
                                        <th rowspan="2">Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga
                                            Surya</th>
                                        <th rowspan="2">Penerangan di Jalan Utama Desa/Kelurahan</th>
                                        <th rowspan="2">Sumber Penerangan di Jalan Utama Desa/Kelurahan</th>
                                        <th rowspan="2">Keberadaan Tempat Pembuangan Sampah Sementara (TPS)</th>
                                        <th rowspan="2">Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)</th>
                                        <th rowspan="2">Keberadaan Bank Sampah di Desa/Kelurahan</th>
                                        <th rowspan="2">Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra
                                            tinggi (SUTET) / Saluran Udara Tegangan Tinggi (SUUT) / Saluran Udara
                                            Tegangan Tinggi Arus Searah (SUTTAS)</th>
                                        <th rowspan="2">Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS</th>
                                        <th rowspan="2">Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS</th>
                                        <th rowspan="2">Keberadaan Sungai Yang Melintasi</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 1</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 2</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 3</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 4</th>
                                        <th rowspan="2">Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 1</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 2</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 3</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 4</th>
                                        <th rowspan="2">Keberadaan Pemukiman Di Bantaran Sungai</th>
                                        <th rowspan="2">Jumlah Pemukiman Di Bantaran Sungai</th>
                                        <th rowspan="2">Jumlah Embung</th>
                                        <th rowspan="2">Lokasi Mata Air</th>
                                        <th rowspan="2">Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan
                                            Padat Dan Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan</th>
                                        <th rowspan="2">Jumlah Pemukiman Kumuh</th>
                                        <th rowspan="2">Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali,
                                            Pasir, Kapur, Kaolin, Pasir Kuarsa, Tanah Liat, Dll.)</th>
                                        <th rowspan="2">Jumlah Sarana Prasarana Kebersihan</th>
                                        <th rowspan="2">Jumlah Rumah Tidak Layak Huni</th>
                                        <th rowspan="2">Tanah Longsor</th>
                                        <th rowspan="2">Banjir</th>
                                        <th rowspan="2">Banjir Bandang</th>
                                        <th rowspan="2">Gempa Bumi</th>
                                        <th rowspan="2">Tsunami</th>
                                        <th rowspan="2">Gelombang Pasang</th>
                                        <th rowspan="2">Angin Puyuh</th>
                                        <th rowspan="2">Gunung Meletus</th>
                                        <th rowspan="2">Kebakaran Hutan</th>
                                        <th rowspan="2">Kekeringan</th>
                                        <th rowspan="2">Abrasi</th>
                                        <th rowspan="2">Sistem Peringatan Dini Bencana Alam</th>
                                        <th rowspan="2">Sistem Peringatan Dini Khusus Tsunami</th>
                                        <th rowspan="2">Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)</th>
                                        <th rowspan="2">Rambu-Rambu dan Jalur Evakuasi Bencana</th>
                                        <th rowspan="2">Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul,
                                            Parit, Drainase, Waduk, Pantai, dll.)</th>
                                        <th rowspan="2">Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa</th>
                                        <th rowspan="2">Keberadaan Bidan Desa yang menetap di Desa/Kelurahan</th>
                                        <th rowspan="2">Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan</th>
                                        <th rowspan="2">Muntaber/diare</th>
                                        <th rowspan="2">Demam Berdarah</th>
                                        <th rowspan="2">Campak</th>
                                        <th rowspan="2">Malaria</th>
                                        <th rowspan="2">Flu Burung/SARS</th>
                                        <th rowspan="2">Hepatitis E</th>
                                        <th rowspan="2">Difteri</th>
                                        <th rowspan="2">Corona/COVID-19 </th>
                                        <th rowspan="2">Lainnya</th>
                                        <th rowspan="2">Lainnya (Status)</th>
                                        <th rowspan="2">Jumlah Masjid</th>
                                        <th rowspan="2">Jumlah Pura</th>
                                        <th rowspan="2">Jumlah Surau/Langgar/Musala</th>
                                        <th rowspan="2">Jumlah Wihara</th>
                                        <th rowspan="2">Jumlah Gereja Kristen</th>
                                        <th rowspan="2">Jumlah Kelenteng</th>
                                        <th rowspan="2">Jumlah Gereja Katolik</th>
                                        <th rowspan="2">Jumlah Balai Basarah</th>
                                        <th rowspan="2">Jumlah Kapel</th>
                                        <th rowspan="2">Tempat Ibadah Lainnya</th>
                                        <th rowspan="2">Jumlah Lainnya</th>
                                        <th rowspan="2">Jumlah tuna netra (buta)</th>
                                        <th rowspan="2">Jumlah tuna rungu (tuli)</th>
                                        <th rowspan="2">Jumlah tuna wicara (bisu)</th>
                                        <th rowspan="2">Jumlah tuna rungu-wicara (tuli-bisu)</th>
                                        <th rowspan="2">Jumlah tuna daksa (disabilitas tubuh)</th>
                                        <th rowspan="2">Jumlah tuna grahita (keterbelakangan mental)</th>
                                        <th rowspan="2">Jumlah tuna laras (eks-sakit jiwa)</th>
                                        <th rowspan="2">Jumlah tuna eks-sakit kusta</th>
                                        <th rowspan="2">Jumlah tuna ganda (fisik-mental)</th>
                                        <th rowspan="2">Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)</th>
                                        <th rowspan="2">Ruang Terbuka Hijau (RTH)</th>
                                        <th rowspan="2">Ruang Terbuka Non Hijau (RTNH)</th>
                                        <th rowspan="2">Sepak bola</th>
                                        <th rowspan="2">Bola voli</th>
                                        <th rowspan="2">Bulu tangkis</th>
                                        <th rowspan="2">Bola basket</th>
                                        <th rowspan="2">Tenis lapangan</th>
                                        <th rowspan="2">Tenis meja</th>
                                        <th rowspan="2">Futsal</th>
                                        <th rowspan="2">Renang</th>
                                        <th rowspan="2">Bela diri (pencak silat, karate, dll.)</th>
                                        <th rowspan="2">Bilyard</th>
                                        <th rowspan="2">Fitness, aerobik, dll.</th>
                                        <th rowspan="2">Fasilitas Lainnya</th>
                                        <th rowspan="2">Kondisi Fasilitas lainnya</th>
                                        <th rowspan="2">Lalu lintas dari/ke desa/kelurahan melalui</th>
                                        <th rowspan="2">Jenis permukaan jalan darat antar desa/kelurahan yang terluas</th>
                                        <th rowspan="2">Jalan darat antar desa/kelurahan dapat dilalui kendaraan bermotor roda 4 atau lebih</th>
                                        <th rowspan="2">Keberadaan angkutan umum</th>
                                        <th rowspan="2">Operasional angkutan umum yang utama</th>
                                        <th rowspan="2">Jam operasi angkutan umum yang utama</th>
                                        <th rowspan="2">Keberadaan internet untuk warnet, game online, dan fasilitas lainnya di desa/kelurahan</th>
                                        <th rowspan="2">Jumlah menara telepon seluler atau Base Transceiver Station (BTS)</th>
                                        <th rowspan="2">Jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa</th>
                                        <th rowspan="2">Sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan</th>
                                        <th rowspan="2">Sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan</th>
                                        <th rowspan="2">Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah</th>
                                        <th rowspan="2">Fasilitas internet di kantor kepala desa/lurah</th>
                                        <th rowspan="2">Kantor pos/pos pembantu/rumah pos</th>
                                        <th rowspan="2">Layanan pos keliling</th>
                                        <th rowspan="2">Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta</th>
                                        <th rowspan="2">Keberadaan Sentra Industri Unggulan Desa</th>
                                        <th rowspan="2">Sentra Industri</th>
                                        <th rowspan="2">Produk pada sentra industri yang mempunyai muatan usaha terbanyak</th>
                                        <th rowspan="2">Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)</th>
                                        <th rowspan="2">Produk barang unggulan/utama desa/kelurahan (makanan)</th>
                                        <th rowspan="2">Produk barang unggulan/utama desa/kelurahan (non makanan)</th>
                                        <th rowspan="2">Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)</th>
                                        <th rowspan="2">Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)</th>
                                        <th rowspan="2">Jumlah Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)</th>
                                        <th rowspan="2">Jumlah Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)</th>
                                        <th rowspan="2">Jumlah Bank Perkreditan Rakyat (BPR)</th>
                                        <th rowspan="2">Jika tidak ada bank, perkiraan jarak ke bank terdekat</th>
                                        <th rowspan="2">Jumlah Koperasi Unit Desa (KUD)</th>
                                        <th rowspan="2">Jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro</th>
                                        <th rowspan="2">Jumlah Koperasi Simpan Pinjam (KSP/Kospin)</th>
                                        <th rowspan="2">Jumlah Koperasi lainnya</th>
                                        <th rowspan="2">Keberadaan Toko Milik KUD</th>
                                        <th rowspan="2">Keberadaan Toko Milik BUM Desa</th>
                                        <th rowspan="2">Keberadaan Toko Selain milik KUD/BUM Desa</th>
                                        <th rowspan="2">Jumlah Sarana Baitul Maal Wa Tamwil (BMT)</th>
                                        <th rowspan="2">Jarak Baitul Maal Wa Tamwil (BMT)</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Baitul Maal Wa Tamwil (BMT)</th>
                                        <th rowspan="2">Jumlah Sarana Anjungan Tunai Mandiri (ATM)</th>
                                        <th rowspan="2">Jarak Anjungan Tunai Mandiri (ATM) </th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Anjungan Tunai Mandiri (ATM)</th>
                                        <th rowspan="2">Jumlah Sarana Agen Bank</th>
                                        <th rowspan="2">Jarak Agen Bank</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Agen Bank</th>
                                        <th rowspan="2">Jumlah Sarana Pedagang Valuta Asing</th>
                                        <th rowspan="2">Jarak Pedagang Valuta Asing</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Pedagang Valuta Asing</th>
                                        <th rowspan="2">Jumlah Sarana Pergadaian</th>
                                        <th rowspan="2">Jarak Pergadaian</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Pergadaian</th>
                                        <th rowspan="2">Jumlah Sarana Agen Tiket/Travel/Biro Perjalanan</th>
                                        <th rowspan="2">Jarak Agen Tiket/Travel/Biro Perjalanan </th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Agen Tiket/Travel/Biro Perjalanan</th>
                                        <th rowspan="2">Jumlah Sarana Bengkel Mobil/Motor</th>
                                        <th rowspan="2">Jarak Bengkel Mobil/Motor</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Bengkel Mobil/Motor</th>
                                        <th rowspan="2">Jumlah Sarana Salon Kecantikan</th>
                                        <th rowspan="2">Jarak Salon Kecantikan</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Salon Kecantikan</th>
                                        <th rowspan="2">Jumlah Sarana Kelompok pertokoan</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Kelompok pertokoan</th>
                                        <th rowspan="2">Jumlah Sarana Pasar dengan bangunan permanen</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Pasar dengan bangunan permanen</th>
                                        <th rowspan="2">Jumlah Sarana Pasar dengan bangunan semi permanen</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Pasar dengan bangunan semi permanen</th>
                                        <th rowspan="2">Jumlah Sarana Pasar tanpa bangunan</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Pasar tanpa bangunan</th>
                                        <th rowspan="2">Jumlah Sarana Minimarket/swalayan/supermarket</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Minimarket/swalayan/supermarket</th>
                                        <th rowspan="2">Jumlah Sarana Restoran/rumah makan</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Restoran/rumah makan</th>
                                        <th rowspan="2">Jumlah Sarana Warung/kedai makanan minuman</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Warung/kedai makanan minuman</th>
                                        <th rowspan="2">Jumlah Sarana Toko/warung kelontong</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Toko/warung kelontong</th>
                                        <th rowspan="2">Jumlah Sarana Hotel</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Hotel</th>
                                        <th rowspan="2">Jumlah Sarana Penginapan (hostel/motel/losmen/wisma)</th>
                                        <th rowspan="2">Kemudahan untuk Mencapai Penginapan (hostel/motel/losmen/wisma)</th>
                                        <th rowspan="2">Kejadian Perkelahian Massal di Desa/Kelurahan Selama Setahun Terakhir</th>
                                        <th rowspan="2">Pembangunan/pemeliharaan pos keamanan lingkungan</th>
                                        <th rowspan="2">Pembentukan/pengaturan regu keamanan</th>
                                        <th rowspan="2">Penambahan jumlah anggota hansip/linmas</th>
                                        <th rowspan="2">Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan</th>
                                        <th rowspan="2">Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga</th>
                                        <th rowspan="2">Jumlah anggota linmas/hansip di desa/kelurahan</th>
                                        <th rowspan="2">Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan</th>
                                    </tr>
                                    <tr style="white-space: nowrap;">
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
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
                                    <label for="filter_tahun">Pilih Tahun:</label>
                                    <select name="filter_tahun" id="filter_tahun" class="form-control mt-2">
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

                <!-- Modal Export -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="GET" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportModalLabel">Pilih Jenis Export</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Filter Kecamatan -->
                                    <label for="kode_kecamatan">Pilih Kecamatan:</label>
                                    <select name="kode_kecamatan" id="kode_kecamatan" class="form-control mt-2 mb-3" onchange="loadDesa(this.value)">
                                        <option value="">Semua Kecamatan</option>
                                        <?php
                                        $kecamatanResult = mysqli_query($conn, "SELECT DISTINCT kecamatan FROM tb_enumerator ORDER BY kecamatan ASC");
                                        while ($kecamatan = mysqli_fetch_assoc($kecamatanResult)) {
                                            echo "<option value='{$kecamatan['kecamatan']}'>{$kecamatan['kecamatan']}</option>";
                                        }
                                        ?>
                                    </select>

                                    <!-- Filter Desa -->
                                    <label for="kode_desa">Pilih Desa:</label>
                                    <select name="kode_desa" id="kode_desa" class="form-control mt-2 mb-3">
                                        <option value="">Semua Desa</option>
                                        <!-- Desa akan dimuat dinamis berdasarkan pilihan kecamatan -->
                                    </select>

                                    <!-- Filter Tahun -->
                                    <label for="filter_tahun">Pilih Tahun:</label>
                                    <select name="filter_tahun" id="filter_tahun" class="form-control mt-2">
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
                                    <button type="submit" name="type" value="excel" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> &nbsp; Export Excel
                                    </button>
                                    <!-- Tombol Ekspor PDF -->
                                    <button type="submit" name="type" value="pdf" class="btn btn-danger">
                                        <i class="fas fa-file-pdf"></i> &nbsp; Export PDF
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function loadDesa(kecamatan) {
                        const desaSelect = document.getElementById('kode_desa');
                        desaSelect.innerHTML = '<option value="">Memuat...</option>'; // Indikasi loading

                        fetch(`get_desa.php?kecamatan=${kecamatan}`)
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

                // SQL Query
                $query = "
                    SELECT DISTINCT 
                        tb_sk_pembentukan.tahun,
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
                        tb_sutet.keberadaan_pemukiman,
                        tb_sutet.jumlah_pemukiman,
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
                        tb_keberadaan_pemukiman_bantaran.keberadaan_pemukiman,
                        tb_keberadaan_pemukiman_bantaran.jumlah_pemukiman,
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
                        tb_enumerator
                    LEFT JOIN
                        tb_sk_pembentukan
                        ON tb_enumerator.id_desa = tb_sk_pembentukan.desa_id
                    LEFT JOIN
                        (
                            SELECT DISTINCT desa_id, tahun 
                            FROM user_progress
                        ) AS filtered_user_progress
                        ON tb_enumerator.id_desa = filtered_user_progress.desa_id
                        AND tb_sk_pembentukan.tahun = filtered_user_progress.tahun
                    LEFT JOIN tb_balai_desa
                        ON tb_enumerator.id_desa = tb_balai_desa.desa_id
                    LEFT JOIN tb_batas_desa
                        ON tb_enumerator.id_desa = tb_batas_desa.desa_id
                    LEFT JOIN tb_jarak_kantor_desa
                        ON tb_enumerator.id_desa = tb_jarak_kantor_desa.desa_id
                    LEFT JOIN tb_idm_status
                        ON tb_enumerator.id_desa = tb_idm_status.desa_id
                    LEFT JOIN tb_website_medsos
                        ON tb_enumerator.id_desa = tb_website_medsos.desa_id
                    LEFT JOIN tb_status_pemerintahan
                        ON tb_enumerator.id_desa = tb_status_pemerintahan.desa_id
                    LEFT JOIN tb_ketersediaan_penetapan_peta_desa
                        ON tb_enumerator.id_desa = tb_ketersediaan_penetapan_peta_desa.desa_id
                    LEFT JOIN tb_banyaknya_dusun_rt_rw
                        ON tb_enumerator.id_desa = tb_banyaknya_dusun_rt_rw.desa_id
                    LEFT JOIN tb_luas_wilayah_desa
                        ON tb_enumerator.id_desa = tb_luas_wilayah_desa.desa_id
                    LEFT JOIN tb_topografi_terluas_wilayah_desa
                        ON tb_enumerator.id_desa = tb_topografi_terluas_wilayah_desa.desa_id
                    LEFT JOIN tb_kepemilikan_kantor
                        ON tb_enumerator.id_desa = tb_kepemilikan_kantor.desa_id
                    LEFT JOIN tb_titik_koordinat_kantor_desa
                        ON tb_enumerator.id_desa = tb_titik_koordinat_kantor_desa.desa_id
                    LEFT JOIN tb_kematian
                        ON tb_enumerator.id_desa = tb_kematian.desa_id
                    LEFT JOIN tb_penduduk_dan_keluarga
                        ON tb_enumerator.id_desa = tb_penduduk_dan_keluarga.desa_id
                    LEFT JOIN tb_ketenagakerjaan
                        ON tb_enumerator.id_desa = tb_ketenagakerjaan.desa_id
                    LEFT JOIN tb_pengguna_listrik_lampu_surya
                        ON tb_enumerator.id_desa = tb_pengguna_listrik_lampu_surya.desa_id
                    LEFT JOIN tb_penerangan_jalan
                        ON tb_enumerator.id_desa = tb_penerangan_jalan.desa_id
                    LEFT JOIN tb_pengelolaan_sampah
                        ON tb_enumerator.id_desa = tb_pengelolaan_sampah.desa_id
                    LEFT JOIN tb_sutet
                        ON tb_enumerator.id_desa = tb_sutet.desa_id
                    LEFT JOIN tb_keberadaan_sungai
                        ON tb_enumerator.id_desa = tb_keberadaan_sungai.desa_id
                    LEFT JOIN tb_keberadaan_danau
                        ON tb_enumerator.id_desa = tb_keberadaan_danau.desa_id
                    LEFT JOIN tb_keberadaan_pemukiman_bantaran
                        ON tb_enumerator.id_desa = tb_keberadaan_pemukiman_bantaran.desa_id
                    LEFT JOIN tb_embung_mata_air
                        ON tb_enumerator.id_desa = tb_embung_mata_air.desa_id
                    LEFT JOIN tb_permukiman_kumuh
                        ON tb_enumerator.id_desa = tb_permukiman_kumuh.desa_id
                    LEFT JOIN tb_lokasi_penggalian
                        ON tb_enumerator.id_desa = tb_lokasi_penggalian.desa_id
                    LEFT JOIN tb_prasarana_kebersihan
                        ON tb_enumerator.id_desa = tb_prasarana_kebersihan.desa_id
                    LEFT JOIN tb_rumah_tidak_layak_huni
                        ON tb_enumerator.id_desa = tb_rumah_tidak_layak_huni.desa_id
                    LEFT JOIN tb_bencana_alam
                        ON tb_enumerator.id_desa = tb_bencana_alam.desa_id
                    LEFT JOIN tb_peringatan_bencana
                        ON tb_enumerator.id_desa = tb_peringatan_bencana.desa_id
                    LEFT JOIN tb_taman_bacaan
                        ON tb_enumerator.id_desa = tb_taman_bacaan.desa_id
                    LEFT JOIN tb_keberadaan_bidan
                        ON tb_enumerator.id_desa = tb_keberadaan_bidan.desa_id
                    LEFT JOIN tb_keberadaan_dukun_bayi
                        ON tb_enumerator.id_desa = tb_keberadaan_dukun_bayi.desa_id
                    LEFT JOIN tb_klb_wabah
                        ON tb_enumerator.id_desa = tb_klb_wabah.desa_id
                    LEFT JOIN tb_disabilitas
                        ON tb_enumerator.id_desa = tb_disabilitas.desa_id
                    LEFT JOIN tb_ruang_publik
                        ON tb_enumerator.id_desa = tb_ruang_publik.desa_id
                    LEFT JOIN tb_fasilitas_olahraga
                        ON tb_enumerator.id_desa = tb_fasilitas_olahraga.desa_id
                    LEFT JOIN tb_prasarana_transportasi
                        ON tb_enumerator.id_desa = tb_prasarana_transportasi.desa_id
                    LEFT JOIN tb_internet_transportasi
                        ON tb_enumerator.id_desa = tb_internet_transportasi.desa_id
                    LEFT JOIN tb_menara_telepon
                        ON tb_enumerator.id_desa = tb_menara_telepon.desa_id
                    LEFT JOIN tb_ketersediaan_internet
                        ON tb_enumerator.id_desa = tb_ketersediaan_internet.desa_id
                    LEFT JOIN tb_keberadaan_kantor_pos
                        ON tb_enumerator.id_desa = tb_keberadaan_kantor_pos.desa_id
                    LEFT JOIN tb_sentra_industri
                        ON tb_enumerator.id_desa = tb_sentra_industri.desa_id
                    LEFT JOIN tb_produk_unggulan
                        ON tb_enumerator.id_desa = tb_produk_unggulan.desa_id
                    LEFT JOIN tb_pangkalan_minyak
                        ON tb_enumerator.id_desa = tb_pangkalan_minyak.desa_id
                    LEFT JOIN tb_bank_operasi
                        ON tb_enumerator.id_desa = tb_bank_operasi.desa_id
                    LEFT JOIN tb_koperasi
                        ON tb_enumerator.id_desa = tb_koperasi.desa_id
                    LEFT JOIN tb_sarana_ekonomi
                        ON tb_enumerator.id_desa = tb_sarana_ekonomi.desa_id
                    LEFT JOIN tb_sarana_prasarana
                        ON tb_enumerator.id_desa = tb_sarana_prasarana.desa_id
                    LEFT JOIN tb_perkelahian_massal
                        ON tb_enumerator.id_desa = tb_perkelahian_massal.desa_id
                    LEFT JOIN tb_keamanan_lingkungan
                        ON tb_enumerator.id_desa = tb_keamanan_lingkungan.desa_id
                    LEFT JOIN tb_linmas_poskamling
                        ON tb_enumerator.id_desa = tb_linmas_poskamling.desa_id
                    LEFT JOIN tb_keberadaan_pos_polisi
                        ON tb_enumerator.id_desa = tb_keberadaan_pos_polisi.desa_id
                ";

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