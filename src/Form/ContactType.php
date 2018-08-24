<?php
// src/Form/ContactType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mailSubject', TextType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('mailTo', EmailType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
            ->add('mailBody', TextareaType::class, array('label' => false,
                'attr' => array('class' => 'form-control')))
        ;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => Ouvrage::class,
//        ));
//    }
//

}