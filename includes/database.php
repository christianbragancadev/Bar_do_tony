<?php
function getDB() {
    $host = "localhost";
    $db   = "bar_canaa";
    $user = "root";
    $pass = "Asd@123";

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8mb4",
            $user,
            $pass
        );

        // ERRO como exceção (fundamental pra sua API)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retorno padrão como array associativo
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;

    } catch (PDOException $e) {

        // ⚠️ IMPORTANTE: resposta em JSON (igual sua API)
        header('Content-Type: application/json');

        die(json_encode([
            "ok" => false,
            "erro" => "Erro na conexão com banco",
            "detalhe" => $e->getMessage() // pode remover em produção
        ]));
    }
}

// ===== FUNÇÕES AUXILIARES =====

function mensagem($texto, $tipo = "info") {
    echo "<div class='alert alert-$tipo' role='alert'>
            $texto
          </div>";
}

function mostra_data($data) {
    if (!$data) return '';

    $d = explode('-', $data);

    if (count($d) !== 3) return $data;

    return $d[2] . "/" . $d[1] . "/" . $d[0];
}
?>