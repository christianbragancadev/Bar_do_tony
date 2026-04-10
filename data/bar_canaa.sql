CREATE DATABASE IF NOT EXISTS bar_canaa
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE bar_canaa;

CREATE TABLE IF NOT EXISTS clientes (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(150) NOT NULL,
    telefone    VARCHAR(30)  DEFAULT NULL,
    observacoes TEXT         DEFAULT NULL,
    criado_em   DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS produtos (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome             VARCHAR(150)  NOT NULL,
    categoria        VARCHAR(30)   NOT NULL DEFAULT 'bebida',
    preco            DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estoque          INT           NOT NULL DEFAULT 0,
    estoque_minimo   INT           NOT NULL DEFAULT 5,
    unidade          VARCHAR(20)   NOT NULL DEFAULT 'unid',
    ativo            TINYINT(1)    NOT NULL DEFAULT 1,
    criado_em        DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS comandas (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente_id    INT UNSIGNED DEFAULT NULL,
    cliente_nome  VARCHAR(150) NOT NULL DEFAULT 'Cliente Avulso',
    status        ENUM('aberta','paga','fiado','cancelada') NOT NULL DEFAULT 'aberta',
    tipo          ENUM('local','viagem')                    NOT NULL DEFAULT 'local',
    total         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    criado_em     DATETIME DEFAULT CURRENT_TIMESTAMP,
    fechado_em    DATETIME DEFAULT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS comanda_itens (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comanda_id      INT UNSIGNED  NOT NULL,
    produto_id      INT UNSIGNED  NOT NULL,
    produto_nome    VARCHAR(150)  NOT NULL,
    quantidade      INT           NOT NULL DEFAULT 1,
    preco_unitario  DECIMAL(10,2) NOT NULL,
    subtotal        DECIMAL(10,2) NOT NULL,
    criado_em       DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comanda_id) REFERENCES comandas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS fiados (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente_id  INT UNSIGNED  NOT NULL,
    comanda_id  INT UNSIGNED  DEFAULT NULL,
    valor       DECIMAL(10,2) NOT NULL,
    status      ENUM('pendente','pago') NOT NULL DEFAULT 'pendente',
    observacoes TEXT          DEFAULT NULL,
    criado_em   DATETIME DEFAULT CURRENT_TIMESTAMP,
    pago_em     DATETIME DEFAULT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (comanda_id) REFERENCES comandas(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produto_id  INT UNSIGNED NOT NULL,
    tipo        ENUM('entrada','saida') NOT NULL,
    quantidade  INT          NOT NULL,
    observacoes TEXT         DEFAULT NULL,
    criado_em   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO produtos (nome, categoria, preco, estoque, estoque_minimo, unidade) VALUES
('Brahma 600ml',          'cerveja',  8.00, 50, 10, 'garrafa'),
('Skol 600ml',            'cerveja',  7.50, 40, 10, 'garrafa'),
('Antarctica 600ml',      'cerveja',  7.50, 30, 10, 'garrafa'),
('Heineken 600ml',        'cerveja', 12.00, 24,  5, 'garrafa'),
('Itaipava 600ml',        'cerveja',  6.00, 60, 15, 'garrafa'),
('Brahma Lata 350ml',     'cerveja',  5.00, 48, 12, 'lata'),
('Skol Lata 350ml',       'cerveja',  4.50, 48, 12, 'lata'),
('Água Mineral 500ml',    'bebida',   3.00, 30, 10, 'garrafa'),
('Refrigerante Lata',     'bebida',   5.00, 36, 10, 'lata'),
('Porção de Batata Frita','petisco', 18.00,  0,  0, 'porcao'),
('Porção de Frango',      'petisco', 25.00,  0,  0, 'porcao'),
('Queijo Coalho',         'petisco', 15.00,  0,  0, 'porcao');