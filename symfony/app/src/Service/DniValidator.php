<?php

namespace App\Service;

class DniValidator
{
    /**
     * Regla simple de ejemplo:
     * - Solo dígitos
     * - Longitud entre 7 y 9
     */
    public function isValid(string $dni): bool
    {
        return (bool) preg_match('/^\d{7,9}$/', $dni);
    }
}
