<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends AbstractAdmin
{
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        return $query;
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('parent')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('parent')
            ->add('properties', 'entity')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $datagrid = $this->getDatagrid();
        $queryBuilder = $datagrid->getQuery();
        $queryBuilder
            ->andWhere($queryBuilder->expr()->isNull($queryBuilder->getRootAlias() . '.parent'));

        $formMapper
            ->add('name')
            ->add('parent', 'sonata_type_model', [
                'required' => false,
                'query' => $queryBuilder
                ])
            ->add('properties')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('parent')
            ->add('properties', 'entity', ['associated_property' => 'name'])
        ;
    }

    /**
     * @param Category $category
     */
    public function prePersist($category)
    {
        $this->updateProperties($category);
    }

    /**
     * @param Category $category
     */
    public function preUpdate($category)
    {
        $this->updateProperties($category);
    }

    /**
     * @param Category $category
     */
    private function updateProperties(Category $category)
    {
        foreach ($category->getProperties() as $property) {
            $property->getCategories()->removeElement($category);
            $property->addCategory($category);
        }
    }
}
