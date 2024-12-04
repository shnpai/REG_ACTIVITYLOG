create table search_applicants_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(255),
    license_number INT,
    license_type VARCHAR(255),
    position_applied VARCHAR(255),
    specialization VARCHAR(255),
    added_by INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_by INT,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    password TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE activity_logs (
    activity_log_id INT AUTO_INCREMENT PRIMARY KEY,
    operation VARCHAR(255),
    id INT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(255),
    license_number INT,
    license_type VARCHAR(255),
    position_applied VARCHAR(255),
    specialization VARCHAR(255),
    username VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE user_searched (
    search_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    keyword VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);