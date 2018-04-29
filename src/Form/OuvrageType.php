<?php
// src/Form/OuvrageType.php
namespace App\Form;

use App\Entity\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('resume', TextareaType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('editor', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('isbnumber', IntegerType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('picture', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ouvrage::class,
        ));
    }
}