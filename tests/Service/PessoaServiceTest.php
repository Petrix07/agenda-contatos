<?php

namespace App\Tests\Service;

use App\Service\PessoaService;
use PHPUnit\Framework\TestCase;

class PessoaServiceTest extends TestCase
{
    public function testDeveriaInvalidarFormatoCpf(): void
    {
        $pessoaService = new PessoaService();
        $cpf = $pessoaService->validaFormatoCpf("867.750.090-101");

        $this->assertFalse($cpf);
    }

    public function testDeveriaValidarFormatoCpf(): void
    {
        $pessoaService = new PessoaService();
        $cpf = $pessoaService->validaFormatoCpf("867.750.090-11");

        $this->assertTrue($cpf);
    }
}
