CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    loan_period_days INT NOT NULL DEFAULT 14,
    late_count INT NOT NULL DEFAULT 0,
    is_blocked TINYINT(1) NOT NULL DEFAULT 0
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    description TEXT,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE borrow (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
) DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu:
INSERT INTO users (username, password, is_admin) VALUES 
('admin', '<Mật khẩu băm>', 1),
('user1', '<Mật khẩu băm>', 0),
('user2', '<Mật khẩu băm>', 0);

INSERT INTO authors (name) VALUES ('Nguyễn Văn A'), ('Trần Thị B');
INSERT INTO categories (name) VALUES ('Văn học'), ('Khoa học');

INSERT INTO books (title, author_id, category_id, description) VALUES
('Sách Văn học 1', 1, 1, 'Mô tả về sách văn học 1'),
('Sách Khoa học 1', 2, 2, 'Mô tả về sách khoa học 1');
