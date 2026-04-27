<?php
/**
 * Helper para geração de QR Codes
 * Usa a biblioteca chillerlan/php-qrcode (instalada via Composer)
 */

require_once __DIR__ . '/../vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function gerarQRCode($texto, $nomeArquivo = null) {
    $qrDir = QR_CODE_DIR;
    
    // Garantir que o diretório existe
    if (!file_exists($qrDir)) {
        mkdir($qrDir, 0777, true);
    }
    
    // Se não foi fornecido nome, gerar um único
    if ($nomeArquivo === null) {
        $nomeArquivo = 'qr_' . md5($texto . time()) . '.png';
    }
    
    $caminhoCompleto = $qrDir . $nomeArquivo;
    
    try {
        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
        ]);
        
        (new QRCode($options))->render($texto, $caminhoCompleto);
        
        return $nomeArquivo;
    } catch (Exception $e) {
        // Fallback para API online em caso de erro crítico local
        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($texto);
        $qrImage = @file_get_contents($url);
        
        if ($qrImage !== false) {
            file_put_contents($caminhoCompleto, $qrImage);
            return $nomeArquivo;
        }
    }
    
    return null;
}

function obterCaminhoQRCode($nomeArquivo) {
    $nomeArquivo = basename($nomeArquivo); // Prevent path traversal
    // Determinar o caminho base baseado na localização da página
    $base_path = (strpos($_SERVER['PHP_SELF'] ?? '', '/pages/') !== false) ? '../' : '';
    return $base_path . 'qrcodes/' . $nomeArquivo;
}
?>
