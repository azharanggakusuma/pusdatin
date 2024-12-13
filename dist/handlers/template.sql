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
