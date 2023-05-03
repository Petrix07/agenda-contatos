<?php

namespace App\Controller;

use App\Form\PessoaType,
    Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response,
    Doctrine\ORM\EntityManagerInterface,
    Symfony\Component\Routing\Annotation\Route;


/**
 * Controller da entidade "Pessoa"
 * @author - Luiz Fernando Petris 
 * @since - 02/05/2023
 */
class PessoaController extends AbstractController
{
    const pathFormCadastroPessoa = 'pessoa/form.html.twig';

    public function index(EntityManagerInterface $oEm): Response
    {
        $oEm;
        return new Response();
    }

    /**
     * @Route("/pessoa/cadastrar", name="categoria_cadastrar")
     */
    public function cadastrar(): Response
    {
        return $this->renderForm(self::pathFormCadastroPessoa, $this->getDadosFormularioCadastroPessoa());
    }

    private function getDadosFormularioCadastroPessoa(): array {
        return [
            'titulo'     => 'Adicionar nova Pessoa',
            'formulario' => $this->createForm(PessoaType::class)
        ];
    }
}
