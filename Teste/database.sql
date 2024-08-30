CREATE DATABASE acai_da_jade;

USE acai_da_jade;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    sabor VARCHAR(50) NOT NULL,
    tamanho VARCHAR(20) NOT NULL,
    valor_total DECIMAL(10, 2) NOT NULL,
    observacoes TEXT,
    rua VARCHAR(100) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100),
    bairro VARCHAR(100) NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE adicionais_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    adicional VARCHAR(50) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

CREATE TABLE sugestoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
