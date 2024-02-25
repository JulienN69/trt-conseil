CREATE DATABASE trt_conseil;

USE trtConseil;

CREATE TABLE user
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password TEXT NOT NULL,
    role array
);