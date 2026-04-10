<?php
require_once __DIR__ . '/../includes/database.php';

if (!is_dir(__DIR__ . '/../data')) mkdir(__DIR__ . '/../data', 0777, true);

header('Content-Type: application/json');
$db = getDB();

$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {

        // ===== CLIENTES =====
        case 'listar_clientes':
            $busca = $_GET['q'] ?? '';
            if ($busca) {
                $stmt = $db->prepare("SELECT * FROM clientes WHERE nome LIKE ? ORDER BY nome");
                $stmt->execute(["%$busca%"]);
            } else {
                $stmt = $db->query("SELECT * FROM clientes ORDER BY nome");
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
                $stmt = $db->prepare("UPDATE clientes SET nome=?, telefone=?, observacoes=? WHERE id=?");
                $stmt->execute([$nome, $telefone, $obs, $id]);
            } else {
                $stmt = $db->prepare("INSERT INTO clientes (nome, telefone, observacoes) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $telefone, $obs]);
                $id = $db->lastInsertId();
            }
            echo json_encode(['ok' => true, 'id' => $id]);
            break;

        case 'excluir_cliente':
            $id = $_POST['id'];
            $fiado = $db->prepare("SELECT COUNT(*) as c FROM fiados WHERE cliente_id=? AND status='pendente'");
            $fiado->execute([$id]);
            if ($fiado->fetch()['c'] > 0) throw new Exception('Cliente possui fiados pendentes');
            $db->prepare("DELETE FROM clientes WHERE id=?")->execute([$id]);
            echo json_encode(['ok' => true]);
            break;

        // ===== PRODUTOS / ESTOQUE =====
        case 'listar_produtos':
            $stmt = $db->query("SELECT * FROM produtos WHERE ativo=1 ORDER BY categoria, nome");
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'salvar_produto':
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $cat = $_POST['categoria'] ?? 'bebida';
            $preco = floatval($_POST['preco'] ?? 0);
            $estoque = intval($_POST['estoque'] ?? 0);
            $est_min = intval($_POST['estoque_minimo'] ?? 5);
            $unidade = $_POST['unidade'] ?? 'unid';
            if (!$nome) throw new Exception('Nome obrigatório');
            if ($id) {
                $old = $db->prepare("SELECT estoque FROM produtos WHERE id=?");
                $old->execute([$id]);
                $oldEstoque = $old->fetch()['estoque'];
                $stmt = $db->prepare("UPDATE produtos SET nome=?, categoria=?, preco=?, estoque=?, estoque_minimo=?, unidade=? WHERE id=?");
                $stmt->execute([$nome, $cat, $preco, $estoque, $est_min, $unidade, $id]);
                if ($estoque != $oldEstoque) {
                    $diff = $estoque - $oldEstoque;
                    $tipo = $diff > 0 ? 'entrada' : 'saida';
                    $mov = $db->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacoes) VALUES (?, ?, ?, ?)");
                    $mov->execute([$id, $tipo, abs($diff), 'Ajuste manual']);
                }
            } else {
                $stmt = $db->prepare("INSERT INTO produtos (nome, categoria, preco, estoque, estoque_minimo, unidade) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nome, $cat, $preco, $estoque, $est_min, $unidade]);
                $id = $db->lastInsertId();
                if ($estoque > 0) {
                    $mov = $db->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacoes) VALUES (?, 'entrada', ?, 'Estoque inicial')");
                    $mov->execute([$id, $estoque]);
                }
            }
            echo json_encode(['ok' => true, 'id' => $id]);
            break;

        case 'inativar_produto':
            $id = $_POST['id'];
            $db->prepare("UPDATE produtos SET ativo=0 WHERE id=?")->execute([$id]);
            echo json_encode(['ok' => true]);
            break;

        case 'estoque_alerta':
            $stmt = $db->query("SELECT * FROM produtos WHERE ativo=1 AND estoque <= estoque_minimo ORDER BY estoque ASC");
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'movimentar_estoque':
            $pid = $_POST['produto_id'];
            $tipo = $_POST['tipo'];
            $qtd = intval($_POST['quantidade']);
            $obs = $_POST['observacoes'] ?? '';
            if ($qtd <= 0) throw new Exception('Quantidade inválida');
            $prod = $db->prepare("SELECT estoque FROM produtos WHERE id=?");
            $prod->execute([$pid]);
            $atual = $prod->fetch()['estoque'];
            if ($tipo === 'saida' && $atual < $qtd) throw new Exception('Estoque insuficiente');
            $novoEstoque = $tipo === 'entrada' ? $atual + $qtd : $atual - $qtd;
            $db->prepare("UPDATE produtos SET estoque=? WHERE id=?")->execute([$novoEstoque, $pid]);
            $mov = $db->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacoes) VALUES (?, ?, ?, ?)");
            $mov->execute([$pid, $tipo, $qtd, $obs]);
            echo json_encode(['ok' => true, 'estoque' => $novoEstoque]);
            break;

        case 'historico_estoque':
            $pid = $_GET['produto_id'] ?? null;
            if ($pid) {
                $stmt = $db->prepare("SELECT m.*, p.nome as produto_nome FROM movimentacoes_estoque m JOIN produtos p ON p.id=m.produto_id WHERE m.produto_id=? ORDER BY m.criado_em DESC LIMIT 50");
                $stmt->execute([$pid]);
            } else {
                $stmt = $db->query("SELECT m.*, p.nome as produto_nome FROM movimentacoes_estoque m JOIN produtos p ON p.id=m.produto_id ORDER BY m.criado_em DESC LIMIT 50");
            }
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        // ===== COMANDAS =====
        case 'listar_comandas':
            $status = $_GET['status'] ?? 'aberta';
            $stmt = $db->prepare("SELECT c.*, (SELECT COUNT(*) FROM comanda_itens WHERE comanda_id=c.id) as num_itens FROM comandas c WHERE c.status=? ORDER BY c.criado_em DESC");
            $stmt->execute([$status]);
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'abrir_comanda':
            $cid = $_POST['cliente_id'] ?? null;
            $nome = trim($_POST['cliente_nome'] ?? 'Cliente Avulso');
            $tipo = $_POST['tipo'] ?? 'local';
            if ($cid) {
                $cl = $db->prepare("SELECT nome FROM clientes WHERE id=?");
                $cl->execute([$cid]);
                $nome = $cl->fetch()['nome'];
            }
            $stmt = $db->prepare("INSERT INTO comandas (cliente_id, cliente_nome, tipo) VALUES (?, ?, ?)");
            $stmt->execute([$cid, $nome, $tipo]);
            echo json_encode(['ok' => true, 'id' => $db->lastInsertId()]);
            break;

        case 'ver_comanda':
            $id = $_GET['id'];
            $comanda = $db->prepare("SELECT * FROM comandas WHERE id=?");
            $comanda->execute([$id]);
            $c = $comanda->fetch();
            $itens = $db->prepare("SELECT * FROM comanda_itens WHERE comanda_id=? ORDER BY criado_em");
            $itens->execute([$id]);
            $c['itens'] = $itens->fetchAll();
            echo json_encode(['ok' => true, 'data' => $c]);
            break;

        case 'adicionar_item':
            $cid = $_POST['comanda_id'];
            $pid = $_POST['produto_id'];
            $qtd = intval($_POST['quantidade'] ?? 1);
            $comanda = $db->prepare("SELECT status FROM comandas WHERE id=?");
            $comanda->execute([$cid]);
            if ($comanda->fetch()['status'] !== 'aberta') throw new Exception('Comanda já está fechada');
            $prod = $db->prepare("SELECT * FROM produtos WHERE id=?");
            $prod->execute([$pid]);
            $p = $prod->fetch();
            if (!$p) throw new Exception('Produto não encontrado');
            if ($p['estoque'] > 0 && $p['categoria'] !== 'petisco') {
                if ($p['estoque'] < $qtd) throw new Exception('Estoque insuficiente: ' . $p['estoque'] . ' disponível(is)');
                $db->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id=?")->execute([$qtd, $pid]);
                $mov = $db->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacoes) VALUES (?, 'saida', ?, ?)");
                $mov->execute([$pid, $qtd, "Comanda #$cid"]);
            }
            $subtotal = $p['preco'] * $qtd;
            $stmt = $db->prepare("INSERT INTO comanda_itens (comanda_id, produto_id, produto_nome, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$cid, $pid, $p['nome'], $qtd, $p['preco'], $subtotal]);
            $db->prepare("UPDATE comandas SET total = (SELECT COALESCE(SUM(subtotal),0) FROM comanda_itens WHERE comanda_id=?) WHERE id=?")->execute([$cid, $cid]);
            echo json_encode(['ok' => true]);
            break;

        case 'remover_item':
            $itemId = $_POST['item_id'];
            $item = $db->prepare("SELECT * FROM comanda_itens WHERE id=?");
            $item->execute([$itemId]);
            $it = $item->fetch();
            if (!$it) throw new Exception('Item não encontrado');
            $prod = $db->prepare("SELECT categoria FROM produtos WHERE id=?");
            $prod->execute([$it['produto_id']]);
            $p = $prod->fetch();
            if ($p && $p['categoria'] !== 'petisco') {
                $db->prepare("UPDATE produtos SET estoque = estoque + ? WHERE id=?")->execute([$it['quantidade'], $it['produto_id']]);
                $mov = $db->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacoes) VALUES (?, 'entrada', ?, ?)");
                $mov->execute([$it['produto_id'], $it['quantidade'], "Remoção comanda #" . $it['comanda_id']]);
            }
            $db->prepare("DELETE FROM comanda_itens WHERE id=?")->execute([$itemId]);
            $db->prepare("UPDATE comandas SET total = (SELECT COALESCE(SUM(subtotal),0) FROM comanda_itens WHERE comanda_id=?) WHERE id=?")->execute([$it['comanda_id'], $it['comanda_id']]);
            echo json_encode(['ok' => true]);
            break;

        case 'fechar_comanda':
            $id = $_POST['comanda_id'];
            $forma = $_POST['forma_pagamento'] ?? 'dinheiro';
            $comanda = $db->prepare("SELECT * FROM comandas WHERE id=?");
            $comanda->execute([$id]);
            $c = $comanda->fetch();
            if ($c['status'] !== 'aberta') throw new Exception('Comanda já fechada');
            if ($forma === 'fiado') {
                if (!$c['cliente_id']) throw new Exception('Fiado requer cliente cadastrado');
                $db->prepare("UPDATE comandas SET status='fiado', fechado_em=CURRENT_TIMESTAMP WHERE id=?")->execute([$id]);
                $fiado = $db->prepare("INSERT INTO fiados (cliente_id, comanda_id, valor) VALUES (?, ?, ?)");
                $fiado->execute([$c['cliente_id'], $id, $c['total']]);
            } else {
                $db->prepare("UPDATE comandas SET status='paga', fechado_em=CURRENT_TIMESTAMP WHERE id=?")->execute([$id]);
            }
            echo json_encode(['ok' => true]);
            break;

        case 'cancelar_comanda':
            $id = $_POST['comanda_id'];
            $itens = $db->prepare("SELECT * FROM comanda_itens WHERE comanda_id=?");
            $itens->execute([$id]);
            foreach ($itens->fetchAll() as $it) {
                $prod = $db->prepare("SELECT categoria FROM produtos WHERE id=?");
                $prod->execute([$it['produto_id']]);
                $p = $prod->fetch();
                if ($p && $p['categoria'] !== 'petisco') {
                    $db->prepare("UPDATE produtos SET estoque = estoque + ? WHERE id=?")->execute([$it['quantidade'], $it['produto_id']]);
                }
            }
            $db->prepare("UPDATE comandas SET status='cancelada', fechado_em=CURRENT_TIMESTAMP WHERE id=?")->execute([$id]);
            echo json_encode(['ok' => true]);
            break;

        // ===== FIADOS =====
        case 'listar_fiados':
            $stmt = $db->query("SELECT f.*, cl.nome as cliente_nome, cl.telefone FROM fiados f JOIN clientes cl ON cl.id=f.cliente_id WHERE f.status='pendente' ORDER BY f.criado_em DESC");
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'fiados_por_cliente':
            $cid = $_GET['cliente_id'];
            $stmt = $db->prepare("SELECT f.*, c.cliente_nome FROM fiados f LEFT JOIN comandas c ON c.id=f.comanda_id WHERE f.cliente_id=? ORDER BY f.status, f.criado_em DESC");
            $stmt->execute([$cid]);
            echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
            break;

        case 'pagar_fiado':
            $id = $_POST['id'];
            $db->prepare("UPDATE fiados SET status='pago', pago_em=CURRENT_TIMESTAMP WHERE id=?")->execute([$id]);
            echo json_encode(['ok' => true]);
            break;

        case 'pagar_todos_fiados':
            $cid = $_POST['cliente_id'];
            $db->prepare("UPDATE fiados SET status='pago', pago_em=CURRENT_TIMESTAMP WHERE cliente_id=? AND status='pendente'")->execute([$cid]);
            echo json_encode(['ok' => true]);
            break;

        // ===== DASHBOARD =====
        case 'dashboard':
            $hoje = date('Y-m-d');
            $comandasHoje = $db->query("SELECT COUNT(*) as c FROM comandas WHERE DATE(criado_em)='$hoje'")->fetch()['c'];
            $receitaHoje = $db->query("SELECT COALESCE(SUM(total),0) as s FROM comandas WHERE DATE(criado_em)='$hoje' AND status='paga'")->fetch()['s'];
            $comandasAbertas = $db->query("SELECT COUNT(*) as c FROM comandas WHERE status='aberta'")->fetch()['c'];
            $totalFiado = $db->query("SELECT COALESCE(SUM(valor),0) as s FROM fiados WHERE status='pendente'")->fetch()['s'];
            $numFiados = $db->query("SELECT COUNT(DISTINCT cliente_id) as c FROM fiados WHERE status='pendente'")->fetch()['c'];
            $alertaEstoque = $db->query("SELECT COUNT(*) as c FROM produtos WHERE ativo=1 AND estoque <= estoque_minimo AND estoque > 0")->fetch()['c'];
            $semEstoque = $db->query("SELECT COUNT(*) as c FROM produtos WHERE ativo=1 AND estoque = 0 AND categoria != 'petisco'")->fetch()['c'];
            $topProdutos = $db->query("SELECT produto_nome, SUM(quantidade) as total FROM comanda_itens WHERE DATE(criado_em)>= DATE('now', '-7 days') GROUP BY produto_nome ORDER BY total DESC LIMIT 5")->fetchAll();
            $receitaSemana = $db->query("SELECT DATE(criado_em) as dia, COALESCE(SUM(total),0) as receita FROM comandas WHERE status='paga' AND DATE(criado_em) >= DATE('now', '-6 days') GROUP BY DATE(criado_em) ORDER BY dia")->fetchAll();
            echo json_encode(['ok' => true, 'data' => compact('comandasHoje','receitaHoje','comandasAbertas','totalFiado','numFiados','alertaEstoque','semEstoque','topProdutos','receitaSemana')]);
            break;

        default:
            throw new Exception("Ação desconhecida: $action");
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'erro' => $e->getMessage()]);
}
?>
