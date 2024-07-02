<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Uchasties\Uchastie\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;
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
            ->add('nike', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Ник',
                'onchange' => 'this.form.submit()',
            ]])
             ->add('email', Type\TextType::class, ['required' => false, 'attr' => [
                 'placeholder' => 'Email',
                 'onchange' => 'this.form.submit()',
             ]])
            ->add('group', Type\ChoiceType::class, [
                'choices' => array_flip($this->groups->assoc()),
                'required' => false,
                'placeholder' => 'Группы',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Активный' => Status::ACTIVE,
                'Архив' => Status::ARCHIVED,
            ], 'required' => false,
                'placeholder' => 'Все статусы',
                'attr' => ['onchange' => 'this.form.submit()']]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
