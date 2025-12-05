<?php
require_once 'force_authenticate.php';
require_once 'functions_db.php';

$usuario_id = (int) $_SESSION['user_id'];

if (isset($_SESSION['user_name'])) {
    $nome_usuario = $_SESSION['user_name'];
} else {
    $nome_usuario = "Jogador";
}

$ordenacao = "total";

if (isset($_GET['order'])) {
    $valor_order = $_GET['order'];

    if ($valor_order === "recorde") {
        $ordenacao = "recorde";
    } elseif ($valor_order === "semana") {
        $ordenacao = "semana";
    } elseif ($valor_order === "total") {
        $ordenacao = "total";
    }
}

$ordenacao_sql = "total_pontos DESC";

if ($ordenacao === "recorde") {
    $ordenacao_sql = "recorde_wpm DESC, total_pontos DESC";
} elseif ($ordenacao === "semana") {
    $ordenacao_sql = "pontos_semana DESC, total_pontos DESC";
} elseif ($ordenacao === "total") {
    $ordenacao_sql = "total_pontos DESC, recorde_wpm DESC";
}

$classe_order_recorde = "";
$classe_order_semana  = "";
$classe_order_total   = "";

if ($ordenacao === "recorde") {
    $classe_order_recorde = " ordenacao-ativa";
} elseif ($ordenacao === "semana") {
    $classe_order_semana = " ordenacao-ativa";
} elseif ($ordenacao === "total") {
    $classe_order_total = " ordenacao-ativa";
}

$conn = connect_db();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

$sql = "SELECT 
        u.id AS usuario_id,
        u.nome,
        COALESCE(MAX(p.wpm), 0) AS recorde_wpm,
        COALESCE(SUM(p.pontuacao), 0) AS total_pontos,
        COALESCE(SUM(
            CASE
                WHEN p.data_partida >= (NOW() - INTERVAL 2 HOUR) THEN p.pontuacao
                ELSE 0
            END
        ), 0) AS pontos_semana
        FROM usuarios u
        LEFT JOIN partidas p ON p.usuario_id = u.id
        GROUP BY u.id, u.nome
        ORDER BY $ordenacao_sql";

$result_ranking = mysqli_query($conn, $sql);

if (!$result_ranking) {
    die("Erro ao buscar ranking de usuários: " . mysqli_error($conn));
}

close_db($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Jogadores - Jogo Digitação</title>
    <link rel="stylesheet" href="css/styleranking.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="card-ranking">

            <h1>Ranking de Jogadores</h1>

            <p class="info-usuario">
                Usuário logado:
                <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>
            </p>

            <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="filtros-ordenacao">
                    <span>Ordenar por:</span>

                    <button type="submit" name="order" value="recorde"
                            class="btn-filtro<?php echo $ordenacao === 'recorde' ? ' ativo' : ''; ?>">
                        Recorde de palavras por minuto
                    </button>

                    <button type="submit" name="order" value="semana"
                            class="btn-filtro<?php echo $ordenacao === 'semana' ? ' ativo' : ''; ?>">
                        Pontos na última semana
                    </button>

                    <button type="submit" name="order" value="total"
                            class="btn-filtro<?php echo $ordenacao === 'total' ? ' ativo' : ''; ?>">
                        Pontos totais
                    </button>
                </div>
            </form>

            <?php if (mysqli_num_rows($result_ranking) === 0): ?>

                <p class="sem-dados">Nenhum usuário encontrado no sistema.</p>

            <?php else: ?>

                <div class="tabela-wrapper">
                    <table class="tabela-ranking">
                        <thead>
                            <tr>
                                <th>Posição</th>
                                <th>Jogadores</th>
                                <th class="col-recorde<?php echo $classe_order_recorde; ?>">
                                    Recorde (palavras por minuto)
                                </th>
                                <th class="col-semana<?php echo $classe_order_semana; ?>">
                                    Pontos na última semana
                                </th>
                                <th class="col-total<?php echo $classe_order_total; ?>">
                                    Pontos totais
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $posicao = 1;

                            while ($linha = mysqli_fetch_assoc($result_ranking)):

                                $id_usuario_linha   = (int) $linha['usuario_id'];
                                $nome_usuario_linha = $linha['nome'];
                                $recorde_wpm        = (int) $linha['recorde_wpm'];
                                $pontos_semana      = (int) $linha['pontos_semana'];
                                $total_pontos       = (int) $linha['total_pontos'];

                                $classes_linha = "linha-ranking";

                                if ($posicao === 1) {
                                    $classes_linha .= " pos-1";
                                } elseif ($posicao === 2) {
                                    $classes_linha .= " pos-2";
                                } elseif ($posicao === 3) {
                                    $classes_linha .= " pos-3";
                                }

                                if ($id_usuario_linha === $usuario_id) {
                                    $classes_linha .= " usuario-logado";
                                }
                            ?>
                                <tr class="<?php echo $classes_linha; ?>">
                                    <td><?php echo $posicao; ?>º</td>
                                    <td><?php echo htmlspecialchars($nome_usuario_linha); ?></td>
                                    <td class="col-recorde<?php echo $classe_order_recorde; ?>">
                                        <?php echo $recorde_wpm; ?>
                                    </td>
                                    <td class="col-semana<?php echo $classe_order_semana; ?>">
                                        <?php echo $pontos_semana; ?>
                                    </td>
                                    <td class="col-total<?php echo $classe_order_total; ?>">
                                        <?php echo $total_pontos; ?>
                                    </td>
                                </tr>
                            <?php
                                $posicao++;
                            endwhile;
                            ?>
                        </tbody>
                    </table>
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
