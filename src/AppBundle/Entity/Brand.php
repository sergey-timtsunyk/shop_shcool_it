<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 */
class Brand
{
    const SERVER_PATH_TO_IMAGE_FOLDER =  'images/brand';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var Product[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product", mappedBy="brand")
     */
    private $products;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Brand
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Brand
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->deleteOldImage($this->getImage());

        $newNameFile = md5($this->getFile()->getPathname()) .
            '_' . time() .
            '.' .$this->getFile()->getClientOriginalExtension();

        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $newNameFile
        );

        // set the path property to the filename where you've saved the file
        $this->image = $newNameFile;

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * @param $name
     */
    private function deleteOldImage($name)
    {
        $fullPath = self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$name;

        if (!empty($name) && file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
}

