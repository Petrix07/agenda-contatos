<?php

namespace App\Controller;

use App\Service\PessoaService;
use App\Entity\Pessoa,
    App\Form\PessoaType,
    Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response,
    Doctrine\ORM\EntityManagerInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\HttpFoundation\Request,
    App\Repository\PessoaRepository;

/**
 * Controller da entidade "Pessoa"
 * @author - Luiz Fernando Petris
 * @since - 02/05/2023
 */
class PessoaController extends AbstractController
{
    /**
     * Renderiza a tela contendo a consulta de pessoas
     * @param PessoaRepository $pessoaRepository
     */
    public function index(PessoaRepository $pessoaRepository): Response
    {
        $dados = [
            "titulo" => "Consulta de Pessoas",
            "pessoas" => $pessoaRepository->findAll(),
        ];

        return $this->render("pessoa/index.html.twig", $dados);
    }

    /**
     * Método que realiza o cadastro de uma nova pessoa
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function cadastrar(
        Request $request,
        PessoaService $pessoaService,
        EntityManagerInterface $entityManager
    ): Response {
        $pessoa = new Pessoa();
        $formulario = $this->getFormularioFromPessoa($request, $pessoa);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            if (!$pessoaService->validaFormatoCpf($pessoa->getCpf())) {
                $this->addFlash(
                    "aviso",
                    "O formato do CPF inserido não é válido. Para continuar a alteração, informe outro CPF."
                );
            } elseif (!$this->verificaCpfExiste($pessoa, $entityManager)) {
                $this->addFlash(
                    "aviso",
                    "Já existe um registro cadastrado com o CPF: {$pessoa->getCpf()}. Para continuar a inclusão, altere o CPF informado."
                );
            } else {
                $entityManager->persist($pessoa);
                $entityManager->flush();
                $this->addFlash("info", "Registro incluído com sucesso!");
            }
        }

        return $this->renderForm("pessoa/form.html.twig", [
            "titulo" => "Adicionar nova Pessoa",
            "formulario" => $formulario,
        ]);
    }

    /**
     * Retorna o formulário da entidade pessoa
     * @param Request $request,
     * @param Pessoa $pessoa,
     */
    private function getFormularioFromPessoa(
        Request $request,
        Pessoa $pessoa
    ): FormInterface {
        $formulario = $this->createForm(PessoaType::class, $pessoa);
        $formulario->handleRequest($request);

        return $formulario;
    }

    /**
     * Método que realiza a alteração de uma pessoa
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PessoaRepository $pessoaRepository
     */
    public function editar(
        $id,
        Request $request,
        PessoaService $pessoaService,
        EntityManagerInterface $entityManager,
        PessoaRepository $pessoaRepository
    ): Response {
        $pessoa = $pessoaRepository->find($id);
        $formulario = $this->getFormularioFromPessoa($request, $pessoa);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            if (!$pessoaService->validaFormatoCpf($pessoa->getCpf())) {
                $this->addFlash(
                    "aviso",
                    "O formato do CPF inserido não é válido. Para continuar a alteração, informe outro CPF."
                );
            } elseif (!$this->verificaCpfExiste($pessoa, $entityManager)) {
                $this->addFlash(
                    "aviso",
                    "Já existe um registro cadastrado com o CPF: {$pessoa->getCpf()}. Para continuar a alteração, informe outro CPF."
                );
            } else {
                $entityManager->flush();
                $this->addFlash("info", "Registro alterado com sucesso!");
            }
        }

        return $this->renderForm("pessoa/form.html.twig", [
            "titulo" => "Alterar dados Pessoa",
            "formulario" => $formulario,
        ]);
    }

    /**
     * Verifica se o CPF informado não está associado a outro registro
     * @param Pessoa $pessoa
     * @param EntityManagerInterface $entityManager
     * @return bool
     */
    private function verificaCpfExiste(
        Pessoa $pessoa,
        EntityManagerInterface $entityManager
    ): bool {
        $resultado = $entityManager->getRepository(Pessoa::class)->findOneBy([
            "cpf" => $pessoa->getCpf(),
        ]);

        if (
            $resultado != null ||
            ($resultado && $resultado->getCpf() == $pessoa->getCpf())
        ) {
            return false;
        }

        return true;
    }

    /**
     * Deleta o registro informado
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param PessoaRepository $pessoaRepository
     * @return Response
     */
    public function excluir(
        $id,
        EntityManagerInterface $entityManager,
        PessoaRepository $pessoaRepository
    ): Response {
        $pessoa = $pessoaRepository->find($id);
        $entityManager->remove($pessoa);
        $entityManager->flush();

        return $this->redirectToRoute("pessoa_consultar");
    }
}
