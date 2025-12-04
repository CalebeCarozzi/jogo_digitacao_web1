<?php 

echo "<h1> tela de ligas </h1>";

require_once 'functions_db.php';
$conn = connect_db();
$sql = 'ALTER TABLE partidas ADD COLUMN wpm INT NOT NULL AFTER usuario_id';
if (!mysqli_query($conn, $sql)) {
    die("Erro ao criar tabela partidas: " . mysqli_error($conn));
}
echo "Tabela de partida alterada <br>";

?>