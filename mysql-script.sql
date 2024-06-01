DROP database promodescuentos;

CREATE DATABASE IF NOT EXISTS promodescuentos;
USE promodescuentos;

-- Crear tabla de roles
CREATE TABLE Roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL
);

-- Crear tabla de usuarios con un campo para el rol
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES Roles (role_id)
);
CREATE INDEX idx_username ON Users (username);
CREATE INDEX idx_email ON Users (email);

-- Crear tabla de categorías
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
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
);
CREATE INDEX idx_title ON Deals (title);


CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    comment_text TEXT NOT NULL,
    deal_id INT,
    user_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (deal_id) REFERENCES Deals (deal_id),
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
);

-- Insertar roles predeterminados
INSERT INTO Roles (role_name) VALUES ('Super Administrador'), ('Administrador'), ('Usuario Común');

-- Insertar categorías predeterminadas
INSERT INTO Categories (name) VALUES
('Videojuegos'), ('Abarrotes y Alimentos'), ('Ropa y Accesorios'), ('Salud y Belleza'),
('Familia, Bebés y Niños'), ('Hogar'), ('Jardín y Hazlo Tú Mismo'), ('Autos y Motos'),
('Entretenimientos y Tiempo Libre'), ('Deportes y Ejercicio'), ('Internet y Telefonía Celular'),
('Viajes'), ('Finanzas y Seguros'), ('Servicios y Suscripciones'), ('Tecnología');


CREATE VIEW DealInformation AS
SELECT d.deal_id, d.title, d.coupon_code, d.link, d.start_date, d.end_date, d.start_time, d.end_time, 
       d.description, d.regular_price, d.offer_price, d.availability, d.shipping_cost, 
       c.name AS category_name,
       u.username AS creator_username, d.image_link
FROM Deals d
JOIN Categories c ON d.category_id = c.category_id
JOIN Users u ON d.user_id = u.user_id;


CREATE VIEW UserInformation AS
SELECT user_id, username, email, role_name
FROM Users
JOIN Roles ON Users.role_id = Roles.role_id;


CREATE VIEW PromotionsEndingSoon AS
SELECT d.deal_id, d.title, d.coupon_code, d.link, d.start_date, d.end_date, d.start_time, d.end_time, 
       d.description, d.regular_price, d.offer_price, d.availability, d.shipping_cost, 
       c.name AS category_name,
       u.username AS creator_username, d.image_link
FROM Deals d
JOIN Categories c ON d.category_id = c.category_id
JOIN Users u ON d.user_id = u.user_id
WHERE (d.end_date = DATE(NOW()) AND d.end_time > TIME(NOW())) 
   OR (d.end_date = DATE(NOW() + INTERVAL 1 DAY) AND d.end_time <= TIME(NOW()));


CREATE VIEW NewestPromotions AS
SELECT d.deal_id, d.title, d.coupon_code, d.link, d.start_date, d.end_date, d.start_time, d.end_time, 
       d.description, d.regular_price, d.offer_price, d.availability, d.shipping_cost, 
       c.name AS category_name,
       u.username AS creator_username, d.image_link
FROM Deals d
JOIN Categories c ON d.category_id = c.category_id
JOIN Users u ON d.user_id = u.user_id
ORDER BY d.timestamp DESC;
