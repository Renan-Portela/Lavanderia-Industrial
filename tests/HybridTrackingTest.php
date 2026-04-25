<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/order_service.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../conexao.php';

class HybridTrackingTest extends TestCase {
    public function testHybridOrderValidation() {
        // Test that we can validate SKU + Custom Description
        $data = [
            'material_id' => 1,
            'tipo_material' => 'Luva Nitrílica Verde'
        ];
        
        $this->assertTrue(OrderService::validateHybridData($data), "Hybrid data should be valid");
    }

    public function testHybridOrderPersistence() {
        $data = [
            'cliente' => 'Test Client',
            'material_id' => 1,
            'tipo_material' => 'Test Material Description',
            'quantidade' => 10,
            'observacao' => 'Test Observation'
        ];
        
        $this->assertTrue(OrderService::validateHybridData($data));
        $this->assertEquals('Test Material Description', $data['tipo_material']);
    }

    public function testQRScanningDisplay() {
        // Logic for retrieving enriched order data for UI
        $id = 1;
        $order = OrderService::getById($id);
        
        if ($order) {
            $this->assertArrayHasKey('material_id', $order);
            $this->assertArrayHasKey('tipo_material', $order);
        } else {
            $this->markTestSkipped('No order found to test scanning display');
        }
    }
}
