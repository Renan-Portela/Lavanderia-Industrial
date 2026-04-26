<?php
/**
 * OrderService Class
 * Manages order status transitions and business rules
 */

require_once __DIR__ . '/../conexao.php';

class OrderService {
    private static $transitions = [
        'Recebido' => ['Lavagem'],
        'Lavagem'  => ['Expedido'],
        'Expedido' => []
    ];

    public static function isValidTransition($current, $next) {
        if (!isset(self::$transitions[$current])) {
            return false;
        }
        return in_array($next, self::$transitions[$current]);
    }

    public static function validateHybridData($data) {
        return !empty($data['material_id']);
    }

    public static function updateStatus($id, $nextStatus) {
        $order = self::getById($id);
        if (!$order) return false;

        if (!self::isValidTransition($order['status'], $nextStatus)) {
            return false;
        }

        return executarQuery("UPDATE pedidos SET status = ? WHERE id = ?", [$nextStatus, $id], "si");
    }

    public static function getById($id) {
        $result = executarQuery("SELECT * FROM pedidos WHERE id = ?", [$id], "i");
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    public static function getByQRCode($codigo) {
        // Formato esperado: PEDIDO-123
        if (preg_match('/^PEDIDO-(\d+)$/', $codigo, $matches)) {
            return self::getById($matches[1]);
        }
        return null;
    }
}
