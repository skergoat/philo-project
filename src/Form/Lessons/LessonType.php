<?php

namespace App\Form\Lessons;

use App\Entity\Lesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('video', TextType::class, [
                'required' => false
            ])
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            // ->add('order_id', TextType::class)
            // ->add('completed')
            // ->add('Cours')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
