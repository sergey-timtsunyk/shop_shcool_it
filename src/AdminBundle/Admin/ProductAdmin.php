<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('category')
            ->add('name')
            ->add('count')
            ->add('price')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('category')
            ->add('name')
            ->add('code')
            ->add('description')
            ->add('count')
            ->add('price')
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
        /** @var Product $product */
        $product = $this->getSubject();
        $fullPath = '/'.Product::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$product->getImage();

        $formMapper
            ->add('category')
            ->add('name')
            ->add('code')
            ->add('description')
            ->add('count')
            ->add('price')
            ->add('propertyValues', 'sonata_type_model', ['multiple' => true, 'property' => 'value'])
            ->add('file', FileType::class, [
                'required' => false,
                'help' => '<img height="200" src="'.$fullPath.'" class="admin-preview" />'
            ])
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
            ->add('code')
            ->add('description')
            ->add('count')
            ->add('price')
        ;
    }

    /**
     * @param Product $product
     */
    public function prePersist($product)
    {
        $this->manageFileUpload($product);
    }

    /**
     * @param Product $product
     */
    public function preUpdate($product)
    {
        $this->manageFileUpload($product);
    }

    /**
     * @param Product $product
     */
    private function manageFileUpload($product)
    {
        if ($product->getFile()) {
            $product->upload();
        }
    }
}
