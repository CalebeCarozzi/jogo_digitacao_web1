<?php
require_once 'force_authenticate.php';
require_once 'functions_db.php';

$usuario_id = (int) $_SESSION['user_id'];

if (isset($_SESSION['user_name'])) {
    $nome_usuario = $_SESSION['user_name'];
} else {
    $nome_usuario = "Jogador";
}

$conn = connect_db();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

$sql = "SELECT id, wpm, pontuacao, data_partida
        FROM partidas
        WHERE usuario_id = $usuario_id
        ORDER BY data_partida DESC";

$result_partidas = mysqli_query($conn, $sql);
if (!$result_partidas) {
    die("Erro ao buscar partidas: " . mysqli_error($conn));
}

$sql = "SELECT 
        COALESCE(SUM(pontuacao), 0) AS total_pontos,
        COALESCE(MAX(wpm), 0) AS recorde_wpm,
        COUNT(*) AS total_partidas
        FROM partidas
        WHERE usuario_id = $usuario_id";

$result_totais = mysqli_query($conn, $sql);
if (!$result_totais) {
    die("Erro ao buscar totais: " . mysqli_error($conn));
}

$totais = mysqli_fetch_assoc($result_totais);

$total_pontos   = (int) $totais['total_pontos'];
$recorde_wpm    = (int) $totais['recorde_wpm'];
$total_partidas = (int) $totais['total_partidas'];

$sql = "SELECT COALESCE(SUM(pontuacao), 0) AS total_semana
        FROM partidas
        WHERE usuario_id = $usuario_id
        AND data_partida >= (NOW() - INTERVAL 7 DAY)";

$result_semana = mysqli_query($conn, $sql);
if (!$result_semana) {
    die("Erro ao buscar pontuação semanal: " . mysqli_error($conn));
}

$semana = mysqli_fetch_assoc($result_semana);
$total_semana = (int) $semana['total_semana'];

close_db($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Partidas - Jogo Digitação</title>
    <link rel="stylesheet" href="css/stylehistory.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="card-history">

            <h1>Histórico de Partidas</h1>

            <p class="info-usuario">
                Usuário:
                <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>
            </p>

            <?php if ($total_partidas === 0): ?>

                <p class="resumo-partidas">Você ainda não jogou nenhuma partida.</p>
                <div class="botoes-rodape">
                    <button type="button" class="btn" onclick="window.location.href='game.php'">
                        Jogar uma partida
                    </button>
                </div>

            <?php else: ?>

                <div class="tabela-wrapper">
                    <table class="tabela-partidas">
                        <thead>
                            <tr>
                                <th>Partida</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Pontos por minuto</th>
                                <th>Pontuação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 1;

                            while ($partida = mysqli_fetch_assoc($result_partidas)):
                                $timestamp = strtotime($partida['data_partida']);
                                $data_formatada = date('j/n/Y', $timestamp);
                                $hora_formatada = date('H', $timestamp) . "h";
                            ?>
                                <tr>
                                    <td><?php echo $contador; ?></td>
                                    <td><?php echo $data_formatada; ?></td>
                                    <td><?php echo $hora_formatada; ?></td>
                                    <td><?php echo (int) $partida['wpm']; ?></td>
                                    <td><?php echo (int) $partida['pontuacao']; ?></td>
                                </tr>
                            <?php
                                $contador++;
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="resumo-card">
                    <p>
                        <strong>Total de partidas jogadas:</strong>
                        <?php echo $total_partidas; ?><br>
                        <strong>Soma total de pontos:</strong>
                        <?php echo $total_pontos; ?><br>
                        <strong>Soma de pontos na última semana:</strong>
                        <?php echo $total_semana; ?><br>
                        <strong>Recorde de palavras por minuto (WPM):</strong>
                        <?php echo $recorde_wpm; ?>
                    </p>
                </div>

            <?php endif; ?>

            <div class="botoes-rodape">
                <button type="button" class="btn" onclick="window.location.href='index.php'">
                    Voltar ao menu
                </button>
            </div>

        </div>
    </div>
</body>
</html>
