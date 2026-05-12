<?php

require_once __DIR__ . '/../config/config.php';

try {
    // Conexão inicial sem banco selecionado
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';charset=utf8mb4',
        DB_USER,
        DB_PASS
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar banco de dados
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // Selecionar banco
    $pdo->exec("USE " . DB_NAME);

    // Criar tabela usuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Criar tabela fornecedores
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS fornecedores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            cnpj VARCHAR(20),
            telefone VARCHAR(20),
            email VARCHAR(100),
            endereco VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Criar tabela produtos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS produtos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fornecedor_id INT NOT NULL,
            nome VARCHAR(100) NOT NULL,
            descricao TEXT,
            preco DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            CONSTRAINT fk_produtos_fornecedores
            FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");

    // Criar tabela cestas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS cestas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            status VARCHAR(20) DEFAULT 'aberta',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            CONSTRAINT fk_cestas_usuarios
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");

    // Criar tabela cesta_itens
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS cesta_itens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cesta_id INT NOT NULL,
            produto_id INT NOT NULL,
            preco_unitario DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            CONSTRAINT fk_cesta_itens_cestas
            FOREIGN KEY (cesta_id) REFERENCES cestas(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,

            CONSTRAINT fk_cesta_itens_produtos
            FOREIGN KEY (produto_id) REFERENCES produtos(id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE,

            CONSTRAINT uk_cesta_produto UNIQUE (cesta_id, produto_id)
        ) ENGINE=InnoDB
    ");

    // Criar usuário administrador, se ainda não existir
    $senhaAdmin = hash('sha256', '123456');

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute(['admin@email.com']);

    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, senha_hash)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            'Administrador',
            'admin@email.com',
            $senhaAdmin
        ]);
    }

    // Criar fornecedores de exemplo, se ainda não existirem
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM fornecedores");
    $totalFornecedores = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    if ($totalFornecedores == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO fornecedores (nome, cnpj, telefone, email, endereco)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            'Mercado Central',
            '00.000.000/0001-00',
            '(45) 99999-9999',
            'contato@mercadocentral.com',
            'Rua Brasil, 100'
        ]);

        $stmt->execute([
            'Distribuidora Alfa',
            '11.111.111/0001-11',
            '(45) 98888-8888',
            'vendas@alfa.com',
            'Avenida Paraná, 500'
        ]);
    }

    // Criar produtos de exemplo, se ainda não existirem
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM produtos");
    $totalProdutos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    if ($totalProdutos == 0) {
        $stmt = $pdo->query("SELECT id FROM fornecedores ORDER BY id ASC LIMIT 2");
        $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($fornecedores) >= 2) {
            $fornecedor1 = $fornecedores[0]['id'];
            $fornecedor2 = $fornecedores[1]['id'];

            $stmt = $pdo->prepare("
                INSERT INTO produtos (fornecedor_id, nome, descricao, preco)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([
                $fornecedor1,
                'Arroz 5kg',
                'Pacote de arroz tipo 1',
                25.90
            ]);

            $stmt->execute([
                $fornecedor1,
                'Feijão 1kg',
                'Pacote de feijão carioca',
                8.50
            ]);

            $stmt->execute([
                $fornecedor2,
                'Café 500g',
                'Café torrado e moído',
                16.90
            ]);

            $stmt->execute([
                $fornecedor2,
                'Açúcar 1kg',
                'Açúcar cristal',
                5.40
            ]);
        }
    }

    echo "<h2>Instalação concluída com sucesso!</h2>";
    echo "<p>Banco de dados criado: <strong>" . DB_NAME . "</strong></p>";
    echo "<p>Tabelas criadas com sucesso.</p>";
    echo "<p>Usuário administrador criado ou já existente.</p>";
    echo "<hr>";
    echo "<p><strong>Usuário de teste:</strong></p>";
    echo "<p>E-mail: admin@email.com</p>";
    echo "<p>Senha: 123456</p>";
    echo "<hr>";
    echo "<a href='../login.php'>Ir para o login</a>";

} catch (PDOException $e) {
    echo "<h2>Erro na instalação</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}