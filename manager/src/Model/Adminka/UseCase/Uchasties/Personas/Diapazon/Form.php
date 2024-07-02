<?php


namespace App\Model\Adminka\UseCase\Uchasties\Personas\Diapazon;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('nomer', Type\IntegerType::class, array(
        //         'label' => 'Вы выбрали персональный номер'
        //     ));
        $builder->add('diapazon', ChoiceType::class, array(
            'label' => 'Выбираем : ',
            'choices'  => array(
//
                'от 1 до 50' => 1,
                'от 51 до 100' => 2,
                'от 101 до 150' => 3,
                'от 151 до 200' => 4,
                'от 201 до 250' => 5,
                'от 251 до 300' => 6,
            ),
            'expanded' => true,
            'multiple' => false
//,
//            'attr' => ['onchange' => 'this.form.submit()']
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
