<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Create;

use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use App\ReadModel\Drevos\Rass\RasFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $kategorias;
    private $rasaFes;

    public function __construct(KategoriaFetcher $kategorias, RasFetcher $rasaFes)
    {
        $this->kategorias = $kategorias;
        $this->rasaFes = $rasaFes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', Type\TextareaType::class, [
                'label' => '1. Комментарий к  Пчело-Матке  ',
                'required' => false,
                'attr' => ['rows' => 3,
                    'placeholder' => '  или нумерация'
                ]])

            ->add('personNom', Type\IntegerType::class, [
                'label' => '2. Номер матки',
            ])

            ->add('date_vixod', Type\DateType::class, [
                'label' => '3. Дата выхода ПчелоМатки  ',
                'required' => false,
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])

            ->add('rasa', Type\ChoiceType::class, [
                'label' => '4. Выбор расы ',
                'choices' => array_flip($this->rasaFes->assocTitle()),
//                'expanded' => true,
                'multiple' => false
            ])

            ->add('kategoria', Type\ChoiceType::class, [
                'label' => '5. Категория ',
                'choices' => array_flip($this->kategorias->allList()),
                'expanded' => true,
                'multiple' => false
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}