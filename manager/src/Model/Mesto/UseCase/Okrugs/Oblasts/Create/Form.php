<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, array(
                'label' => 'Название Области \ Края ',
                'attr' => [
                    'placeholder' => 'Введите название'
                ]
            ))
            ->add('nomer', Type\TextType::class, array(
                'label' => 'Номер Области \ Края ',
                'attr' => [
                    'placeholder' => 'Введите номер'
                ]
            )) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
