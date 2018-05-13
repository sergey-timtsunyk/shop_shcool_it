<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyRepository")
 */
class Property
{
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var Category[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="properties")
     * @ORM\JoinTable(name="property_to_category")
     */
    private $categories;

    /**
     * @var PropertyValue[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PropertyValue", mappedBy="property")
     */
    private $propertyValues;

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
     * Set name
     *
     * @param string $name
     *
     * @return Property
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
     * @return ArrayCollection|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function addCategory($category)
    {
        return $this->categories[] = $category;
    }

    /**
     * @return PropertyValue[]
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name ?: '';
    }
}

