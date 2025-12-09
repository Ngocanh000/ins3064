DROP TABLE IF EXISTS uploads;
DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS authors;
DROP TABLE IF EXISTS users;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  email VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (id, username, password_hash, role)
VALUES
(1, 'na', '202cb962ac59075b964b07152d234b70', 'user'),
(2, 'admin', '289dff07669d7a23de0ef88d2f7129e7', 'admin');

CREATE TABLE authors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  bio TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO authors (name) VALUES
('Paulo Coelho'),
('Nhiều tác giả'),
('Dale Carnegie'),
('Napoleon Hill'),
('ANDREW MATTHEWS'),
('David J. Lieberman'),
('Jack London');

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name) VALUES
('novel'),
('Life Skills'),
('Adventure story');

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(300) NOT NULL,
  author_id INT,
  category_id INT,
  year YEAR,
  quantity INT DEFAULT 0,
  description TEXT,
  cover_image VARCHAR(255),
  link VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE SET NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO books 
(title, author_id, category_id, year, quantity, link, description, cover_image) VALUES
('Nhà giả kim', 1, 1, 1988, 3, 'https://nhasachmienphi.com/nha-gia-kim.html', 'Tất cả những trải nghiệm...', 'uploads/1762326042_nhasachmienphi-nha-gia-kim.jpg'),
('Hạt giống tâm hồn', 2, 1, 1993, 3, 'https://ebookvie.com/ebook/hat-giong-tam-hon-tron-bo-11-cuon/', 'Hạt Giống Tâm Hồn...', 'uploads/ebook-hat-giong-tam-hon-full-prc-pdf-epub-azw3.jpg'),
('Đắc Nhân Tâm', 3, 1, 1936, 3, 'https://nhasachmienphi.com/dac-nhan-tam.html', 'Khi ta nhắc đến cuốn sách...', 'uploads/dac-nhan-tam.webp'),
('Cách nghĩ để thành công', 4, 1, 1937, 5, 'https://dilib.vn/tom-tat-sach/cach-nghi-de-thanh-cong-401.html', 'Cuốn sách "Cách Nghĩ Để Thành Công"...', 'uploads/401-cach-nghi-de-thanh-cong-1.jpg'),
('Đời thay đổi khi chúng ta thay đổi', 5, 1, 1988, 4, 'https://docsach24.co/e-book/doi-thay-doi-khi-chung-ta-thay-doi-3691.html', 'hsak', 'uploads/doi_thay_doi_khi_chung_ta_thay_doi.jpg'),
('Đọc Vị Bất Kỳ Ai', 6, 2, 2018, 3, 'https://file.nhasachmienphi.com/pdf/...', 'Tác phẩm "Đọc vị bất kỳ ai"...', 'uploads/Đọc-vị-bất-kỳ-ai-2-1-1024x682.jpg'),
('Tiếng gọi nơi hoang dã', 7, 3, 1903, 3, 'https://ia802308.us.archive.org/15/items/sachvui...', 'Đến với tiếng gọi nơi hoang dã...', 'uploads/nhasachmienphi-tieng-goi-noi-hoang-da.jpg');

CREATE TABLE loans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  borrowed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  due_date DATE,
  returned_at DATETIME,
  status ENUM('borrowed','returned','overdue') DEFAULT 'borrowed',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE uploads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_id INT,
  filename VARCHAR(255),
  path VARCHAR(500),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
