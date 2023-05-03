<?php

namespace App\Form;

use App\Entity\Pessoa,
    Symfony\Bridge\Doctrine\Form\Type\EntityType,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\Extension\Core\Type\TextType,
    Symfony\Component\Form\Extension\Core\Type\IntegerType,
    Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Classe destinada a criação de formulários da entidade "Contato"
 * @author - Luiz Fernando Petris
 * @since - 02/05/2023
 */
class ContatoType extends AbstractType
{
   /*
    * Constrói o formulário de cadastro da entidade "Contato"
    */
    public function buildForm(FormBuilderInterface $oBuilder, array $aOptions)
    {
        $oBuilder
            ->add('tipo',      IntegerType::class,  ['label' => 'Tipo:'])
            ->add('descricao', TextType::class,     ['label' => 'Descrição:'])
            ->add('pessoa',    EntityType::class,   ['class' => Pessoa::class, 'choice_label' => 'nome', 'label' => 'Pessoa:'])
            ->add('Salvar',    SubmitType::class);
    }
}
