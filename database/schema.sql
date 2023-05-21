-- Создание базы данных calendar 
CREATE DATABASE calendar;
USE calendar;

-- Создание таблицы пользователей (users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Создание таблицы задач и связь с таблицей пользователей по их id (user_id)
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    theme VARCHAR(255) NOT NULL,
    type ENUM('встреча', 'звонок', 'совещание', 'дело') NOT NULL,
    location VARCHAR(255) NOT NULL,
    datetime DATETIME NOT NULL,
    duration INT NOT NULL,
    comment TEXT,
    status ENUM('запланировано', 'завершено') NOT NULL DEFAULT 'запланировано',
    FOREIGN KEY (user_id) REFERENCES users(id)
);