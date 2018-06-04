<?php
// src/Form/UserProfilType.php
namespace App\Form;

use App\Entity\User;
use App\Form\Model\ChangePassword;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('username', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('oldPassword', PasswordType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('password', PasswordType::class, array('label' => false, 'attr' => array('class' => 'form-control' )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}