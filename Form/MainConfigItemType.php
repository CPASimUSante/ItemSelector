<?php

namespace CPASimUSante\ItemSelectorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MainConfigItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mainResourceType', 'entity', [
                'label' => 'Ressource principale',
                'empty_value' => 'Choisissez une ressource',
                'class' => 'Claroline\CoreBundle\Entity\Resource\ResourceType',
                'choice_label' => 'name',
            ])
            ->add('resourceType', 'entity', [
                'label' => 'Type d\'item',
                'class' => 'Claroline\CoreBundle\Entity\Resource\ResourceType',
                'choice_label' => 'name',
            ])
            ->add('workspace', 'entity', [
                'label' => 'Workspace',
                'class' => 'Claroline\CoreBundle\Entity\Workspace\Workspace',
                'choice_label' => 'name',
            ])
            ->add('namePattern', 'text', [
                'empty_data' => null,
                'required' => false,
                'label' => 'Pattern',
            ])
            ->add('itemCount', 'integer', [
                'empty_data' => 3,
                'label' => 'Nombre maximum d\'items',
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CPASimUSante\ItemSelectorBundle\Entity\MainConfigItem',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cpasimusante_itemselectorbundle_mainconfigitem';
    }
}
