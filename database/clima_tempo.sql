-- Banco de dados do ClimaTempo DW
-- Todos os dados são fictícios

CREATE DATABASE IF NOT EXISTS clima_tempo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clima_tempo;

DROP TABLE IF EXISTS favoritas;
DROP TABLE IF EXISTS cidades;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS administradores;

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    plano ENUM('gratuito', 'premium') NOT NULL DEFAULT 'gratuito',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    estado VARCHAR(60) NOT NULL,
    pais VARCHAR(60) NOT NULL,
    temperatura INT NOT NULL,
    sensacao INT NOT NULL,
    maxima INT NOT NULL,
    minima INT NOT NULL,
    condicao VARCHAR(60) NOT NULL,
    icone VARCHAR(30) NOT NULL,
    umidade INT NOT NULL,
    vento INT NOT NULL,
    pressao INT NOT NULL,
    visibilidade INT NOT NULL,
    descricao VARCHAR(500) NOT NULL DEFAULT '',
    atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE favoritas (
    usuario_id INT NOT NULL,
    cidade_id INT NOT NULL,
    PRIMARY KEY (usuario_id, cidade_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (cidade_id) REFERENCES cidades(id) ON DELETE CASCADE
);

-- Administrador: admin@climatempo.test / admin123
INSERT INTO administradores (nome, email, senha) VALUES
('Administrador', 'admin@climatempo.test', '$2y$10$Ik.JF9teFpMi7OLgUP1yyulV5jd770pidtdfZZShNRZFMiLJqZdcW');

-- Usuários de teste, senha: senha1234
INSERT INTO usuarios (nome, email, senha, plano) VALUES
('Ana Silva', 'ana.silva@exemplo.com', '$2y$10$I6xODoLIYLs01UoR2/qBfOFN2XIM/lRFNBAzPS3Dhl6uwfsiQHreW', 'premium'),
('Carlos Souza', 'carlos.souza@exemplo.com', '$2y$10$I6xODoLIYLs01UoR2/qBfOFN2XIM/lRFNBAzPS3Dhl6uwfsiQHreW', 'gratuito');

INSERT INTO cidades (nome, estado, pais, temperatura, sensacao, maxima, minima, condicao, icone, umidade, vento, pressao, visibilidade, descricao) VALUES
('Ceará', 'Piauí', 'Brasil', 26, 26, 26, 26, 'Algumas nuvens', 'cloud-moon', 82, 21, 1012, 10, 'Algumas nuvens no momento, com sensação térmica de 26°. Sem chuva significativa prevista nas próximas 24 horas.'),
('Concórdia', 'Santa Catarina', 'Brasil', 20, 19, 24, 14, 'Parcialmente nublado', 'cloud-sun', 70, 12, 1016, 10, 'Céu com nuvens e aberturas de sol. Noite amena.'),
('Paris', 'Île-de-France', 'França', 9, 7, 11, 5, 'Nublado', 'cloud', 88, 18, 1009, 8, 'Céu encoberto durante todo o dia, com possibilidade de garoa no fim da tarde.'),
('São Paulo', 'São Paulo', 'Brasil', 23, 24, 27, 18, 'Chuva fraca', 'cloud-rain', 76, 10, 1014, 7, 'Pancadas de chuva fraca à tarde.'),
('Curitiba', 'Paraná', 'Brasil', 17, 16, 21, 12, 'Neblina', 'cloud-fog', 91, 8, 1018, 3, 'Neblina pela manhã, dissipando ao longo do dia.'),
('Florianópolis', 'Santa Catarina', 'Brasil', 24, 25, 28, 20, 'Céu limpo', 'sun', 65, 15, 1015, 10, 'Dia ensolarado e sem previsão de chuva.');

-- Ana (Premium) tem 4 de 5 favoritas e Carlos (Gratuito) tem 3 de 3
INSERT INTO favoritas (usuario_id, cidade_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4),
(2, 2), (2, 4), (2, 5);
