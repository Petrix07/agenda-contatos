<?php

namespace App\Controller;

use App\Entity\Pessoa,
    App\Form\PessoaType,
    Symfony\Bundle\FrameworkBundle\Controller\AbstractController,
    Symfony\Component\HttpFoundation\Response,
    Doctrine\ORM\EntityManagerInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\HttpFoundation\Request;
use App\Repository\PessoaRepository;

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
     * @param Request $oRequisicao
     * @param EntityManagerInterface $oEm
     * @return Response
     */
    public function cadastrar(Request $oRequisicao, EntityManagerInterface $oEm): Response
    {
        $oPessoa = new Pessoa();
        $oFormulario = $this->createForm(PessoaType::class, $oPessoa);
        $oFormulario->handleRequest($oRequisicao);

        if ($this->permiteExecucaoBanco($oFormulario)) {
            if ($this->validaInformacoesRegistro($oPessoa, $oEm)) {
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
     * Verifica se a condição do formulário permite a execução no banco de dados
     * @return bool
     */
    private function permiteExecucaoBanco(FormInterface $oFormulario): bool
    {
        return $oFormulario->isSubmitted() && $oFormulario->isValid();
    }

    /**
     * Aplica as validações da regra de negócio sob o registro 
     * @return bool
     */
    private function validaInformacoesRegistro(Pessoa $oPessoa, EntityManagerInterface $oEm)
    {
        return $this->isNovoRegistroCpf($oPessoa, $oEm);
    }

    /**
     * Verifica se o CPF informado não está associado a outro registro
     * @return bool
     */
    private function isNovoRegistroCpf(Pessoa $oPessoa, EntityManagerInterface $oEm)
    {
        $xRetorno = $oEm->getRepository(Pessoa::class)->findOneBy([
            'cpf' => $oPessoa->getCpf(),
        ]);
        return $xRetorno == null;
    }
}
