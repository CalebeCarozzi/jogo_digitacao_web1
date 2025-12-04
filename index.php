<?php
// Essa página é o menu inicial -> precisa de login
require_once "force_authenticate.php";

// Aqui: sessão já está aberta e $login é true

$nome_usuario = "Jogador";

if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] !== "") {
    $nome_usuario = $_SESSION["user_name"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Menu Inicial - Jogo de Digitação</title>
</head>
<body>
    <h1>Jogo de Digitação</h1>

    <p>Olá, <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>!</p>
    <p>Escolha uma opção:</p>

    <ul style="list-style: none; padding-left: 0;">
        <li style="margin-bottom: 8px;">
            <a href="JS/game.php">Iniciar jogo</a>
        </li>
        <li style="margin-bottom: 8px;">
            <a href="history.php">Histórico de partidas</a>
        </li>
        <li style="margin-bottom: 8px;">
            <a href="ranking_usuarios.php">Ranking de usuários</a>
        </li>
        <li style="margin-bottom: 8px;">
            <a href="ligas.php">Ligas</a>
        </li>
        <li style="margin-bottom: 8px;">
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</body>
</html>
