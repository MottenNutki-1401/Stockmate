-- Create the 'users' table with necessary fields
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Create related table with foreign key constraint (if needed)
-- CREATE TABLE IF NOT EXISTS related_table (
--     user_id INT,
--     other_column VARCHAR(255),
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );
