<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Mapping\Receipt;

/**
 * Receipt Details Entity Mapping Class
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Timur Bolotyuh <timur.bolotyuh@gmail.com>
 */
class Details
{
    /**
     * @var string $id ID
     */
    private $id;

    /**
     * @var string $number Number
     */
    private $number;

    /**
     * @var string $sendDate Send date
     */
    private $sendDate;

    /**
     * @var string $receiveDate Receive date
     */
    private $receiveDate;

    /**
     * @var string $senderWarehouseName Sender warehouse name
     */
    private $senderWarehouseName;

    /**
     * @var string $recipientWarehouseName Recipient warehouse name
     */
    private $recipientWarehouseName;

    /**
     * @var float $discount Discount
     */
    private $discount;

    /**
     * @var float $totalCost Total cost
     */
    private $totalCost;

    /**
     * @var int $status Status
     */
    private $status;

    /**
     * @var float $weight Weight
     */
    private $weight;

    /**
     * @var float $volume Volume
     */
    private $volume;

    /**
     * @var string $sites Sites
     */
    private $sites;

    /**
     * @var bool $paymentStatus Payment status
     */
    private $paymentStatus;

    /**
     * @var integer $currency Currency
     */
    private $currency;

    /**
     * @var integer $insuranceCost Insurance cost
     */
    private $insuranceCost;

    /**
     * @var integer $insuranceCurrency Insurance currency
     */
    private $insuranceCurrency;

    /**
     * @var integer $pushStateCode Push state code
     */
    private $pushStateCode;

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
     * Set number
     *
     * @param string $number Number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string Number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set currency
     *
     * @param int $currency Currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return int Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set discount
     *
     * @param float $discount Discount
     *
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float Discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set insurance cost
     *
     * @param int $insuranceCost Insurance cost
     *
     * @return $this
     */
    public function setInsuranceCost($insuranceCost)
    {
        $this->insuranceCost = $insuranceCost;

        return $this;
    }

    /**
     * Get insurance cost
     *
     * @return int Insurance cost
     */
    public function getInsuranceCost()
    {
        return $this->insuranceCost;
    }

    /**
     * Set insurance currency
     *
     * @param int $insuranceCurrency Insurance currency
     *
     * @return $this
     */
    public function setInsuranceCurrency($insuranceCurrency)
    {
        $this->insuranceCurrency = $insuranceCurrency;

        return $this;
    }

    /**
     * Get insurance currency
     *
     * @return int
     */
    public function getInsuranceCurrency()
    {
        return $this->insuranceCurrency;
    }

    /**
     * Set payment status
     *
     * @param bool $paymentStatus Payment status
     *
     * @return $this
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get payment status
     *
     * @return bool
     */
    public function isPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set push state code
     *
     * @param int $pushStateCode Push state code
     *
     * @return $this
     */
    public function setPushStateCode($pushStateCode)
    {
        $this->pushStateCode = $pushStateCode;

        return $this;
    }

    /**
     * Get push state code
     *
     * @return int
     */
    public function getPushStateCode()
    {
        return $this->pushStateCode;
    }

    /**
     * Set receive date
     *
     * @param string $receiveDate Receive date
     *
     * @return $this
     */
    public function setReceiveDate($receiveDate)
    {
        $this->receiveDate = $receiveDate;

        return $this;
    }

    /**
     * Get receive date
     *
     * @return string
     */
    public function getReceiveDate()
    {
        return $this->receiveDate;
    }

    /**
     * Set recipient warehouse name
     *
     * @param bool $recipientWarehouseName Recipient warehouse name
     *
     * @return $this
     */
    public function setRecipientWarehouseName($recipientWarehouseName)
    {
        $this->recipientWarehouseName = $recipientWarehouseName;

        return $this;
    }

    /**
     * Get recipient warehouse name
     *
     * @return bool
     */
    public function isRecipientWarehouseName()
    {
        return $this->recipientWarehouseName;
    }

    /**
     * Set send date
     *
     * @param string $sendDate Send date
     *
     * @return $this
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get send date
     *
     * @return string Send date
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set sender warehouse name
     *
     * @param string $senderWarehouseName Sender warehouse name
     *
     * @return $this
     */
    public function setSenderWarehouseName($senderWarehouseName)
    {
        $this->senderWarehouseName = $senderWarehouseName;

        return $this;
    }

    /**
     * Get sender warehouse name
     *
     * @return string
     */
    public function getSenderWarehouseName()
    {
        return $this->senderWarehouseName;
    }

    /**
     * Set sites
     *
     * @param string $sites Sites
     *
     * @return $this
     */
    public function setSites($sites)
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * Get sites
     *
     * @return string Sites
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * Set status
     *
     * @param int $status Status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set total cost
     *
     * @param float $totalCost Total cost
     *
     * @return $this
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * Get total cost
     *
     * @return float
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * Set volume
     *
     * @param float $volume Volume
     *
     * @return $this
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set weight
     *
     * @param float $weight Weight
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float Weight
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
