<?php

namespace CPASimUSante\ItemSelectorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemSelectorType extends AbstractType
{
    /**
     * @var int the main resource type
     */
    private $mainResourceType;

    /**
     * @var int the item resource type
     */
    private $resourceType;

    /**
     * @var string the pattern to filter the resource
     */
    private $namePattern;

    public function __construct($mainResourceType = '', $resourceType = '', $namePattern = '')
    {
        $this->mainResourceType = $mainResourceType;
        $this->resourceType = $resourceType;
        $this->namePattern = $namePattern;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', 'hidden', [
                    'data' => 'itemselector',
                ]
            )
            ->add(
                'title', 'text', [
                    'label' => 'title',
                ]
            );
        //To avoid displaying them in ItemSelector Resource creation modal
        if ($options['inside']) {
            $builder
                ->add(
                    'resource', 'resourcePicker', [
                        'required' => true,
                        'attr' => [
                            'data-is-picker-multi-select-allowed' => 0,
                            'data-is-directory-selection-allowed' => 0,
                            'data-type-white-list' => $this->mainResourceType,
                            /*'data-restrict-for-owner'               => 0,*/
                        ],
                        'label' => 'resource_to_open',
                    ]
                )
                ->add(
                    'items', 'collection', [
                        'type' => new ItemType($this->resourceType, $this->namePattern),
                        'by_reference' => false,
                        'prototype' => true,
                        'allow_add' => true,
                        'allow_delete' => true,
                    ]
                )
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CPASimUSante\ItemSelectorBundle\Entity\ItemSelector',
            'translation_domain' => 'resource',
            'inside' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cpasimusante_itemselector';
    }
}
