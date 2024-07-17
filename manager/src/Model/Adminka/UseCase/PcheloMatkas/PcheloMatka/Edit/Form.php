<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

            ->add('content', Type\TextareaType::class, array(
                'label' => 'В БД   внутренняя нумерация или комментарий  - записаны так. Можно изменить!',

            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}