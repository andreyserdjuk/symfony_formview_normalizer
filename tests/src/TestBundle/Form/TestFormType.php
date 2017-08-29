<?php

namespace Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\Extension\Core\Type;

class TestFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            'form',
            Type\FormType::class
            )
            ->add(
                'birthday',
                Type\BirthdayType::class
            )
            ->add(
                'checkbox',
                Type\CheckboxType::class,
                [
                    'label' => 'Symfony is great!',
                ]
            )
            ->add(
                'choice_multiple_expanded',
                Type\ChoiceType::class,
                [
                    'choices' => [
                        'test_value_1' => 'test_label_1',
                        'test_value_2' => 'test_label_2',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'Symfony is great!',
                ]
            )
            ->add(
                'choice_multiple_not_expanded',
                Type\ChoiceType::class,
                [
                    'choices' => [
                        'test_value_1' => 'test_label_1',
                        'test_value_2' => 'test_label_2',
                    ],
                    'multiple' => true,
                    'expanded' => false,
                ]
            )
            ->add(
                'choice',
                Type\ChoiceType::class,
                [
                    'choices' => [
                        'test_value_1' => 'test_label_1',
                        'test_value_2' => 'test_label_2',
                    ],
                    'multiple' => false,
                    'expanded' => false,
                ]
            )
            ->add(
                'collection',
                Type\CollectionType::class
            )
            ->add(
                'country',
                Type\CountryType::class
            )
            ->add(
                'date',
                Type\DateType::class
            )
            ->add(
                'datetime',
                Type\DateTimeType::class
            )
            ->add(
                'email',
                Type\EmailType::class
            )
            ->add(
                'hidden',
                Type\HiddenType::class
            )
            ->add(
                'integer',
                Type\IntegerType::class
            )
            ->add(
                'language',
                Type\LanguageType::class
            )
            ->add(
                'locale',
                Type\LocaleType::class
            )
            ->add(
                'money',
                Type\MoneyType::class
            )
            ->add(
                'number',
                Type\NumberType::class
            )
            ->add(
                'password',
                Type\PasswordType::class
            )
            ->add(
                'percent',
                Type\PercentType::class
            )
            ->add(
                'radio',
                Type\RadioType::class
            )
            ->add(
                'range',
                Type\RangeType::class
            )
            ->add(
                'repeated',
                Type\RepeatedType::class
            )
            ->add(
                'search',
                Type\SearchType::class
            )
            ->add(
                'textarea',
                Type\TextareaType::class
            )
            ->add(
                'text',
                Type\TextType::class
            )
            ->add(
                'time',
                Type\TimeType::class
            )
            ->add(
                'timezone',
                Type\TimezoneType::class
            )
            ->add(
                'url',
                Type\UrlType::class
            )
            ->add(
                'file',
                Type\FileType::class
            )
            ->add(
                'button',
                Type\ButtonType::class
            )
            ->add(
                'submit',
                Type\SubmitType::class
            )
            ->add(
                'reset',
                Type\ResetType::class
            )
            ->add(
                'currency',
                Type\CurrencyType::class
            );
    }
}
