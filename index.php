<?php
require_once "force_authenticate.php";

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
    <link rel="stylesheet" href="css/styleind.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="card-menu">
            <h1>Jogo de Digitação</h1>

            <p class="boas-vindas">
                Olá, <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>!
            </p>

            <ul class="menu-opcoes">
                <li><a href="game.php" class="btn-menu">Iniciar jogo</a></li>
                <li><a href="history.php" class="btn-menu">Histórico de partidas</a></li>
                <li><a href="ranking_usuarios.php" class="btn-menu">Ranking de usuários</a></li>
                <li><a href="ligas.php" class="btn-menu">Ligas</a></li>
                <li><a href="logout.php" class="btn-menu btn-sair">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
