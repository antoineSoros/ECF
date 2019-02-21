<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName',null,[
                'attr'=>[
                    'class'=>'form-control',
                    
                ]])
            ->add('userEmail',null,[
                'attr'=>[
                    'class'=>'form-control',
                    
                ]])
            ->add('userPassword', \Symfony\Component\Form\Extension\Core\Type\RepeatedType::class, [
    'type' => \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
    'invalid_message' => 'The password fields must match.',
    'attr'=>['class'=>'form-control'],
                    
                
    'options' => ['attr' => ['class' => 'password-field']],
    'required' => true,
    'first_options'  => ['label' => 'Password'],
    'second_options' => ['label' => 'Repeat Password'],
])
            ->add('SUBMIT', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
