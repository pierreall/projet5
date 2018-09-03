<?php
// src/Form/UserEditType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('username', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('roles', CollectionType::class, array(
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'label' => false,
                    'attr' => array('class' => 'form-control'),
                    'choices' => array(
                        'administrateur' => 'ROLE_ADMIN',
                        'client' => 'ROLE_USER',
                    )
                )))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}