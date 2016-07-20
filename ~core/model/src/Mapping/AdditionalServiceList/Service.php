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
 * Service Entity Mapping Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Service
{
    /**
     * @var int $id ID
     */
    private $id;

    /**
     * @var string $name Name
     */
    private $name;

    /**
     * @var float $cost Cost
     */
    private $cost;

    /**
     * @var int $count Count
     */
    private $count;

    /**
     * @var int $classification Classification
     */
    private $classification;

    /**
     * @var float $minWidth Min width
     */
    private $minWidth;

    /**
     * @var float $maxWidth Max width
     */
    private $maxWidth;

    /**
     * @var float $sum Sum
     */
    private $sum;

    /**
     * @var string $comment Comment
     */
    private $comment;

    /**
     * @var int $currencyCode Currency code
     */
    private $currencyCode;

    /**
     * Set ID
     *
     * @param int $id ID
     *
     * @return $this Service
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get ID
     *
     * @return int ID
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
     * @return $this Service
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
     * Set cost
     *
     * @param float $cost Cost
     *
     * @return $this Service
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float Cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set count
     *
     * @param int $count Count
     *
     * @return $this Service
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return int Count
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set classification
     *
     * @param int $classification Classification
     *
     * @return $this Service
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return int Classification
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set min width
     *
     * @param float $minWidth Min width
     *
     * @return $this Service
     */
    public function setMinWidth($minWidth)
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    /**
     * Get min width
     *
     * @return float Min width
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }

    /**
     * Set max width
     *
     * @param float $maxWidth Max width
     *
     * @return $this Service
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Get max width
     *
     * @return float Max width
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Set sum
     *
     * @param float $sum Sum
     *
     * @return $this Service
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return float Sum
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set comment
     *
     * @param string $comment Comment
     *
     * @return $this Service
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string Comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set currency code
     *
     * @param int $currency Currency code
     *
     * @return $this Service
     */
    public function setCurrencyCode($currency)
    {
        $this->currencyCode = $currency;

        return $this;
    }

    /**
     * Get currency code
     *
     * @return int Currency code
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }
}
