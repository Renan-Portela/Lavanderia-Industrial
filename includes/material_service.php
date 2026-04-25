<?php
/**
 * MaterialService Class
 * CRUD for materials with soft-delete support
 */

require_once __DIR__ . '/../conexao.php';

class MaterialService {
    public static function getAll($activeOnly = true) {
        $sql = "SELECT * FROM materiais";
        if ($activeOnly) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY nome ASC";
        
        $result = executarQuery($sql);
        $materials = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $materials[] = $row;
            }
        }
        return $materials;
    }

    public static function getById($id) {
        $result = executarQuery("SELECT * FROM materiais WHERE id = ?", [$id], "i");
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    public static function create($data) {
        $sql = "INSERT INTO materiais (nome, sku, tipo_lavagem, descricao) VALUES (?, ?, ?, ?)";
        $params = [$data['nome'], $data['sku'], $data['tipo_lavagem'], $data['descricao'] ?? ''];
        return executarQuery($sql, $params, "ssss");
    }

    public static function update($id, $data) {
        $sql = "UPDATE materiais SET nome = ?, sku = ?, tipo_lavagem = ?, descricao = ? WHERE id = ?";
        $params = [$data['nome'], $data['sku'], $data['tipo_lavagem'], $data['descricao'] ?? '', $id];
        return executarQuery($sql, $params, "ssssi");
    }

    public static function delete($id) {
        // Soft delete
        return executarQuery("UPDATE materiais SET is_active = 0 WHERE id = ?", [$id], "i");
    }
}
