<?php
require_once 'credentials_db.php';
require_once 'functions_db.php';

// Conecta ao banco
$conn = connect_db();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

// Desabilitar restrições de chave estrangeira
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

// Limpar todas as tabelas
mysqli_query($conn, "TRUNCATE TABLE partidas");
mysqli_query($conn, "TRUNCATE TABLE ligas_membros");
mysqli_query($conn, "TRUNCATE TABLE ligas");
mysqli_query($conn, "TRUNCATE TABLE usuarios");

// Reativar FK
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

echo "<p>✔ Todas as tabelas foram limpas com sucesso.</p>";

// ================================================
// INSERIR USUÁRIOS DE TESTE
// Senha = 8 vezes a primeira letra do nome
// ================================================

$usuarios = [
    ['João',      'joao@email.com',     'jjjjjjjj'],
    ['Maria',     'maria@email.com',    'mmmmmmmm'],
    ['Pedro',     'pedro@email.com',    'pppppppp'],
    ['Ana',       'ana@email.com',      'aaaaaaaa'],
    ['Lucas',     'lucas@email.com',    'llllllll'],
    ['Julia',     'julia@email.com',    'jjjjjjjj'],
    ['Diego',     'diego@email.com',    'dddddddd'],
    ['Carla',     'carla@email.com',    'cccccccc'],
    ['Fernanda',  'fernanda@email.com', 'ffffffff'],
    ['Bruno',     'bruno@email.com',    'bbbbbbbb'],
];

echo "<p>Inserindo usuários de teste...</p>";

foreach ($usuarios as $u) {

    $nome  = mysqli_real_escape_string($conn, $u[0]);
    $email = mysqli_real_escape_string($conn, $u[1]);

    // Gerar hash da senha
    $senha_hash = password_hash($u[2], PASSWORD_DEFAULT);

    $sql = "
        INSERT INTO usuarios (nome, email, senha_hash)
        VALUES ('$nome', '$email', '$senha_hash')
    ";

    if (!mysqli_query($conn, $sql)) {
        echo "<p style='color:red;'>Erro ao inserir $nome: " . mysqli_error($conn) . "</p>";
    } else {
        echo "<p>✔ Usuário $nome inserido.</p>";
    }
}

echo "<hr>";
echo "<h3 style='color:green;'>Banco resetado com sucesso! 10 usuários adicionados.</h3>";
echo "<p>Agora você pode testar o sistema normalmente.</p>";
echo "<p><strong>Lembrete:</strong> As senhas são 8 vezes a primeira letra do nome.</p>";

echo "<a href='login.php'>Ir para o login</a>";

close_db($conn);
?>
