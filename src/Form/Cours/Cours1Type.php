<?php

namespace App\Form\Cours;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
// use App\Form\Cours\CoursCardsImageFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Cours1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('level', TextType::class)
            ->add('duration', TextType::class)
            ->add('description', TextareaType::class)
            ->add('mainImage', FileType::class, [
                'mapped' => false,
                'required' => false // provisoire 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
