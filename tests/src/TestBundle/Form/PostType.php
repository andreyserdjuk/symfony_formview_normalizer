<?php

namespace Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Entity\Post;
use Tests\AndreySerdjuk\SymfonyFormViewNormalizer\src\TestBundle\Entity\User;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'name',
                ]
            )
            ->add(
                'content',
                TextType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
