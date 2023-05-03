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
 * Controller da entidade "COntato"
 * @author - Luiz Fernando Petris 
 * @since - 02/05/2023
 */
class ContatoController extends AbstractController
{
    const pathConsultaContato     = 'contato/index.html.twig',
          pathFormCadastroContato = 'contato/form.html.twig';
    /**
     * Renderiza a tela de consulta de contatos
     * @param ContatoRepository $oContatoRepo
     * @return Response
     */
    public function index(ContatoRepository $oContatoRepo): Response
    {
        $aDados = [
            'titulo'   => "Consulta de Contatos",
            'contatos' => $oContatoRepo->findAll()
        ];

        return $this->render(self::pathConsultaContato, $aDados);
    }

    /*
    * Método que realiza o cadastro de um novo contato
    * @param Request $oRequisicao
    * @param EntityManagerInterface $oEm
    * @return Response
    */
    public function cadastrar(Request $oRequisicao, EntityManagerInterface $oEm): Response
    {
        $oContato = new Contato();
        $oFormulario = $this->getFormularioFromContato($oRequisicao, $oContato);

        if ($this->permiteExecucaoBanco($oFormulario)) {
            $oEm->persist($oContato);
            $oEm->flush();
            $this->addFlash('info', 'Registro incluído com sucesso!');
        }

        return $this->renderForm(self::pathFormCadastroContato, ['titulo' => 'Adicionar novo Contato', 'formulario' => $oFormulario]);
    }

    /**
     * Retorna o formulário da entidade Contato
     * @param Request $oRequisicao,
     * @param Contato $oContato,
     */
    private function getFormularioFromContato(Request $oRequisicao, Contato $oContato)
    {
        $oFormulario = $this->createForm(ContatoType::class, $oContato);
        $oFormulario->handleRequest($oRequisicao);

        return $oFormulario;
    }

    /**
     * Verifica se a condição do formulário permite a execução no banco de dados
     * @param FormInterface $oFormulario
     * @return bool
     */
    private function permiteExecucaoBanco(FormInterface $oFormulario): bool
    {
        return $oFormulario->isSubmitted() && $oFormulario->isValid();
    }

    /**
     *  Realiza a atualização de um contato
     * @param int $id
     * @param Request $oRequisicao
     * @param EntityManagerInterface $oEm
     * @param ContatoRepository $oContatoRepo
     * @return Response
     */
    public function editar($id, Request $oRequisicao, EntityManagerInterface $oEm, ContatoRepository $oContatoRepo): Response
    {
        $oContato = $oContatoRepo->find($id);
        $oFormulario = $this->getFormularioFromContato($oRequisicao, $oContato);
        if ($this->permiteExecucaoBanco($oFormulario)) {
            $oEm->flush();
            $this->addFlash('info', 'Registro alterado com sucesso!');

        }

        return $this->renderForm(self::pathFormCadastroContato, ['titulo' => 'Editar Contato', 'formulario' => $oFormulario]);
    }

    /**
     * Realiza a exclusão de um contato
     * @param int $id
     * @param EntityManagerInterface $oEm
     * @param ContatoRepository $oContatoRepo
     * @return Response
     */
    public function excluir($id, EntityManagerInterface $oEm, ContatoRepository $oContatoRepo): Response
    {
        $oContato = $oContatoRepo->find($id);
        $oEm->remove($oContato);
        $oEm->flush();

        return $this->redirectToRoute('contato_consultar');
    }
}
