CREATE DATABASE IF NOT EXISTS empregados;

USE empregados;

CREATE TABLE funcionario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    salario DECIMAL(10, 2) NOT NULL
);

INSERT INTO funcionario (nome, cargo, salario) VALUES ('João Silva', 'Gerente', 5000.00)