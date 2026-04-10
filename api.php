<?php
header('Content-Type: application/json');

require_once 'includes/database.php';

// Garante pasta data (se precisar futuramente)
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

$pdo = getDB(); // 🔥 PADRONIZADO

$action = $_REQUEST['action'] ?? '';

try {

    switch ($action) {

        // ===== CLIENTES =====
        case 'listar_clientes':
            $busca = $_GET['q'] ?? '';
            if ($busca) {
                $stmt = $pdo->prepare("SELECT * FROM clientes WHERE nome LIKE ? ORDER BY nome");
                $stmt->execute(["%$busca%"]);
            } else {
                $stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome");
            }
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'salvar_cliente':
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $obs = trim($_POST['observacoes'] ?? '');

            if (!$nome) throw new Exception('Nome obrigatório');

            if ($id) {
                $stmt = $pdo->prepare("UPDATE clientes SET nome=?, telefone=?, observacoes=? WHERE id=?");
                $stmt->execute([$nome, $telefone, $obs, $id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO clientes (nome, telefone, observacoes) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $telefone, $obs]);
                $id = $pdo->lastInsertId();
            }

            echo json_encode(['ok' => true, 'id' => $id]);
            break;

        case 'excluir_cliente':
            $id = $_POST['id'] ?? null;

            if (!$id) throw new Exception('ID inválido');

            $fiado = $pdo->prepare("SELECT COUNT(*) as c FROM fiados WHERE cliente_id=? AND status='pendente'");
            $fiado->execute([$id]);

            if ($fiado->fetch()['c'] > 0) {
                throw new Exception('Cliente possui fiados pendentes');
            }

            $pdo->prepare("DELETE FROM clientes WHERE id=?")->execute([$id]);

            echo json_encode(['ok' => true]);
            break;

        // ===== COMANDAS =====
        case 'abrir_comanda':
            $cid = $_POST['cliente_id'] ?? null;
            $tipo = $_POST['tipo'] ?? 'local';

            $nome = 'Cliente Avulso';

            if ($cid) {
                $cl = $pdo->prepare("SELECT nome FROM clientes WHERE id=?");
                $cl->execute([$cid]);
                $res = $cl->fetch();

                if (!$res) throw new Exception('Cliente não encontrado');

                $nome = $res['nome'];
            }

            $stmt = $pdo->prepare("INSERT INTO comandas (cliente_id, cliente_nome, tipo) VALUES (?, ?, ?)");
            $stmt->execute([$cid ?: null, $nome, $tipo]);

            echo json_encode([
                'ok' => true,
                'id' => $pdo->lastInsertId()
            ]);
            break;

        case 'listar_comandas':
            $status = $_GET['status'] ?? 'aberta';

            $stmt = $pdo->prepare("
                SELECT c.*, 
                (SELECT COUNT(*) FROM comanda_itens WHERE comanda_id=c.id) as num_itens
                FROM comandas c
                WHERE c.status=?
                ORDER BY c.criado_em DESC
            ");

            $stmt->execute([$status]);

            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        // ===== TESTE (IMPORTANTE PRA DEBUG) =====
        case 'teste':
            echo json_encode([
                'ok' => true,
                'msg' => 'API funcionando'
            ]);
            break;

        default:
            throw new Exception("Ação desconhecida: $action");
    }

} catch (Exception $e) {

    echo json_encode([
        'ok' => false,
        'erro' => $e->getMessage()
    ]);
}