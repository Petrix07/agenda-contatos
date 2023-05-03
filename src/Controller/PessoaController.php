<?php

namespace App\Controller;

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
    const pathConsultaPessoa     = 'pessoa/index.html.twig',
          pathFormCadastroPessoa = 'pessoa/form.html.twig';

    /**
     * Renderiza a tela contendo a consulta de pessoas
     * @param PessoaRepository $oPessoaRepo
     */
    public function index(PessoaRepository $oPessoaRepo): Response
    {
        $aDados = [
            'titulo'  => 'Consulta de Pessoas',
            'pessoas' => $oPessoaRepo->findAll()
        ];
        return $this->render(self::pathConsultaPessoa, $aDados);
    }

    /**
     * Método que realiza o cadastro de uma nova pessoa
     * @param Request $oRequisicao
     * @param EntityManagerInterface $oEm
     * @return Response
     */
    public function cadastrar(Request $oRequisicao, EntityManagerInterface $oEm): Response
    {
        $oPessoa = new Pessoa();
        $oFormulario = $this->getFormularioFromPessoa($oRequisicao, $oPessoa);

        if ($this->permiteExecucaoBanco($oFormulario)) {
            if ($this->validaInformacoesRegistroInclusao($oPessoa, $oEm)) {
                $oEm->persist($oPessoa);
                $oEm->flush();
                $this->addFlash('info', 'Registro incluído com sucesso!');
            } else {
                $this->addFlash('aviso', "Já existe um registro cadastrado com o CPF: {$oPessoa->getCpf()}. Para continuar a inclusão, altere o CPF informado.");
            }
        }

        return $this->renderForm(self::pathFormCadastroPessoa, ['titulo' => 'Adicionar nova Pessoa', 'formulario' => $oFormulario]);
    }

    /**
     * Retorna o formulário da entidade pessoa
     * @param Request $oRequisicao,
     * @param Pessoa $oPessoa,
     */
    private function getFormularioFromPessoa(Request $oRequisicao, Pessoa $oPessoa)
    {
        $oFormulario = $this->createForm(PessoaType::class, $oPessoa);
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
     * Aplica as validações da regra de negócio sob o registro 
     * @param Pessoa $oPessoa
     * @param EntityManagerInterface $oEm
     * @return bool
     */
    private function validaInformacoesRegistroInclusao(Pessoa $oPessoa, EntityManagerInterface $oEm)
    {
        return $this->verificaCpfIsValidoInclusao($oPessoa, $oEm);
    }

    /**
     * Verifica se o CPF informado não está associado a outro registro
     * @param Pessoa $oPessoa
     * @param EntityManagerInterface $oEm
     * @return bool
     */
    private function verificaCpfIsValidoInclusao(Pessoa $oPessoa, EntityManagerInterface $oEm)
    {
        $xRetorno = $oEm->getRepository(Pessoa::class)->findOneBy([
            'cpf' => $oPessoa->getCpf()
        ]);
        return $xRetorno == null;
    }

    /**
     * Método que realiza a alteração de uma pessoa
     * @param int $id
     * @param Request $oRequisicao
     * @param EntityManagerInterface $oEm
     * @param PessoaRepository $oPessoaRepo
     */
    public function editar($id, Request $oRequisicao, EntityManagerInterface $oEm, PessoaRepository $oPessoaRepo): Response
    {
        $oPessoa     = $oPessoaRepo->find($id);
        $oFormulario = $this->getFormularioFromPessoa($oRequisicao, $oPessoa);
        if ($this->permiteExecucaoBanco($oFormulario)) {
            if ($this->validaInformacoesRegistroAlteracao($oPessoa, $oEm)) {
                $oEm->flush();
                $this->addFlash('info', 'Registro alterado com sucesso!');
            } else {
                $this->addFlash('aviso', "Já existe um registro cadastrado com o CPF: {$oPessoa->getCpf()}. Para continuar a alteração, informe outro CPF.");
            }
        }

        return $this->renderForm(self::pathFormCadastroPessoa, ['titulo' => 'Alterar dados Pessoa', 'formulario' => $oFormulario]);
    }

    /**
     * Valida as regras de negócio definidas no contexto de alteração
     * @param Pessoa $oPessoa
     * @param EntityManagerInterface $oEm
     * @return bool
     */
    private function validaInformacoesRegistroAlteracao(Pessoa $oPessoa, EntityManagerInterface $oEm): bool
    {
        return $this->verificaCpfIsValidoAlteracao($oPessoa, $oEm);
    }

    /**
     * Verifica se o CPF informado está associado a outro registro além do presente no formulário de alteração
     * @param Pessoa $oPessoa
     * @param EntityManagerInterface $oEm
     * @return bool
     */
    private function verificaCpfIsValidoAlteracao(Pessoa $oPessoa, EntityManagerInterface $oEm): bool
    {   
        $xRetorno = $oEm->getRepository(Pessoa::class)->findBy([
            'cpf' => $oPessoa->getCpf()
        ]);
        
        return is_array($xRetorno) ? count($xRetorno) <= 1 : true;
    }

    /**
     * Deleta o registro informado
     * @param int $id
     * @param EntityManagerInterface $oEm
     * @param PessoaRepository $oPessoaRepo
     * @return Response
     */
    public function excluir($id, EntityManagerInterface $oEm, PessoaRepository $oPessoaRepo): Response
    {
        $oPessoa = $oPessoaRepo->find($id);
        $oEm->remove($oPessoa);
        $oEm->flush();

        return $this->redirectToRoute('pessoa_consultar');
    }
}
