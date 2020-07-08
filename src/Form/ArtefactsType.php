<?php

namespace App\Form;

use App\Entity\Artefacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ArtefactsType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array( 'label' => 'Название артефакта' ))
            ->add('date', null, array( 'label' => 'Дата обнаружения' ))
            ->add('place', null, array( 'label' => 'Место обнаружения' ))
            ->add('period', null, array( 'label' => 'Эпоха артефакта' ))
            ->add('klas', null, array( 'label' => 'Класс артефакта' ))
            ->add('kl_pr', null, array( 'label' => 'Признаки артефакта' ))
            ->add('zn_pr', null, array( 'label' => 'Значения признаков артефакта' ))
        ;

        $user = $this->security->getUser();

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $artefact = $event->getData();
            $form = $event->getForm();

            if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                $form->add('user', null, array( 'label' => 'Кем найден' ));
            } else {
                $artefact->setUser($user);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artefacts::class,
        ]);
    }
}
