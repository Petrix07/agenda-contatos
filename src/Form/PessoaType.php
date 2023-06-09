<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\Extension\Core\Type\TextType,
    Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Classe destinada a criação de formulários da entidade "Pessoa"
 * @author - Luiz Fernando Petris
 * @since - 02/05/2023
 */
class PessoaType extends AbstractType {

    /**
     * Constrói o formulário de cadastro da entidade "Pessoa"
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $oBuilder, array $aOptions)
    {
        $oBuilder
            ->add('nome',   TextType::class,  ['label' => 'Nome:'])
            ->add('cpf',    TextType::class,  ['label' => 'CPF:'])
            ->add('Salvar', SubmitType::class);
    }

}