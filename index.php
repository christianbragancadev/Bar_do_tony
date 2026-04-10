<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bar do Tony – Sistema de Gestão</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #0d0d0d;
  --bg2: #141414;
  --bg3: #1c1c1c;
  --surface: #222222;
  --surface2: #2a2a2a;
  --border: #333;
  --amber: #f5a623;
  --amber2: #e8931a;
  --amber-dim: rgba(245,166,35,0.12);
  --amber-glow: rgba(245,166,35,0.25);
  --green: #4caf76;
  --green-dim: rgba(76,175,118,0.12);
  --red: #e05252;
  --red-dim: rgba(224,82,82,0.12);
  --blue: #5b9bd5;
  --blue-dim: rgba(91,155,213,0.12);
  --text: #f0ece4;
  --text2: #a09890;
  --text3: #6a6260;
  --radius: 10px;
  --shadow: 0 4px 24px rgba(0,0,0,0.4);
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Barlow', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

/* SIDEBAR */
#sidebar {
  position: fixed; left: 0; top: 0; bottom: 0; width: 220px;
  background: var(--bg2); border-right: 1px solid var(--border);
  display: flex; flex-direction: column; z-index: 100;
}
.sidebar-logo {
  padding: 24px 20px 20px;
  border-bottom: 1px solid var(--border);
}
.sidebar-logo h1 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 28px; color: var(--amber); letter-spacing: 2px;
  line-height: 1;
}
.sidebar-logo p { font-size: 11px; color: var(--text3); margin-top: 4px; letter-spacing: 1px; text-transform: uppercase; }
.nav-section { padding: 16px 12px 8px; font-size: 10px; color: var(--text3); letter-spacing: 1.5px; text-transform: uppercase; }
.nav-btn {
  display: flex; align-items: center; gap: 10px; width: 100%;
  padding: 11px 16px; border: none; background: none;
  color: var(--text2); font-family: 'Barlow', sans-serif; font-size: 14px; font-weight: 500;
  cursor: pointer; border-radius: 8px; margin: 2px 8px; width: calc(100% - 16px);
  transition: all 0.15s; text-align: left;
}
.nav-btn:hover { background: var(--surface); color: var(--text); }
.nav-btn.active { background: var(--amber-dim); color: var(--amber); }
.nav-btn svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.8; }
.badge {
  margin-left: auto; background: var(--red); color: #fff;
  font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
}
.sidebar-footer {
  margin-top: auto; padding: 16px; border-top: 1px solid var(--border);
  font-size: 11px; color: var(--text3); text-align: center;
}

/* MAIN */
#main { margin-left: 220px; min-height: 100vh; }
.topbar {
  background: var(--bg2); border-bottom: 1px solid var(--border);
  padding: 0 28px; height: 60px; display: flex; align-items: center;
  justify-content: space-between; position: sticky; top: 0; z-index: 50;
}
.topbar h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 600; letter-spacing: 0.5px; }
.page { display: none; padding: 28px; }
.page.active { display: block; }

/* CARDS */
.cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
.card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 20px; position: relative; overflow: hidden;
}
.card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--amber); }
.card.green::before { background: var(--green); }
.card.red::before { background: var(--red); }
.card.blue::before { background: var(--blue); }
.card-label { font-size: 11px; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
.card-value { font-family: 'Bebas Neue', sans-serif; font-size: 36px; color: var(--text); line-height: 1; }
.card-sub { font-size: 12px; color: var(--text2); margin-top: 6px; }

/* PANELS */
.panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 20px; }
.panel-header {
  padding: 14px 20px; border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.panel-title { font-family: 'Barlow Condensed', sans-serif; font-size: 16px; font-weight: 600; letter-spacing: 0.5px; }
.panel-body { padding: 20px; }

/* BUTTONS */
.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px; border: none; border-radius: 8px;
  font-family: 'Barlow', sans-serif; font-size: 14px; font-weight: 600;
  cursor: pointer; transition: all 0.15s; text-decoration: none;
}
.btn-amber { background: var(--amber); color: #111; }
.btn-amber:hover { background: var(--amber2); }
.btn-green { background: var(--green); color: #fff; }
.btn-green:hover { background: #3d9963; }
.btn-red { background: var(--red); color: #fff; }
.btn-red:hover { background: #c84444; }
.btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { color: var(--text); background: var(--surface); }
.btn-sm { padding: 6px 12px; font-size: 12px; }
.btn-icon { padding: 7px; border-radius: 6px; }

/* TABLE */
table { width: 100%; border-collapse: collapse; font-size: 14px; }
th { padding: 10px 14px; text-align: left; font-size: 11px; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--border); font-weight: 600; }
td { padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
tr:last-child td { border-bottom: none; }
tr:hover td { background: rgba(255,255,255,0.02); }

/* STATUS BADGES */
.status {
  display: inline-block; padding: 3px 10px; border-radius: 20px;
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
}
.status-aberta { background: var(--blue-dim); color: var(--blue); }
.status-paga { background: var(--green-dim); color: var(--green); }
.status-fiado { background: var(--amber-dim); color: var(--amber); }
.status-cancelada { background: var(--red-dim); color: var(--red); }
.status-pendente { background: var(--amber-dim); color: var(--amber); }
.status-pago { background: var(--green-dim); color: var(--green); }

/* FORMS */
.form-group { margin-bottom: 16px; }
label { display: block; font-size: 12px; color: var(--text3); margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
input, select, textarea {
  width: 100%; background: var(--bg3); border: 1px solid var(--border);
  color: var(--text); padding: 10px 14px; border-radius: 8px;
  font-family: 'Barlow', sans-serif; font-size: 14px;
  transition: border-color 0.15s;
}
input:focus, select:focus, textarea:focus { outline: none; border-color: var(--amber); }
select option { background: var(--bg3); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

/* MODAL */
.overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,0.7); z-index: 1000;
  align-items: center; justify-content: center;
}
.overlay.show { display: flex; }
.modal {
  background: var(--bg2); border: 1px solid var(--border); border-radius: 14px;
  padding: 28px; width: 90%; max-width: 520px; max-height: 90vh;
  overflow-y: auto; position: relative;
}
.modal.modal-lg { max-width: 750px; }
.modal h3 { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 20px; }
.modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); }
.close-btn { position: absolute; right: 20px; top: 20px; background: var(--surface2); border: none; color: var(--text2); width: 30px; height: 30px; border-radius: 6px; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center; }
.close-btn:hover { color: var(--text); }

/* COMANDA DETAIL */
.comanda-item {
  display: flex; align-items: center; justify-content: space-between;
  padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
}
.comanda-item:last-child { border-bottom: none; }
.comanda-total { font-family: 'Bebas Neue', sans-serif; font-size: 32px; color: var(--amber); }

/* SEARCH BAR */
.search-bar { display: flex; gap: 10px; margin-bottom: 16px; }
.search-bar input { flex: 1; }

/* TOAST */
#toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
.toast {
  background: var(--surface); border: 1px solid var(--border); border-radius: 10px;
  padding: 14px 18px; font-size: 14px; min-width: 250px; display: flex; align-items: center; gap: 10px;
  animation: slideIn 0.25s ease;
  box-shadow: var(--shadow);
}
.toast.ok { border-left: 4px solid var(--green); }
.toast.err { border-left: 4px solid var(--red); }
@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

/* ESTOQUE ALERT */
.alerta-estoque { background: var(--red-dim); border: 1px solid var(--red); border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px; color: var(--red); display: flex; align-items: center; gap: 8px; }

/* DIVIDER */
.divider { border: none; border-top: 1px solid var(--border); margin: 20px 0; }

/* CHART BARS */
.bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 120px; }
.bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
.bar { width: 100%; background: var(--amber); border-radius: 4px 4px 0 0; transition: height 0.5s; min-height: 2px; }
.bar-label { font-size: 10px; color: var(--text3); }
.bar-val { font-size: 10px; color: var(--amber); font-weight: 700; }

.empty-state { padding: 48px; text-align: center; color: var(--text3); }
.empty-state svg { width: 48px; height: 48px; opacity: 0.3; margin-bottom: 12px; }
.empty-state p { font-size: 14px; }

/* SCROLLBAR */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

/* Grid helpers */
.flex { display: flex; }
.flex-center { display: flex; align-items: center; }
.flex-between { display: flex; align-items: center; justify-content: space-between; }
.gap-8 { gap: 8px; }
.gap-12 { gap: 12px; }
.mt-16 { margin-top: 16px; }
.text-amber { color: var(--amber); }
.text-green { color: var(--green); }
.text-red { color: var(--red); }
.text-muted { color: var(--text3); font-size: 13px; }
.fw-bold { font-weight: 700; }
.text-right { text-align: right; }

.categoria-tag {
  display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase;
}
.cat-cerveja { background: var(--amber-dim); color: var(--amber); }
.cat-bebida { background: var(--blue-dim); color: var(--blue); }
.cat-petisco { background: var(--green-dim); color: var(--green); }

.fiado-card {
  background: var(--bg3); border: 1px solid var(--border); border-radius: var(--radius);
  padding: 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;
}
</style>
</head>
<body>

<nav id="sidebar">
  <div class="sidebar-logo">
    <h1>Bar do Tony</h1>
    <p>Bairro Canaã – Ipatinga/MG</p>
  </div>

  <div class="nav-section">Principal</div>
  <button class="nav-btn active" onclick="navTo('dashboard')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    Dashboard
  </button>
  <button class="nav-btn" onclick="navTo('comandas')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 0 2-2h2a2 2 0 0 0 2 2"/></svg>
    Comandas
    <span class="badge" id="badge-comandas" style="display:none">0</span>
  </button>

  <div class="nav-section">Clientes</div>
  <button class="nav-btn" onclick="navTo('clientes')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    Clientes
  </button>
  <button class="nav-btn" onclick="navTo('fiados')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    Fiados
    <span class="badge" id="badge-fiados" style="display:none">0</span>
  </button>

  <div class="nav-section">Estoque</div>
  <button class="nav-btn" onclick="navTo('produtos')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
    Produtos
  </button>
  <button class="nav-btn" onclick="navTo('estoque')">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
    Movimentação
  </button>

  <div class="sidebar-footer">v1.0 – Bar Canaã © 2025</div>
</nav>

<div id="main">
  <div class="topbar">
    <h2 id="page-title">Dashboard</h2>
    <div class="flex gap-8" id="topbar-actions"></div>
  </div>

  <!-- DASHBOARD -->
  <div class="page active" id="page-dashboard">
    <div class="cards-grid">
      <div class="card"><div class="card-label">Comandas Hoje</div><div class="card-value" id="d-cmd-hoje">—</div></div>
      <div class="card green"><div class="card-label">Receita Hoje</div><div class="card-value" id="d-receita">—</div></div>
      <div class="card blue"><div class="card-label">Comandas Abertas</div><div class="card-value" id="d-abertas">—</div></div>
      <div class="card red"><div class="card-label">Total em Fiado</div><div class="card-value" id="d-fiado">—</div><div class="card-sub" id="d-fiado-num"></div></div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
      <div class="panel">
        <div class="panel-header"><span class="panel-title">📊 Receita – Últimos 7 dias</span></div>
        <div class="panel-body">
          <div class="bar-chart" id="grafico-receita"></div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header"><span class="panel-title">🏆 Top Produtos (7 dias)</span></div>
        <div class="panel-body" id="top-produtos"></div>
      </div>
    </div>
    <div id="alerta-estoque-dashboard"></div>
  </div>

  <!-- COMANDAS -->
  <div class="page" id="page-comandas">
    <div class="flex-between" style="margin-bottom:16px">
      <div class="flex gap-8">
        <button class="btn btn-ghost btn-sm" onclick="filtroComanda('aberta')" id="tab-aberta">Abertas</button>
        <button class="btn btn-ghost btn-sm" onclick="filtroComanda('paga')" id="tab-paga">Pagas</button>
        <button class="btn btn-ghost btn-sm" onclick="filtroComanda('fiado')" id="tab-fiado">Fiado</button>
        <button class="btn btn-ghost btn-sm" onclick="filtroComanda('cancelada')" id="tab-cancelada">Canceladas</button>
      </div>
      <button class="btn btn-amber" onclick="abrirModalComanda()">+ Nova Comanda</button>
    </div>
    <div class="panel">
      <div class="panel-body" style="padding:0">
        <table>
          <thead><tr><th>#</th><th>Cliente</th><th>Tipo</th><th>Itens</th><th>Total</th><th>Abertura</th><th>Status</th><th></th></tr></thead>
          <tbody id="tabela-comandas"><tr><td colspan="8" class="empty-state"><p>Carregando...</p></td></tr></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- CLIENTES -->
  <div class="page" id="page-clientes">
    <div class="flex-between" style="margin-bottom:16px">
      <div class="search-bar" style="margin:0;flex:1;max-width:400px">
        <input type="text" id="busca-cliente" placeholder="Buscar por nome..." oninput="buscarClientes()">
      </div>
      <button class="btn btn-amber" onclick="abrirModalCliente()">+ Novo Cliente</button>
    </div>
    <div class="panel">
      <div class="panel-body" style="padding:0">
        <table>
          <thead><tr><th>Nome</th><th>Telefone</th><th>Observações</th><th>Cadastro</th><th></th></tr></thead>
          <tbody id="tabela-clientes"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- FIADOS -->
  <div class="page" id="page-fiados">
    <div class="panel" style="margin-bottom:20px">
      <div class="panel-header"><span class="panel-title">💰 Fiados Pendentes</span></div>
      <div class="panel-body" id="lista-fiados"></div>
    </div>
  </div>

  <!-- PRODUTOS -->
  <div class="page" id="page-produtos">
    <div class="flex-between" style="margin-bottom:16px">
      <div></div>
      <button class="btn btn-amber" onclick="abrirModalProduto()">+ Novo Produto</button>
    </div>
    <div id="alerta-estoque-produtos"></div>
    <div class="panel">
      <div class="panel-body" style="padding:0">
        <table>
          <thead><tr><th>Produto</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Mínimo</th><th>Unidade</th><th></th></tr></thead>
          <tbody id="tabela-produtos"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ESTOQUE -->
  <div class="page" id="page-estoque">
    <div class="flex-between" style="margin-bottom:16px">
      <div></div>
      <button class="btn btn-amber" onclick="abrirModalMovimento()">+ Registrar Movimentação</button>
    </div>
    <div class="panel">
      <div class="panel-header"><span class="panel-title">Histórico de Movimentações</span></div>
      <div class="panel-body" style="padding:0">
        <table>
          <thead><tr><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Observação</th><th>Data</th></tr></thead>
          <tbody id="tabela-estoque"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODALS -->
<!-- Modal Comanda -->
<div class="overlay" id="modal-comanda">
  <div class="modal">
    <button class="close-btn" onclick="fecharModal('modal-comanda')">×</button>
    <h3>Nova Comanda</h3>
    <div class="form-group">
      <label>Cliente (opcional)</label>
      <select id="cmd-cliente-id">
        <option value="">— Cliente Avulso —</option>
      </select>
    </div>
    <div class="form-group">
      <label>Tipo</label>
      <select id="cmd-tipo">
        <option value="local">Mesa/Local</option>
        <option value="viagem">Para Viagem</option>
      </select>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="fecharModal('modal-comanda')">Cancelar</button>
      <button class="btn btn-amber" onclick="salvarComanda()">Abrir Comanda</button>
    </div>
  </div>
</div>

<!-- Modal Ver Comanda -->
<div class="overlay" id="modal-ver-comanda">
  <div class="modal modal-lg">
    <button class="close-btn" onclick="fecharModal('modal-ver-comanda')">×</button>
    <h3 id="ver-comanda-titulo">Comanda #—</h3>
    <div id="ver-comanda-info" style="margin-bottom:16px;color:var(--text2);font-size:13px;"></div>
    
    <div class="panel" style="margin-bottom:16px">
      <div class="panel-header">
        <span class="panel-title">Adicionar Produto</span>
      </div>
      <div class="panel-body">
        <div class="form-row">
          <div class="form-group" style="margin:0">
            <label>Produto</label>
            <select id="item-produto"></select>
          </div>
          <div class="form-group" style="margin:0">
            <label>Quantidade</label>
            <input type="number" id="item-qtd" value="1" min="1">
          </div>
        </div>
        <div style="margin-top:12px;text-align:right">
          <button class="btn btn-green" onclick="adicionarItem()">+ Adicionar</button>
        </div>
      </div>
    </div>

    <div id="lista-itens-comanda"></div>
    
    <div class="flex-between" style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border)">
      <div>
        <div class="text-muted">Total da Comanda</div>
        <div class="comanda-total" id="total-comanda">R$ 0,00</div>
      </div>
      <div class="flex gap-8" id="acoes-comanda"></div>
    </div>
  </div>
</div>

<!-- Modal Fechar Comanda -->
<div class="overlay" id="modal-fechar-comanda">
  <div class="modal">
    <button class="close-btn" onclick="fecharModal('modal-fechar-comanda')">×</button>
    <h3>Fechar Comanda</h3>
    <p style="color:var(--text2);margin-bottom:16px;font-size:14px;">Selecione a forma de pagamento:</p>
    <div class="form-group">
      <label>Forma de Pagamento</label>
      <select id="forma-pagamento">
        <option value="dinheiro">💵 Dinheiro</option>
        <option value="pix">💠 PIX</option>
        <option value="cartao">💳 Cartão</option>
        <option value="fiado">📋 Fiado (anotar para pagar depois)</option>
      </select>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="fecharModal('modal-fechar-comanda')">Cancelar</button>
      <button class="btn btn-green" onclick="confirmarFecharComanda()">Confirmar Fechamento</button>
    </div>
  </div>
</div>

<!-- Modal Cliente -->
<div class="overlay" id="modal-cliente">
  <div class="modal">
    <button class="close-btn" onclick="fecharModal('modal-cliente')">×</button>
    <h3 id="modal-cliente-titulo">Novo Cliente</h3>
    <input type="hidden" id="cli-id">
    <div class="form-group">
      <label>Nome *</label>
      <input type="text" id="cli-nome" placeholder="Nome completo">
    </div>
    <div class="form-group">
      <label>Telefone</label>
      <input type="text" id="cli-telefone" placeholder="(31) 99999-9999">
    </div>
    <div class="form-group">
      <label>Observações</label>
      <textarea id="cli-obs" rows="2" placeholder="Informações adicionais..."></textarea>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="fecharModal('modal-cliente')">Cancelar</button>
      <button class="btn btn-amber" onclick="salvarCliente()">Salvar</button>
    </div>
  </div>
</div>

<!-- Modal Produto -->
<div class="overlay" id="modal-produto">
  <div class="modal">
    <button class="close-btn" onclick="fecharModal('modal-produto')">×</button>
    <h3 id="modal-produto-titulo">Novo Produto</h3>
    <input type="hidden" id="prod-id">
    <div class="form-group">
      <label>Nome *</label>
      <input type="text" id="prod-nome" placeholder="Ex: Brahma 600ml">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Categoria</label>
        <select id="prod-categoria">
          <option value="cerveja">🍺 Cerveja</option>
          <option value="bebida">🥤 Bebida</option>
          <option value="petisco">🍟 Petisco</option>
        </select>
      </div>
      <div class="form-group">
        <label>Unidade</label>
        <select id="prod-unidade">
          <option value="unid">Unidade</option>
          <option value="lata">Lata</option>
          <option value="garrafa">Garrafa</option>
          <option value="porcao">Porção</option>
          <option value="lt">Litro</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Preço (R$) *</label>
        <input type="number" id="prod-preco" min="0" step="0.50" placeholder="0,00">
      </div>
      <div class="form-group">
        <label>Estoque Atual</label>
        <input type="number" id="prod-estoque" min="0" placeholder="0">
      </div>
    </div>
    <div class="form-group">
      <label>Estoque Mínimo (alerta)</label>
      <input type="number" id="prod-estoque-min" min="0" placeholder="5">
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="fecharModal('modal-produto')">Cancelar</button>
      <button class="btn btn-amber" onclick="salvarProduto()">Salvar</button>
    </div>
  </div>
</div>

<!-- Modal Movimentação -->
<div class="overlay" id="modal-movimento">
  <div class="modal">
    <button class="close-btn" onclick="fecharModal('modal-movimento')">×</button>
    <h3>Movimentação de Estoque</h3>
    <div class="form-group">
      <label>Produto *</label>
      <select id="mov-produto"></select>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Tipo</label>
        <select id="mov-tipo">
          <option value="entrada">⬆ Entrada (compra)</option>
          <option value="saida">⬇ Saída (perda/ajuste)</option>
        </select>
      </div>
      <div class="form-group">
        <label>Quantidade *</label>
        <input type="number" id="mov-qtd" min="1" placeholder="0">
      </div>
    </div>
    <div class="form-group">
      <label>Observações</label>
      <input type="text" id="mov-obs" placeholder="Ex: Compra do fornecedor">
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="fecharModal('modal-movimento')">Cancelar</button>
      <button class="btn btn-amber" onclick="salvarMovimento()">Registrar</button>
    </div>
  </div>
</div>

<div id="toast-container"></div>

<script>
const API = 'api.php';
let currentPage = 'dashboard';
let currentComandaId = null;
let currentComandaStatus = null;
let currentComandaClienteId = null;
let filtroComandaAtual = 'aberta';

async function api(params) {
  const isPost = params.method === 'POST' || params.body;
  const url = API + (isPost ? '' : '?' + new URLSearchParams(params));
  const opts = isPost ? {
    method: 'POST',
    body: new URLSearchParams(params.body || params)
  } : {};
  if (isPost) delete opts.body.method;
  const r = await fetch(url, opts);
  return r.json();
}

function toast(msg, ok = true) {
  const d = document.createElement('div');
  d.className = 'toast ' + (ok ? 'ok' : 'err');
  d.innerHTML = (ok ? '✓' : '✗') + ' ' + msg;
  document.getElementById('toast-container').appendChild(d);
  setTimeout(() => d.remove(), 3500);
}

function navTo(page) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('page-' + page).classList.add('active');
  document.querySelector(`.nav-btn[onclick="navTo('${page}')"]`).classList.add('active');
  const titles = { dashboard:'Dashboard', comandas:'Comandas', clientes:'Clientes', fiados:'Fiados', produtos:'Produtos', estoque:'Movimentação de Estoque' };
  document.getElementById('page-title').textContent = titles[page] || page;
  currentPage = page;
  loadPage(page);
}

async function loadPage(page) {
  if (page === 'dashboard') await loadDashboard();
  else if (page === 'comandas') await loadComandas();
  else if (page === 'clientes') await loadClientes();
  else if (page === 'fiados') await loadFiados();
  else if (page === 'produtos') await loadProdutos();
  else if (page === 'estoque') await loadEstoque();
}

// ====== DASHBOARD ======
async function loadDashboard() {
  const r = await api({ action: 'dashboard' });
  if (!r.ok) return;
  const d = r.data;
  document.getElementById('d-cmd-hoje').textContent = d.comandasHoje;
  document.getElementById('d-receita').textContent = formatMoeda(d.receitaHoje);
  document.getElementById('d-abertas').textContent = d.comandasAbertas;
  document.getElementById('d-fiado').textContent = formatMoeda(d.totalFiado);
  document.getElementById('d-fiado-num').textContent = d.numFiados + ' cliente(s) devendo';

  const badgeC = document.getElementById('badge-comandas');
  badgeC.style.display = d.comandasAbertas > 0 ? '' : 'none';
  badgeC.textContent = d.comandasAbertas;
  const badgeF = document.getElementById('badge-fiados');
  badgeF.style.display = d.numFiados > 0 ? '' : 'none';
  badgeF.textContent = d.numFiados;

  // Gráfico
  const graf = document.getElementById('grafico-receita');
  const dias = d.receitaSemana;
  const maxVal = dias.length ? Math.max(...dias.map(x => parseFloat(x.receita))) : 1;
  graf.innerHTML = dias.map(dia => {
    const h = maxVal > 0 ? (parseFloat(dia.receita) / maxVal * 100) : 2;
    const label = dia.dia.slice(5).replace('-', '/');
    return `<div class="bar-col"><div class="bar-val">${formatMoeda(dia.receita).replace('R$ ','')}</div><div class="bar" style="height:${Math.max(h,2)}%"></div><div class="bar-label">${label}</div></div>`;
  }).join('') || '<p style="color:var(--text3);font-size:13px">Sem vendas recentes</p>';

  // Top produtos
  const tp = document.getElementById('top-produtos');
  tp.innerHTML = d.topProdutos.map((p,i) =>
    `<div class="flex-between" style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05)">
      <span style="font-size:13px"><span style="color:var(--text3);margin-right:8px">#${i+1}</span>${p.produto_nome}</span>
      <span style="font-weight:700;color:var(--amber)">${p.total}×</span>
    </div>`
  ).join('') || '<p style="color:var(--text3);font-size:13px">Sem dados</p>';

  // Alerta
  const al = document.getElementById('alerta-estoque-dashboard');
  if (d.alertaEstoque > 0 || d.semEstoque > 0) {
    al.innerHTML = `<div class="alerta-estoque">⚠️ ${d.semEstoque} produto(s) sem estoque e ${d.alertaEstoque} no limite mínimo. <a href="#" onclick="navTo('produtos');return false" style="color:inherit;margin-left:8px;font-weight:700">Ver Produtos →</a></div>`;
  } else al.innerHTML = '';
}

// ====== COMANDAS ======
async function loadComandas() {
  const r = await api({ action: 'listar_comandas', status: filtroComandaAtual });
  const tabela = document.getElementById('tabela-comandas');
  if (!r.ok || !r.data.length) {
    tabela.innerHTML = `<tr><td colspan="8"><div class="empty-state"><p>Nenhuma comanda ${filtroComandaAtual}</p></div></td></tr>`;
    return;
  }
  tabela.innerHTML = r.data.map(c => `
    <tr>
      <td><strong>#${c.id}</strong></td>
      <td>${c.cliente_nome}</td>
      <td><span style="font-size:12px;color:var(--text2)">${c.tipo === 'local' ? '🍺 Local' : '🛍 Viagem'}</span></td>
      <td>${c.num_itens} item(s)</td>
      <td><strong class="text-amber">${formatMoeda(c.total)}</strong></td>
      <td style="font-size:12px;color:var(--text2)">${formatData(c.criado_em)}</td>
      <td><span class="status status-${c.status}">${c.status}</span></td>
      <td><button class="btn btn-ghost btn-sm" onclick="verComanda(${c.id})">Abrir</button></td>
    </tr>
  `).join('');
}

function filtroComanda(status) {
  filtroComandaAtual = status;
  document.querySelectorAll('[id^=tab-]').forEach(b => { b.style.background = ''; b.style.color = ''; });
  const btn = document.getElementById('tab-' + status);
  if (btn) { btn.style.background = 'var(--amber)'; btn.style.color = '#111'; }
  loadComandas();
}

async function abrirModalComanda() {
  const r = await api({ action: 'listar_clientes' });
  const sel = document.getElementById('cmd-cliente-id');
  sel.innerHTML = '<option value="">— Cliente Avulso —</option>' +
    (r.data || []).map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
  document.getElementById('modal-comanda').classList.add('show');
}

async function salvarComanda() {
  const r = await api({
    method: 'POST',
    action: 'abrir_comanda',
    cliente_id: document.getElementById('cmd-cliente-id').value,
    tipo: document.getElementById('cmd-tipo').value
  });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-comanda');
  toast('Comanda #' + r.id + ' aberta!');
  await loadComandas();
  verComanda(r.id);
}

async function verComanda(id) {
  const r = await api({ action: 'ver_comanda', id });
  if (!r.ok) { toast(r.erro, false); return; }
  const c = r.data;
  currentComandaId = id;
  currentComandaStatus = c.status;
  currentComandaClienteId = c.cliente_id;
  document.getElementById('ver-comanda-titulo').textContent = `Comanda #${id} — ${c.cliente_nome}`;
  document.getElementById('ver-comanda-info').textContent = `Tipo: ${c.tipo === 'local' ? 'Local' : 'Viagem'} | Aberta em: ${formatData(c.criado_em)} | Status: ${c.status}`;

  const prods = await api({ action: 'listar_produtos' });
  const selP = document.getElementById('item-produto');
  selP.innerHTML = (prods.data || []).map(p => `<option value="${p.id}" data-preco="${p.preco}">${p.nome} – ${formatMoeda(p.preco)} (est: ${p.estoque})</option>`).join('');

  const addSection = document.querySelector('#modal-ver-comanda .panel');
  addSection.style.display = c.status === 'aberta' ? '' : 'none';

  const lista = document.getElementById('lista-itens-comanda');
  if (!c.itens.length) {
    lista.innerHTML = '<div class="empty-state" style="padding:24px"><p>Nenhum item ainda</p></div>';
  } else {
    lista.innerHTML = c.itens.map(it => `
      <div class="comanda-item">
        <div>
          <div style="font-weight:600">${it.produto_nome}</div>
          <div style="font-size:12px;color:var(--text2)">${it.quantidade}× ${formatMoeda(it.preco_unitario)}</div>
        </div>
        <div class="flex gap-8 flex-center">
          <strong class="text-amber">${formatMoeda(it.subtotal)}</strong>
          ${c.status === 'aberta' ? `<button class="btn btn-icon btn-red btn-sm" onclick="removerItem(${it.id})">✕</button>` : ''}
        </div>
      </div>
    `).join('');
  }

  document.getElementById('total-comanda').textContent = formatMoeda(c.total);
  const acoes = document.getElementById('acoes-comanda');
  if (c.status === 'aberta') {
    acoes.innerHTML = `
      <button class="btn btn-ghost" onclick="cancelarComanda(${id})">Cancelar Comanda</button>
      <button class="btn btn-green" onclick="abrirFecharComanda()">Fechar e Pagar</button>
    `;
  } else {
    acoes.innerHTML = `<span class="status status-${c.status}">${c.status}</span>`;
  }

  document.getElementById('modal-ver-comanda').classList.add('show');
}

async function adicionarItem() {
  const pid = document.getElementById('item-produto').value;
  const qtd = document.getElementById('item-qtd').value;
  const r = await api({ method: 'POST', action: 'adicionar_item', comanda_id: currentComandaId, produto_id: pid, quantidade: qtd });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Item adicionado!');
  verComanda(currentComandaId);
}

async function removerItem(itemId) {
  if (!confirm('Remover este item?')) return;
  const r = await api({ method: 'POST', action: 'remover_item', item_id: itemId });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Item removido');
  verComanda(currentComandaId);
}

function abrirFecharComanda() {
  const sel = document.getElementById('forma-pagamento');
  if (!currentComandaClienteId) {
    Array.from(sel.options).forEach(o => { if (o.value === 'fiado') o.disabled = true; });
  } else {
    Array.from(sel.options).forEach(o => o.disabled = false);
  }
  document.getElementById('modal-fechar-comanda').classList.add('show');
}

async function confirmarFecharComanda() {
  const forma = document.getElementById('forma-pagamento').value;
  const r = await api({ method: 'POST', action: 'fechar_comanda', comanda_id: currentComandaId, forma_pagamento: forma });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-fechar-comanda');
  fecharModal('modal-ver-comanda');
  toast('Comanda fechada com sucesso!');
  loadComandas();
  loadDashboard();
}

async function cancelarComanda(id) {
  if (!confirm('Cancelar esta comanda? O estoque será restaurado.')) return;
  const r = await api({ method: 'POST', action: 'cancelar_comanda', comanda_id: id });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-ver-comanda');
  toast('Comanda cancelada');
  loadComandas();
}

// ====== CLIENTES ======
async function loadClientes(busca = '') {
  const r = await api({ action: 'listar_clientes', q: busca });
  const tabela = document.getElementById('tabela-clientes');
  if (!r.ok || !r.data.length) {
    tabela.innerHTML = `<tr><td colspan="5"><div class="empty-state"><p>Nenhum cliente encontrado</p></div></td></tr>`;
    return;
  }
  tabela.innerHTML = r.data.map(c => `
    <tr>
      <td><strong>${c.nome}</strong></td>
      <td>${c.telefone || '—'}</td>
      <td style="font-size:13px;color:var(--text2)">${c.observacoes || '—'}</td>
      <td style="font-size:12px;color:var(--text3)">${formatData(c.criado_em)}</td>
      <td>
        <div class="flex gap-8">
          <button class="btn btn-ghost btn-sm" onclick="editarCliente(${c.id},'${escapar(c.nome)}','${escapar(c.telefone||'')}','${escapar(c.observacoes||'')}')">Editar</button>
          <button class="btn btn-red btn-sm" onclick="excluirCliente(${c.id})">Excluir</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function escapar(s) { return (s||'').replace(/'/g, "\\'"); }

function buscarClientes() {
  const q = document.getElementById('busca-cliente').value;
  loadClientes(q);
}

function abrirModalCliente() {
  document.getElementById('modal-cliente-titulo').textContent = 'Novo Cliente';
  document.getElementById('cli-id').value = '';
  document.getElementById('cli-nome').value = '';
  document.getElementById('cli-telefone').value = '';
  document.getElementById('cli-obs').value = '';
  document.getElementById('modal-cliente').classList.add('show');
}

function editarCliente(id, nome, tel, obs) {
  document.getElementById('modal-cliente-titulo').textContent = 'Editar Cliente';
  document.getElementById('cli-id').value = id;
  document.getElementById('cli-nome').value = nome;
  document.getElementById('cli-telefone').value = tel;
  document.getElementById('cli-obs').value = obs;
  document.getElementById('modal-cliente').classList.add('show');
}

async function salvarCliente() {
  const r = await api({
    method: 'POST', action: 'salvar_cliente',
    id: document.getElementById('cli-id').value,
    nome: document.getElementById('cli-nome').value,
    telefone: document.getElementById('cli-telefone').value,
    observacoes: document.getElementById('cli-obs').value
  });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-cliente');
  toast('Cliente salvo!');
  loadClientes();
}

async function excluirCliente(id) {
  if (!confirm('Excluir este cliente?')) return;
  const r = await api({ method: 'POST', action: 'excluir_cliente', id });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Cliente excluído');
  loadClientes();
}

// ====== FIADOS ======
async function loadFiados() {
  const r = await api({ action: 'listar_fiados' });
  const container = document.getElementById('lista-fiados');
  if (!r.ok || !r.data.length) {
    container.innerHTML = '<div class="empty-state"><p>🎉 Nenhum fiado pendente!</p></div>';
    return;
  }
  // Agrupar por cliente
  const agrupado = {};
  r.data.forEach(f => {
    if (!agrupado[f.cliente_id]) agrupado[f.cliente_id] = { nome: f.cliente_nome, tel: f.telefone, total: 0, fiados: [] };
    agrupado[f.cliente_id].total += parseFloat(f.valor);
    agrupado[f.cliente_id].fiados.push(f);
  });
  container.innerHTML = Object.entries(agrupado).map(([cid, g]) => `
    <div class="fiado-card">
      <div>
        <div style="font-weight:700;font-size:15px">${g.nome}</div>
        <div style="font-size:12px;color:var(--text3);margin-top:4px">${g.tel || 'Sem telefone'} · ${g.fiados.length} comanda(s)</div>
      </div>
      <div class="flex gap-8 flex-center">
        <div style="text-align:right">
          <div style="font-family:'Bebas Neue',sans-serif;font-size:26px;color:var(--red)">${formatMoeda(g.total)}</div>
        </div>
        <button class="btn btn-green btn-sm" onclick="pagarTodosFiados(${cid}, '${escapar(g.nome)}', '${formatMoeda(g.total)}')">Quitar Tudo</button>
      </div>
    </div>
    ${g.fiados.map(f => `
      <div style="padding:8px 16px;margin-left:16px;border-left:2px solid var(--border);margin-bottom:8px;font-size:13px;display:flex;justify-content:space-between;align-items:center">
        <span style="color:var(--text2)">${formatData(f.criado_em)} ${f.comanda_id ? '· Comanda #' + f.comanda_id : ''} ${f.observacoes ? '· ' + f.observacoes : ''}</span>
        <div class="flex gap-8 flex-center">
          <strong class="text-amber">${formatMoeda(f.valor)}</strong>
          <button class="btn btn-ghost btn-sm" onclick="pagarFiado(${f.id})">Pagar</button>
        </div>
      </div>
    `).join('')}
  `).join('<hr class="divider">');
}

async function pagarFiado(id) {
  if (!confirm('Marcar este fiado como pago?')) return;
  const r = await api({ method: 'POST', action: 'pagar_fiado', id });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Fiado quitado!');
  loadFiados(); loadDashboard();
}

async function pagarTodosFiados(cid, nome, total) {
  if (!confirm(`Quitar todos os fiados de ${nome} (${total})?`)) return;
  const r = await api({ method: 'POST', action: 'pagar_todos_fiados', cliente_id: cid });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Todos os fiados quitados!');
  loadFiados(); loadDashboard();
}

// ====== PRODUTOS ======
async function loadProdutos() {
  const r = await api({ action: 'listar_produtos' });
  const alerta = await api({ action: 'estoque_alerta' });
  const al = document.getElementById('alerta-estoque-produtos');
  if (alerta.data && alerta.data.length) {
    al.innerHTML = `<div class="alerta-estoque">⚠️ Produtos com estoque no limite ou zerado: ${alerta.data.map(p=>p.nome).join(', ')}</div>`;
  } else al.innerHTML = '';

  const tabela = document.getElementById('tabela-produtos');
  if (!r.ok || !r.data.length) {
    tabela.innerHTML = `<tr><td colspan="7"><div class="empty-state"><p>Nenhum produto cadastrado</p></div></td></tr>`;
    return;
  }
  const catTag = (c) => {
    const m = { cerveja: 'cat-cerveja 🍺', bebida: 'cat-bebida 🥤', petisco: 'cat-petisco 🍟' };
    return `<span class="categoria-tag ${m[c]?.split(' ')[0] || ''}">${m[c] || c}</span>`;
  };
  tabela.innerHTML = r.data.map(p => {
    const alerta = p.estoque <= p.estoque_minimo && p.categoria !== 'petisco';
    const estoqueColor = p.estoque === 0 ? 'var(--red)' : alerta ? 'var(--amber)' : 'var(--green)';
    return `<tr>
      <td><strong>${p.nome}</strong></td>
      <td>${catTag(p.categoria)}</td>
      <td class="text-amber"><strong>${formatMoeda(p.preco)}</strong></td>
      <td><span style="font-weight:700;color:${estoqueColor}">${p.estoque}</span> ${alerta ? '⚠️' : ''}</td>
      <td style="color:var(--text3)">${p.estoque_minimo}</td>
      <td style="color:var(--text2);font-size:13px">${p.unidade}</td>
      <td>
        <div class="flex gap-8">
          <button class="btn btn-ghost btn-sm" onclick="editarProduto(${p.id},'${escapar(p.nome)}','${p.categoria}','${p.preco}','${p.estoque}','${p.estoque_minimo}','${p.unidade}')">Editar</button>
          <button class="btn btn-red btn-sm" onclick="inativarProduto(${p.id})">Remover</button>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function abrirModalProduto() {
  document.getElementById('modal-produto-titulo').textContent = 'Novo Produto';
  document.getElementById('prod-id').value = '';
  document.getElementById('prod-nome').value = '';
  document.getElementById('prod-categoria').value = 'cerveja';
  document.getElementById('prod-preco').value = '';
  document.getElementById('prod-estoque').value = '0';
  document.getElementById('prod-estoque-min').value = '5';
  document.getElementById('prod-unidade').value = 'unid';
  document.getElementById('modal-produto').classList.add('show');
}

function editarProduto(id, nome, cat, preco, est, estMin, unid) {
  document.getElementById('modal-produto-titulo').textContent = 'Editar Produto';
  document.getElementById('prod-id').value = id;
  document.getElementById('prod-nome').value = nome;
  document.getElementById('prod-categoria').value = cat;
  document.getElementById('prod-preco').value = preco;
  document.getElementById('prod-estoque').value = est;
  document.getElementById('prod-estoque-min').value = estMin;
  document.getElementById('prod-unidade').value = unid;
  document.getElementById('modal-produto').classList.add('show');
}

async function salvarProduto() {
  const r = await api({
    method: 'POST', action: 'salvar_produto',
    id: document.getElementById('prod-id').value,
    nome: document.getElementById('prod-nome').value,
    categoria: document.getElementById('prod-categoria').value,
    preco: document.getElementById('prod-preco').value,
    estoque: document.getElementById('prod-estoque').value,
    estoque_minimo: document.getElementById('prod-estoque-min').value,
    unidade: document.getElementById('prod-unidade').value
  });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-produto');
  toast('Produto salvo!');
  loadProdutos();
}

async function inativarProduto(id) {
  if (!confirm('Remover este produto do sistema?')) return;
  const r = await api({ method: 'POST', action: 'inativar_produto', id });
  if (!r.ok) { toast(r.erro, false); return; }
  toast('Produto removido');
  loadProdutos();
}

// ====== ESTOQUE ======
async function loadEstoque() {
  const r = await api({ action: 'historico_estoque' });
  const tabela = document.getElementById('tabela-estoque');
  if (!r.ok || !r.data.length) {
    tabela.innerHTML = `<tr><td colspan="5"><div class="empty-state"><p>Nenhuma movimentação</p></div></td></tr>`;
    return;
  }
  tabela.innerHTML = r.data.map(m => `
    <tr>
      <td><strong>${m.produto_nome}</strong></td>
      <td><span class="status ${m.tipo === 'entrada' ? 'status-paga' : 'status-fiado'}">${m.tipo === 'entrada' ? '⬆ Entrada' : '⬇ Saída'}</span></td>
      <td><strong>${m.quantidade}</strong></td>
      <td style="font-size:13px;color:var(--text2)">${m.observacoes || '—'}</td>
      <td style="font-size:12px;color:var(--text3)">${formatData(m.criado_em)}</td>
    </tr>
  `).join('');
}

async function abrirModalMovimento() {
  const r = await api({ action: 'listar_produtos' });
  const sel = document.getElementById('mov-produto');
  sel.innerHTML = (r.data || []).map(p => `<option value="${p.id}">${p.nome} (est: ${p.estoque})</option>`).join('');
  document.getElementById('mov-qtd').value = '';
  document.getElementById('mov-obs').value = '';
  document.getElementById('modal-movimento').classList.add('show');
}

async function salvarMovimento() {
  const r = await api({
    method: 'POST', action: 'movimentar_estoque',
    produto_id: document.getElementById('mov-produto').value,
    tipo: document.getElementById('mov-tipo').value,
    quantidade: document.getElementById('mov-qtd').value,
    observacoes: document.getElementById('mov-obs').value
  });
  if (!r.ok) { toast(r.erro, false); return; }
  fecharModal('modal-movimento');
  toast('Movimentação registrada!');
  loadEstoque();
  loadProdutos();
}

// ====== UTILS ======
function fecharModal(id) {
  document.getElementById(id).classList.remove('show');
}

function formatMoeda(v) {
  return 'R$ ' + parseFloat(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function formatData(d) {
  if (!d) return '—';
  const dt = new Date(d.replace(' ', 'T'));
  return dt.toLocaleDateString('pt-BR') + ' ' + dt.toLocaleTimeString('pt-BR', {hour:'2-digit',minute:'2-digit'});
}

// Fechar modal clicando fora
document.querySelectorAll('.overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); });
});

// Init
loadDashboard();
</script>
</body>
</html>
