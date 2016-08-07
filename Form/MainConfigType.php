<?php

namespace CPASimUSante\ItemSelectorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MainConfigType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'items', 'collection', [
                    'type' => new MainConfigItemType(),
                    'by_reference' => false,
                    'prototype' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CPASimUSante\ItemSelectorBundle\Entity\MainConfig',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cpasimusante_itemselectorbundle_mainconfig';
    }
}
