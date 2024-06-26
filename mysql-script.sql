DROP DATABASE IF EXISTS promodescuentos;

CREATE DATABASE IF NOT EXISTS promodescuentos
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
USE promodescuentos;

-- Crear tabla de roles
CREATE TABLE Roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear tabla de usuarios con un campo para el rol
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar_link VARCHAR(255),
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES Roles (role_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE INDEX idx_username ON Users (username);
CREATE INDEX idx_email ON Users (email);

-- Crear tabla de categorías
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE INDEX idx_category ON Categories (name);

-- Crear tabla de ofertas
CREATE TABLE Deals (
    deal_id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255) NOT NULL,
    store VARCHAR(50) NOT NULL,
    title VARCHAR(140) NOT NULL,
    regular_price DECIMAL(10, 2),
    offer_price DECIMAL(10, 2),
    coupon_code VARCHAR(50),
    availability ENUM('ONLINE', 'OFFLINE') NOT NULL,
    shipping_cost DECIMAL(10, 2),
    shipping_address VARCHAR(50),
    image_link VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE,
    end_date DATE,
    start_time TIME,
    end_time TIME,
    category_id INT,
    user_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories (category_id),
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE INDEX idx_title ON Deals (title);

-- Crear tabla de comentarios con ON DELETE CASCADE
CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    comment_text TEXT NOT NULL,
    deal_id INT,
    user_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (deal_id) REFERENCES Deals (deal_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insertar roles predeterminados
INSERT INTO Roles (role_name) VALUES ('Super Administrador'), ('Administrador'), ('Usuario Común');

-- Insertar categorías predeterminadas
INSERT INTO Categories (name) VALUES
('Videojuegos'), ('Abarrotes y alimentos'), ('Ropa y accesorios'), ('Salud y belleza'),
('Familia, bebés y niños'), ('Hogar'), ('Jardín y hazlo tú mismo'), ('Autos y motos'),
('Entretenimientos y tiempo libre'), ('Deportes y ejercicio'), ('Internet y telefonía celular'),
('Viajes'), ('Finanzas y seguros'), ('Servicios y suscripciones'), ('Tecnología');

-- Crear vista DealInformation
CREATE VIEW DealInformation AS
SELECT d.deal_id, d.title, d.coupon_code, d.link, d.start_date, d.end_date, d.start_time, d.end_time, 
       d.description, d.regular_price, d.offer_price, d.availability, d.shipping_cost, d.shipping_address, d.store, 
       c.name AS category_name,
       u.username AS creator_username, d.image_link, d.timestamp, u.avatar_link, u.user_id
FROM Deals d
JOIN Categories c ON d.category_id = c.category_id
JOIN Users u ON d.user_id = u.user_id;

-- Crear vista UserInformation
CREATE VIEW UserInformation AS
SELECT user_id, username, email, role_name
FROM Users
JOIN Roles ON Users.role_id = Roles.role_id;

-- Crear vista HOT
CREATE VIEW HOT AS
SELECT d.deal_id, d.title, d.image_link, d.end_date, d.end_time, 
       d.offer_price, d.regular_price, d.availability, d.shipping_cost, d.store, 
       d.coupon_code, d.description, u.username AS creator_username, u.avatar_link,
       (SELECT COUNT(*) FROM Comments c WHERE c.deal_id = d.deal_id) AS comment_count, d.link, d.timestamp AS creation_datetime
FROM Deals d
JOIN Users u ON d.user_id = u.user_id
WHERE (d.end_date = DATE(NOW()) AND d.end_time > TIME(NOW())) 
   OR (d.end_date = DATE(NOW() + INTERVAL 1 DAY) AND d.end_time <= TIME(NOW()))
ORDER BY d.end_date ASC, d.end_time ASC;

-- Crear vista news
CREATE VIEW news AS
SELECT d.deal_id, d.title, d.image_link, d.end_date, d.end_time, 
       d.offer_price, d.regular_price, d.availability, d.shipping_cost, d.store, 
       d.coupon_code, d.description, u.username AS creator_username, u.avatar_link,
       (SELECT COUNT(*) FROM Comments c WHERE c.deal_id = d.deal_id) AS comment_count, d.link, d.timestamp AS creation_datetime
FROM Deals d
JOIN Users u ON d.user_id = u.user_id
ORDER BY d.timestamp DESC;

-- Crear vista foryou
CREATE VIEW foryou AS
SELECT d.deal_id, d.title, d.image_link, d.end_date, d.end_time, 
       d.offer_price, d.regular_price, d.availability, d.shipping_cost, d.store, 
       d.coupon_code, d.description, u.username AS creator_username, u.avatar_link,
       (SELECT COUNT(*) FROM Comments c WHERE c.deal_id = d.deal_id) AS comment_count, d.link, d.timestamp AS creation_datetime
FROM Deals d
JOIN Users u ON d.user_id = u.user_id
ORDER BY d.timestamp DESC;

-- Creación de los privilegios

-- Crear el usuario
CREATE USER 'app_user'@'localhost' IDENTIFIED BY '2468101214';

-- Asignar privilegios al usuario
GRANT SELECT, INSERT, UPDATE ON promodescuentos.* TO 'app_user'@'localhost';

-- Aplicar los cambios
FLUSH PRIVILEGES;
