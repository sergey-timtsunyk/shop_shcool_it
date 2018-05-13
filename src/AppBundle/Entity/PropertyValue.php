<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyValue
 *
 * @ORM\Table(name="property_value")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyValueRepository")
 */
class PropertyValue
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
     * @ORM\Column(name="value", type="string", length=50)
     */
    private $value;

    /**
     * @var Property
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Property", inversedBy="propertyValues")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @var Product[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product", mappedBy="propertyValues")
     */
    private $products;

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
     * Set value
     *
     * @param string $value
     *
     * @return PropertyValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Property $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function __toString()
    {
        return $this->value ?: '';
    }
}

