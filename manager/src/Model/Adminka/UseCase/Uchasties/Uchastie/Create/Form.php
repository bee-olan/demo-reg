<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Uchastie\Create;

use App\ReadModel\Adminka\Uchasties\GroupFetcher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $groups;

    public function __construct(GroupFetcher $groups)
    {
        $this->groups = $groups;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('group', Type\ChoiceType::class, [
                'label' => '1. Выбрать группу   ',
                'choices' => array_flip($this->groups->assoc()),
                'expanded' => true,
                'multiple' => false
                ])
            ->add('nike', Type\TextType::class, array(
                'label' => '2. Ваш ник',
                'attr' => [
                    'placeholder' => 'Введите ник'
                ]
            ))    
            ->add('firstName', Type\TextType::class, ['label' => 'Имя'])
            ->add('lastName', Type\TextType::class, ['label' => 'Фамилия'])
            ->add('email', Type\EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
