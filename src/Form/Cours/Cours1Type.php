<?php

namespace App\Form\Cours;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
// use App\Form\Cours\CoursCardsImageFormType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Cours1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cours = $options['data'] ?? null;
        $isEdit = $cours && $cours->getId(); 

        $builder
            ->add('titre', TextType::class)
            ->add('level', TextType::class)
            ->add('duration', TextType::class)
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#e2e2e2',
                    'toolbar' => 'full',
                    'required' => true
                ],
            ])
        ;
        $imageConstraints = [
            new Image([
                'maxSize' => '5M',
            ])
        ];
        if (!$isEdit || !$cours->getMainImage()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Veuillez charger une image svp',
            ]);
        }
        $builder
            ->add('mainImage', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints
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
