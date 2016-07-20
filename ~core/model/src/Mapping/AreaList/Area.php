<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\AreaList;

/**
 * Area Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Area
{
    /**
     * @var string $id ID
     */
    private $id;

    /**
     * @var string $name Name
     */
    private $name;

    /**
     * @var bool $regionalName Regional name
     */
    private $regionalName;

    /**
     * @var bool $warehouse Has warehouse?
     */
    private $warehouse;

    /**
     * @var bool $extraCityPickup Has extra city pickup?
     */
    private $extraCityPickup;

    /**
     * @var bool $extraCityShipping Has extra city shipping?
     */
    private $extraCityShipping;

    /**
     * @var bool $regionalAreaPickup Has regional area pickup?
     */
    private $regionalAreaPickup;

    /**
     * @var bool $regionalAreaShipping Has regional area shipping?
     */
    private $regionalAreaShipping;

    /**
     * Set ID
     *
     * @param string $id ID
     *
     * @return $this Area
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get ID
     *
     * @return string ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return $this Area
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set regional name
     *
     * @param string $regionalName Regional name
     *
     * @return $this Area
     */
    public function setRegionalName($regionalName)
    {
        $this->regionalName = $regionalName;

        return $this;
    }

    /**
     * Get regional name
     *
     * @return string Regional name
     */
    public function getRegionalName()
    {
        return $this->regionalName;
    }

    /**
     * Set warehouse
     *
     * @param bool $hasWarehouse Has warehouse
     *
     * @return $this Area
     */
    public function setWarehouse($hasWarehouse)
    {
        $this->warehouse = $hasWarehouse;

        return $this;
    }

    /**
     * Has warehouse
     *
     * @return bool
     */
    public function hasWarehouse()
    {
        return $this->warehouse;
    }

    /**
     * Set extra city pickup
     *
     * @param bool $hasExtraCityPickup Has extra city pickup
     *
     * @return $this Area
     */
    public function setExtraCityPickup($hasExtraCityPickup)
    {
        $this->extraCityPickup = $hasExtraCityPickup;

        return $this;
    }

    /**
     * Has extra city pickup
     *
     * @return bool
     */
    public function hasExtraCityPickup()
    {
        return $this->extraCityPickup;
    }

    /**
     * Set extra city shipping
     *
     * @param bool $hasExtraCityShipping Has extra city shipping
     *
     * @return $this Area
     */
    public function setExtraCityShipping($hasExtraCityShipping)
    {
        $this->extraCityShipping = $hasExtraCityShipping;

        return $this;
    }

    /**
     * Has extra city shipping?
     *
     * @return bool Has extra city shipping?
     */
    public function hasExtraCityShipping()
    {
        return $this->extraCityShipping;
    }

    /**
     * Set regional area pickup
     *
     * @param bool $hasRegionalAreaPickup Has regional area pickup
     *
     * @return $this Area
     */
    public function setRegionalAreaPickup($hasRegionalAreaPickup)
    {
        $this->regionalAreaPickup = $hasRegionalAreaPickup;

        return $this;
    }

    /**
     * Has regional area pickup?
     *
     * @return bool Has regional area pickup?
     */
    public function hasRegionalAreaPickup()
    {
        return $this->regionalAreaPickup;
    }

    /**
     * Set regional area shipping
     *
     * @param bool $hasRegionalAreaShipping Has regional area shipping
     *
     * @return $this Area
     */
    public function setRegionalAreaShipping($hasRegionalAreaShipping)
    {
        $this->regionalAreaShipping = $hasRegionalAreaShipping;

        return $this;
    }

    /**
     * Has regional area shipping?
     *
     * @return bool Has regional area shipping?
     */
    public function hasRegionalAreaShipping()
    {
        return $this->regionalAreaShipping;
    }
}
