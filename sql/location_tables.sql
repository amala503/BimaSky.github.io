-- Create provinsi table
CREATE TABLE IF NOT EXISTS provinsi (
    id_provinsi INT AUTO_INCREMENT PRIMARY KEY,
    nama_provinsi VARCHAR(100) NOT NULL
);

-- Create kabupaten table
CREATE TABLE IF NOT EXISTS kabupaten (
    id_kabupaten INT AUTO_INCREMENT PRIMARY KEY,
    provinsi_id INT,
    nama_kabupaten VARCHAR(100) NOT NULL,
    FOREIGN KEY (provinsi_id) REFERENCES provinsi(id_provinsi)
);

-- Create kecamatan table
CREATE TABLE IF NOT EXISTS kecamatan (
    id_kecamatan INT AUTO_INCREMENT PRIMARY KEY,
    kabupaten_id INT,
    nama_kecamatan VARCHAR(100) NOT NULL,
    FOREIGN KEY (kabupaten_id) REFERENCES kabupaten(id_kabupaten)
);

-- Create kelurahan table
CREATE TABLE IF NOT EXISTS kelurahan (
    id_kelurahan INT AUTO_INCREMENT PRIMARY KEY,
    kecamatan_id INT,
    nama_kelurahan VARCHAR(100) NOT NULL,
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id_kecamatan)
);

-- Insert sample data for provinsi
INSERT INTO provinsi (nama_provinsi) VALUES 
('DKI Jakarta'),
('Jawa Barat'),
('Jawa Tengah'),
('Jawa Timur'),
('Banten');

-- Insert sample data for kabupaten in DKI Jakarta
INSERT INTO kabupaten (provinsi_id, nama_kabupaten) VALUES 
(1, 'Jakarta Pusat'),
(1, 'Jakarta Utara'),
(1, 'Jakarta Barat'),
(1, 'Jakarta Selatan'),
(1, 'Jakarta Timur');

-- Insert sample data for kecamatan in Jakarta Pusat
INSERT INTO kabupaten (provinsi_id, nama_kabupaten) VALUES 
(2, 'Bandung'),
(2, 'Bekasi'),
(2, 'Bogor'),
(2, 'Depok'),
(2, 'Cimahi');

-- Insert sample data for kecamatan in Jakarta Pusat
INSERT INTO kecamatan (kabupaten_id, nama_kecamatan) VALUES 
(1, 'Gambir'),
(1, 'Tanah Abang'),
(1, 'Menteng'),
(1, 'Senen'),
(1, 'Kemayoran');

-- Insert sample data for kelurahan in Gambir
INSERT INTO kelurahan (kecamatan_id, nama_kelurahan) VALUES 
(1, 'Gambir'),
(1, 'Cideng'),
(1, 'Petojo Utara'),
(1, 'Petojo Selatan'),
(1, 'Kebon Kelapa');
