<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\Tariff;

/**
 * Tariff Category Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Category
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
     * @var int $categoryId Category ID
     */
    private $categoryId;

    /**
     * @var int $maxWidth Max width
     */
    private $maxWidth;

    /**
     * @var float $maxSize Max size
     */
    private $maxSize;

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
     * Set category ID
     *
     * @param int $categoryId Category ID
     *
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get category ID
     *
     * @return int Category ID
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set max width
     *
     * @param int $maxWidth Max width
     *
     * @return $this
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Get max width
     *
     * @return int Max width
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Set max size
     *
     * @param float $maxSize Max size
     *
     * @return $this
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;

        return $this;
    }

    /**
     * Get max size
     *
     * @return float Max size
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }
}
