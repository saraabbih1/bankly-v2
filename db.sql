
USE banklyv2;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150),
    email VARCHAR(150),
    password VARCHAR(255),
    role ENUM('admin','agent'),
    created_at DATE
);


CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    cin VARCHAR(20),
    phone VARCHAR(20),
    address VARCHAR(255),
    created_at DATE
);


CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    account_number VARCHAR(20),
    account_type ENUM('courant','epargne'),
    balance FLOAT,
    status ENUM('active','blocked','closed'),
    created_at DATE,
    CONSTRAINT fk_account_client
        FOREIGN KEY (client_id) REFERENCES clients(id)
        ON DELETE CASCADE
);
 
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    amount DECIMAL(10,2),
    transaction_type ENUM('debit','credit'),
    description VARCHAR(200),
    transaction_date DATE,
    CONSTRAINT fk_transaction_account
        FOREIGN KEY (account_id) REFERENCES accounts(id)
        ON DELETE CASCADE
);




