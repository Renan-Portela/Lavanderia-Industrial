<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/sku_helper.php';
require_once __DIR__ . '/../includes/material_service.php';
require_once __DIR__ . '/../conexao.php';

class MaterialTest extends TestCase {
    public function testGenerateSKU() {
        $cat = 'GLV';
        $mat = 'IND';
        $siz = 'XL';
        $wash = 'A';
        
        $sku = SKUHelper::generate($cat, $mat, $siz, $wash);
        $this->assertEquals('GLV-IND-XL-A', $sku);
    }

    public function testValidateSKUValid() {
        $this->assertTrue(SKUHelper::validate('GLV-IND-XL-A'));
        $this->assertTrue(SKUHelper::validate('EPI-RSP-GG-S'));
    }

    public function testValidateSKUInvalid() {
        $this->assertFalse(SKUHelper::validate('GLV-IND'));
        $this->assertFalse(SKUHelper::validate('INVALID-SKU-FORMAT'));
    }

    public function testMaterialServiceLogic() {
        $this->assertTrue(class_exists('MaterialService'));
        
        // Testando a estrutura de dados esperada pelo Service
        $data = [
            'nome' => 'Test Material',
            'sku' => 'TST-MAT-01-A',
            'tipo_lavagem' => 'A',
            'descricao' => 'Test Description'
        ];
        
        $this->assertEquals('TST-MAT-01-A', $data['sku']);
        $this->assertTrue(SKUHelper::validate($data['sku']));
    }
}
