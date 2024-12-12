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
