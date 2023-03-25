<?php

namespace App\Form;

use App\Entity\Developpeur;
use App\Entity\Langage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', null, [
                "label" => "Pseudo : ",
                "attr" => ["class" => "input"]
            ])
            ->add('email', null, [
                "label" => "Email : ",
                "attr" => ["class" => "input"]
            ])
            ->add('plainPassword', PasswordType::class, [
                "label" => "Mot de passe : ",
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', "class" => "input"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe est obligatoire',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add("langages", EntityType::class, [
                "label" => "Langage : ",
                "class" => Langage::class,
                "choice_label" => "nom",
                "expanded" => true,
                "multiple" => true,
                "attr" => ["class" => "checkbox"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developpeur::class,
        ]);
    }
}
