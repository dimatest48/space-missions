-- Створення таблиці користувачів
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Створення таблиці агентств
CREATE TABLE agencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(50),
    founded_year INT
);

-- Створення таблиці космічних місій
CREATE TABLE missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    launch_date DATE,
    agency_id INT,
    FOREIGN KEY (agency_id) REFERENCES agencies(id)
);

-- Створення таблиці коментарів
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Додавання тестових агентств
INSERT INTO agencies (name, country, founded_year) VALUES
('NASA', 'USA', 1958),
('ESA', 'Europe', 1975),
('SpaceX', 'USA', 2002);

-- Додавання тестових місій
INSERT INTO missions (title, description, launch_date, agency_id) VALUES
('Apollo 11', 'First moon landing mission', '1969-07-16', 1),
('Mars Express', 'Mars orbiter by ESA', '2003-06-02', 2),
('Starship Test', 'Starship launch vehicle test flight', '2024-04-12', 3);

-- Додавання тестового користувача
INSERT INTO users (username, email, password, role) VALUES
('testuser', 'test@example.com', SHA2('password123', 256), 'user');

-- Додавання тестових коментарів
INSERT INTO comments (mission_id, user_id, content) VALUES
(1, 1, 'Ta misja była przełomowa dla ludzkości.'),
(2, 1, 'Bardzo ciekawa misja Europejskiej Agencji Kosmicznej.');

