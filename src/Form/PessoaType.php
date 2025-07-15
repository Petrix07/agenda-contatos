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
class PessoaType extends AbstractType
{
    /**
     * Constrói o formulário de cadastro da entidade "Pessoa"
     * @param FormBuilderInterface
     * @param array
     */
    public function buildForm(
        FormBuilderInterface $oBuilder,
        array $aOptions
    ): void {
        $oBuilder
            ->add("nome", TextType::class, ["label" => "Nome:"])
            ->add("cpf", TextType::class, [
                "label" => "CPF:",
                "attr" => ["maxlength" => 14],
            ])
            ->add("Salvar", SubmitType::class);
    }
}
