<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\AdditionalServiceList;

/**
 * Classification Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Classification
{
    /**
     * @var int $classificationCode Classification code
     */
    private $classificationCode;

    /**
     * @var string $name Name
     */
    private $name;

    /**
     * @var Service[] $additionalServices Additional services
     */
    private $additionalServices;

    /**
     * Set classification code
     *
     * @param int $classificationCode Classification code
     *
     * @return $this Classification
     */
    public function setClassificationCode($classificationCode)
    {
        $this->classificationCode = $classificationCode;

        return $this;
    }

    /**
     * Get classification code
     *
     * @return int Classification code
     */
    public function getClassificationCode()
    {
        return $this->classificationCode;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return $this Classification
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
     * Set additional services
     *
     * @param array|Service[] $additionalServices Additional services
     *
     * @return $this Classification
     */
    public function setAdditionalServices(array $additionalServices)
    {
        $this->additionalServices = $additionalServices;

        return $this;
    }

    /**
     * Get additional services
     *
     * @return array|Service[] Additional services
     */
    public function getAdditionalServices()
    {
        return $this->additionalServices;
    }
}
