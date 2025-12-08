SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET NAMES utf8mb4 */;

/* ==================================================================
   1. BẢNG BOOKS (đảm bảo book có trường file_path)
   ================================================================== */
CREATE TABLE IF NOT EXISTS books (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  author VARCHAR(100),
  category VARCHAR(100),
  year INT,
  quantity INT,
  link VARCHAR(255),
  description TEXT,
  cover_image VARCHAR(255),
  file_path VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ==================================================================
   2. BẢNG LOANS (mượn – trả)
   ================================================================== */
CREATE TABLE IF NOT EXISTS loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    return_date DATETIME DEFAULT NULL,
    status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
    
    CONSTRAINT fk_loans_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE,
    
    CONSTRAINT fk_loans_book FOREIGN KEY (book_id)
        REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ==================================================================
   3. BẢNG AUTHORS (nếu cần)
   ================================================================== */
CREATE TABLE IF NOT EXISTS authors (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ==================================================================
   4. BẢNG CATEGORIES (nếu cần)
   ================================================================== */
CREATE TABLE IF NOT EXISTS categories (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* ==================================================================
   5. BẢNG UPLOADS – để xử lý upload ảnh
   ================================================================== */
CREATE TABLE IF NOT EXISTS uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
