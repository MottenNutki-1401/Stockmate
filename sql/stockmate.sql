-- Create the database
CREATE DATABASE IF NOT EXISTS stockmate;

-- Use the database
USE stockmate;

-- Create the stock_items table
CREATE TABLE IF NOT EXISTS stock_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    item_id VARCHAR(50) NOT NULL UNIQUE,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL
);

-- Insert sample data
INSERT INTO stock_items (item_name, quantity, item_id, price, image_path) VALUES
('Product A', 100, 'PROD001', 99.99, '/Stockmate/Assets/product_a.png'),
('Product B', 50, 'PROD002', 149.50, '/Stockmate/Assets/product_b.png'),
('Product C', 200, 'PROD003', 249.99, '/Stockmate/Assets/product_c.png');
