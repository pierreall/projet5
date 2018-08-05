<?php
// src/Form/OuvrageType.php
namespace App\Form;

use App\Entity\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class OuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('sub_title', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('genre', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('resume', TextareaType::class,  array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('editor', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('isbnumber', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('dewey', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('picture', FileType::class, array( 'required' => false,
                'data_class' => null, 'label' => false,
                'attr' => array('class' => 'form-control-file')/*, 'empty_data' => '67ed4725ccd826c68edc65f1313f7994.jpeg'*/))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ouvrage::class,
        ));
    }


}