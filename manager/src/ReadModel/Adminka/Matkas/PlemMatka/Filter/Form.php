<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\PlemMatka\Filter;


use App\Model\Adminka\Entity\Matkas\PlemMatka\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Название',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('persona', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'ПерсонНомер',
                'onchange' => 'this.form.submit()',
            ]])

//            ->add('kategoria', Type\ChoiceType::class, [
//                'label' => 'Категория ПлемМатки',
//                'choices' => array_flip($this->kategorias->allList()),
//                'expanded' => true,
//                'multiple' => false
//            ])

            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Активная' => Status::ACTIVE,
                'Архив' => Status::ARCHIVED,
            ], 'required' => false, 'placeholder' => 'Все статусы', 'attr' => ['onchange' => 'this.form.submit()']]);
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
