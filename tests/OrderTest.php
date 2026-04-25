<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/qrcode_helper.php';
require_once __DIR__ . '/../includes/order_service.php';
require_once __DIR__ . '/../conexao.php';

class OrderTest extends TestCase {
    public function testGerarQRCodeLocal() {
        $texto = 'TEST-QR-123';
        $arquivo = 'test_qr.png';
        $caminho = __DIR__ . '/../qrcodes/' . $arquivo;
        
        if (file_exists($caminho)) unlink($caminho);
        $resultado = gerarQRCode($texto, $arquivo);
        $this->assertEquals($arquivo, $resultado);
        $this->assertFileExists($caminho);
        if (file_exists($caminho)) unlink($caminho);
    }

    public function testStatusTransitionValid() {
        $this->assertTrue(OrderService::isValidTransition('Recebido', 'Lavagem'));
        $this->assertTrue(OrderService::isValidTransition('Lavagem', 'Expedido'));
    }

    public function testStatusTransitionInvalid() {
        $this->assertFalse(OrderService::isValidTransition('Recebido', 'Expedido'));
        $this->assertFalse(OrderService::isValidTransition('Expedido', 'Recebido'));
    }

    public function testGetByQRCode() {
        $this->assertNull(OrderService::getByQRCode('INVALID'));
        // We can't easily test valid ones without DB seed, but logic for parsing ID is verifiable
        // if we mock getById or just trust the regex.
    }
}
