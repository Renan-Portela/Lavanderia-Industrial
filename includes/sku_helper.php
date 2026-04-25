<?php
/**
 * SKUHelper Class
 * Manages SKU generation and validation following [CAT]-[MAT]-[SIZ]-[WASH]
 */

class SKUHelper {
    public static function generate($cat, $mat, $siz, $wash) {
        return strtoupper(trim($cat) . '-' . trim($mat) . '-' . trim($siz) . '-' . trim($wash));
    }

    public static function validate($sku) {
        $pattern = '/^[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+-[AS]$/i';
        return (bool)preg_match($pattern, $sku);
    }
}
