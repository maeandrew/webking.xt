<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\WarehouseInfo;

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
     * @var string $address Address
     */
    private $address;

    /**
     * @var string $operatingTime Operating time
     */
    private $operatingTime;

    /**
     * @var string $phone Phone
     */
    private $phone;

    /**
     * @var string $emailStorage Email storage
     */
    private $emailStorage;

    /**
     * @var float $latitude Latitude
     */
    private $latitude;

    /**
     * @var float $longitude Longitude
     */
    private $longitude;

    /**
     * @var bool $isOffice Is office?
     */
    private $isOffice;

    /**
     * Set ID
     *
     * @param string $id ID
     *
     * @return $this
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
     * @return $this
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
     * Set address
     *
     * @param string $address Address
     *
     * @return $this
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
     * Set operating time
     *
     * @param string $operatingTime Operating time
     *
     * @return $this
     */
    public function setOperatingTime($operatingTime)
    {
        $this->operatingTime = $operatingTime;

        return $this;
    }

    /**
     * Get operating time
     *
     * @return string Operating time
     */
    public function getOperatingTime()
    {
        return $this->operatingTime;
    }

    /**
     * Set phone
     *
     * @param string $phone Phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email storage
     *
     * @param string $emailStorage Email storage
     *
     * @return $this
     */
    public function setEmailStorage($emailStorage)
    {
        $this->emailStorage = $emailStorage;

        return $this;
    }

    /**
     * Get email storage
     *
     * @return string Email storage
     */
    public function getEmailStorage()
    {
        return $this->emailStorage;
    }

    /**
     * Set latitude
     *
     * @param float $latitude Latitude
     *
     * @return $this
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
     * @return $this
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
     * Set office
     *
     * @param bool $isOffice Office
     *
     * @return $this
     */
    public function setOffice($isOffice)
    {
        $this->isOffice = $isOffice;

        return $this;
    }

    /**
     * Is office?
     *
     * @return bool Office
     */
    public function isOffice()
    {
        return $this->isOffice;
    }
}
