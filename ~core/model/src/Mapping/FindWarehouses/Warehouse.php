<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\FindWarehouses;

/**
 * Warehouse Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Warehouse
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
     * @var float $latitude Latitude
     */
    private $latitude;

    /**
     * @var float $longitude Longitude
     */
    private $longitude;

    /**
     * @var float $distance Distance
     */
    private $distance;

    /**
     * @var string $cityName City name
     */
    private $cityName;

    /**
     * @var string $address Address
     */
    private $address;

    /**
     * @var bool $warehouse Has warehouse
     */
    private $warehouse;

    /**
     * Set ID
     *
     * @param string $id ID
     *
     * @return $this Warehouse
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
     * @return $this Warehouse
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
     * Set latitude
     *
     * @param float $latitude Latitude
     *
     * @return $this Warehouse
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float Latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude Longitude
     *
     * @return $this Warehouse
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float Longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set distance
     *
     * @param float $distance Distance
     *
     * @return $this Warehouse
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return float Distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set city name
     *
     * @param string $cityName City name
     *
     * @return $this Warehouse
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get city name
     *
     * @return string City name
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set address
     *
     * @param string $address Address
     *
     * @return $this Warehouse
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set warehouse
     *
     * @param bool $hasWarehouse True if has warehouse, otherwise - false
     *
     * @return $this Warehouse
     */
    public function setWarehouse($hasWarehouse)
    {
        $this->warehouse = $hasWarehouse;

        return $this;
    }

    /**
     * Has warehouse?
     *
     * @return bool True if has warehouse, otherwise - false
     */
    public function hasWarehouse()
    {
        return $this->warehouse;
    }
}
