CREATE TABLE tb_jarak_kantor_desa (
  id_jarak_kantor_desa int NOT NULL AUTO_INCREMENT,
  jarak_ke_ibukota_kecamatan varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  jarak_ke_ibukota_kabupaten varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  user_id int DEFAULT NULL,
  desa_id int DEFAULT NULL,
  PRIMARY KEY (id_jarak_kantor_desa),
  KEY fk_user_id (user_id),
  KEY fk_desa_id (desa_id),
  CONSTRAINT fk_tb_jarak_kantor_desa_id FOREIGN KEY (desa_id) REFERENCES tb_enumerator (id_desa) ON DELETE CASCADE,
  CONSTRAINT fk_tb_jarak_kantor_user_id FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;