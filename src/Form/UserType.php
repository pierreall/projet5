<?php
// src/Form/UserType.php
namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('email', EmailType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('username', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
//            ->add('oldPassword', PasswordType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('Password', RepeatedType::class,  array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password', 'attr' => array('class' => 'form-control')),
                'second_options' => array('label' => 'Repeat Password',  'attr' => array('class' => 'form-control')),

            ))
//                ->add('Password', PasswordType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('roles', CollectionType::class, array(
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'label' => false,
                    'attr' => array('class' => 'form-control'),
                    'choices' => array(
                        'administrateur' => 'ROLE_ADMIN',
                        'client' => 'ROLE_USER',
                    )
                )
            ))

            ->add('isActive', TextType::class, array('attr' => array('class' => 'form-control')))
//            ->add('oldPassword', TextType::class,array('attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}