<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response;

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
