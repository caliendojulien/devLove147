<?php

namespace App\Form;

use App\Entity\Langage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LangageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                "label" => "Nom : ",
                "attr" => ["class" => "input"]
            ])
            ->add('image', null, [
                "label" => "Image : ",
                "attr" => ["class" => "input"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Langage::class,
        ]);
    }
}
