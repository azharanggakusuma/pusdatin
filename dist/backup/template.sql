CREATE TABLE tb_jarak_kantor_desa (
  id_jarak_kantor_desa int NOT NULL AUTO_INCREMENT,
  jarak_ke_ibukota_kecamatan varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  jarak_ke_ibukota_kabupaten varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_jarak_kantor_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_titik_koordinat_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_titik_koordinat_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_topografi_terluas_wilayah_desa (
  id_topografi_terluas_wilayah_desa int NOT NULL AUTO_INCREMENT,
  topografi_terluas_wilayah_desa varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_topografi_terluas_wilayah_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_topografi_terluas_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_topografi_terluas_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_luas_tanah_kas_desa (
  id_luas_tanah_kas_desa int NOT NULL AUTO_INCREMENT,
  tanah_bengkok DECIMAL(10,2) NOT NULL,
  tanah_titi_sara DECIMAL(10,2) NOT NULL,
  kebun_desa DECIMAL(10,2) NOT NULL,
  sawah_desa DECIMAL(10,2) NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_luas_tanah_kas_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_luas_tanah_kas_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_luas_tanah_kas_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_status_pemerintahan_desa (
  id_status_pemerintahan_desa int NOT NULL AUTO_INCREMENT,
  klasifikasi_desa varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  status_pemerintahan varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_status_pemerintahan_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_status_pemerintahan_desa_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_status_pemerintahan_desa_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_dusun_rw_rt (
  id_dusun_rw_rt int NOT NULL AUTO_INCREMENT,
  jumlah_dusun int NOT NULL,
  jumlah_rw int NOT NULL,
  jumlah_rt int NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_dusun_rw_rt),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_dusun_rw_rt_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_dusun_rw_rt_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_alamat_balai_desa (
  id_alamat_balai_desa int NOT NULL AUTO_INCREMENT,
  alamat_balai_desa varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  kecamatan varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_alamat_balai_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_alamat_balai_desa_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_alamat_balai_desa_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_dasar_hukum_pemerintahan_desa (
  id_dasar_hukum_pemerintahan_desa int NOT NULL AUTO_INCREMENT,
  dasar_hukum varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  no_peraturan varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_dasar_hukum_pemerintahan_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_dasar_hukum_pemerintahan_desa_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_dasar_hukum_pemerintahan_desa_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_dasar_hukum_bpd (
  id_dasar_hukum_bpd int NOT NULL AUTO_INCREMENT,
  ketersediaan_dasar_hukum varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  nomor_peraturan varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_dasar_hukum_bpd),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_dasar_hukum_bpd_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_dasar_hukum_bpd_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE tb_ketersediaan_penetapan_batas (
  id_penetapan_batas int NOT NULL AUTO_INCREMENT,
  penetapan_batas_desa varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  no_surat_batas_desa varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  ketersediaan_peta_desa varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  no_surat_peta_desa varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_penetapan_batas),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_penetapan_batas_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_penetapan_batas_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_alamat_website_media_sosial (
  id_alamat_website int NOT NULL AUTO_INCREMENT,
  alamat_website varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  alamat_email varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  alamat_facebook varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  alamat_twitter varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  alamat_youtube varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_alamat_website),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_alamat_website_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_alamat_website_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_kepemilikan_kantor (
  id_kepemilikan_kantor INT NOT NULL AUTO_INCREMENT,
  aset_desa VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id INT DEFAULT NULL,
  desa_id INT DEFAULT NULL,
  PRIMARY KEY (id_kepemilikan_kantor),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_kepemilikan_kantor_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_kepemilikan_kantor_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_kondisi_kantor (
  id_kondisi_kantor INT NOT NULL AUTO_INCREMENT,
  kondisi_kantor VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  user_id INT DEFAULT NULL,
  desa_id INT DEFAULT NULL,
  PRIMARY KEY (id_kondisi_kantor),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_kondisi_kantor_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_kondisi_kantor_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_idm_status (
  id_idm_status INT NOT NULL AUTO_INCREMENT,
  status_2024 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  status_2025 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  user_id INT DEFAULT NULL,
  desa_id INT DEFAULT NULL,
  PRIMARY KEY (id_idm_status),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_idm_status_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_idm_status_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tb_ketersediaan_internet (
  id INT NOT NULL AUTO_INCREMENT,
  internet_status VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  internet_speed VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  computer_count INT NOT NULL,
  computer_usage_frequency VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
  user_id INT DEFAULT NULL,
  desa_id INT DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_ketersediaan_internet_user_id FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_tb_ketersediaan_internet_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 