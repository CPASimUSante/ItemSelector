<?php

namespace CPASimUSante\ItemSelectorBundle\Form;

use Claroline\CoreBundle\Repository\ResourceNodeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * @var int the resource type ( Exercise)
     */
    private $resourceType;

    /**
     * @var string the pattern to filter the resource
     */
    private $namePattern;

    public function __construct($resourceType, $namePattern = '')
    {
        $this->resourceType = $resourceType;
        $this->namePattern = $namePattern;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $resourceType = $this->resourceType;
        $namePattern = $this->namePattern;
        $orderedBy = 'name';

        $builder
            ->add(
                'resourceNode', 'entity', [
                    'label' => 'Code',
                    'class' => 'ClarolineCoreBundle:Resource\ResourceNode',
                    'choice_label' => 'name',
                    'empty_value' => 'Choisissez un item',
                    'query_builder' => function (ResourceNodeRepository $er) use ($resourceType, $namePattern, $orderedBy) {
                        $qb = $er->createQueryBuilder('rn')
                            ->where('rn.resourceType = :resourcetype')
                            ->setParameter('resourcetype', $resourceType);
                        if ($namePattern != '') {
                            $qb->andWhere('rn.name LIKE :namePattern')
                                ->setParameter('namePattern', $namePattern.'%');
                        }
                        $qb->orderBy('rn.'.$orderedBy, 'ASC');

                        return $qb;
                    },
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CPASimUSante\ItemSelectorBundle\Entity\Item',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cpasimusante_itemselectorbundle_item';
    }
}
