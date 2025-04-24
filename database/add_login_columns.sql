-- Menambahkan kolom username dan password ke tabel pelanggan jika belum ada
ALTER TABLE pelanggan
ADD COLUMN IF NOT EXISTS username VARCHAR(50) UNIQUE,
ADD COLUMN IF NOT EXISTS password VARCHAR(255);

-- Update kolom username dengan nilai default dari email atau nama_pelanggan jika username masih NULL
UPDATE pelanggan 
SET username = COALESCE(email, REPLACE(LOWER(nama_pelanggan), ' ', '_'))
WHERE username IS NULL;

-- Tambahkan index untuk username
CREATE INDEX IF NOT EXISTS idx_username ON pelanggan(username);
