<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\WarehouseList;

/**
 * Warehouse Details Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class WarehouseDetails
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
     * @var string $cityId City ID
     */
    private $cityId;

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
     * @var string $email Email
     */
    private $email;

    /**
     * @var float $latitude Latitude
     */
    private $latitude;

    /**
     * @var float $longitude Longitude
     */
    private $longitude;

    /**
     * @var bool $office Is office?
     */
    private $office;

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
     * Set city ID
     *
     * @param string $cityId City ID
     *
     * @return $this
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get city ID
     *
     * @return string City ID
     */
    public function getCityId()
    {
        return $this->cityId;
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
     * Set E-Mail
     *
     * @param string $email E-Mail
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get E-Mail
     *
     * @return string E-Mail
     */
    public function getEmail()
    {
        return $this->email;
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
     * @param bool $office Office
     *
     * @return $this
     */
    public function setOffice($office)
    {
        $this->office = $office;

        return $this;
    }

    /**
     * Is office?
     *
     * @return bool
     */
    public function isOffice()
    {
        return $this->office;
    }
}
