<?php

namespace Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TestFormType
 * @package AndreySerdjuk\Tests\Form
 */
class TestFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                NumberType::class
            )
            ->add(
                'someText',
                TextareaType::class
            )
            ->add(
                'birthday',
                BirthdayType::class
            )
            ->add(
                'active',
                CheckboxType::class
            )
            ->add(
                'favoriteCars',
                ChoiceType::class,
                [
                    'choices' => [
                        'vw_golf' => 'vw golf',
                        'grand_vitara' => 'grand vitara',
                        'toyota_prado' => 'toyota prado',
                    ],
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestModel::class,
        ]);
    }
}
