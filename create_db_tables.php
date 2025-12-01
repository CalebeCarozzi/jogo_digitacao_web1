<?php

require_once "credentials_db.php";


//conectando ao servidor sem o banco ainda 
$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}


//criando base de dados
$sql = "CREATE DATABASE IF NOT EXISTS $database
        DEFAULT CHARACTER SET utf8mb4
        DEFAULT COLLATE utf8mb4_unicode_ci";

if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar banco de dados $database: " . mysqli_error($conn));
}

echo "Banco de dados '$database' criado<br>";


// Selecionando banco
if (!mysqli_select_db($conn, $database)) {
    die("Erro ao selecionar banco de dados $database: " . mysqli_error($conn));
}



// Criando tabelas

$sql = "CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar tabela usuarios: " . mysqli_error($conn));
}
echo "Tabela de usuarios criada<br>";




$sql = "CREATE TABLE IF NOT EXISTS partidas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL,
  pontuacao INT NOT NULL,
  data_partida DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_partidas_usuario (usuario_id),
  INDEX idx_partidas_data (data_partida),

  CONSTRAINT fk_partidas_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar tabela partidas: " . mysqli_error($conn));
}
echo "Tabela de partidas criada<br>";




$sql = "CREATE TABLE IF NOT EXISTS ligas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  chave_entrada VARCHAR(100) NOT NULL,
  dono_id INT UNSIGNED NOT NULL,
  data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  UNIQUE KEY uk_ligas_nome (nome),

  CONSTRAINT fk_ligas_dono
    FOREIGN KEY (dono_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar tabela ligas: " . mysqli_error($conn));
}
echo "Tabela ligas criada<br>";




$sql = "CREATE TABLE IF NOT EXISTS ligas_membros (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  liga_id INT UNSIGNED NOT NULL,
  usuario_id INT UNSIGNED NOT NULL,
  data_entrada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  UNIQUE KEY uk_liga_usuario (liga_id, usuario_id),

  INDEX idx_ligas_membros_liga (liga_id),
  INDEX idx_ligas_membros_usuario (usuario_id),

  CONSTRAINT fk_ligas_membros_liga
    FOREIGN KEY (liga_id) REFERENCES ligas(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ligas_membros_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar tabela ligas_membros: " . mysqli_error($conn));
}
echo "Tabela ligas_membros criada<br>";




mysqli_close($conn);

echo "conexão e criação completa";
?>