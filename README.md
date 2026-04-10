# Bar Canaã – Sistema de Gestão
**Bar Canaã | Bairro Canaã, Ipatinga - MG**

Sistema completo de gestão para bares, desenvolvido em PHP + SQLite (sem necessidade de MySQL).

---

## 📋 Funcionalidades

- **Dashboard** com visão geral: receita do dia, comandas abertas, fiados pendentes e gráfico semanal
- **Comandas**: abertura, lançamento de itens com baixa automática do estoque, fechamento com múltiplas formas de pagamento
- **Fiados**: controle por cliente, quitação individual ou total, histórico
- **Clientes**: cadastro completo com busca
- **Produtos**: cadastro de cervejas, bebidas e petiscos com preços
- **Estoque**: controle com alertas de estoque mínimo, histórico de entradas e saídas

---

## ⚙️ Requisitos

- PHP 7.4 ou superior
- Extensão PDO SQLite habilitada (`php_pdo_sqlite`)
- Servidor web: Apache, Nginx ou servidor embutido do PHP

---

## 🚀 Instalação

### Opção 1 – Servidor local com PHP embutido (mais simples)
```bash
cd bar_canaa
php -S localhost:8080
```
Acesse: http://localhost:8080

### Opção 2 – XAMPP / WAMP / LAMP
1. Copie a pasta `bar_canaa` para `htdocs/` (XAMPP) ou `www/` (WAMP)
2. Acesse: http://localhost/bar_canaa

### Opção 3 – Servidor Apache/Nginx
1. Copie os arquivos para o diretório público do servidor
2. Garanta que a pasta `data/` tem permissão de escrita: `chmod 777 data/`

---

## 📁 Estrutura de Arquivos

```
bar_canaa/
├── index.php              # Interface principal do sistema
├── api.php                # API backend (todas as ações)
├── includes/
│   └── database.php       # Conexão SQLite e inicialização do banco
├── data/                  # Banco de dados SQLite (criado automaticamente)
│   └── bar_canaa.db
└── README.md
```

---

## 🗄️ Banco de Dados

O banco SQLite é criado automaticamente na pasta `data/` no primeiro acesso.
Já vem com produtos pré-cadastrados (cervejas e petiscos comuns).

**Tabelas:**
- `clientes` – cadastro de clientes
- `produtos` – produtos e estoque
- `comandas` – comandas abertas/fechadas
- `comanda_itens` – itens de cada comanda
- `fiados` – controle de fiados por cliente
- `movimentacoes_estoque` – histórico de entradas/saídas

---

## 💾 Backup

Para fazer backup, basta copiar o arquivo `data/bar_canaa.db`.
Ele contém todos os dados do sistema.

---

## 🔒 Segurança

Para uso em produção, recomenda-se:
- Adicionar autenticação por senha (login simples com `session_start()`)
- Usar HTTPS
- Proteger a pasta `data/` com `.htaccess`:
  ```
  Deny from all
  ```
