<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response,
    Doctrine\ORM\EntityManagerInterface;


/**
 * Controller da entidade "Pessoa"
 * @author - Luiz Fernando Petris 
 * @since - 02/05/2023
 */
class PessoaController extends AbstractController
{
    /**
     * @Route("/", name="pessoa_index")
     */
    public function index(EntityManagerInterface $oEm): Response
    {
        $oEm;
        return new Response();
    }
}
