<?php

namespace App\Form;

use App\Entity\Klas;
use App\Entity\ZnPr;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZnPrType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priznaArea')
            ->add('pr')
            ->add('class', EntityType::class, [
                'class'    => Klas::class,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ZnPr::class,
        ]);
    }
}
