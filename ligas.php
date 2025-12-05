<?php
require_once 'force_authenticate.php';
require_once 'functions_db.php';
require_once 'lib/sanitize.php';

$usuario_id = (int) $_SESSION['user_id'];

if (isset($_SESSION['user_name'])) {
    $nome_usuario_logado = $_SESSION['user_name'];
} else {
    $nome_usuario_logado = "Jogador";
}

$erros_criacao = [];
$mensagem_sucesso = "";

$nome_liga_form = "";
$chave_entrada_form = "";

if (isset($_SESSION['mensagem_liga_sucesso'])) {
    $mensagem_sucesso = $_SESSION['mensagem_liga_sucesso'];
    unset($_SESSION['mensagem_liga_sucesso']);
}

$ordenacao = "total";

if (isset($_GET['order'])) {
    $valor_order = $_GET['order'];

    if ($valor_order === "semana") {
        $ordenacao = "semana";
    } elseif ($valor_order === "total") {
        $ordenacao = "total";
    }
}

$classe_order_semana = "";
$classe_order_total  = "";

if ($ordenacao === "semana") {
    $classe_order_semana = " ordenacao-ativa";
} elseif ($ordenacao === "total") {
    $classe_order_total = " ordenacao-ativa";
}

$conn = connect_db();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nome_liga'])) {
        $nome_liga_form = sanitize($_POST['nome_liga']);
    }

    if (isset($_POST['chave_entrada'])) {
        $chave_entrada_form = sanitize($_POST['chave_entrada']);
    }

    if (empty($nome_liga_form)) {
        $erros_criacao[] = "O nome da liga é obrigatório.";
    }

    if (empty($chave_entrada_form)) {
        $erros_criacao[] = "A palavra-chave é obrigatória.";
    }

    if (empty($erros_criacao)) {

        $nome_liga_db = mysqli_real_escape_string($conn, $nome_liga_form);

        $sql = "SELECT id
                FROM ligas
                WHERE nome = '$nome_liga_db'
                LIMIT 1";

        $res_verifica = mysqli_query($conn, $sql);

        if (!$res_verifica) {
            $erros_criacao[] = "Erro ao verificar nome da liga: " . mysqli_error($conn);
        } else {
            if (mysqli_num_rows($res_verifica) > 0) {
                $erros_criacao[] = "Já existe uma liga com esse nome. Escolha outro.";
            }
        }

        if (empty($erros_criacao)) {

            $chave_db = mysqli_real_escape_string($conn, $chave_entrada_form);
            $dono_id  = $usuario_id;

            $sql = "INSERT INTO ligas (nome, chave_entrada, dono_id)
                    VALUES ('$nome_liga_db', '$chave_db', $dono_id)";

            if (!mysqli_query($conn, $sql)) {
                $erros_criacao[] = "Erro ao criar liga: " . mysqli_error($conn);
            } else {
                $nova_liga_id = mysqli_insert_id($conn);

                $sql = "INSERT INTO ligas_membros (liga_id, usuario_id)
                        VALUES ($nova_liga_id, $dono_id)";

                if (!mysqli_query($conn, $sql)) {
                    $erros_criacao[] = "Liga criada, mas houve erro ao adicionar você como membro: " . mysqli_error($conn);
                } else {
                    $_SESSION['mensagem_liga_sucesso'] = "Liga criada com sucesso!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
            }
        }
    }
}

$sql =
    "    SELECT 
        l.id,
        l.nome,
        l.data_criacao,
        lm.usuario_id AS membro_atual
    FROM ligas l
    LEFT JOIN ligas_membros lm
        ON lm.liga_id = l.id
        AND lm.usuario_id = $usuario_id
    ORDER BY l.nome ASC
";

$result_ligas = mysqli_query($conn, $sql);

if (!$result_ligas) {
    die("Erro ao buscar ligas: " . mysqli_error($conn));
}

$ligas = array();

while ($linha = mysqli_fetch_assoc($result_ligas)) {

    $liga_id = (int) $linha['id'];
    $nome_liga = $linha['nome'];
    $data_criacao = $linha['data_criacao'];
    $membro_atual = $linha['membro_atual'];

    $eh_membro = ($membro_atual !== null);

    $data_criacao_db = mysqli_real_escape_string($conn, $data_criacao);

    $sql = "SELECT SUM(p.pontuacao) AS total_pontos
            FROM ligas_membros lm
            JOIN partidas p ON p.usuario_id = lm.usuario_id
            WHERE lm.liga_id = $liga_id
            AND p.data_partida >= '$data_criacao_db'";

    $res_totais = mysqli_query($conn, $sql);

    $pontos_totais = 0;
    if ($res_totais) {
        $row_totais = mysqli_fetch_assoc($res_totais);
        if ($row_totais['total_pontos'] !== null) {
            $pontos_totais = (int) $row_totais['total_pontos'];
        }
    }

    $sql = "SELECT SUM(p.pontuacao) AS pontos_semana
            FROM ligas_membros lm
            JOIN partidas p ON p.usuario_id = lm.usuario_id
            WHERE lm.liga_id = $liga_id
            AND p.data_partida >= '$data_criacao_db'
            AND p.data_partida >= (NOW() - INTERVAL 1 hour)";

    $res_semana = mysqli_query($conn, $sql);

    $pontos_semana = 0;
    if ($res_semana) {
        $row_semana = mysqli_fetch_assoc($res_semana);
        if ($row_semana['pontos_semana'] !== null) {
            $pontos_semana = (int) $row_semana['pontos_semana'];
        }
    }

    $ligas[] = array(
        'id' => $liga_id,
        'nome' => $nome_liga,
        'data_criacao' => $data_criacao,
        'eh_membro' => $eh_membro,
        'pontos_totais' => $pontos_totais,
        'pontos_semana' => $pontos_semana
    );
}

close_db($conn);

if ($ordenacao === "semana") {
    usort($ligas, function ($a, $b) {
        if ($a['pontos_semana'] === $b['pontos_semana']) {
            return 0;
        }
        return ($a['pontos_semana'] > $b['pontos_semana']) ? -1 : 1;
    });
} else {
    usort($ligas, function ($a, $b) {
        if ($a['pontos_totais'] === $b['pontos_totais']) {
            return 0;
        }
        return ($a['pontos_totais'] > $b['pontos_totais']) ? -1 : 1;
    });
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ligas - Jogo Digitação</title>
    <link rel="stylesheet" href="css/styleligas.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="card-ligas">

            <h1>Ligas</h1>

            <p class="info-usuario">
                Jogador logado:
                <strong><?php echo htmlspecialchars($nome_usuario_logado); ?></strong>
            </p>

            <?php if (!empty($mensagem_sucesso)): ?>
                <p class="msg-sucesso" id="mansagem-sucesso">
                    <?php echo htmlspecialchars($mensagem_sucesso); ?>
                </p>
            <?php endif; ?>

            <div class="conteudo-ligas">
                <div class="coluna-ligas-lista">

                    <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="filtros-ordenacao">
                            <span>Ordenar por:</span>

                        <button type="submit" name="order" value="semana"
                            class="btn-filtro<?php echo $ordenacao === 'semana' ? ' ativo' : ''; ?>">
                            Pontos na última semana
                        </button>

                        <button type="submit" name="order" value="total"
                                class="btn-filtro<?php echo $ordenacao === 'total' ? ' ativo' : ''; ?>">
                            Pontos totais da liga
                        </button>
                    </div>
                    </form>

                    <?php if (count($ligas) === 0): ?>

                        <p class="sem-dados" id="sem-liga-cadastrada">Nenhuma liga cadastrada ainda.</p>

                    <?php else: ?>

                        <div class="tabela-wrapper">
                            <table class="tabela-ligas">
                                <thead>
                                    <tr>
                                        <th>Posição</th>
                                        <th>Nome da liga</th>
                                        <th class="col-semana<?php echo $classe_order_semana; ?>">
                                            Pontos na última semana
                                        </th>
                                        <th class="col-total<?php echo $classe_order_total; ?>">
                                            Pontos totais da liga
                                        </th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $posicao = 1;

                                    foreach ($ligas as $liga):

                                        $liga_id = $liga['id'];
                                        $nome_liga = $liga['nome'];
                                        $pontos_semana = $liga['pontos_semana'];
                                        $pontos_totais = $liga['pontos_totais'];
                                        $eh_membro = $liga['eh_membro'];

                                        $classes_linha = "linha-ranking-liga";

                                        if ($posicao === 1) {
                                            $classes_linha .= " pos-1";
                                        } elseif ($posicao === 2) {
                                            $classes_linha .= " pos-2";
                                        } elseif ($posicao === 3) {
                                            $classes_linha .= " pos-3";
                                        }

                                        if ($eh_membro) {
                                            $classes_linha .= " ligas-do-usuario";
                                        }
                                    ?>
                                        <tr class="<?php echo $classes_linha; ?>">
                                            <td><?php echo $posicao; ?>º</td>
                                            <td><?php echo htmlspecialchars($nome_liga); ?></td>
                                            <td class="col-semana<?php echo $classe_order_semana; ?>">
                                                <?php echo $pontos_semana; ?>
                                            </td>
                                            <td class="col-total<?php echo $classe_order_total; ?>">
                                                <?php echo $pontos_totais; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-ver-liga"
                                                    onclick="window.location.href='ligas_detalhe.php?liga_id=<?php echo $liga_id; ?>'">
                                                    Ver liga
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                        $posicao++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="coluna-ligas-form">
                    <h2>Criar nova liga</h2>

                    <?php if (!empty($erros_criacao)): ?>
                        <div class="erros-liga">
                            <p><strong>Erros ao criar liga:</strong></p>
                            <ul>
                                <?php foreach ($erros_criacao as $erro): ?>
                                    <li><?php echo htmlspecialchars($erro); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="campo-form">
                            <label for="nome_liga">Nome da liga:</label><br>
                            <input type="text" id="nome_liga" name="nome_liga"
                                   value="<?php echo htmlspecialchars($nome_liga_form); ?>">
                        </div>

                        <div class="campo-form">
                            <label for="chave_entrada">Palavra-chave da liga:</label><br>
                            <input type="text" id="chave_entrada" name="chave_entrada"
                                   value="<?php echo htmlspecialchars($chave_entrada_form); ?>">
                        </div>

                        <div class="botoes-form">
                            <button type="submit" class="btn">Criar liga</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="botoes-rodape">
                <button type="button" class="btn" onclick="window.location.href='index.php'">
                    Voltar ao menu
                </button>
            </div>

        </div>
    </div>
</body>
</html>
