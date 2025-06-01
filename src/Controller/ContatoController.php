<?php

namespace App\Controller;

use App\Entity\Contato,
    Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response,
    Doctrine\ORM\EntityManagerInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\HttpFoundation\Request,
    App\Form\ContatoType,
    App\Repository\ContatoRepository;

/**
 * Controller da entidade "Contato"
 * @author - Luiz Fernando Petris
 * @since - 02/05/2023
 */
class ContatoController extends AbstractController
{
    /**
     * Renderiza a tela de consulta de contatos
     * @param ContatoRepository $contatoRepository
     * @return Response
     */
    public function index(ContatoRepository $contatoRepository): Response
    {
        $dados = [
            "titulo" => "Consulta de Contatos",
            "contatos" => $contatoRepository->findAll(),
        ];

        return $this->render("contato/index.html.twig", $dados);
    }

    /*
     * Método que realiza o cadastro de um novo contato
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function cadastrar(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $contato = new Contato();
        $formulario = $this->getFormularioFromContato($request, $contato);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $entityManager->persist($contato);
            $entityManager->flush();
            $this->addFlash("info", "Registro incluído com sucesso!");
        }

        return $this->renderForm("contato/form.html.twig", [
            "titulo" => "Adicionar novo Contato",
            "formulario" => $formulario,
        ]);
    }

    /**
     * Retorna o formulário da entidade Contato
     * @param Request $request,
     * @param Contato $contato,
     */
    private function getFormularioFromContato(
        Request $request,
        Contato $contato
    ): FormInterface {
        $formulario = $this->createForm(ContatoType::class, $contato);
        $formulario->handleRequest($request);

        return $formulario;
    }

    /**
     * Realiza a atualização de um contato
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ContatoRepository $contatoRepository
     * @return Response
     */
    public function editar(
        $id,
        Request $request,
        EntityManagerInterface $entityManager,
        ContatoRepository $contatoRepository
    ): Response {
        $contato = $contatoRepository->find($id);
        $formulario = $this->getFormularioFromContato($request, $contato);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $entityManager->flush();
            $this->addFlash("info", "Registro alterado com sucesso!");
        }

        return $this->renderForm("contato/form.html.twig", [
            "titulo" => "Editar Contato",
            "formulario" => $formulario,
        ]);
    }

    /**
     * Realiza a exclusão de um contato
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param ContatoRepository $contatoRepository
     * @return Response
     */
    public function excluir(
        $id,
        EntityManagerInterface $entityManager,
        ContatoRepository $contatoRepository
    ): Response {
        $contato = $contatoRepository->find($id);
        $entityManager->remove($contato);
        $entityManager->flush();

        return $this->redirectToRoute("contato_consultar");
    }
}
