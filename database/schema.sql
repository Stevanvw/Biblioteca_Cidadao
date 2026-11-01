

CREATE DATABASE IF NOT EXISTS biblioteca_cidadao
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca_cidadao;


CREATE TABLE IF NOT EXISTS funcionarios (
  id    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS autores (
  id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
  id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Clientes da biblioteca (cadastrados pelo funcionário)
CREATE TABLE IF NOT EXISTS usuarios (
  id    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome  VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS livros (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo       VARCHAR(150) NOT NULL,
  autor_id     INT UNSIGNED NOT NULL,
  categoria_id INT UNSIGNED NOT NULL,
  editora      VARCHAR(50)  NOT NULL,
  isbn         CHAR(13)     NOT NULL UNIQUE,
  FOREIGN KEY (autor_id)     REFERENCES autores(id),
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS emprestimos (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  usuario_id      INT UNSIGNED NOT NULL,
  livro_id        INT UNSIGNED NOT NULL,
  data_emprestimo DATE NOT NULL,
  data_devolucao  DATE NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (livro_id)   REFERENCES livros(id),
  CHECK (data_devolucao >= data_emprestimo)
) ENGINE=InnoDB;


-- Login: atendimento@bibliotecacidadao.gov.br / biblioteca2026
INSERT INTO funcionarios (email, senha) VALUES
  ('atendimento@bibliotecacidadao.gov.br', '$2y$10$wn7uT5ivJKWZw6Qup/hddeTVFBwa4XhSdeJ53KqSUjLQN/PXjAKYW');

INSERT INTO autores (nome) VALUES
  ('J.R.R. Tolkien'), ('David Goggins'), ('Machado de Assis'),
  ('Clarice Lispector'), ('Isaac Asimov'), ('Robert C. Martin');

INSERT INTO categorias (nome) VALUES
  ('Romance'), ('Conto'), ('Ficção científica'), ('Tecnologia'), ('Biografia');

-- Exemplo (senha 12345)
INSERT INTO usuarios (nome, email, senha) VALUES
  ('Luis Stevan', 'stevanoli08@gmail.com', '$2y$10$svtgAF6TQjXPekPTggqNNu/Ms/Es.vrOJLNQ9kL3mytb0iCB/FOY2');

INSERT INTO livros (titulo, autor_id, categoria_id, editora, isbn) VALUES
  ('Nada pode me ferir', 2, 5, 'Editora Sextante', '9786555646139');

INSERT INTO emprestimos (usuario_id, livro_id, data_emprestimo, data_devolucao) VALUES
  (1, 1, '2026-09-28', '2026-10-05');
