<?php
require_once __DIR__ . '/config/config.php';

// Função para conectar ao banco de dados
function conectarDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Função para executar query preparada
function executarQuery($sql, $params = [], $types = "") {
    $conn = conectarDB();
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }
    
    if (!empty($params)) {
        if (empty($types)) {
            $types = str_repeat("s", count($params));
        }
        $stmt->bind_param($types, ...$params);
    }
    
    $success = $stmt->execute();
    $result = $stmt->get_result();
    
    $stmt->close();
    $conn->close();
    
    return $result !== false ? $result : $success;
}

// Função para inicializar o banco e tabelas (Migrações)
function inicializarDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
    // Criar banco de dados se não existir
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->query($sql);
    $conn->close();
    
    // Conectar ao banco criado
    $conn = conectarDB();
    
    // Tabela Materiais
    $sql = "CREATE TABLE IF NOT EXISTS materiais (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL UNIQUE,
        sku VARCHAR(50) NOT NULL UNIQUE,
        tipo_lavagem ENUM('A', 'S') NOT NULL,
        descricao TEXT,
        is_active BOOLEAN DEFAULT 1,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->query($sql);
    
    // Tabela Usuarios
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        perfil ENUM('Admin', 'Operador') NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->query($sql);
    
    // Tabela Pedidos (com material_id)
    $sql = "CREATE TABLE IF NOT EXISTS pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        material_id INT,
        cliente VARCHAR(100) NOT NULL,
        tipo_material VARCHAR(100) NOT NULL,
        quantidade DECIMAL(10,2) NOT NULL,
        unidade ENUM('UN', 'KG') NOT NULL DEFAULT 'UN',
        observacao TEXT,
        status ENUM('Recebido', 'Lavagem', 'Expedido') NOT NULL DEFAULT 'Recebido',
        codigo_qr VARCHAR(255),
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (material_id) REFERENCES materiais(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->query($sql);
    
    // Migração: Alterar quantidade para DECIMAL e adicionar unidade
    $result = $conn->query("SHOW COLUMNS FROM pedidos LIKE 'unidade'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE pedidos MODIFY COLUMN quantidade DECIMAL(10,2) NOT NULL");
        $conn->query("ALTER TABLE pedidos ADD COLUMN unidade ENUM('UN', 'KG') NOT NULL DEFAULT 'UN' AFTER quantidade");
    }

    // Garantir que material_id existe (para bases legadas)
    $result = $conn->query("SHOW COLUMNS FROM pedidos LIKE 'material_id'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE pedidos ADD COLUMN material_id INT AFTER id");
        $conn->query("ALTER TABLE pedidos ADD FOREIGN KEY (material_id) REFERENCES materiais(id)");
    }

    // Garantir que status é ENUM
    $conn->query("ALTER TABLE pedidos MODIFY COLUMN status ENUM('Recebido', 'Lavagem', 'Expedido') NOT NULL DEFAULT 'Recebido'");
    
    // Tabela Avaliações
    $sql = "CREATE TABLE IF NOT EXISTS avaliacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        estrelas INT NOT NULL,
        comentario TEXT,
        data_avaliacao DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->query($sql);
    
    // Tabela Sugestões
    $sql = "CREATE TABLE IF NOT EXISTS sugestoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $conn->query($sql);
    
    return $conn;
}
?>
