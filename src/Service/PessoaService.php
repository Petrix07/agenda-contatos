<?php

namespace App\Service;

class PessoaService
{
    /**
     * Valida o formato do CPF
     * @param string $cpf
     */
    public function validaFormatoCpf(string $cpf): bool
    {
        $pattern = "/^\d{3}\.\d{3}\.\d{3}-\d{2}$/";
        return preg_match($pattern, $cpf) == 1 ? true : false;
    }
}
