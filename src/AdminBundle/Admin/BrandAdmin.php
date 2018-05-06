<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Brand;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BrandAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('name')
           // ->add('description')
           // ->add('image')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $fullPath = '/'.Brand::SERVER_PATH_TO_IMAGE_FOLDER.'/';

        $listMapper
            ->add('id')
            ->add('name')
            ->add('description')
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
        /** @var Brand $brand */
        $brand = $this->getSubject();
        $fullPath = '/'.Brand::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$brand->getImage();

        $formMapper
           // ->add('id')
            ->add('name')
            ->add('description')
            ->add('file', FileType::class, [
                'required' => false,
                'help' => '<img src="'.$fullPath.'" class="admin-preview" />'
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
            ->add('description')
            ->add('image', null)
        ;
    }

    /**
     * @param Brand $brand
     */
    public function prePersist($brand)
    {
        $this->manageFileUpload($brand);
    }

    /**
     * @param Brand $brand
     */
    public function preUpdate($brand)
    {
        $this->manageFileUpload($brand);
    }

    /**
     * @param Brand $brand
     */
    private function manageFileUpload($brand)
    {
        if ($brand->getFile()) {
            $brand->upload();
        }
    }
}
