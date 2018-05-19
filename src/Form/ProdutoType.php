<?php

namespace App\Form;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => "Nome do produto",
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('preco', TextType::class, [
                'label' => "Preço do produto",
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('descricao', TextareaType::class, [
                'label' => 'Descrição do produto',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('enviar', SubmitType::class, ['label' => "salvar",
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->add('voltar', SubmitType::class, ['label' => "voltar",
                'attr' => [
                    'class' => 'btn bt-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
