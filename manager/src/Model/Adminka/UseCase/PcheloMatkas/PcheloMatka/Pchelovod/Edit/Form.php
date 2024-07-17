<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod\Edit;

use App\ReadModel\Adminka\PcheloMatkas\PchelosezonFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $pchelosezons;

    public function __construct( PchelosezonFetcher $pchelosezons)
    {
        $this->pchelosezons = $pchelosezons;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pchelosezons', Type\ChoiceType::class, [
                'choices' => array_flip($this->pchelosezons->listOfPcheloMatka($options['pchelomatka'])),
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['pchelomatka']);
    }
}
