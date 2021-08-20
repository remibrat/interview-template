<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\UniqueEmail;
use App\Validator\PasswordDigit;
use App\Validator\PasswordLength;
use App\Validator\PasswordSpecial;
use App\Validator\PasswordLowercase;
use App\Validator\PasswordUppercase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new UniqueEmail(),
                    new Email(),
                    new NotBlank()
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match',
                'constraints' => [
                    new PasswordLength(),
                    new PasswordUppercase(),
                    new PasswordDigit(),
                    new PasswordSpecial(),
                    new PasswordLowercase()
                ],
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
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
