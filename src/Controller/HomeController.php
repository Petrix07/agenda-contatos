<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response;

/**
 * Controller da tela de HomePage do sistema
 * @author - Luiz Fernando Petris
 * @since - 03/04/2023
 */
class HomeController extends AbstractController
{

    /**
     * @inheritdoc
     */
    public function index(): Response
    {
        return $this->render('home\index.html.twig');
    }
}
